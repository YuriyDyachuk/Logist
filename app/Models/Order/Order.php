<?php

namespace App\Models\Order;


use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\User;
use App\Models\Status;
use App\Models\Specialization;
use App\Models\SpecializationUser;
use App\Models\Geo;
use App\Models\OrderGeo;
use App\Models\Transport\Category;
use App\Models\Transport\Transport;
use App\Traits\DocumentsRelations;
use App\Models\Relationships\OrderAddress;
use App\Models\Order\OrderPerformer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Traits\Order\OrderOffer;
use App\Models\Traits\Order\OrderPerformer as OrderPerformerTrait;
use App\Models\Traits\Order\OrderStatus as OrderStatusTrait;
use App\Models\Traits\Order\OrderGeo as OrderGeoTrait;

class Order extends Model
{
    use DocumentsRelations, OrderOffer, OrderPerformerTrait, OrderStatusTrait, OrderGeoTrait;

    const PARTNER_REQUEST = 'request';
    const PARTNER_APPROVED = 'approved';
    const PARTNER_REJECT = 'reject';

    public $timestamps = true;

    protected $fillable = [

        'inner_id',
        'user_id',
        'comment',
        'type',
        'transport_cat_id',
        'current_status_id',
        'currency',
        'payment_type_id',
        'payment_term_id',
        'amount_plan',
        'amount_fact',
        'is_vat',
        'directions',
        'directions_history',
        'direction_waypoints',
        'progress',
        'rating_terms',
        'register_trans_terms',
        'meta_data',
        'show_without_delay',
        'created_at',
        'updated_at',
        'deleted_at',
        'amount_partner',
        'partner_vat',
        'partner_payment_type_id',
        'partner_payment_term_id',
        'completed_at',
    ];

    protected $hidden = ['show_without_delay'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'meta_data'          => 'array',
        'directions'         => 'array',
        'progress'           => 'array',
        'show_without_delay' => 'array',
    ];


    public static function boot()
    {
        parent::boot();

        self::created(function($order){

            $max_inner = Order::where('user_id', $order->user_id)->max('inner_id');
            if(is_null($max_inner))
                $max_inner = 1;
            else
                $max_inner++;

            $order->update(['inner_id' => $max_inner]);
        });
    }

	/**
	 * @return mixed
	 */
	public function payment_type()
	{
		return $this->belongsTo(OrderPaymentType::class, 'payment_type_id');
	}

	/**
	 * @return mixed
	 */
	public function payment_term()
	{
		return $this->belongsTo(OrderPaymentTerm::class, 'payment_term_id');
	}

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'current_status_id');
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
        $status = Status::where('name', $status)->first();

        $this->current_status_id = $status ? $status->id : 0;

        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status()->first();
    }

    /**
     * @param string $status
     * @return bool
     */
    public function hasStatus($status)
    {
        return $this->getStatus()->name == $status;
    }

    /**
     * @return array
     */
    public function placesDelivery()
    {
        $arr    = [];
        $places = $this->addresses()->get()->toArray();

        for ($i = 0; $i < count($places); $i++) {
            $arr[$places[$i]['type']][] = $places[$i];
        }

        return $arr;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this
            ->belongsToMany('App\Models\Address', 'order_addresses')
            ->withPivot('date_at', 'type')
            //->wherePivot('type','unloading')
            ->orderBy('order_addresses.date_at', 'ASC');
    }

    public function orderAddress()
    {
        return $this
            ->hasMany(OrderAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function addressesUnloading()
    {
        return $this
            ->hasMany('App\Models\Relationships\OrderAddress')
            ->where('type', 'unloading')
            ->orderBy('date_at', 'DESC');
    }

    /**
     * Find companies in the system that have the same shipping type as the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suitablePerformers()
    {
        return $this->hasMany('App\Models\SpecializationUser', 'specialization_id', 'transport_cat_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class)->orderBy('price');
    }

    public function suitableOffers()
    {
        return $this->hasMany('App\Models\Order\OfferOrder');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function performers(){
        return $this->hasMany(OrderPerformer::class);
    }

    /**
     * @return string
     */
    public function getCategoryName()
    {
        return $this->hasOne(Category::class, 'id', 'transport_cat_id')->value('name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'transport_cat_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cargo()
    {
        return $this->hasOne('App\Models\Order\Cargo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function clientOrder()
    {
        return $this->hasOne('App\Models\ClientOrder');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function loadingType()
	{
		return $this->belongsToMany(CargoLoadingType::class, 'order_cargo_loading', 'order_id', 'loading_type_id')->withTimestamps();
	}

    /**
     * @return mixed
     */
    public function specializationName()
    {
        return $this->hasOne('App\Models\Specialization', 'id', 'specialization_id')->first()->name;
    }


    public function geo()
    {
        return $this->hasMany(OrderGeo::class)->limit(500);
    }

    /**
     * @return Model|null|static
     */
    public function latestGeo()
    {
        return $this->hasMany(OrderGeo::class)->latest()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transports()
    {
        return $this->belongsToMany(Transport::class, 'order_performers', 'order_id', 'transport_id')->wherePivot('deleted_at', null);
    }

    /**
     * @return Model|null|static
     */
    public function geoTransport()
    {
        $geo = $this->latestGeo();

        return $geo ? Transport::where('id', $geo->transport_id)->first() : null;
    }

    /**
     * @return bool
     */
    public function isLike($userId)
    {
        return $this->belongsToMany(User::class, 'likes')
            ->where('user_id', $userId)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profitability()
    {
        return $this->hasOne(Profitability::class);
    }


    public function isEditablePoints(){

        $user = Auth::user();
        $creator = $this->owner()->first();

        if(($user->isLogist() || $creator->isLogistic()) && ($creator->id == $user->id || $user->id == $this->parent_id) && $this->status()->first()->name == OrderStatus::PLANNING)
            return true;
        else
            return false;
    }

    public function isOrderFromClient($userId = null){

		if($userId == null){
		    $userId = $this->user_id;
	    }

        $client =  \App\Models\User::find($userId);

        if($client->hasRole(\App\Enums\UserRoleEnums::CLIENT)){
            return $client;
        }

        return false;
    }


    /**
     * @return Model|null|static
     */
    public function Clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function scopePerformerExecutor($query, $users){
        if(is_array($users)){
            return $query->whereHas('performers', function($q) use ($users){
                $q->whereIn('user_id', $users);
            });
        }

        return $query->whereHas('performers', function($q) use ($users){
            $q->whereIn('user_id', $users);
        });
    }

    public function testimonial(){
        return $this->hasMany('App\Models\Transport\Testimonial');
    }

    public function history(){
        return $this->hasMany('App\Models\Order\OrderStatusHistory');
    }

    public function scopeStatus($query, $status_id){
		return $query->where('current_status_id', $status_id);
    }
}
