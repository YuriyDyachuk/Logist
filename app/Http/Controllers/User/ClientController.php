<?php

namespace App\Http\Controllers\User;


use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;

use App\Models\Partner;
use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use App\Models\RoleUser;

use App\Enums\UserRoleEnums;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\InvitationController;
use App\Http\Controllers\ImageController;

use App\Services\LogisticService;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(!app_has_access('clients.all'))
//            abort(404);

        $users_array = (new LogisticService())->getLogistsArray();

        $clients = Client::whereIn('user_id', $users_array)->with('user')->orderBy('created_at', 'asc')->paginate(15);

        foreach ($clients as $client) {
            $metaData         = $client->user->meta_data ?? [];
//            $pivotData        = json_decode($client->data, true);
            $pivotData        = $client->data;

            if(is_string($pivotData))
                $pivotData = json_decode($pivotData, true);

            $client->data     = array_merge($metaData, $pivotData);
            $client->position = $client->data['position'] ?? null;

            // If the client is a employee
            if ($client->user->parent_id > 0) {
                $client->company_name = User::findOrFail($client->user->parent_id)->value('name');
                $client->position     = trans('all.' . $client->role()->first()->getRoleName());
            }
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
//        if(!app_has_access('clients.all'))
//            abort(404);

        $user = $user_company = \Auth::user();

//        if($user->parent_id != 0){
//	        $user_company = User::find($user->parent_id);
//	        if(!$user_company){
//		        $user_company = $user;
//	        }
//		}

        $clientId = $request->get('id', 0);
        $data     = null;

        if ($clientId > 0) {
            $data = json_encode($request->only('skype', 'condition'));
        } else {

            $client = User::whereEmail($request->email)->first();

            $data     = json_encode($request->except('_token', 'invite', 'email'));

            if($client){
                $clientId = $client->id;
            }
            else {
                $client = User::create([
                    'email'    => $request->email,
                    'name'     => $request->name,
                    'password' => bcrypt(str_random(8)),
                    'invited'  => true,
                    'phone' => $request->phone1
                ]);

                $clientId = $client->id;

                $role = Role::where('name', UserRoleEnums::CLIENT)->first();

                RoleUser::create([
                    'user_id'     => $client->id,
                    'role_id' => $role->id,
                ]);
            }

            if ($request->file('images')) {
                ImageController::upload($request->file('images'), $clientId, User::class, 'users');
            }

            if ($request->has('invite')) {
                InvitationController::send($user, $client);
            }
        }

        $user->clients()->attach($clientId, ['data' => $data]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClient $request, $id)
    {
//        if(!app_has_access('clients.all'))
//            abort(404);

        $user   = User::findOrFail($id);
        $client = Client::whereClientId($id)->first();

        $user->name = $request->get('name');
        $user->save();

        $client->data = $request->except('_token', '_method', 'invite', 'email');
        $client->save();

        if ($request->file('images')) {
            if ($image = $user->images()->first()) {
                $image->delete();
            }
            ImageController::upload($request->file('images'), $user->id, User::class, 'users');
        }

        return response()->json(['status' => 'success', 'data' => $request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = \Auth::user();

        if($user->is_admin == 1){
			$user = User::findOrFail($user->parent_id);
        }

        $user->clients()->detach($id);

        return response()->json(['status' => 'success']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isExists(Request $request)
    {
        $user = \Auth::user();
        $user_company = $user->parent_id == 0 ? $user->id : $user->parent_id;

        $client = null;

        if ($request->has('email')) {
            $client = User::whereEmail($request->get('email'))->first();
        }

        if ($client) {

            $isClient = Client::whereUserId($user->id)->whereClientId($client->id)->first();
            if($isClient === null){
                return response()->json(['status' => 'success', 'client' => null, 'alreadyExists' => false]);
            }

            $metaData = $client->meta_data;

            if ($client->isCompany()) {
                $client->companyName = $client->name;
                $client->name        = $metaData['delegate_name'] ?? 'name';
                $client->city        = $metaData['city'] ?? '';
                $client->country     = $metaData['country'] ?? '';
                $client->index       = $metaData['index'] ?? '';
            }

            $client->setVisible(['id', 'email', 'name', 'phone', 'city', 'country', 'index', 'companyName', 'position']);

            if ($client->parent_id > 0) {
                $client->companyName = User::findOrFail($client->parent_id)->value('name');
                $client->position    = trans('all.' . $client->role()->first()->getRoleName());
                $client->addVisible('position');
            }

            if ($client->isCompanyClient(\Auth::user()->id)) {
                return response()->json(['status' => 'success', 'client' => $client, 'alreadyExists' => true]);
            }
        }

        return response()->json(['status' => 'success', 'client' => $client, 'alreadyExists' => false]);
    }

    /**
     *  User to invite on the system.
     *
     * @param $clientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function toInvite($clientId)
    {
        try {
            $user   = \Auth::user();
            $client = User::findOrFail($clientId);

            InvitationController::send($user, $client);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function setMainPhone(Request $request){
        $user = \Auth::user();
        $user->phone = $request->phone2;
        $user->save();

        $client = Client::where('client_id', $user->id)->first();
        $client_data = $client->data;

        $client_data['phone2'] = $request->phone;
        $client_data['phone1'] = $request->phone2;
        $client->data = $client_data;
        $client->save();

        return response()->json(['result' => 'ok']);
    }

    public function history($id)
    {
        $user = User::findOrFail($id);
        $authUser= \Auth::user()->id;
        $partner = Partner::where('user_one_id', $authUser)->where('user_two_id', $id)->first();
        return view('clients.history.index',[
                'user' => $user,
                'partner' => $partner,
            ]
        );
    }
}
