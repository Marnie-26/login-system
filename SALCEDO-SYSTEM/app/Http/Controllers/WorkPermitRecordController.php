<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkPermit;
use App\Models\User;

class WorkPermitRecordController extends Controller
{
    public function visit_log_permit(){
        return view('log_work_permit');
    }

    public function view_permit_record(){
        $work_permits = WorkPermit::orderBy('created_at', 'desc')->paginate(5);
        $noResult = $work_permits->isEmpty();
        return view ('work_permit_record', compact('work_permits', 'noResult'));
    }

    public function delete_permit_record($id){
        $work_permit = WorkPermit::find($id);
        if ($work_permit) {
            $work_permit->delete();
            return redirect('/view-permit-record')->with('success', "Work permit's record deleted successfully.");
        } else {
            return redirect('/view-permit-record')->with('error', "Work permit's record not found.");
        }
    }

    public function permits_export_excel(){
        $work_permits = WorkPermit::select('unit_no', 'resident_name', 'work_scope', 'date_from', 'date_to', 'contractor_name', 'contact_person')->orderBy('created_at', 'desc')->get();

        $admin = User::where('type', '1')->first();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="work-permit-record.xls"');

        echo "Admin: " . $admin->first_name . " " . $admin->last_name . "\t\n";
        echo "Date Exported: " . date('Y-m-d') . "\t\n";
        echo "Total records: " . count($work_permits) . "\t\n";
        echo "\t\n";

        echo "Unit No.\tResident / Owner\tDetailed scope of work\tDate From\tDate To\tContractor\tContact Person\n";

        foreach ($work_permits as $work_permit) {
            echo $work_permit->unit_no . "\t" . 
            $work_permit->resident_name . "\t" . 
            $work_permit->work_scope . "\t" . 
            $work_permit->date_from . "\t" . 
            $work_permit->date_to  . "\t" .
            $work_permit->contractor_name . "\t" .
            $work_permit->contact_person . "\n";
        }

        exit();
    }

    
    public function store(Request $request){
        $validatedData = $request->validate([
            'unit_no' => 'nullable|string',
            'resident_name' => 'nullable|string',
            'work_scope' => 'nullable|string',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'contractor_name' => 'nullable|string',
            'contact_person' => 'nullable|string',
        ]);
    
        // Regular expression to check for numbers
        $pattern = '/\d/';
     
        if(preg_match($pattern, $validatedData['resident_name']) || preg_match($pattern, $validatedData['contact_person'])){
            return redirect('/visit-log-permit')->with('error', "Please enter a valid information for Resident Name or Contact Person.");
        }else{
            $work_permit = new WorkPermit();
            $work_permit->fill($validatedData);
            $saved = $work_permit->save();
            
            if($saved){
                return redirect('/visit-log-permit')->with('success', "Work permit record saved successfully!");
            }else{
                return redirect('/visit-log-permit')->with('error', "Saving work permit record failed. Please try again.");
            }
        }
    }

    public function update_permit_record(Request $request)
    {
        try {
            $permit_id = $request->input('permit_id');
            $unit_no = $request->input('unit_no');
            $resident_name = $request->input('resident_name');
            $work_scope = $request->input('work_scope');
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            $contractor_name = $request->input('contractor_name');
            $contact_person = $request->input('contact_person');

            if (preg_match('/[0-9]/', $resident_name) || preg_match('/[0-9]/', $contact_person)) {
                return redirect()->back()->with('error', 'Please enter a valid information for Resident Name or Contact Person.');
            }

            $work_permit = WorkPermit::findOrFail($permit_id);
    
            $work_permit->unit_no = $unit_no;
            $work_permit->resident_name = $resident_name;
            $work_permit->work_scope = $work_scope;
            $work_permit->date_from = $date_from;
            $work_permit->date_to = $date_to;
            $work_permit->contractor_name = $contractor_name;
            $work_permit->contact_person = $contact_person;
            $work_permit->save();
    
            return redirect()->back()->with('success', 'Work permit record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Editing work permit record failed. Please try again.');
        }
    }

    public function search_permit_record(Request $request)
    {
        $search = $request->input('search_permit');

        $work_permits = WorkPermit::where('unit_no', 'LIKE', "%$search%")
            ->orWhere('resident_name', 'LIKE', "%$search%")
            ->orWhere('work_scope', 'LIKE', "%$search%")
            ->orWhere('date_from', 'LIKE', "%$search%")
            ->orWhere('date_to', 'LIKE', "%$search%")
            ->orWhere('contractor_name', 'LIKE', "%$search%")
            ->orWhere('contact_person', 'LIKE', "%$search%")
            ->paginate(20);

        $noResult = $work_permits->isEmpty();

        return view('work_permit_record', compact('work_permits', 'noResult'));
    }
}
