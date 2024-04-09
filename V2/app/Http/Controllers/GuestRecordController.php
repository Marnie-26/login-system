<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guests;

class GuestRecordController extends Controller
{
    public function index(){
        return view('guest_login');
    }

    public function visit_guest_record(){
        $guests = Guests::all();
        return view ('guest_record', compact('guests'));
    }

    public function delete_guest_record($id){
        $guest = Guests::find($id);
        if ($guest) {
            $guest->delete();
            return redirect('/visit-guest-record')->with('success', "Visitor's record deleted successfully.");
        } else {
            return redirect('/visit-guest-record')->with('error', "Visitor's record not found.");
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'first_name' => 'nullable|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'visit_purpose' => 'nullable|string',
            'visit_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'time_in' => 'nullable|date_format:H:i',
        ]);

        // Regular expression to check for numbers
        $pattern = '/\d/';
    
        // Check if any of the fields contain numbers
        if (preg_match($pattern, $validatedData['first_name']) ||
            preg_match($pattern, $validatedData['middle_name']) ||
            preg_match($pattern, $validatedData['last_name'])) {
            return redirect('/guest-login')->with('error', "Please enter a valid information.");
        } else {
            $guest = new Guests();
            $guest->fill($validatedData);
            $saved = $guest->save();
            
            if($saved){
                return redirect('/guest-login')->with('success', "Visitor's record saved successfully!");
            }
        }
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin-login');
    }
}
