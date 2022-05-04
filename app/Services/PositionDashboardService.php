<?php

namespace App\Services;

use Illuminate\Http\Request;

class PositionDashboardService
{
    // Location drag&drop block
    public $userDataName;

    // Dashboard block
    public $userDashboardDataName;
    public $userDashboardChildDataName;
    public $userDashboardChildDataNameTwo;

    public function __construct()
    {
        // Location drag&drop block
        $this->userDataName = 'locations_modal_blocks';

        // Dashboard block
        $this->userDashboardDataName = 'locations_dashboard_blocks';
        $this->userDashboardChildDataName = 'locations_dashboard_child_blocks';
        $this->userDashboardChildDataNameTwo = 'locations_dashboard_child_blocks_two';
    }

    public function ajaxPosDashboard(Request $request, UserDataService $user_data_service)
    {
        $user = auth()->user();

        if ($request->ajax() && $request->has('position')) {
            // for block sorting
            $user_data_service->set($user->id, $this->userDataName, $request->position, true);
            return response()->json();
        }

        if ($request->ajax() && $request->has('position_dashboard')) {
            $user_data_service->set($user->id, $this->userDashboardDataName, $request->position_dashboard, true);
            return response()->json();
        }

        if ($request->ajax() && $request->has('position_dashboard_child')) {
            $user_data_service->set($user->id, $this->userDashboardChildDataName, $request->position_dashboard_child, true);
            return response()->json();
        }

        if ($request->ajax() && $request->has('position_dashboard_child_two')) {
            $user_data_service->set($user->id, $this->userDashboardChildDataNameTwo, $request->position_dashboard_child_two, true);
            return response()->json();
        }
    }
}