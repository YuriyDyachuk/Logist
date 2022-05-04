<?php

namespace App\Models\Transport;

use App\Enums\OrderStatus;
use App\Enums\TransportStatus;
use App\Models\Order\OrderPerformer;
use App\Models\Status;
use App\Models\Geo;
use App\Models\OrderGeo;
use App\Models\Order\Order;
use App\Models\Document\DocumentType;
use App\Models\Document\Document;
use App\Models\User;
use App\Traits\DocumentsRelations;
use App\Traits\ImagesRelations\ImagesRelations;

//use Tymon\JWTAuth\Providers\JWT\JWTInterface;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transport\RollingStockType;
use App\Models\Order\CargoLoadingType;

use App\Services\StatusService;

class Transport extends Authenticatable implements JWTSubject
{
    use SoftDeletes, ImagesRelations, DocumentsRelations;

    protected $table = 'transports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inner_id',
        'active',
        'login',
        'password',
        'remember_token',
        'user_id',
        'category_id',
        'rolling_stock_type_id',
        'type_id',
        'loading_type_id',
        'body_type',
        'number',
        'model',
        'year',
        'condition',
        'tonnage',
        'height',
        'length',
        'width',
        'volume',
        'tracker_imei',
        'status_id',
        'monitoring',
        'verified',
        'data',
        'last_login',
        'lat',
        'lng',
        'current_date',
        'current_order_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $dates = ['deleted_at'];

	// Rest omitted for brevity

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

    public static function boot()
    {
        parent::boot();

        self::creating(function($transport){

            $max_id = SELF::withTrashed()->max('id');
            if(is_null($max_id))
                $max_id = 1;
            else
                $max_id++;

            if ($transport->type_id == 4 || $transport->type_id == 5) {
                $max_inner = SELF::withTrashed()->where('user_id', $transport->user_id)->whereIn('type_id', [4,5])->max('inner_id');
            } else {
                $max_inner = SELF::withTrashed()->where('user_id', $transport->user_id)->whereIn('type_id', [2,3,6])->max('inner_id');
            }
            if(is_null($max_inner))
                $max_inner = 1;
            else
                $max_inner++;

            $transport->id = $max_id;
            $transport->inner_id = $max_inner;
            $transport->update(['id' => $transport->id, 'inner_id' => $transport->inner_id]);
        });

        self::updating(function($transport) {
            if ($transport->isDirty('status_id'))
            {
                (new StatusService)->updateTransportStatus($transport->id, $transport->status_id);
            }
        });
    }

    /**
     * @return mixed
     */
    public function getPassport()
    {
        $passport = $this->documents()
            ->where('document_type_id', DocumentType::search('technical_passport_transport')['id'])->get();

        if ($passport)
            return $passport;

        return new Document();
    }

    /**
     * @return bool
     */
    public function isTrailer()
    {
        $name = Category::getName($this->type_id);

        return $name == 'trailer' || $name == 'semitrailer';
    }

    /**
     * @return bool
     */
    public function isTractor()
    {
        return Category::getName($this->type_id) == 'tractor';
    }

    public function getTypeName()
    {
        return $this->hasOne(Category::class, 'id', 'type_id')->value('name') ?? null;
    }

    /**
     * @param integer $user
     * @return mixed
     */
    public function ableTrailers(int $user)
    {
        return $this->whereIn('type_id', Category::getTrailersId())
            ->where('user_id', $user);
    }

    /**
     * @param int $user
     * @return Transport
     */
    public function ableTrucks(int $user)
    {
        return $this->whereIn('type_id', Category::getTrucksId())
            ->where('user_id', $user)
            ->where('status_id', '!=', Status::getId(TransportStatus::FLIGHT))
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('transports as t2')
                    ->whereRaw('t2.parent_id = transports.id');
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAttachTrailer()
    {
        return $this->newQuery()
            ->where('parent_id', $this->id)
            ->get();
    }

    /**
     * @return $this
     */
    public function attachedTrailer()
    {
        return $this->where('parent_id', $this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|null|static[]
     */
    public function getAttachTruck()
    {
        return $this->newQuery()
            ->where('id', $this->parent_id)
            ->get();
    }

    /**
     * @return $this
     */
    public function attachedTruck()
    {
        return $this->where('id', $this->parent_id);
    }

    /**
     * @return mixed
     */
    public function getAttachedOrder()
    {
        return $this->orders->isNotEmpty() ? $this->orders->last() : null;

//        return $this->belongsToMany(Order::class, 'order_performers', 'transport_id', 'order_id')
//            ->where('rejected', 0)->latest()->first();
    }

    public function performers(){
        return $this->hasMany('App\Models\Order\OrderPerformer');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_performers', 'transport_id', 'order_id');
    }

    /**
     * @return mixed
     */
    public function getAttachedOrders()
    {
        return $this->belongsToMany(Order::class, 'order_performers', 'transport_id', 'order_id')->wherePivot('deleted_at', null)->orderBy('created_at', 'desc');
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
//     */
//    public function trailers()
//    {
//        return $this->belongsToMany('App\Models\Transport\Transport', 'auto_trailers', 'auto_id', 'trailer_id');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
//     */
//    public function tractors()
//    {
//        return $this->belongsToMany('App\Models\Transport\Transport', 'auto_trailers', 'trailer_id', 'auto_id');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function drivers()
    {
        return $this->belongsToMany('App\Models\User', 'transports_drivers');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function gps_parameters(){
		return $this->hasMany('App\Models\Transport\GpsParameterLast');
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasStatus($name)
    {
        return $this->status()->value('name') == $name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function geo()
    {
        return $this->hasMany(OrderGeo::class)->orderBy('datetime')->orderBy('id', 'desc');
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder|null
     */
    public function latestGeo()
    {
        return $this->hasMany(OrderGeo::class)->latest()->first();
    }

	public function latestGeoLastTwo()
	{
		return $this->hasMany(OrderGeo::class)->orderBy('datetime', 'desc')->orderBy('id', 'desc')->limit(5);
	}


    /**
     * @param $order_id
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder|null
     */
    public function geo_order($order_id){

        return $this->hasMany(Geo::class)->where('order_id', $order_id)->orderBy('created_at', 'desc');
    }

    public function isConnected(){
        return is_null($this->last_login) ? false : true;
    }

    public function rollingStockType(){
        return $this->hasOne(RollingStockType::class, 'id', 'rolling_stock_type_id');
    }

    public function loadingType()
    {
        return $this->belongsTo(CargoLoadingType::class, 'loading_type_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function activeScope($query){
        return $query->where('active', 1);
    }

    /**
     * Join user(s)
     * @param $query
     * @return mixed
     */
    public function scopeUsersJoin($query)
    {
        return $query->leftJoin(
            (new TransportDriver)->getTable(),
            (new self)->getTable() . '.id',
            '=',
            (new TransportDriver)->getTable() . '.transport_id'
        )->leftJoin(
            (new User)->getTable(),
            (new TransportDriver)->getTable() . '.user_id',
            '=',
            (new User)->getTable() . '.id'
        );
    }

    /**
     * Join order(s)
     * @param $query
     * @return mixed
     */
    public function scopeOrdersJoin($query)
    {
        return $query->leftJoin(
            (new OrderPerformer)->getTable(),
            (new self)->getTable() . '.id',
            '=',
            (new OrderPerformer)->getTable() . '.transport_id'
        )->leftJoin(
            (new Order)->getTable(),
            (new OrderPerformer)->getTable() . '.order_id',
            '=',
            (new Order)->getTable() . '.id'
        );
    }
}
