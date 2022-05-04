<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\CredentialsOutside;
use App\Models\Service;
use App\Models\Status;
use App\Models\User;
use App\Models\Image;
use App\Models\EmailActivation;
use App\Models\Client;
use App\Models\Role;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;

use Auth;
use Validator;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CcardController;
use App\Http\Controllers\ImageController;

use App\Services\DocumentService;
use App\Services\GeographerService;
use App\Services\UserDataService;

//use App\Http\Requests\UpdateProfile;
use App\Http\Requests\Settings\UserSettingsStore;

class SettingController extends Controller
{
    /**
     * Get a validator for password.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validatorPassword(array $data)
    {
        return Validator::make($data,
            [
                'password' => 'min:8|confirmed|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            ],
            [
                'password.regex' => trans('validation.password_regex'),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();

        $user->load('credentialsOutside');

	    $address = [];
	    $geodata = new GeographerService();
	    $address['countries'] = $geodata->getCountries();


	    $address['regions'] = isset($user->meta_data['address_country_code']) ? $geodata->getStates($user->meta_data['address_country_code']) : null;
	    $address['cities'] = isset($user->meta_data['address_region_code']) ? $geodata->getCities($user->meta_data['address_region_code']) : null;
	    $address['regions_legal'] = isset($user->meta_data['address_legal_country_code']) ? $geodata->getStates($user->meta_data['address_legal_country_code']) : null;
	    $address['regions_legal'] = isset($user->meta_data['address_legal_region_code']) ? $geodata->getCities($user->meta_data['address_legal_region_code']) : null;

	    $address['regions_post'] = isset($user->meta_data['address_post_country_code']) ? $geodata->getStates($user->meta_data['address_post_country_code']) : null;
	    $address['regions_post'] = isset($user->meta_data['address_post_region_code']) ? $geodata->getCities($user->meta_data['address_post_region_code']) : null;

        $userData    = (new UserDataService())->all($user->id);
        $user->cards = CcardController::get_cards_list($user->id);

        $documents = array();
        foreach ($user->documents as $key => $document) {
            $documents[$document->document_type_id][]                      = $document;
            $documents[$document->document_type_id]['files'][]['filename'] = $document->filename;
        }

        $documents_types = DocumentType::all();

        return view('settings.index', compact('user', 'userData', 'documents', 'documents_types', 'address'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProfile $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserSettingsStore $request)
    {
        if($request->has('check') && $request->check == 0){
            return response()->json(['result' => true]);
        }

        $user = auth()->user();

        if (!empty($request->file('images'))) {
            $this->createImages($user, $request->file('images'));
        }

        if (isset($request->document) && $request->document != 1) {
            $this->attemptChangeEmail($user, $request);
            $this->attemptChangePassword($user, $request);
        }

            $fields = $request->only([
                "type",
                'name',
                'delegate_name',

                "address_country",
                "address_index",
                "address_region",
                "address_city",
                "address_street",
                "address_number",
                "payment_account",
                "inn",

                "address_legal_country",
                "address_legal_index" ,
                "address_legal_region",
                "address_legal_city",
                "address_legal_street",
                "address_legal_number",
                "address_post_country",
                "address_post_index",
                "address_post_region",
                "address_post_city",
                "address_post_street",
                "address_post_number",
                "egrpou",

                'site_url',
                'description',

                'deviation_notification',
                'deviation_distance'
            ]);


        // Address
        if($request->address_country !== null){
	        $fields['address_country_code'] = $fields['address_country'];
	        $name = (new GeographerService())->getCountryByCode($fields['address_country_code'])->name;
	        $fields['address_country'] = $name;
        }

	    if($request->address_region !== null){
		    $fields['address_region_code'] = $fields['address_region'];
		    $name = (new GeographerService())->getStateByCode($fields['address_region_code'])->name;
		    $fields['address_region'] = $name;
	    }

	    if($request->address_region !== null){
		    $fields['address_city_code'] = $fields['address_city'];
		    $name = (new GeographerService())->getCityByCode($fields['address_city_code'])->name;
		    $fields['address_city'] = $name;
	    }

	    // Legal address
	    if($request->address_legal_country !== null){
		    $fields['address_legal_country_code'] = $fields['address_legal_country'];
		    $name = (new GeographerService())->getCountryByCode($fields['address_legal_country_code'])->name;
		    $fields['address_legal_country'] = $name;
	    }

	    if($request->address_legal_region !== null){
		    $fields['address_legal_region_code'] = $fields['address_legal_region'];
		    $name = (new GeographerService())->getStateByCode($fields['address_legal_region_code'])->name;
		    $fields['address_legal_region'] = $name;
	    }

	    if($request->address_legal_city !== null){
		    $fields['address_legal_city_code'] = $fields['address_legal_city'];
		    $name = (new GeographerService())->getCityByCode($fields['address_legal_city_code'])->name;
		    $fields['address_legal_city'] = $name;
	    }

	    // Post address
	    if($request->address_post_country !== null){
		    $fields['address_post_country_code'] = $fields['address_post_country'];
		    $name = (new GeographerService())->getCountryByCode($fields['address_post_country_code'])->name;
		    $fields['address_post_country'] = $name;
	    }

	    if($request->address_post_region !== null){
		    $fields['address_post_region_code'] = $fields['address_post_region'];
		    $name = (new GeographerService())->getStateByCode($fields['address_post_region_code'])->name;
		    $fields['address_post_region'] = $name;
	    }

	    if($request->address_post_city !== null){
		    $fields['address_post_city_code'] = $fields['address_post_city'];
		    $name = (new GeographerService())->getCityByCode($fields['address_post_city_code'])->name;
		    $fields['address_post_city'] = $name;
	    }

            $updated = false;

            foreach ($fields as $key => $item) {
                if (!$item)
                    continue;


                if ($user->$key != $item) {
	                (new UserDataService())->set($user->id, $key, $item);
                    $updated = true;
                }
            }

            if ($updated) {
                $statusId = Status::where('type', 'user')->where('name', 'Not accepted')->value('id');
                $data['status'] = $statusId;
                $user->meta_data = array_merge($data, $fields);
            }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        $user->save();

        $this->updateOrCreateCredentialsOutside($user->id, $request->only('systems'));

        $request->session()->flash('msg-success', trans('all.changes_successfully_saved'));


        if($request->ajax()){
            return response()->json(['result' => 'true', 'redirect' => route('user.setting')]);
        }

        return redirect()->back();
    }

    /**
     * If email is changed, then we need to send activation to e-mail again
     *
     * @param User $user
     * @param Request $request
     * @return  void
     */
    protected function attemptChangeEmail(User $user, Request $request)
    {
        if ($user->email != $request->get('email')) {
            $title = env('APP_NAME') . ' - ' . trans('all.activation_mail');
            $token = Str::random(60);

            AuthController::send_activation_mail($user, $token, $title);

            $user->email = $request->get('email');

            // Old email
            EmailActivation::where('user_id', $user->id)->delete();

            // New email
            EmailActivation::create([
                'email'   => $request->get('email'),
                'user_id' => $user->id,
                'token'   => $token,
            ]);

            $request->session()->flash('msg-popup', trans('all.you_will_get_email_activation'));
        }
    }

