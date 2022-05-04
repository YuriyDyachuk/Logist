<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\SpecializationCats;
use App\SpecializationCatsRel;
use App\SpecializationDocs;
use App\SpecializationDocsRel;
use App\SpecializationUsersRel;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Specialization;

class SpecializationController extends Controller
{

    /**
     * Get specializations of user
     *
     * @param string $role
     * @return array $specializations
     */
    public static function get($role = null)
    {
        $specializations = [];

        if ($role) {
            $res = Role::where('name', $role)->first();
            $specializations = $res->specializations;
        } else {
            $specializations = Specialization::where('parent_id', 0)->get();
        }

//        foreach ($specializations as $specialization) {
//            $specialization->childs = $specialization->getChild()->toArray();
//        }

        return $specializations;
    }


    /**
     * Get specializations of user
     *
     * @return string json
     */
    public function getAjax()
    {
        $specializations = static::get(Auth::user()->getRole());

        foreach ($specializations as $specialization) {
            $specialization->name = trans('all.' . $specialization->name);
        }

        return json_encode(['result' => true, 'data' => $specializations]);
    }

    /**
     * Create specializations for user
     *
     * @param Request $request
     * @return string
     */
    public function saveAjax(Request $request)
    {
        $sp = array_unique($request->get('sp'));
        $user = Auth::user();
        $currentSpId = [];

        foreach ($user->specializations as $specialization) {
            $currentSpId[] = $specialization->id;
        }

        foreach ($sp as $item) {
            if ( ! in_array($item, $currentSpId)) {
                $user->specializations()->attach($item);
            }
        }

        return response()->json(['result' => true]);
    }
}
