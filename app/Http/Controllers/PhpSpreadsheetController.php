<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\SoilData;
use App\Exports\SoilDataExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Validator;
use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;
use App\Models\Signup;
use App\Models\UpazilaNirdesika;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Spreadsheet;
use App\Models\SoilPhysicalData;

class PhpSpreadsheetController extends Controller
{

    public function uploadSoilPhysicalData(Request $request)
    {
        // Validation rules
        $request->validate([
            'division' => 'required|string',
            'district' => 'required|string',
            'upazila' => 'required|string',
            'year' => 'required|numeric|min:1900|max:2500',
            'land_type' => 'required|string|max:255',
            'soil_group' => 'required|string|max:255',
            'sg_area' => 'required|string|max:255',
            'texture' => 'required|string|max:255',
            'consistency' => 'required|string|max:255',
            'drainage' => 'required|string|max:255',
            'moisture' => 'required|string|max:255',
            'recession' => 'required|string|max:255',
            'relief' => 'required|string|max:255',
        ]);

        try {
            // Storing the data
            $soilPhysicalData = new SoilPhysicalData();
            $soilPhysicalData->division = $request->division;
            $soilPhysicalData->district = $request->district;
            $soilPhysicalData->upazila = $request->upazila;
            $soilPhysicalData->year = $request->year;
            $soilPhysicalData->land_type = $request->land_type;
            $soilPhysicalData->soil_group = $request->soil_group;
            $soilPhysicalData->sg_area = $request->sg_area;
            $soilPhysicalData->texture = $request->texture;
            $soilPhysicalData->consistency = $request->consistency;
            $soilPhysicalData->drainage = $request->drainage;
            $soilPhysicalData->moisture = $request->moisture;
            $soilPhysicalData->recession = $request->recession;
            $soilPhysicalData->relief = $request->relief;

            $soilPhysicalData->save();

            // Success message
            return redirect()->back()->with('success', 'Soil physical data has been successfully uploaded.');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'An error occurred while uploading the data. Please try again later.');
        }
    }

    public function getUpazilaNirdesikhaCount()
    {
        // Query the database to get soil chemical data
        $totalDistinctUpazilaNirdesikha = UpazilaNirdesika::select('Upazila')
            ->distinct()
            ->count('Upazila');

        return response()->json(['totalDistinctUpazilaNirdesikha' => $totalDistinctUpazilaNirdesikha]);
    }
    // Example controller function
    public function getSoilChemicalDataCount()
    {
        // Query the database to get soil chemical data
        $totalDistinctUpazilas = SoilData::select('upazila')
            ->distinct()
            ->count('upazila');

        return response()->json(['totalDistinctUpazilas' => $totalDistinctUpazilas]);
    }


    public function approveRequest(Request $request)
    {
        $request->validate([
            'division' => 'required|string',
            'district' => 'required|string',
            'upazila' => 'required|string',
            'year' => 'required|numeric|min:1900|max:2500',
        ]);

        $division = $request->input('division');
        $district = $request->input('district');
        $upazila = $request->input('upazila');
        $year = $request->input('year');
        // Step 1: Check if data exists in the SoilData table
        $soilDataExists = SoilData::where('division', $division)
            ->where('district', $district)
            ->where('upazila', $upazila)
            ->where('year', $year)
            ->exists();
        if (!$soilDataExists) {
            return response()->json(['message' => 'No matching data found in the Database.'], 200);
        }
        // Check the user's role
        if (Auth::user()->role == 'admin') {
            // Step 2: Check if a message for the same combination already exists
            $existingMessage = Message::where('division', $division)
                ->where('district', $district)
                ->where('upazila', $upazila)
                ->where('year', $year)
                ->where('admin_id', Auth::id()) // Ensure the message is from the same admin
                ->exists();

            if (!$existingMessage) {
                // Step 3: Get all super admins
                $superAdmins = Signup::where('role', 'super admin')->get();

                // Step 4: Send a single message to all super admins
                foreach ($superAdmins as $superAdmin) {
                    Message::create([
                        'admin_id' => Auth::id(),  // current admin's ID
                        'admin_name' => Auth::user()->name,  // current admin's name
                        'receiver_id' => $superAdmin->id,  // super admin's ID
                        'message' => 'New data has been inserted by ' . Auth::user()->name,
                        'division' =>  $division,
                        'district' => $district,
                        'upazila' => $upazila,
                        'year' => $year,
                    ]);
                }
            }
        }

        if (Auth::user()->role == 'super admin') {
            SoilData::where('division', $division)
                ->where('district', $district)
                ->where('upazila', $upazila)
                ->where('year', $year)
                ->update(['approval' => 'Approved']);
        }
        return response()->json(['message' => 'Request sent successfully!'], 200);
        // Redirect back with a success message
        // return redirect()->back()->with('success', 'Request sent successfully!');
    }

    // super admin rejection message 
    public function rejectMessage(Request $request, $division, $district, $upazila, $year)
    {
        $rejectionMessage = $request->input('message');
        $newMessageforAdmin = Message::where('division', $division)
            ->where('district', $district)
            ->where('upazila', $upazila)
            ->where('year', $year)
            ->get()
            ->unique('receiver_id');
        // dd($newMessageforAdmin);
        $adminIds = Signup::where('role', 'admin')->pluck('id')->toArray();
        $super_admin = Signup::where('role', 'super admin')->pluck('id')->toArray();
        // dd($newMessageforAdmin);
        foreach ($newMessageforAdmin as $message) {
            $receiverId = $message->admin_id;  // Access the receiver_id
        }

        Message::create([
            'admin_id' => Auth::id(),  // current admin's ID
            'admin_name' => Auth::user()->name,  // current admin's name
            'receiver_id' => $receiverId,  // super admin's ID
            'message' => $rejectionMessage,
            'division' => $division,
            'district' => $district,
            'upazila' => $upazila,
            'year' => $year,
        ]);

        Message::where('division', $division)
            ->where('district', $district)
            ->where('upazila', $upazila)
            ->where('year', $year)
            ->whereIn('receiver_id', $super_admin)
            ->delete();

        SoilData::where('division', $division)
            ->where('district', $district)
            ->where('upazila', $upazila)
            ->where('year', $year)
            ->delete();

        return response()->json(['success' => true]);
    }

    // super admin data download function
    public function downloadExcel($division, $district, $upazila, $year)
    {
        $query = \App\Models\SoilData::query();

        if ($division) {
            $query->where('division', $division);
        }
        if ($district) {
            $query->where('district', $district);
        }
        if ($upazila) {
            $query->where('upazila', $upazila);
        }
        if ($year) {
            $query->where('year', $year);
        }

        $data = $query->get();
        if ($data->isEmpty()) {
            // If no data is found, return with a success message
            return redirect()->back()->with('success', 'No Soil Data Found for the selected criteria!');
        }
        // Generate CSV content
        $csvFileName = 'data_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
        $headers = ['Division', 'District', 'Upazila', 'fid', 'smpl_no', 'mu', 'land_type', 'soil_series', 'soil_group', 'texture', 'ec', 'ph', 'ea', 'om', 'n', 'po', 'pb', 'k', 's', 'zn', 'b', 'ca', 'mg', 'cu', 'fe', 'mn', 'upz_code', 'year'];

        // Return the response with the CSV file
        return response()->stream(
            function () use ($data, $headers) {
                $handle = fopen('php://output', 'w');

                // Handle fopen failure
                if ($handle === false) {
                    return response()->json(['error' => 'Could not open output stream'], 500);
                }

                // Add the headers
                fputcsv($handle, $headers);

                // Add the data rows
                foreach ($data as $row) {
                    fputcsv($handle, [
                        $row->division,
                        $row->district,
                        $row->upazila,
                        $row->fid,
                        $row->smpl_no,
                        $row->mu,
                        $row->land_type,
                        $row->soil_series,
                        $row->soil_group,
                        $row->texture,
                        $row->ec,
                        $row->ph,
                        $row->ea,
                        $row->om,
                        $row->n,
                        $row->po,
                        $row->pb,
                        $row->k,
                        $row->s,
                        $row->zn,
                        $row->b,
                        $row->ca,
                        $row->mg,
                        $row->cu,
                        $row->fe,
                        $row->mn,
                        $row->upz_code,
                        $row->year
                    ]);
                }

                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            ]
        );
    }

    public function deleteMessage($id)
    {
        $upazilaNirdesika = Message::findOrFail($id);
        $upazilaNirdesika->delete();

        return redirect()->back()->with('success', 'Message deleted successfully!');
    }

    public function updateMessageAndsoilData($division, $district, $upazila, $year)
    {
        $recordExists1 = SoilData::where('division', $division)
            ->where('district', $district)
            ->where('upazila', $upazila)
            ->where('year', $year)
            ->exists();


        $recordExists = Message::where('division', $division)
            ->where('district', $district)
            ->where('upazila', $upazila)
            ->where('year', $year)
            ->exists();

        if ($recordExists1 && $recordExists) {
            SoilData::where('division', $division)
                ->where('district', $district)
                ->where('upazila', $upazila)
                ->where('year', $year)
                ->update(['approval' => 'Approved']);

            $newMessageforAdmin = Message::where('division', $division)
                ->where('district', $district)
                ->where('upazila', $upazila)
                ->where('year', $year)
                ->get()
                ->unique('receiver_id');
            // dd($newMessageforAdmin);
            $adminIds = Signup::where('role', 'admin')->pluck('id')->toArray();
            $super_admin = Signup::where('role', 'super admin')->pluck('id')->toArray();
            // dd($newMessageforAdmin);
            foreach ($newMessageforAdmin as $message) {
                $receiverId = $message->admin_id;  // Access the receiver_id
            }
            if (in_array($receiverId, $adminIds)) {

                Message::create([
                    'admin_id' => Auth::id(),  // current admin's ID
                    'admin_name' => Auth::user()->name,  // current admin's name
                    'receiver_id' => $receiverId,  // super admin's ID
                    'message' => 'New data has been Approved by ' . Auth::user()->name,
                    'division' => $message->division,
                    'district' => $message->district,
                    'upazila' => $message->upazila,
                    'year' => $message->year,
                ]);
            }


            Message::where('division', $division)
                ->where('district', $district)
                ->where('upazila', $upazila)
                ->where('year', $year)
                ->whereIn('receiver_id', $super_admin)
                ->delete();

            // return response()->json(['status' => 'success', 'message' => 'Data updated successfully']);
            return redirect()->back()->with('success', 'Data updated successfully');
        } else {
            return redirect()->back()->with('success', 'Failed to update data');
        }
    }

    public function getData(Request $request)
    {
        $adminorsuper = Signup::where('id', Auth::id())->get();
        // // Assuming you're using a model called UpazilaData\

        $data = Message::select('id', 'division', 'district', 'upazila', 'year', 'message')->where('receiver_id', Auth::id())
            ->get();

        return response()->json($data);
    }


    public function getMessagesData()
    {
        if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin')) {
            $messages = Message::where('receiver_id', Auth::id())->get();
            $messageCount = $messages->count();

            return response()->json([
                'messageCount' => $messageCount,
                'messages' => $messages
            ]);
        }

        return response()->json(['messageCount' => 0, 'messages' => []]);
    }
    public function store(Request $request)
    {
        // Step 1: Insert the data (e.g., a new record in your table)
        $data = new Message();
        $data->field = $request->input('field');
        $data->save();

        // Step 2: Check if the current user is an admin
        if (Auth::user()->role == 'admin') {
            // Step 3: Get all super admins
            $superAdmins = Signup::where('role', 'super admin')->get();

            // Step 4: Send a message to each super admin
            foreach ($superAdmins as $superAdmin) {
                Message::create([
                    'admin_id' => Auth::id(),  // current admin's ID
                    'admin_name' => Auth::user()->name,  // current admin's name
                    'receiver_id' => $superAdmin->id,  // super admin's ID
                    'message' => 'New data has been inserted by admin.',
                ]);
            }
        }

        // Step 5: Redirect or return response
        return redirect()->back()->with('success', 'Data inserted and message sent to super admin(s).');
    }

    public function downloadNirdesikaData(Request $request)
    {
        $validatedData = $request->validate([
            'division2' => 'nullable|string|max:255',
            'district2' => 'nullable|string|max:255',
            'upazila2' => 'nullable|string|max:255',
            'year2' => 'nullable|numeric',
        ]);
        $division = $validatedData['division2'];
        $district = $validatedData['district2'];
        $upazila = $validatedData['upazila2'];
        $year = $validatedData['year2'];
        $query = \App\Models\UpazilaNirdesika::query();

        if ($division) {
            $query->where('Division', $division);
        }
        if ($district) {
            $query->where('District', $district);
        }
        if ($upazila) {
            $query->where('Upazila', $upazila);
        }
        if ($year) {
            $query->where('Year', $year);
        }

        $data = $query->get();
        if ($data->isEmpty()) {
            // If no data is found, return with a success message
            return redirect()->back()->with('success', 'No Soil Data Found for the selected criteria!');
        }
        // Generate CSV content
        $csvFileName = 'NirdesikaData_' . now()->format('Y_m_d_H_i_s') . '.csv';
        $headers = ['Division', 'District', 'Upazila', 'year'];

        // Return the response with the CSV file
        return response()->stream(
            function () use ($data, $headers) {
                $handle = fopen('php://output', 'w');

                // Handle fopen failure
                if ($handle === false) {
                    return response()->json(['error' => 'Could not open output stream'], 500);
                }

                // Add the headers
                fputcsv($handle, $headers);

                // Add the data rows
                foreach ($data as $row) {
                    fputcsv($handle, [
                        $row->Division,
                        $row->District,
                        $row->Upazila,
                        $row->Year
                    ]);
                }

                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            ]
        );
    }

    public function retrieveNirdesikaData(Request $request)
    {
        $validatedData = $request->validate([
            'division' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'upazila' => 'nullable|string|max:255',
            'year' => 'nullable|numeric',
        ]);
        $query = \App\Models\UpazilaNirdesika::query();
        // Apply filters based on the validated data
        if (!empty($validatedData['division'])) {
            $query->where('Division', $validatedData['division']);
        }

        if (!empty($validatedData['district'])) {
            $query->where('District', $validatedData['district']);
        }

        if (!empty($validatedData['upazila'])) {
            $query->where('Upazila', $validatedData['upazila']);
        }

        if (!empty($validatedData['year'])) {
            $query->where('Year', $validatedData['year']);
        }

        // Execute the query and get the results
        $results = $query->get();
        // dd($results);
        if (!$results->isEmpty()) {
            return redirect()->back()->with('success', 'Upazila Nirdesikha Data Found!');
        } else {
            return redirect()->back()->with('success', 'No Upazila Nirdesikha Data found for the provided criteria.');
        }

        // Return the results, for example, as a JSON response
        return response()->json($results);
    }
    public function requestCount()
    {
        // Assuming you have a model named `Request` or equivalent
        // that contains a column for the status of the request
        // e.g., 'status' => 'pending'

        try {
            // Query the database for the count of pending requests
            $totalPendingRequests = Request::where('status', 'pending')->count();

            // Return a JSON response with the count
            return response()->json([
                'success' => true,
                'data' => [
                    'totalRow' => $totalPendingRequests
                ]
            ]);
        } catch (\Exception $e) {
            // Handle any errors, such as database connection issues
            return response()->json([
                'success' => false,
                'message' => 'Error fetching pending requests',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/demo');
    }
    public function login(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ]);

        // Retrieve the user by email from the database
        $user = Signup::where('email', $validated['email'])->first();

        // Check if user exists and password matches
        if ($user && Hash::check($validated['password'], $user->password)) {
            // Log the user in using Laravel's Auth system
            Auth::login($user);  // Log in the user

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            Session::flash('debug', Auth::user()->name);
            // Redirect to the intended page or 'demo'
            // dd(Auth::user()->name);
            return redirect()->intended('demo');
        }

        // If authentication fails, return back with an error message
        return redirect()->back()->with('success', 'The provided credentials do not match our records.');
    }
    public function signin(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'organization' => 'required|string|max:255',
                'email' => 'required|email|unique:signups,email',
                'password' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'profession' => 'required|string|max:255',
                'purpose' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
            ]);

            // Hash the password
            $validated['password'] = Hash::make($validated['password']);

            // dd($validated['password']);
            // Create a new signup entry
            Signup::create($validated);

            // Redirect or return a response
            return redirect()->back()->with('success', 'Signup successful!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('success', 'The email has already been taken. Please use a different email address.');
        }
    }


    public function download(Request $request)
    {
        $validatedData = $request->validate([
            'division2' => 'nullable|string|max:255',
            'district2' => 'nullable|string|max:255',
            'upazila2' => 'nullable|string|max:255',
            'year2' => 'nullable|numeric',
        ]);
        // dd($validatedData['division2']);
        // Query the database based on the filter criteria

        $division = $validatedData['division2'];
        $district = $validatedData['district2'];
        $upazila = $validatedData['upazila2'];
        $year = $validatedData['year2'];
        $query = \App\Models\SoilData::query();

        if ($division) {
            $query->where('division', $division);
        }
        if ($district) {
            $query->where('district', $district);
        }
        if ($upazila) {
            $query->where('upazila', $upazila);
        }
        if ($year) {
            $query->where('year', $year);
        }



        $data = $query->get();
        if ($data->isEmpty()) {
            // If no data is found, return with a success message
            return redirect()->back()->with('success', 'No Soil Data Found for the selected criteria!');
        }
        // Generate CSV content
        $csvFileName = 'data_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
        $headers = ['Division', 'District', 'Upazila', 'fid', 'smpl_no', 'mu', 'land_type', 'soil_series', 'soil_group', 'texture', 'ec', 'ph', 'ea', 'om', 'n', 'po', 'pb', 'k', 's', 'zn', 'b', 'ca', 'mg', 'cu', 'fe', 'mn', 'upz_code', 'year'];

        // Return the response with the CSV file
        return response()->stream(
            function () use ($data, $headers) {
                $handle = fopen('php://output', 'w');

                // Handle fopen failure
                if ($handle === false) {
                    return response()->json(['error' => 'Could not open output stream'], 500);
                }

                // Add the headers
                fputcsv($handle, $headers);

                // Add the data rows
                foreach ($data as $row) {
                    fputcsv($handle, [
                        $row->division,
                        $row->district,
                        $row->upazila,
                        $row->fid,
                        $row->smpl_no,
                        $row->mu,
                        $row->land_type,
                        $row->soil_series,
                        $row->soil_group,
                        $row->texture,
                        $row->ec,
                        $row->ph,
                        $row->ea,
                        $row->om,
                        $row->n,
                        $row->po,
                        $row->pb,
                        $row->k,
                        $row->s,
                        $row->zn,
                        $row->b,
                        $row->ca,
                        $row->mg,
                        $row->cu,
                        $row->fe,
                        $row->mn,
                        $row->upz_code,
                        $row->year
                    ]);
                }

                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            ]
        );
    }




    public function retrieveData(Request $request)
    {
        $validatedData = $request->validate([
            'division' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'upazila' => 'nullable|string|max:255',
            'year' => 'nullable|numeric',
        ]);
        $query = \App\Models\SoilData::query();
        // Apply filters based on the validated data
        if (!empty($validatedData['division'])) {
            $query->where('division', $validatedData['division']);
        }

        if (!empty($validatedData['district'])) {
            $query->where('district', $validatedData['district']);
        }

        if (!empty($validatedData['upazila'])) {
            $query->where('upazila', $validatedData['upazila']);
        }

        if (!empty($validatedData['year'])) {
            $query->where('year', $validatedData['year']);
        }

        // Execute the query and get the results
        $results = $query->get();
        // dd($results);
        if (!$results->isEmpty()) {
            return redirect()->back()->with('success', 'Soil Data Found!');
        } else {
            return redirect()->back()->with('success', 'No Soil Data found for the provided criteria.');
        }

        // Return the results, for example, as a JSON response
        return response()->json($results);
    }

    public function processFile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240' // Optional: limit file size to 10MB
        ]);

        $file = $request->file('excel_file');
        $filePath = $file->getPathname();

        try {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // Color all cells
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE);
                }
            }

            // Track values in the second column for duplicates
            $sampleNumbers = [];

            // Identify duplicates
            for ($row = 2; $row <= $highestRow; $row++) {
                $cell = $worksheet->getCellByColumnAndRow(2, $row);
                $cellValue = $cell->getValue();
                if (!isset($sampleNumbers[$cellValue])) {
                    $sampleNumbers[$cellValue] = 0;
                }
                $sampleNumbers[$cellValue]++;
            }

            for ($row = 2; $row <= $highestRow; $row++) {
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $cellValue = $cell->getValue();

                    if ($cellValue === null) {
                        continue;
                    }

                    // Apply conditional formatting based on the rules provided
                    // Duplicate Sample Number
                    if ($col == 2 && $sampleNumbers[$cellValue] > 1) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // Land Type
                    if ($col == 4) {
                        $cellValueLower = strtolower($cellValue);
                        $allowedValues = ["hl", "mhl", "mll", "vll"];
                        if (!in_array($cellValueLower, $allowedValues)) {
                            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                        } else {
                            // Additional checks for land type
                            if ($cellValueLower == "hl" || $cellValueLower == "vll") {
                                $specificCell = $worksheet->getCellByColumnAndRow(16, $row);
                                $specificValue = $specificCell->getValue();

                                if (($cellValueLower == "hl" && ($specificValue < 0 || $specificValue > 50)) ||
                                    ($cellValueLower == "vll" && ($specificValue < 0 || $specificValue > 400))
                                ) {
                                    $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                                        ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                                }
                            }
                        }
                    }

                    // Texture
                    if ($col == 7) {
                        $cellValueLower = strtolower($cellValue);
                        $allowedValues = ["sand", "sandyloam", "sandy loam", "loam", "clayloam", "clay loam", "clay"];
                        if (!in_array($cellValueLower, $allowedValues)) {
                            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                        }
                    }

                    // EC
                    if ($col == 8 && $cellValue == 0) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // pH
                    if ($col == 9 && ($cellValue < 3 || $cellValue > 9)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // N
                    if ($col == 12 && ($cellValue < 0 || $cellValue > 1)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // K
                    if ($col == 15 && ($cellValue < 0 || $cellValue > 1)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // S
                    if ($col == 16 && $cellValue == 0) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // Ca
                    if ($col == 19 && ($cellValue < 0 || $cellValue > 50)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // Mg
                    if ($col == 20 && ($cellValue < 0 || $cellValue > 15)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // Ca > Mg
                    if ($col == 19) {
                        $cellMg = $worksheet->getCellByColumnAndRow($col + 1, $row);
                        $cellValueMg = $cellMg->getValue();
                        if ($cellValue < $cellValueMg) {
                            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                            $cellMg->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                        }
                    }

                    // Zn
                    if ($col == 17 && ($cellValue < 0 || $cellValue > 15)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }

                    // B
                    if ($col == 18 && ($cellValue < 0 || $cellValue > 4)) {
                        $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
                    }
                }
            }

            // Store the spreadsheet in session or temp storage
            $writer = new Xlsx($spreadsheet);
            $outputFilePath = storage_path('app/public/Processed_file.xlsx');
            $writer->save($outputFilePath);

            // Store the path in the session to be used in the download function
            session(['processed_file_path' => $outputFilePath]);
            return response()->json(['message' => 'File processed successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Unable to process the Excel file: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process the file: ' . $e->getMessage()], 500);
        }
    }

    public function downloadFile()
    {
        // Retrieve the file path from the session
        $filePath = session('processed_file_path');

        if (!$filePath || !file_exists($filePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        try {
            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Unable to download the file: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to download the file.'], 500);
        }
    }

    public function checkFileStatus()
    {
        $filePath = session('processed_file_path');

        if ($filePath && file_exists($filePath)) {
            return response()->json(['status' => 'processed'], 200);
        }

        return response()->json(['status' => 'not_processed'], 404);
    }


    // Soil Data Input Form
    public function storeSoilData(Request $request)
    {
        $validatedData = $request->validate([
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'fid' => 'nullable|numeric',
            'smpl_no' => 'nullable|numeric',
            'mu' => 'nullable|numeric',
            'land_type' => 'nullable|string|max:255',
            'soil_series' => 'nullable|string|max:255',
            'soil_group' => 'nullable|numeric',
            'texture' => 'nullable|string|max:255',
            'ec' => 'nullable|numeric',
            'ph' => 'nullable|numeric',
            'ea' => 'nullable|numeric',
            'om' => 'nullable|numeric',
            'n' => 'nullable|numeric',
            'po' => 'nullable|numeric',
            'pb' => 'nullable|numeric',
            'k' => 'nullable|numeric',
            's' => 'nullable|numeric',
            'zn' => 'nullable|numeric',
            'b' => 'nullable|numeric',
            'ca' => 'nullable|numeric',
            'mg' => 'nullable|numeric',
            'cu' => 'nullable|numeric',
            'fe' => 'nullable|numeric',
            'mn' => 'nullable|numeric',
            'upz_code' => 'nullable|numeric',
            'year' => 'required|numeric',
            'excel' => 'nullable|file|mimes:xlsx,xls'
        ]);

        // Create a new SoilData record using the validated data
        // SoilData::create($validatedData);
        if ($request->hasFile('excel')) {
            $file = $request->file('excel');
            $filePath = $file->getPathname();
            try {
                // Load the spreadsheet
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();

                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                for ($row = 2; $row <= $highestRow; $row++) {
                    $excelData = [
                        'division' => $validatedData['division'],
                        'district' => $validatedData['district'],
                        'upazila' => $validatedData['upazila']
                    ];
                    for ($col = 1; $col <= $highestColumnIndex; $col++) {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $cellValue = $cell->getValue();
                        switch ($col) {
                            case 1:
                                $excelData['fid'] = $cellValue;
                                break;
                            case 2:
                                $excelData['smpl_no'] = $cellValue;
                                break;
                            case 3:
                                $excelData['mu'] = $cellValue;
                                break;
                            case 4:
                                $excelData['land_type'] = $cellValue;
                                break;
                            case 5:
                                $excelData['soil_series'] = $cellValue;
                                break;
                            case 6:
                                $excelData['soil_group'] = doubleval($cellValue);
                                break;
                            case 7:
                                $excelData['texture'] = doubleval($cellValue);
                                break;
                            case 8:
                                $excelData['ec'] = doubleval($cellValue);
                                break;
                            case 9:
                                $excelData['ph'] = doubleval($cellValue);
                                break;
                            case 10:
                                $excelData['ea'] = doubleval($cellValue);
                                break;
                            case 11:
                                $excelData['om'] = doubleval($cellValue);
                                break;
                            case 12:
                                $excelData['n'] = doubleval($cellValue);
                                break;
                            case 13:
                                $excelData['po'] = doubleval($cellValue);
                                break;
                            case 14:
                                $excelData['pb'] = doubleval($cellValue);
                                break;
                            case 15:
                                $excelData['k'] = doubleval($cellValue);
                                break;
                            case 16:
                                $excelData['s'] = doubleval($cellValue);
                                break;
                            case 17:
                                $excelData['zn'] = doubleval($cellValue);
                                break;
                            case 18:
                                $excelData['b'] = doubleval($cellValue);
                                break;
                            case 19:
                                $excelData['ca'] = doubleval($cellValue);
                                break;
                            case 20:
                                $excelData['mg'] = doubleval($cellValue);
                                break;
                            case 21:
                                $excelData['cu'] = doubleval($cellValue);
                                break;
                            case 22:
                                $excelData['fe'] = doubleval($cellValue);
                                break;
                            case 23:
                                $excelData['mn'] = doubleval($cellValue);
                                break;
                            case 24:
                                $excelData['upz_code'] = doubleval($cellValue);
                                break;
                        }
                    }
                    $excelData['year'] = $validatedData['year'];

                    SoilData::create($excelData);
                }
            } catch (\Exception $e) {
                Log::error('Unable to process the Excel file: ' . $e->getMessage());
                return response()->json(['error' => 'Unable to process the file: ' . $e->getMessage()], 500);
            }
        } else {
            SoilData::create($validatedData);
        }

        if (Auth::user()->role == 'admin') {
            // Step 3: Get all super admins
            $superAdmins = Signup::where('role', 'super admin')->get();
            foreach ($superAdmins as $superAdmin) {
                Message::create([
                    'admin_id' => Auth::id(),  // current admin's ID
                    'admin_name' => Auth::user()->name,  // current admin's name
                    'receiver_id' => $superAdmin->id,  // super admin's ID
                    'message' => 'New data has been inserted by admin.',
                    'division' => $validatedData['division'],
                    'district' => $validatedData['district'],
                    'upazila' => $validatedData['upazila'],
                    'year' => $validatedData['year'],
                ]);
            }
        }

        if (Auth::user()->role == 'super admin') {
            SoilData::where('division', $validatedData['division'])
                ->where('district', $validatedData['district'])
                ->where('upazila', $validatedData['upazila'])
                ->where('year', $validatedData['year'])
                ->update(['approval' => 'Approved']);
        }
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Soil Data Submitted Successfully!');
    }
}
