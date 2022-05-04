<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\Transport\Transport;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * @param $transportId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFreeAjax($transportId)
    {
        $transport = Transport::findOrFail($transportId);

        $currentDriver = $transport->drivers()->first();
        $freeDrivers   = (new RoleUser())->getDrivers(\Auth::user()->id, true);
        $drivers       = [];

        $html = '';


        if ($currentDriver) {
            $currentDriver->license = $currentDriver->meta_data['driver_licence'];
            array_push($drivers, collect($currentDriver)->only('id', 'name', 'phone', 'license'));

            $html .= '<option value="0">' . trans('all.no_chosen') . '</option>';
            $html .= '<option value="' . $currentDriver->id . '" selected>' . $currentDriver->name . '</option>';
        }

        if ($freeDrivers->count()) {
            foreach ($freeDrivers as $driver) {
                $driver->license = json_decode($driver->meta_data, true)['driver_licence'];
                array_push($drivers, collect($driver)->only('id', 'name', 'phone', 'license'));

                $html .= '<option value="' . $driver->id . '">' . $driver->name . '</option>';
            }
        }

        if (!$currentDriver && !$freeDrivers->count()) {
            $html .= '<option value="0" disabled>' . trans('all.empty_list') . '</option>';
        }

        $html .= '<option value="0" class="AddNewItem" data-url-add="'.route('user.profile').'?redirectTo='.route
            ('transport.index').'#add_staff">' . trans('profile.add_employee') . '</option>';

        return response()->json(['status' => 'success', 'html' => $html, 'drivers' => $drivers]);
    }
}
