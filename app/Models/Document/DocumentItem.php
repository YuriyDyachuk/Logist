<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order;
use Auth;
use DB;
use App\Models\User;

class DocumentItem extends Model
{
    protected $table = 'documents_items';

	protected $fillable = [
		'slug',
		'format'
	];

//	public static function documentsList()
//    {
//        $doc = new DocumentItem();
//        $order = new Order();
//        $user = Auth::user();
//
//        $docs = DocumentItem::select('*', $order->getTable().'.id as entity_id', $doc->getTable().'.id as item_id')
//            ->join($order->getTable(), $order->getTable().'.id', '=', $order->getTable().'.id')
//            ->where($order->getTable().'.user_id', $user->id);
//
//        return $docs;
//    }
//
//
//	public static function allDocuments()
//    {
//        $docs = self::documentsList();
//		return $docs->paginate(10);
//	}
//
//	public function contragent()
//    {
//        return $this->user_id ? User::find($this->user_id) : null;
//    }
}
