<?php

namespace App\Http\Controllers\User;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\PartnerStatus;
use App\Models\Handbook\PaymentType;
use App\Models\Role;
use App\Models\Transport\Testimonial;
use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Config;
use DB;

use Hash;
use App\Http\Controllers\ImageController;
use Validator;


class ProfileController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $user_current = Auth::user();
	    $user = $id ? User::findOrFail($id): Auth::user();

        $user->metaDataToArray();

        $user_company = $user;

        $func = $user->company['meta_data'];
        $resCompany = json_decode($func);

        if ($user->getRoleName() === \App\Enums\UserRoleEnums::LOGIST) {
            $user_company = User::find($user->parent_id);
        }

        $roles    = Role::getMainRoles()->get();

        if(!checkPaymentAccess('staff_manager')) {
	        // if not features with staff - logist, manager
	        $roles = $roles->filter( function ( $value, $key ) {
		        if($value->children){
			        unset($value->children[1]); // logist
			        unset($value->children[2]); // manager
		        }
		        return $value;
	        });
        }

        $paymentTypes = PaymentType::allStaff();
        $staffs       = $user_company->getStaffs();

        foreach ($staffs as $staff) {
            $staff->metaDataToArray();
            $staff->role_id = $staff->roles->first()->id;
            $staff->role_name = $staff->roles->first()->name;
            $staff->role_parent_id = $staff->roles->first()->parent_id;
            $staff->role_can_admin = $staff->roles->first()->can_admin;
        }

        $partners = $user_company->getPartners();

	    // user can see partner profile page
	    if($id && Partner::isPartner($user_current->id, $id) === null && !$user_current->isClient()){
			abort(404);
	    }

	    // if user client ... in offer
	    if($id && $user_current->isClient()){
			$order = new \App\Models\Order\Order();
		    if($order->isUserSentOffer($id)){
			    abort(404);
		    }
	    }

        $partner_statuses = PartnerStatus::statuses();

        foreach ($roles as $k => $role)
        {
			if($role->children->isNotEmpty()){
	            foreach ($role->children as $kChild => $child) {
                    $roles[$k]->children[$kChild]->name = trans('all.' . $roles[$k]->children[$kChild]->name);
	            }
	        }
        }

        $testimonials_all = Testimonial::whereCompanyId($user_company->id)->whereNotNull('rating')->get();
        $testimonials_rating_count = $testimonials_all->count();
        $testimonials_rating_sum = $testimonials_all->sum('rating');

        if($testimonials_rating_count > 0){
            $testimonials_rating = (int)round($testimonials_rating_sum / $testimonials_rating_count);
        }
        else {
            $testimonials_rating = 0;
        }

        $testimonials = Testimonial::whereCompanyId($user_company->id)->whereNotNull('comment')->with('driver')->paginate(2);

        if ($request->ajax() && $request->has('action') && $request->action == 'testimonials') {
            $view = view('profile.partials.testimonial-comments', compact('testimonials'))->render();
            return response()->json(['status' => 'ok', 'html' => $view]);
        }


        return view('profile.profile', compact('user','resCompany', 'partners', 'partner_statuses', 'staffs', 'roles', 'paymentTypes', 'testimonials', 'testimonials_rating'));
    }

    public function set_helper($helper){
        $user = Auth::user();
        $user->metaDataToArray();
        $meta = $user->meta_data;
        $meta['helpers'][$helper] = 1;
        $user->update(['meta_data' => $meta]);

        return response()->json(['result' => true]);
    }

}
