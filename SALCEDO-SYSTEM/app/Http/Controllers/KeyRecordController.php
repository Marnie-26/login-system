<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Key;
use App\Models\User;

class KeyRecordController extends Controller
{
    public function visit_log_key(){
        return view('log_key');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'unit_no' => 'nullable|string',
            'authorized_by' => 'required|in:unit_owner,tenant',
            'contractor_name' => 'nullable|string',
            'borrow_purpose' => 'nullable|string',
            'borrow_date' => 'nullable|date',
            'time_borrowed' => 'nullable|date_format:H:i',
        ]);
    
     
        $key = new Key();
        $key->fill($validatedData);
        $saved = $key->save();
        
        if($saved){
            return redirect('/visit-log-key')->with('success', "Key record saved successfully!");
        }else{
            return redirect('/visit-log-key')->with('error', "Saving key record failed. Please try again.");
        }
    }

    public function view_key_record(){
        $keys = Key::orderBy('created_at', 'desc')->paginate(5);
        $noResult = $keys->isEmpty();
        return view ('key_record', compact('keys', 'noResult'));
    }

    public function log_time_returned(Request $request){
        $validatedData = $request->validate([
            'key_id' => 'required|exists:keys,id',
            'time_returned' => 'required|date_format:H:i',
        ]);
    
        $key = Key::find($validatedData['key_id']);
        $key->time_returned = $validatedData['time_returned'];
        $time_returned_logged = $key->save();
        
        if ($time_returned_logged) {
            return response()->json(['success' => true, 'message' => 'Time returned logged successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Logging time returned failed. Please try again.']);
        }
    }

    public function keys_export_excel(){
        $keys = Key::select('unit_no', 'authorized_by', 'contractor_name', 'borrow_purpose', 'borrow_date', 'time_borrowed', 'time_returned')->orderBy('created_at', 'desc')->get();

        $admin = User::where('type', '1')->first();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="keys-monitoring-record.xls"');

        echo "Admin: " . $admin->first_name . " " . $admin->last_name . "\t\n";
        echo "Date Exported: " . date('Y-m-d') . "\t\n";
        echo "Total records: " . count($keys) . "\t\n";
        echo "\t\n";

        echo "Unit No.\tAuthorized by\tContractor\tPurpose\tDate\tTime Borrowed\tTime Returned\n";

        foreach ($keys as $key) {
            $time_returned = $key->time_returned ? date('h:i A', strtotime($key->time_returned)) : '-';
            $authorized_by_display = $key->authorized_by == 'unit_owner' ? 'Unit Owner' : ($key->authorized_by == 'tenant' ? 'Tenant' : $key->authorized_by);

            echo $key->unit_no . "\t" . 
            $authorized_by_display . "\t" . 
            $key->contractor_name . "\t" . 
            $key->borrow_purpose . "\t" . 
            $key->borrow_date . "\t" .
            date('h:i A', strtotime($key->time_borrowed)) . "\t" . 
            $time_returned . "\n";
        }
        exit();
    }

    public function search_key_record(Request $request)
    {
        $search = $request->input('search_key');

        if (strtolower($search) == 'unit owner') {
            $search = 'unit_owner';
        } elseif (strtolower($search) == 'tenant') {
            $search = 'tenant';
        }

        $searchTime = $search;
        if (preg_match('/\d{1,2}:\d{2} (AM|PM)/i', $search, $matches)) {
            $searchTime = \Carbon\Carbon::createFromFormat('h:i A', $search)->format('H:i:s');
        } else {
            $searchTime = $search;
        }

        $keys = Key::where('unit_no', 'LIKE', "%$search%")
            ->orWhere('authorized_by', 'LIKE', "%$search%")
            ->orWhere('contractor_name', 'LIKE', "%$search%")
            ->orWhere('borrow_purpose', 'LIKE', "%$search%")
            ->orWhere('borrow_date', 'LIKE', "%$search%")
            ->orWhere('time_borrowed', 'LIKE', "%$searchTime%")
            ->orWhere('time_returned', 'LIKE', "%$searchTime%")
            ->paginate(20);

        $noResult = $keys->isEmpty();

        return view('key_record', compact('keys', 'noResult'));
    }

    public function delete_key_record($id){
        $key = Key::find($id);
        if ($key) {
            $key->delete();
            return redirect('/view-key-record')->with('success', "Key's record deleted successfully.");
        } else {
            return redirect('/view-key-record')->with('error', "Key's record not found.");
        }
    }

    public function update_key_record(Request $request)
    {
        try {
            $key_id = $request->input('key_id');
            $unit_no = $request->input('unit_no');
            $authorized_by = $request->input('authorized_by');
            $contractor_name = $request->input('contractor_name');
            $borrow_purpose = $request->input('borrow_purpose');
            $borrow_date = $request->input('borrow_date');
            $time_borrowed = $request->input('time_borrowed');
            $time_returned = $request->input('time_returned');

            $key = Key::findOrFail($key_id);
    
            $key->unit_no = $unit_no;
            $key->authorized_by = $authorized_by;
            $key->contractor_name = $contractor_name;
            $key->borrow_purpose = $borrow_purpose;
            $key->borrow_date = $borrow_date;
            $key->time_borrowed = $time_borrowed;
            $key->time_returned = $time_returned;
    
            $key->save();
    
            return redirect()->back()->with('success', 'Key record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Editing key record failed. Please try again.');
        }
    }
}
