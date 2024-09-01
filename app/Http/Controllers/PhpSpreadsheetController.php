<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\SoilData;

class PhpSpreadsheetController extends Controller
{
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'excel_file' => 'required|file|mimes:xlsx,xls'
    //     ]);

    //     $file = $request->file('excel_file');
    //     $filePath = $file->getPathname();

    //     try {
    //         $spreadsheet = IOFactory::load($filePath);
    //         $worksheet = $spreadsheet->getActiveSheet();

    //         // Color all cells
    //         $highestRow = $worksheet->getHighestRow();
    //         $highestColumn = $worksheet->getHighestColumn();
    //         $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);


    //         for ($row = 2; $row <= $highestRow; $row++) {
    //             for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //                 $cell = $worksheet->getCellByColumnAndRow($col, $row);
    //                 $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE);
    //             }
    //         }

    //         // Array to keep track of values in the second column and their occurrences
    //         $sampleNumbers = [];

    //         // First pass: identify duplicates
    //         for ($row = 2; $row <= $highestRow; $row++) {
    //             $cell = $worksheet->getCellByColumnAndRow(2, $row);
    //             $cellValue = $cell->getValue();
    //             if (!isset($sampleNumbers[$cellValue])) {
    //                 $sampleNumbers[$cellValue] = 0;
    //             }
    //             $sampleNumbers[$cellValue]++;
    //         }


    //         for ($row = 2; $row <= $highestRow; $row++) {
    //             for ($col = 1; $col <= $highestColumnIndex; $col++) {
    //                 $cell = $worksheet->getCellByColumnAndRow($col, $row);
    //                 $cellValue = $cell->getValue();

    //                 if ($cellValue === null) {
    //                     continue;
    //                 }

    //                 // Duplicate Sample Number
    //                 if ($col == 2) {
    //                     if ($sampleNumbers[$cellValue] > 1) {
    //                         // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         //     ->getStartColor()->setARGB(Color::COLOR_RED);

    //                         $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                             ->getStartColor()->setARGB('FFFFCCCC'); // Light red color

    //                     }
    //                 }

    //                 // Land Type
    //                 if ($col == 4) {
    //                     $cellValueLower = strtolower($cellValue);
    //                     $allowedValues = ["hl", "mhl", "mll", "vll"];
    //                     if (!in_array($cellValueLower, $allowedValues)) {
    //                         // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         //     ->getStartColor()->setARGB(Color::COLOR_RED);

    //                         $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                             ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                     } else {
    //                         // land type == hl s < 0 || s > 50
    //                         // land type == vll s < 0 || s > 400
    //                         if ($cellValueLower == "hl" || $cellValueLower == "vll") {
    //                             $specificCell = $worksheet->getCellByColumnAndRow(16, $row);
    //                             $specificValue = $specificCell->getValue();

    //                             if (($cellValueLower == "hl" && ($specificValue < 0 || $specificValue > 50)) ||
    //                                 ($cellValueLower == "vll" && ($specificValue < 0 || $specificValue > 400))
    //                             ) {
    //                                 // $specificCell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                                 //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                                 $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                                     ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                             }
    //                         }
    //                     }
    //                 }


    //                 // Texture
    //                 if ($col == 7) {
    //                     $cellValueLower = strtolower($cellValue);
    //                     $allowedValues = ["sand", "sandyloam", "sandy loam", "loam", "clayloam", "clay loam", "clay"];
    //                     if (!in_array($cellValueLower, $allowedValues)) {
    //                         // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                         $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                             ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                     }
    //                 }

    //                 // EC
    //                 if ($col == 8 && $cellValue == 0) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 // pH
    //                 if ($col == 9 && ($cellValue < 3 || $cellValue > 9)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 // N
    //                 if ($col == 12 && ($cellValue < 0 || $cellValue > 1)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 // K
    //                 if ($col == 15 && ($cellValue < 0 || $cellValue > 1)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 //S
    //                 if ($col == 16 && $cellValue == 0) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 // Ca
    //                 if ($col == 19 && ($cellValue < 0 || $cellValue > 50)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 // Mg
    //                 if ($col == 20 && ($cellValue < 0 || $cellValue > 15)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }

    //                 // Ca > Mg
    //                 if ($col == 19) {
    //                     $cellMg = $worksheet->getCellByColumnAndRow($col + 1, $row);
    //                     $cellValueMg = $cellMg->getValue();
    //                     if ($cellValue < $cellValueMg) {
    //                         // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                         // $cellMg->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         //     ->getStartColor()->setARGB(Color::COLOR_RED);


    //                         $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                             ->getStartColor()->setARGB('FFFFCCCC'); // Light red color

    //                         $cellMg->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                             ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                     }
    //                 }

    //                 // Zn
    //                 if ($col == 17 && ($cellValue < 0 || $cellValue > 15)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color

    //                 }

    //                 // B
    //                 if ($col == 18 && ($cellValue < 0 || $cellValue > 4)) {
    //                     // $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                     //     ->getStartColor()->setARGB(Color::COLOR_RED);
    //                     $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('FFFFCCCC'); // Light red color
    //                 }
    //             }
    //         }

    //         // Save the modified file
    //         $writer = new Xlsx($spreadsheet);
    //         $outputFilePath = storage_path('app/public/Validated_file(C&GIS).xlsx');
    //         $writer->save($outputFilePath);

    //         return response()->download($outputFilePath)->deleteFileAfterSend(true);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Unable to read the file: ' . $e->getMessage()], 500);
    //     }
    // }

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

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Soil Data Submitted Successfully!');
    }
}
