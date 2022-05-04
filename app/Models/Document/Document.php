<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order;
use App\Models\Document\DocumentSign;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $table = 'documents';

    protected $fillable = [
        'name', 'filename', 'template_id', 'user_id_added', 'document_type_id', 'imagetable_id', 'imagetable_type', 'verified',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'imagetable_id', 'imagetable_type',
    ];

    public function type()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }

    public function getName()
    {
        return $this->type()->first()->name;
    }

    /**
     * Get all of the owning imagetable models.
     */
    public function imagetable()
    {
        return $this->morphTo();
    }

    static public function storeDocumentToDB($order_id, $template_id, $template_slug, $template_filename, $userId = null){
	    Document::query()->create([
		    'name'            => $template_slug,
		    'filename'        => $template_filename,
		    'user_id_added'   => ($userId) ? $userId : \Auth::id(),
		    'template_id'     => $template_id,
		    'document_type_id'=> DocumentType::whereName("order_document")->value('id'),
		    'imagetable_id'   => $order_id,
		    'imagetable_type' => Order::class,
	    ]);
    }

	/**
	 * @deprecated
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function documents_item(){
	    return $this->belongsTo('App\Models\Document\DocumentItem', 'template_id', 'id');
    }

	public function documents_form(){
		return $this->belongsTo('App\Models\Document\DocumentForms', 'template_id', 'id');
	}

	public function graph_signature()
	{
		return $this->hasMany('App\Models\Document\Document', 'imagetable_id','id');
	}

	public function signature()
	{
		return $this->hasMany('App\Models\Document\DocumentSign');
	}

	public function mobileid()
	{
		return $this->hasMany('App\Models\Signature');
	}

	/**
	 * TODO remake
	 *
	 * @return bool
	 */
	public function isSigned()
	{

		$sign = $this->signature;

		$userId = auth()->id();

		$filtered = $sign->filter(function ($value, $key) use ($userId) {
			return $value['user_id'] == $userId;
		});

		$signed_own = $filtered->unique('user_id')->count();
		$signed = $sign->unique('user_id')->count();


		if($signed_own == 0){
			return -1; // false
		} else if($signed != 0 && $signed == $signed_own) {
			return 0; // wait for client/cargo
		} else if($signed > $signed_own){
			return 1; // true
		} else {
			return -1; // false
		}
	}
}
