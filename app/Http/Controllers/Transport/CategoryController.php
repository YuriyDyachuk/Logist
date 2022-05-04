<?php

namespace App\Http\Controllers\Transport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transport\Category;
use App\Models\Transport\RollingStockType;

class CategoryController extends Controller
{
    /**
     * Get transport type or rolling stock type for transport category.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse JSON
     */
    public function getTypeOrRollingStock(Request $request)
    {
        $id       = $request->get('categoryId') ?? Category::whereName('semitrailer')->value('id');
        $status   = 'success';
        $groups   = array();
        $category = array();

        if ($id == 'auto' || $id == 'trailer') {
            $id = Category::whereName('semitrailer')->value('id');
        }

        if ($request->type == 'type' && $id > 0) {
            $category = Category::getType($id);
        }

        if ($request->type == 'rollingStock' && $id > 0) {
            $groups = Category::isSpecial($id) ? [] : RollingStockType::getGroups();

            // Translation
            foreach ($groups as $item) {
                $item->name_lang = trans('handbook.' . $item->name);
            }

            $category = Category::find($id)->rollingStockType;
        }

        // Translation
        foreach ($category as $item) {
            $item->name_lang = trans('handbook.' . $item->name);
        }

        $locale = app()->getLocale();

        return response()->json(compact('status', 'groups', 'category', 'id', 'locale'));
    }
}
