<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guests;
use App\Models\User;

class GuestRecordController extends Controller
{
    public function export_excel()
    {
        $guests = Guests::select('first_name', 'middle_name', 'last_name', 'visit_purpose', 'id_presented', 'visit_date', 'time_in', 'time_out')->orderBy('created_at', 'desc')->get();

        $admin = User::where('type', '1')->first();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="visitors-login-record.xls"');

        echo "Admin: " . $admin->first_name . " " . $admin->last_name . "\t\n";
        echo "Date Exported: " . date('Y-m-d') . "\t\n";
        echo "Total records: " . count($guests) . "\t\n";
        echo "\t\n";

        echo "First Name\tMiddle Name\tLast Name\tPurpose\tID Presented\tDate\tTime In\tTime Out\n";

        foreach ($guests as $guest) {
            $time_out = $guest->time_out ? date('h:i A', strtotime($guest->time_out)) : '-';
            echo $guest->first_name . "\t" . 
            $guest->middle_name . "\t" . 
            $guest->last_name . "\t" . 
            $guest->visit_purpose . "\t" . 
            $guest->id_presented . "\t" .
            $guest->visit_date . "\t" . 
            date('h:i A', strtotime($guest->time_in)) . "\t" . 
            $time_out . "\n";
        }
        exit();
    }

    public function index(){
        return view('guest_login');
    }

    public function visit_guest_record(){
        $guests = Guests::orderBy('created_at', 'desc')->paginate(5);
        $noResult = $guests->isEmpty();
        return view ('guest_record', compact('guests', 'noResult'));
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

    public function update_guest_record(Request $request)
    {
        try {
            $guest_id = $request->input('guest_id');
            $first_name = $request->input('first_name');
            $middle_name = $request->input('middle_name');
            $last_name = $request->input('last_name');
            $visit_purpose = $request->input('visit_purpose');
            $id_presented = $request->input('id_presented');
            $visit_date = $request->input('visit_date');
            $time_in = $request->input('time_in');
            $time_out = $request->input('time_out');
    
            if (preg_match('/[0-9]/', $first_name) || preg_match('/[0-9]/', $middle_name) || preg_match('/[0-9]/', $last_name)) {
                return redirect()->back()->with('error', 'Please enter valid information.');
            }

            $guest = Guests::findOrFail($guest_id);
    
            $guest->first_name = $first_name;
            $guest->middle_name = $middle_name;
            $guest->last_name = $last_name;
            $guest->visit_purpose = $visit_purpose;
            $guest->id_presented = $id_presented;
            $guest->visit_date = $visit_date;
            $guest->time_in = $time_in;
            $guest->time_out = $time_out;
    
            $guest->save();
    
            return redirect()->back()->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Editing record failed. Please try again.');
        }
    }
    

    public function store(Request $request){
        $validatedData = $request->validate([
            'first_name' => 'nullable|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'visit_purpose' => 'nullable|string',
            'id_presented' => 'nullable|string',
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

    public function log_time_out(Request $request){
        $validatedData = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'time_out' => 'required|date_format:H:i|after:time_in',
        ]);
    
        $guest = Guests::find($validatedData['guest_id']);
        $guest->time_out = $validatedData['time_out'];
        $time_out_logged = $guest->save();
        
        if ($time_out_logged) {
            return response()->json(['success' => true, 'message' => 'Time out logged successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Logging time out failed. Please try again.']);
        }
    }

    public function search_guest_record(Request $request)
    {
        $search = $request->input('search');

        $guests = Guests::where('first_name', 'LIKE', "%$search%")
            ->orWhere('middle_name', 'LIKE', "%$search%")
            ->orWhere('last_name', 'LIKE', "%$search%")
            ->orWhere('visit_purpose', 'LIKE', "%$search%")
            ->orWhere('visit_date', 'LIKE', "%$search%")
            ->orWhere('id_presented', 'LIKE', "%$search%")
            ->orWhere('time_in', 'LIKE', "%$search%")
            ->orWhere('time_out', 'LIKE', "%$search%")
            ->paginate(5);

        $noResult = $guests->isEmpty();

        return view('guest_record', compact('guests', 'noResult'));
    }
}
