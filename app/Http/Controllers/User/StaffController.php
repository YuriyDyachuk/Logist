<?php

namespace App\Http\Controllers\User;

use App\Models\EmailActivation;
use App\Models\RoleUser;
use App\Models\Role;
use App\Models\Transport\Transport;
use App\Models\User;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;

use App\Services\DocumentService;
use App\Services\TransportService;
use App\Services\AmplitudeService;
use App\Services\VerificationService;
use Auth;

use App\Http\Controllers\ImageController;
use App\Http\Requests\StaffStore;
use App\Http\Requests\StaffUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Handbook\PaymentType;

use Illuminate\Support\Str;
use Mail;
use App\Mail\InvitePartner;
use App\Mail\RegisteredStaff;

use App\Enums\UserRoleEnums;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StaffStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffStore $request)
    {
        $data     = null;
        $employer = Auth::user();
        $metaData = $request->only(['birthday', 'passport', 'inn_number', 'payment_type', 'work_start', 'driver_licence', 'rate', 'percent']);

        $password = $request->get('password');

        $data['email']     = $request->get('email');
        $data['name']      = $request->get('full_name');
        $data['phone']     = $request->get('phone');
        $data['parent_id'] = $employer->id;
        $data['password']  = bcrypt($request->get('password'));
        $data['meta_data'] = $metaData;
        $data['meta_data'] = $metaData;
        $data['verify_email'] = 1;
        $data['verify_phone'] = 1;

        //todo:only for testing
        $data['verified'] = 1;

        DB::beginTransaction();

        try {
            $staff = User::create($data);

            $role_id = $request->get('position');

            if($role_id !== Role::getRoleIdByName(UserRoleEnums::LOGISTIC)){
                $is_admin = $request->is_admin ? 1 : 0;
                $staff->update(['is_admin' => $is_admin]);
            }

            RoleUser::create([
	            'user_id'   => $staff->id,
	            'role_id'   => $role_id,
            ]);

            if ($request->file('images')) {
                $this->storeImages($staff, $request->file('images'));
            }

            $data_amplitude = [
                "add_admin" => $request->is_admin ? 1 : 0,
                "source" => "cabinet",
            ];

            // logist
            if($role_id == 4){
                $data_amplitude['add_new_logist'] = 'yes';
                $data_amplitude['add_new_driver'] = 'no';
            }

            // driver
            if($role_id == 3){
                $data_amplitude['add_new_logist'] = 'no';
                $data_amplitude['add_new_driver'] = 'yes';
            }

            // logist || manager
            if($role_id == 5 || $role_id == 4){
	            Mail::to($staff->email)->send(new RegisteredStaff($staff));
            }

            (new AmplitudeService())->request('Add new employee', $data_amplitude);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

            if (!$employer->tutorial && $role_id == \App\Enums\UserRoleEnums::DRIVER) {

            $transport = Transport::where('user_id', $employer->id)->first();

            $service_transport   = new TransportService($employer);

            $service_transport->syncDriver($transport, $staff->id);

//            $employer->update(['tutorial' => 1]);
        }

        if(!empty($request->get('redirectTo'))) {
            $redirectTo = $request->get('redirectTo');
            $refresh = false;
        } else {
            $redirectTo = route('user.profile') . '#staffs';
            $refresh = true;
        }


        return response()->json(['status' => 'success', 'url' => $redirectTo, 'refresh' => $refresh]);
    }

    /**
     * Upload and save images
     *
     * @param int $staffId
     * @param array $files
     * @return void
     */
    protected function storeImages($staff, $files = [])
    {
        foreach ($files as $key => $images) {
            switch ($key) {
                case 'avatar':
                    ImageController::upload([0 => $images], $staff->id, User::class, 'users');
                    break;

                case 'license':
                    $docType = DocumentType::whereName("driver's_license")->value('id');
                    DocumentService::save($staff, $images, $docType);
                    break;
            }
        }
    }

    /**
     * If a user has passport, return the document
     * else, create a new document.
     *
     * @param  int $staffId
     * @return  mixed
     */
    public function findOrCreateLicense($staffId, $filename)
    {
        return Document::firstOrCreate([
            'document_type_id' => DocumentType::search('driver\'s_license')['id'],
            'filename'         => $filename,
            'imagetable_id'    => $staffId,
            'imagetable_type'  => User::class,
        ]);
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
        return json_encode($request->all());
    }


    public function save(StaffUpdate $request, $id)
    {
        $data     = null;
        $employer = Auth::user();
        $metaData = $request->only(['birthday', 'passport', 'inn_number', 'payment_type', 'work_start', 'driver_licence', 'rate', 'percent']);

        $data['email']     = $request->email;
        $data['name']      = $request->full_name;
        $data['phone']     = $request->phone;

        if($request->password != ''){
	        $data['password']  = bcrypt($request->password);
        }

//        $data['parent_id'] = $employer->id;
        $data['meta_data'] = $metaData;

        $staff = User::find($id);
        $staff->update($data);

        if ($request->file('images')) {
            if (count($staff->images) > 0 ) {
                // TODO delete old image
                $staff->images()->first()->delete();
            }
            $this->storeImages($staff, $request->file('images'));
        }

        $role_user = RoleUser::where('user_id', $staff->id)->first();
        if ($role_user) {
            $role_id = $role_user->role_id;
	        $role_user->delete();
        }

        if($request->get('position') !== null){
            $role_id = $request->get('position');
        }

        if($role_id !== Role::getRoleIdByName(UserRoleEnums::LOGISTIC)){
            $is_admin = $request->is_admin !== null ? 1 : 0;
            $staff->update(['is_admin' => $is_admin]);
        }

        RoleUser::create([
            'user_id'     => $staff->id,
            'role_id' => $role_id,
        ]);

        if(!empty($request->get('redirectTo'))) {
            $redirectTo = $request->get('redirectTo');
            $refresh = false;
        } else {
            $redirectTo = route('user.profile') . '#staffs';
            $refresh = true;
        }


        return response()->json(['status' => 'success', 'url' => $redirectTo, 'refresh' => $refresh]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

//        if (!app_has_access('clients.all'))
//            abort(404);

        $current_user = \Auth::user();
        if($current_user->isLogistic() || $current_user->isAdmin()){
            $role = RoleUser::where('user_id', $id)->first();
            if ($role) {
                $role->delete();
            }

            $user = User::where('id', $id)->first();
            if ($user) {
                $user->delete();
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'false']);
    }

}
