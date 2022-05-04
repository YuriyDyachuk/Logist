<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Throwable
     */
    public function show($id)
    {
        $template = Template::query()->where('id', $id)
            ->with(['order.addresses', 'order.cargo'])->first();

        $template->order->directions = null;

        return response()->json(['status' => 'OK', 'data' => $template]);
    }
}
