<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ImageController;
use App\Models\Partner;
use App\Models\User;
use App\Models\Role;
use App\Models\PartnerStatus;
use App\Enums\UserRoleEnums;
use App\Notifications\InvitePartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\InvitationController;
use Illuminate\Support\Facades\Notification;

use App\Services\AmplitudeService;

class PartnerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        if(!app_has_access('clients.all'))
//            abort(404);

        $user     = \Auth::user();
        $partnerID = $request->get('id', 0);
        $data     = null;

//        if ($partnerID > 0) {
//            $data = json_encode($request->only('phone1', 'companyName'));

        Partner::storePartner($partnerID);
        $partner = User::findOrFail($partnerID);
        InvitationController::send($user, $partner);
        Notification::send($partner, new InvitePartner($user));

//        }
//        else {
//            $partner = User::create([
//                'email'    => $request->get('email'),
//                'name'     => $request->get('name'),
//                'password' => bcrypt(str_random(8)),
//                'invited'  => true,
//            ]);
//
//
//            $data     = json_encode($request->except('_token', 'invite', 'email'));
//
//            if ($request->file('images')) {
//                ImageController::upload($request->file('images'), $partnerID, User::class, 'users');
//            }
//
//            if ($request->has('invite')) {
//                InvitationController::send($user, $partner);
//            }
//        }

//        $user->partners()->attach($partnerID, ['data' => $data]);

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
    public function update(Request $request, $id)
    {
//        if(!app_has_access('clients.all'))
//            abort(404);

        $user   = User::findOrFail($id);
        $partner = Partner::wherePartnerId($id)->first();

        $user->name = $request->get('name');
        $user->save();

        $partner->data = $request->except('_token', '_method', 'invite', 'email');
        $partner->save();

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
//        if(!app_has_access('clients.all'))
//            abort(404);

        Partner::deletePartner($id);

        return response()->json(['status' => 'success']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isExists(Request $request)
    {
        $user_current = \Auth::user();

        $partner = null;

        $partnerEmail = $request->email;

        if ($partnerEmail && $partnerEmail != '') {

            $roles = Role::where('name', UserRoleEnums::LOGISTIC)->pluck('id');

            $partner = User::whereEmail($partnerEmail)->where('id', '!=', $user_current->id)
                ->whereHas('role', function($q) use ($roles){
                    $q->whereIn('role_id', $roles);
                })
                ->isActivatedUser()
                ->first();
        }

        if ($partner) {

            $current_user_id = $user_current->id;

            $isPartnerList = Partner::isPartner($current_user_id, $partner->id);

            if($isPartnerList){
                $status = $isPartnerList->status->name;

                return response()->json(['status' => $status, 'partner' => $partner, 'alreadyExists' => true]);
            }

            return response()->json(['status' => 'success', 'partner' => $partner, 'alreadyExists' => false]);

        }
        else {
            // TODO maybe delete

            $account = User::whereEmail($partnerEmail)->first();

            if($account){
                return response()->json(['status' => 'disable', 'partner' => '', 'alreadyExists' => true]);
            }
        }

        return response()->json(['status' => 'disable', 'partner' => '', 'alreadyExists' => false]);
    }

    /**
     *  User to invite on the system.
     *
     * @param $partnerID
     * @return \Illuminate\Http\JsonResponse
     */
    public function toInvite($partnerID)
    {
        try {
            $user   = \Auth::user();
            $partner = User::findOrFail($partnerID);

            InvitationController::send($user, $partner);

            (new AmplitudeService())->simpleRequest('Invite new partner');

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function notification(Request $request)
    {

        if($request->approved == 1){
            Partner::storePartner($request->user_id, PartnerStatus::getId(PartnerStatus::ACCEPTED));
        }
        elseif($request->approved == 0) {
            Partner::storePartner($request->user_id, PartnerStatus::getId(PartnerStatus::DECLINED));
        }

        return redirect('/profile#partners');
    }
}
