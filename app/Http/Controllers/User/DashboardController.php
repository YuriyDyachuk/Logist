<?php

namespace App\Http\Controllers\User;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\UserDataService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexDashboard(UserDataService  $userDataService)
    {
        $user = Auth::user();
        $userBlockModalPositions = $userDataService->get($user->id, 'locations_dashboard_blocks', true);
        $userBlockModalPositionsChild = $userDataService->get($user->id, 'locations_dashboard_child_blocks', true);
        $userBlockModalPositionsChildTwo = $userDataService->get($user->id, 'locations_dashboard_child_blocks_two', true);

        return view('dashboard.index', [
            'user' => $user,
            'positions' => $userBlockModalPositions,
            'positions_child' => $userBlockModalPositionsChild,
            'positions_child_two' => $userBlockModalPositionsChildTwo,
        ]);
    }
}
