<?php

namespace App\Http\Controllers;
use App\Models\Guests;
use App\Models\Key;
use App\Models\WorkPermit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function main_dashboard()
    {
        $guests = Guests::whereNull('deleted_at')->get();
        $keys = Key::whereNull('deleted_at')->get();
        $work_permits = WorkPermit::whereNull('deleted_at')->get();

        return view('main_dashboard', [
            'guests' => $guests,
            'keys' => $keys,
            'work_permits' => $work_permits
        ]);
    }
}
