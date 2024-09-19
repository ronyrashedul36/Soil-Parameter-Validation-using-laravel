<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UpazilaNirdesika;
use App\Models\SoilData;
use App\Models\soil_data;

class UpazilaNirdesikhaController extends Controller
{


    public function store(Request $request)
    {
        $data = $request->validate([
            'division' => 'required|string',
            'district' => 'required|string',
            'upazila' => 'required|string',
            'pdf' => 'required|file|mimes:pdf', // Assuming you're storing file uploads
            'year' => 'required|integer',
        ]);

        // Handle file upload
        if ($request->hasFile('pdf')) {
            $pdfFile = $request->file('pdf');
            $filename = time() . '.' . $pdfFile->getClientOriginalExtension();

            // Move the uploaded file to the desired directory
            $pdfFile->move(public_path('assets'), $filename);

            UpazilaNirdesika::create([
                'Division' => $data['division'],
                'District' => $data['district'],
                'Upazila' => $data['upazila'],
                'FilePath' => $filename,
                'Year' => $data['year'],
            ]);

            return redirect()->back()->with('success', 'Data has been stored successfully!');
        } else {
            // Handle error if no file is uploaded
            return redirect()->back()->withErrors(['pdf' => 'Please select a PDF file to upload.']);
        }
    }
    public function show()
    {
        $data = UpazilaNirdesika::all();
        return view('/demo', compact('data'));
    }

    public function show1()
    {
        // $data = SoilData::all();
        $data = SoilData::whereIn('approval', ['Approved'])->get();
        return view('/soilchemicaldata', compact('data'));
    }


    public function download(Request $request, $FilePath)
    {
        return response()->download(public_path('assets/' . $FilePath));
    }

    public function delete($id)
    {
        $upazilaNirdesika = UpazilaNirdesika::findOrFail($id);
        $upazilaNirdesika->delete();

        return redirect()->back()->with('success', 'Upazila Nirdesika deleted successfully!');
    }


    public function edit($id)
    {
        $data = UpazilaNirdesika::find($id);
        return view('edit', compact('data'));
    }

    public function editsoilchemicaldata($id)
    {
        $data = SoilData::find($id);
        return view('editsoilchemicaldata', compact('data'));
    }

    public function update_data(Request $request, $id)
    {
        $UpazilaNirdesika = UpazilaNirdesika::find($id);

        $UpazilaNirdesika->Division = $request->input('division');
        $UpazilaNirdesika->District = $request->input('district');
        $UpazilaNirdesika->Upazila = $request->input('upazila');

        // Handle file upload if a new file is provided
        if ($request->hasFile('pdf')) {
            $pdfFile = $request->file('pdf');
            $filename = time() . '.' . $pdfFile->getClientOriginalExtension();

            // Move the uploaded file to the desired directory
            $pdfFile->move(public_path('assets'), $filename);

            // Update FilePath field
            $UpazilaNirdesika->FilePath = $filename;
        }

        $UpazilaNirdesika->Year = $request->input('year');
        $UpazilaNirdesika->update();

        return redirect('demo')->with('success', 'Data updated successfully');
    }


    public function update_soilchemicaldata(Request $request, $id)
    {
        $SoilData = SoilData::find($id);

        $SoilData->division = $request->input('division');
        $SoilData->district = $request->input('district');
        $SoilData->upazila = $request->input('upazila');
        $SoilData->year = $request->input('year');
        $SoilData->fid = $request->input('fid');
        $SoilData->smpl_no = $request->input('smpl_no');
        $SoilData->mu = $request->input('mu');
        $SoilData->land_type = $request->input('land_type');
        $SoilData->soil_series = $request->input('soil_series');
        $SoilData->soil_group = $request->input('soil_group');
        $SoilData->texture = $request->input('texture');
        $SoilData->ec = $request->input('ec');
        $SoilData->ph = $request->input('ph');
        $SoilData->ea = $request->input('ea');
        $SoilData->om = $request->input('om');
        $SoilData->n = $request->input('n');
        $SoilData->po = $request->input('po');
        $SoilData->pb = $request->input('pb');
        $SoilData->k = $request->input('k');
        $SoilData->s = $request->input('s');
        $SoilData->zn = $request->input('zn');
        $SoilData->b = $request->input('b');
        $SoilData->ca = $request->input('ca');
        $SoilData->mg = $request->input('mg');
        $SoilData->cu = $request->input('cu');
        $SoilData->fe = $request->input('fe');
        $SoilData->mn = $request->input('mn');
        $SoilData->upz_code = $request->input('upz_code');

        $SoilData->update();

        return redirect('soilchemicaldata')->with('success', 'Data updated successfully');
    }

    public function deletesoilchemicaldata($id)
    {
        $SoilData = SoilData::findOrFail($id);
        $SoilData->delete();

        return redirect()->back()->with('success', 'soil chemical data deleted successfully!');
    }
}