    /**
     * If password changed, we send email to confirm it.
     *
     * @param User $user
     * @param Request $request
     */
    protected function attemptChangePassword(User $user, Request $request)
    {
        $password = $request->get('password');

        if (!empty($password)) {
            $this->validatorPassword($request->all())->validate();

            $title = env('APP_NAME') . ' - ' . trans('all.password_reset');

            $user->forceFill(['remember_token' => Str::random(60)])
                ->save();

	        (new UserDataService())->set($user->id, 'new_password', bcrypt($password));

            AuthController::send_password_confirm_mail($user, $user->remember_token, $title);

            $request->session()->flash('msg-success', trans('all.password_reseted_emailsend'));
        }
    }

    /**
     * Upload images in storage
     *
     * @param \App\Models\User $user
     * @param $files
     */
    public function createImages(User $user, $files)
    {
        foreach ($files as $key => $images) {

            if ($key == 'avatar' || $key == 'signature') {
                if ($image = $user->images()->first()) {
                    $image->delete();
                }
                ImageController::upload($images, $user->id, User::class, 'users', $key);
            }

            if ($key == 'documents') {
                foreach ($images as $documentTypeId => $data) {
                    foreach ($data as $item) {
                        DocumentService::save($user, $item, $documentTypeId);
                    }
                }
            }
        }
    }

    /**
     * @param int $userId
     * @param array $data
     * @return void
     */
    private function updateOrCreateCredentialsOutside(int $userId, array $data)
    {
        $systems = ['globus'];
        foreach ($systems as $system) {
            if (!empty($data['systems'])) {
                if (empty($data['systems'][$system]['login']) || empty($data['systems'][$system]['password'])) {
                    continue;
                }

                CredentialsOutside::query()->updateOrCreate(
                    [
                        'type' => $system, 'user_id' => $userId,
                    ],
                    [
                        'login'    => $data['systems'][$system]['login'],
                        'password' => encrypt($data['systems'][$system]['password']),
                        'api_key'  => encrypt($data['systems'][$system]['api_key']),
                    ]
                );
            }
        }
    }
}
