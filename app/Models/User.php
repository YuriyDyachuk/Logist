<?php

namespace App\Models;

use App\Models\Transport\Transport;
use App\Traits\DocumentsRelations;
use App\Traits\ImagesRelations;

use App\Models\Traits\User\UsersRole;
use App\Models\Traits\User\UsersPartner;
use App\Models\Traits\User\UsersModule;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Subscriptions\Subscription;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;


class User extends Authenticatable
{
    use HasApiTokens,
        Notifiable,
        ImagesRelations,
        DocumentsRelations,
        SoftDeletes,

        UsersRole,
        UsersPartner,
        UsersModule;

    protected $appends = ['company'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verify_email',
        'verify_phone',
        'role_id',
        'phone',
        'is_activated',
        'balance',
        'balance_return',
        'social_type',
        'social_id',
        'meta_data',
        'parent_id',
        'is_admin',
        'invited',
        'type',
        'locale',
        'verified',
        'tutorial'
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    public function unserialize(){
        $this->metaDataToArray();

        if($this->meta_data){
            foreach($this->meta_data as $key => $item) {
                if(!isset($this->$key))
                    $this->$key = $item;
            }
        }

        if(!isset($this->status)){
            if(SELF::isActivatedUser()){

                $status = Status::where('type', 'user')
                    ->where('name', 'Active')->first();
            } else {

                $status = Status::where('type', 'user')
                    ->where('name', 'Not Active')->first();
            }

            $this->status = $status->id;
        }

        return $this;
    }

    public function getCompanyAttribute()
    {
        if ($this->parent_id)
            return UserCompany::find($this->parent_id);
        else
            return UserCompany::find($this->id);
    }


    public function getAvatar()
    {
        return $this->images()->first()->filename ?? '';
    }

    /**
     *  Takes a JSON encoded string and converts it into array.
     */
    public function metaDataToArray()
    {
        if (!is_array($this->meta_data)) {
            $this->meta_data = json_decode($this->meta_data, true);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emailActivation()
    {
        return $this->hasMany('App\Models\EmailActivation');
    }

    public function verifications()
    {
        return $this->hasMany('App\Models\Verification');
    }

    /**
     * @return bool
     */
    public function isActivateEmail()
    {
        return $this->is_activated == 1;
    }

    /**
     * @return bool
     */
    public function isActivatedUser()
    {
        return ($this->verify_email && $this->verify_phone) ? true : false;
    }

    public function scopeIsActivatedUser($query){
        return $query->whereNotNull('verify_email')->whereNotNull('verify_phone');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specializations()
    {
        return $this->belongsToMany('App\Models\Specialization', 'specialization_user', 'user_id', 'specialization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany('App\Models\Service')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ccards()
    {
        return $this->hasMany(Ccards::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getStaffs()
    {
        return $this->newQuery()
            ->where('parent_id', $this->id)
	        ->with('role')
	        ->with('roles')
            ->latest()
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany('App\Models\User', 'clients', 'user_id', 'client_id')
            ->withPivot('data')
            ->withTimestamps();
    }

    public function client(){
        return $this->hasOne('App\Models\Client', 'client_id', 'id');
    }

    /**
     * @param $authUserId
     * @return int
     */
    public function isCompanyClient($authUserId)
    {
        return $this->hasMany(Client::class, 'client_id', 'id')
                    ->where('user_id', $authUserId)->count();
    }

    public function isUserClient()
    {
        return $this->hasOne(Client::class, 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transports() {
        return $this->hasMany(Transport::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credentialsOutside(){
        return $this->hasMany('App\Models\CredentialsOutside');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templates()
    {
        return $this->hasMany('App\Models\Template');
    }

    public function driverTransport(){
		return $this->belongsToMany(\App\Models\Transport\Transport::class, 'transports_drivers', 'user_id', 'transport_id');
    }

    public function driver_comments()
    {
        return $this->hasMany('App\Models\Transport\Comment', 'driver_id', 'id');
    }

	/**
	 * Send reset password
	 *
	 * @param string $token
	 */
	public function sendPasswordResetNotification($token)
	{
		Mail::to($this)->send(new PasswordReset($token));
	}

    /**
     * Check, is deviation notification enabled
     *
     * @return bool
     */
    public function isDeviationEnabled():bool
    {
        return isset($this->meta_data['deviation_notification'])
            && (int) $this->meta_data['deviation_notification'] === 1
            && ($this->isLogist() || $this->isLogistic());
    }

    /**
     * Return deviation distance
     *
     * @return mixed
     */
    public function getDeviationDistance()
    {
        $deviationDistance = $this->meta_data['deviation_distance'] ?? null;

        if ($deviationDistance === null) {
            return 0;
        }

        return $deviationDistance;
    }
}
