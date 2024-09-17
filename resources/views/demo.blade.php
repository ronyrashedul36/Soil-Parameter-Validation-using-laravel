@include('developer')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Rashedul Islam">
    <title>Upazila Nirdesika</title>
    <!-- Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- use version 0.20.2 -->
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>


    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            /* Remove default margin */
            padding: 0;
            /* Remove default padding */
        }

        footer {
            background: #111;
            padding: 10px;
            text-align: center;
            color: #ffffff;
            font-size: 20px;
            margin-top: auto;
            width: 100%;
        }


        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-nav .nav-item:hover .dropdown-menu {
            display: block;
        }

        /* Optional: Adds a bit of padding to the dropdown items */
        .dropdown-menu {
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .navbar-nav {
            width: 100%;
            justify-content: space-around;
        }
    </style>
</head>

<body>

    <!-- <div class="container">
        <div class="row">

            <div class="col-lg-2 col-md-2 col-sm-2" style="margin-top: 10px; display: flex; justify-content: flex-end;">
                <img src="http://apps.barc.gov.bd/flipbook/flipbook/images/barc-logo.png?>" width="100" height="100" alt="">
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 text-center" style="margin-top: 20px;">
                <h2>Bangladesh Agricultural Research Council (BARC)</h2>
                <h3>New Airport Road, Farmgate, Dhaka - 1215</h3>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1" style="margin-top: 10px; display: flex; justify-content: flex-end; align-items: left;">

            </div>
        </div>
    </div> -->


    @include('header')

    <div class="container mt-2">
        <!-- <div class="text-center">
            <a class="btn btn-success" href="/soilvalidation">Soil Validation</a>
            <a class="btn btn-success" href="/inputform">Upload Upazila Nirdesika</a>
        </div> -->

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">

                <!-- Navbar Toggler for Mobile View -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- Dropdown with Hover Effect -->
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Soil Chemical Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/soilvalidation">Data Validate & Import</a>
                                <a class="dropdown-item" href="/soilsinglerowdataentry">Soil Data Entry</a>
                                <a class="dropdown-item" href="/soilchemicaldata">Soil Chemical Data</a>
                                <a class="dropdown-item" href="/reportofsoilchemicaldata">Report</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Upazila Nirdesika
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/demo">Nirdesika Management</a>
                                <a class="dropdown-item" href="/inputform">Upload</a>
                                <a class="dropdown-item" href="/upazilanirdesikareport">Report</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Soil Physical Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Upload Data</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Soil Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Land Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>


        @if(Session::has('success'))
        <div class="alert alert-success" role="alert" id="success-alert">
            {{ Session::get('success') }}
        </div>
        @endif
        <div class="flex-container">
            <h4>List of Upazila Nirdesika</h4>
        </div>

        <div>
            <table class="table" id="upazila_nirdesikas">
                <thead>
                    <tr>
                        <th>Division</th>
                        <th>District</th>
                        <th>Upazila</th>
                        <th>Download</th>
                        <th>Year</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->Division }}</td>
                        <td>{{ $item->District }}</td>
                        <td>{{ $item->Upazila }}</td>
                        <td><a href="{{ url('/download', $item->FilePath) }}">Download</a></td>
                        <td>{{ $item->Year }}</td>
                        <td>
                           
                            <a href="{{url('/edit', $item->id)}}" class="btn btn-primary editbtn">Edit</a>
                            <form action="{{ url('/delete', $item->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('institutionlogo')


    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Find the success alert element
            var successAlert = document.getElementById('success-alert');
            // If the success alert exists, set a timeout to hide it after 5 seconds (5000 milliseconds)
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#upazila_nirdesikas').DataTable();
        });


        // function searchTable() {
        //     var input, filter, table, tr, td, i, j, txtValue;
        //     input = document.getElementById("searchInput");
        //     filter = input.value.toUpperCase();
        //     table = document.getElementById("upazila_nirdesikas");
        //     tr = table.getElementsByTagName("tr");
        //     for (i = 0; i < tr.length; i++) {
        //         var found = false;
        //         for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
        //             td = tr[i].getElementsByTagName("td")[j];
        //             if (td) {
        //                 txtValue = td.textContent || td.innerText;
        //                 if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //                     found = true;
        //                 }
        //             }
        //         }
        //         tr[0].style.display = "";
        //         if (found) {
        //             tr[i].style.display = "";
        //         } else {
        //             tr[i].style.display = "none";
        //         }
        //     }
        // }
    </script>

    <!-- <script>

        // row, col, value & Message as report of errored cell after the existing value of excel file
        function readExcel() {
            var input = document.getElementById('excel');

            if (input.files.length === 0) {
                alert("Please select an Excel file.");
                return;
            }

            var file = input.files[0];

            if (file.name.split('.').pop() !== 'xls') {
                alert("Please select a .xlsx file.");
                return;
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, {
                    type: 'array'
                });
                var sheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[sheetName];
                var jsonData = XLSX.utils.sheet_to_json(worksheet);

                validateAndGenerateReport(jsonData, workbook, worksheet);
            };

            reader.readAsArrayBuffer(file);

            function validateAndGenerateReport(worksheetData, workbook, worksheet) {
                const reportEntries = [];
                const smplNoTracker = {};
                const muValues = new Set();

                const validTextures = new Set(["sand", "sandyloam", "loam", "clayloam", "clay", "sandy loam", "clay loam"]);
                const validLandTypes = new Set(["HL", "MHL", "MLL", "LL", "VLL"]);

                worksheetData.forEach((rowData, rowIndex) => {
                    const {
                        ph,
                        ec,
                        n,
                        texture: rawTexture,
                        land_type: landtype,
                        k,
                        smpl_no,
                        s,
                        ca,
                        mg,
                        zn,
                        b,
                        mu
                    } = rowData;
                    const texture = String(rawTexture).toLowerCase();

                    if (smpl_no) {
                        if (smplNoTracker[smpl_no]) {
                            smplNoTracker[smpl_no].count++;
                            smplNoTracker[smpl_no].rows.push(rowIndex + 2);
                        } else {
                            smplNoTracker[smpl_no] = {
                                count: 1,
                                rows: [rowIndex + 2]
                            };
                        }
                    }

                    if (ph < 3 || ph > 9) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'I', ph, 'outside ph range (3 < ph < 9)'));
                    }

                    if (ec === 0) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'H', ec, 'EC is 0 (EC != 0)'));
                    }

                    if (n < 0 || n > 1) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'L', n, 'outside N range (0 < N < 1)'));
                    }

                    if (texture && !validTextures.has(texture)) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'G', rawTexture, 'invalid texture (sand, sandyloam, loam, clayloam, clay, sandy loam, clay loam)'));
                    }

                    if (landtype && !validLandTypes.has(landtype)) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'D', landtype, 'invalid land type (HL, MHL, MLL, LL, VLL)'));
                    }

                    if (k < 0 || k > 1) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'O', k, 'outside K range (0 < K < 1)'));
                    }

                    if (landtype == "HL") {
                        if (0 > s || 50 < s) {
                            reportEntries.push(buildReportEntry(rowIndex + 2, 'P', s, 'outside S range (0 < S < 50)'));
                        }
                    }

                    if (landtype == "VLL") {
                        if (0 > s || 400 < s) {
                            reportEntries.push(buildReportEntry(rowIndex + 2, 'P', s, 'outside S range (0 < S < 400)'));
                        }
                    }

                    if (ca < 0 || ca > 50) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'S', ca, 'outside Ca range (0 < Ca < 50)'));
                    }

                    if (mg < 0 || mg > 15) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'T', mg, 'outside Mg range (0 < Mg < 15)'));
                    }

                    if (ca < mg) {
                        const combinedNumbers = `${ca},${mg}`;
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'T', combinedNumbers, 'Ca > Mg, 0 stands false'));
                    }

                    if (zn < 0 || zn > 15) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'Q', zn, 'outside Zn range (0 < zn < 5)'));
                    }

                    if (b < 0 || b > 4) {
                        reportEntries.push(buildReportEntry(rowIndex + 2, 'R', b, 'outside B range (0 < b < 4)'));
                    }

                    muValues.add(mu);
                    var muArray = Array.from(muValues);
                    var muMin = Math.min(...muArray);
                    var muMax = Math.max(...muArray);

                    for (let mu = muMin + 1; mu < muMax; mu++) {
                        if (!muValues.has(mu)) {
                            reportEntries.push(buildReportEntry(0, 'C', mu, `Missing Mapping Unit value`));
                        }
                    }
                });

                for (const [smpl_no, {
                        count,
                        rows
                    }] of Object.entries(smplNoTracker)) {
                    if (count > 1) {
                        rows.forEach(row => {
                            reportEntries.push(buildReportEntry(row, 'A', smpl_no, 'duplicate smpl_no'));
                        });
                    }
                }

                appendValidationReport(worksheet, reportEntries, workbook);
            }

            function buildReportEntry(row, col, value, message) {
                return {
                    row,
                    col,
                    value,
                    message
                };
            }

            function appendValidationReport(worksheet, reportEntries, workbook) {
                const range = XLSX.utils.decode_range(worksheet['!ref']);
                const startRow = range.e.r + 2; // Start after the last row of the existing data

                // Add header row for validation report
                XLSX.utils.sheet_add_aoa(worksheet, [
                    ['Row', 'Column', 'Value', 'Message']
                ], {
                    origin: startRow
                });

                // Add report entries to the worksheet
                XLSX.utils.sheet_add_json(worksheet, reportEntries, {
                    header: ['row', 'col', 'value', 'message'],
                    skipHeader: true,
                    origin: startRow + 1 // Add data after the header row
                });

                const wbout = XLSX.write(workbook, {
                    bookType: 'xlsx',
                    type: 'binary'
                });
                const blob = new Blob([s2ab(wbout)], {
                    type: 'application/octet-stream'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement("a");

                document.body.appendChild(a);
                a.style.display = "none";
                a.href = url;
                a.download = "Validation_Report.xlsx";
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            }

            function s2ab(s) {
                const buf = new ArrayBuffer(s.length);
                const view = new Uint8Array(buf);
                for (let i = 0; i < s.length; i++) {
                    view[i] = s.charCodeAt(i) & 0xFF;
                }
                return buf;
            }
        }
    </script> -->

    <script>
        // Message column is included after existing excel value where errors are described
        // function readExcel() {
        //     const input = document.getElementById('excel');

        //     if (input.files.length === 0) {
        //         alert("Please select an Excel file.");
        //         return;
        //     }

        //     const file = input.files[0];

        //     if (file.name.split('.').pop() !== 'xls' && file.name.split('.').pop() !== 'xlsx') { // Changed to check for .xlsx files
        //         alert("Please select a .xls/.xlsx file.");
        //         return;
        //     }

        //     const reader = new FileReader();

        //     reader.onload = function(e) {
        //         const data = new Uint8Array(e.target.result);
        //         const workbook = XLSX.read(data, {
        //             type: 'array'
        //         });
        //         const sheetName = workbook.SheetNames[0];
        //         const worksheet = workbook.Sheets[sheetName];
        //         const jsonData = XLSX.utils.sheet_to_json(worksheet);

        //         validateAndGenerateReport(jsonData, workbook, worksheet);
        //     };

        //     reader.readAsArrayBuffer(file);

        //     function validateAndGenerateReport(worksheetData, workbook, worksheet) {
        //         const smplNoTracker = {};
        //         const muValues = new Set();

        //         const validTextures = new Set(["sand", "sandyloam", "loam", "clayloam", "clay", "sandy loam", "clay loam"]);
        //         const validLandTypes = new Set(["HL", "MHL", "MLL", "LL", "VLL"]);

        //         const reportEntries = worksheetData.map((rowData, rowIndex) => {
        //             const {
        //                 ph,
        //                 ec,
        //                 n,
        //                 texture: rawTexture,
        //                 land_type: landtype,
        //                 k,
        //                 smpl_no,
        //                 s,
        //                 ca,
        //                 mg,
        //                 zn,
        //                 b,
        //                 mu
        //             } = rowData;
        //             const texture = String(rawTexture).toLowerCase();

        //             let messages = [];

        //             // Track sample numbers
        //             if (smpl_no) {
        //                 if (smplNoTracker[smpl_no]) {
        //                     smplNoTracker[smpl_no].count++;
        //                     smplNoTracker[smpl_no].rows.push(rowIndex + 2);
        //                 } else {
        //                     smplNoTracker[smpl_no] = {
        //                         count: 1,
        //                         rows: [rowIndex + 2]
        //                     };
        //                 }
        //             }

        //             // Validation checks
        //             if (ph < 3 || ph > 9) {
        //                 messages.push('pH outside range (3 < pH < 9)');
        //             }

        //             if (ec === 0) {
        //                 messages.push('EC is 0 (EC != 0)');
        //             }

        //             if (n < 0 || n > 1) {
        //                 messages.push('N outside range (0 < N < 1)');
        //             }

        //             if (texture && !validTextures.has(texture)) {
        //                 messages.push('Invalid texture (sand, sandyloam, loam, clayloam, clay, sandy loam, clay loam)');
        //             }

        //             if (landtype && !validLandTypes.has(landtype)) {
        //                 messages.push('Invalid land type (HL, MHL, MLL, LL, VLL)');
        //             }

        //             if (k < 0 || k > 1) {
        //                 messages.push('K outside range (0 < K < 1)');
        //             }

        //             if (landtype == "HL" && (0 > s || s > 50)) {
        //                 messages.push('S outside range for HL (0 < S < 50)');
        //             }

        //             if (landtype == "VLL" && (0 > s || s > 400)) {
        //                 messages.push('S outside range for VLL (0 < S < 400)');
        //             }

        //             if (ca < 0 || ca > 50) {
        //                 messages.push('Ca outside range (0 < Ca < 50)');
        //             }

        //             if (mg < 0 || mg > 15) {
        //                 messages.push('Mg outside range (0 < Mg < 15)');
        //             }

        //             if (ca < mg) {
        //                 messages.push('Ca < Mg, which is invalid');
        //             }

        //             if (zn < 0 || zn > 15) {
        //                 messages.push('Zn outside range (0 < Zn < 15)');
        //             }

        //             if (b < 0 || b > 4) {
        //                 messages.push('B outside range (0 < B < 4)');
        //             }

        //             muValues.add(mu);
        //             return {
        //                 ...rowData,
        //                 message: messages.join("; ")
        //             };
        //         });

        //         const muArray = Array.from(muValues);
        //         const muMin = Math.min(...muArray);
        //         const muMax = Math.max(...muArray);

        //         for (let mu = muMin + 1; mu < muMax; mu++) {
        //             if (!muValues.has(mu)) {
        //                 reportEntries.push({
        //                     message: `Missing Mapping Unit value: ${mu}`
        //                 });
        //             }
        //         }

        //         // Check for duplicate sample numbers
        //         for (const [smpl_no, {
        //                 count,
        //                 rows
        //             }] of Object.entries(smplNoTracker)) {
        //             if (count > 1) {
        //                 rows.forEach(row => {
        //                     const entry = reportEntries[row - 2];
        //                     entry.message = (entry.message ? entry.message + "; " : "") + 'Duplicate sample number';
        //                 });
        //             }
        //         }

        //         appendValidationReport(worksheet, reportEntries, workbook);
        //     }

        //     function appendValidationReport(worksheet, reportEntries, workbook) {
        //         const range = XLSX.utils.decode_range(worksheet['!ref']);
        //         const startRow = 0; // Start after the last row of the existing data

        //         // Add report entries to the worksheet
        //         XLSX.utils.sheet_add_json(worksheet, reportEntries, {
        //             origin: startRow
        //         });

        //         const wbout = XLSX.write(workbook, {
        //             bookType: 'xlsx',
        //             type: 'binary'
        //         });
        //         const blob = new Blob([s2ab(wbout)], {
        //             type: 'application/octet-stream'
        //         });
        //         const url = URL.createObjectURL(blob);
        //         const a = document.createElement("a");

        //         document.body.appendChild(a);
        //         a.style.display = "none";
        //         a.href = url;
        //         a.download = "Validation_Report.xlsx";
        //         a.click();
        //         window.URL.revokeObjectURL(url);
        //         document.body.removeChild(a);
        //         document.getElementById('excel').value = "";
        //     }

        //     function s2ab(s) {
        //         const buf = new ArrayBuffer(s.length);
        //         const view = new Uint8Array(buf);
        //         for (let i = 0; i < s.length; i++) {
        //             view[i] = s.charCodeAt(i) & 0xFF;
        //         }
        //         return buf;
        //     }
        // }
    </script>

    <script>
        //color a single cell
        // function readExcel() {

        //     //color a single cell
        //     const input = document.getElementById('excel');

        //     if (input.files.length === 0) {
        //         alert("Please select an Excel file.");
        //         return;
        //     }

        //     const file = input.files[0];

        //     if (file.name.split('.').pop() !== 'xls') { // Check for .xlsx files
        //         alert("Please select a .xlsx file.");
        //         return;
        //     }
        //     const reader = new FileReader();
        //     reader.onload = function(e) {
        //         const data = new Uint8Array(e.target.result);
        //         const workbook = XLSX.read(data, {
        //             type: 'array'
        //         });
        //         const sheetName = workbook.SheetNames[0];
        //         const worksheet = workbook.Sheets[sheetName];

        //         // Color a single cell
        //         colorCell(worksheet, 'A3');

        //         // Export the modified workbook
        //         exportWorkbook(workbook);
        //     };

        //     reader.readAsArrayBuffer(file);

        //     function colorCell(worksheet, cellAddress) {
        //         if (!worksheet[cellAddress]) {
        //             worksheet[cellAddress] = {
        //                 t: 's',
        //                 v: ''
        //             }; // Create cell if it doesn't exist
        //         }
        //         worksheet[cellAddress].s = {
        //             fill: {
        //                 fgColor: {
        //                     rgb: "FF0000" // red
        //                 }
        //             },
        //             font: {
        //                 name: 'Times New Roman',
        //                 sz: 16,
        //                 color: {
        //                     rgb: "#FF000000"
        //                 },
        //                 bold: true,
        //                 italic: false,
        //                 underline: false
        //             }
        //         }; // Red fill for the cell
        //     }

        //     function exportWorkbook(workbook) {
        //         const wbout = XLSX.write(workbook, {
        //             bookType: 'xlsx',
        //             type: 'binary'
        //         });
        //         const blob = new Blob([s2ab(wbout)], {
        //             type: 'application/octet-stream'
        //         });
        //         const url = URL.createObjectURL(blob);
        //         const a = document.createElement("a");

        //         document.body.appendChild(a);
        //         a.style.display = "none";
        //         a.href = url;
        //         a.download = "Colored_File.xlsx";
        //         a.click();
        //         window.URL.revokeObjectURL(url);
        //         document.body.removeChild(a);
        //     }

        //     function s2ab(s) {
        //         const buf = new ArrayBuffer(s.length);
        //         const view = new Uint8Array(buf);
        //         for (let i = 0; i < s.length; i++) {
        //             view[i] = s.charCodeAt(i) & 0xFF;
        //         }
        //         return buf;
        //     }
        // }
    </script>

    <script>
        //color whole sheet
        // function readExcel() {
        //     const input = document.getElementById('excel');

        //     if (input.files.length === 0) {
        //         alert("Please select an Excel file.");
        //         return;
        //     }

        //     const file = input.files[0];

        //     if (file.name.split('.').pop() !== 'xlsx') { // Check for .xlsx files
        //         alert("Please select a .xlsx file.");
        //         return;
        //     }

        //     const reader = new FileReader();

        //     reader.onload = function(e) {
        //         const data = new Uint8Array(e.target.result);
        //         const workbook = XLSX.read(data, {
        //             type: 'array'
        //         });
        //         const sheetName = workbook.SheetNames[0];
        //         const worksheet = workbook.Sheets[sheetName];
        //         const jsonData = XLSX.utils.sheet_to_json(worksheet, {
        //             header: 1,
        //             defval: ''
        //         });

        //         colorRows(worksheet, jsonData);

        //         exportWorkbook(workbook);
        //     };

        //     reader.readAsArrayBuffer(file);

        //     function colorRows(worksheet, worksheetData) {
        //         const range = XLSX.utils.decode_range(worksheet['!ref']);
        //         for (let rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
        //             for (let colNum = range.s.c; colNum <= range.e.c; colNum++) {
        //                 const cellRef = XLSX.utils.encode_cell({
        //                     r: rowNum,
        //                     c: colNum
        //                 });
        //                 if (!worksheet[cellRef]) {
        //                     worksheet[cellRef] = {
        //                         t: 's',
        //                         v: ''
        //                     }; // Create cell if it doesn't exist
        //                 }
        //                 worksheet[cellRef].s = {
        //                     fill: {
        //                         fgColor: {
        //                             rgb: "FF0000"
        //                         }
        //                     }
        //                 }; // Red fill for the row
        //             }
        //         }
        //     }

        //     function exportWorkbook(workbook) {
        //         const wbout = XLSX.write(workbook, {
        //             bookType: 'xlsx',
        //             type: 'binary'
        //         });
        //         const blob = new Blob([s2ab(wbout)], {
        //             type: 'application/octet-stream'
        //         });
        //         const url = URL.createObjectURL(blob);
        //         const a = document.createElement("a");

        //         document.body.appendChild(a);
        //         a.style.display = "none";
        //         a.href = url;
        //         a.download = "Colored_File.xlsx";
        //         a.click();
        //         window.URL.revokeObjectURL(url);
        //         document.body.removeChild(a);
        //     }

        //     function s2ab(s) {
        //         const buf = new ArrayBuffer(s.length);
        //         const view = new Uint8Array(buf);
        //         for (let i = 0; i < s.length; i++) {
        //             view[i] = s.charCodeAt(i) & 0xFF;
        //         }
        //         return buf;
        //     }
        // }
    </script>

    <script>
        // This code will generate excel file.
        //create new file which contains row, col, value & Message as report of errored cell 
        // function readExcel() {
        //     // Get the input element
        //     var input = document.getElementById('excel');

        //     // Check if any file is selected
        //     if (input.files.length === 0) {
        //         alert("Please select an Excel file.");
        //         return;
        //     }

        //     // Get the file
        //     var file = input.files[0];

        //     // Check if the file is of type .xlsx
        //     if (file.name.split('.').pop() !== 'xls') {
        //         alert("Please select a .xlsx file.");
        //         return;
        //     }

        //     // Initialize a FileReader
        //     var reader = new FileReader();

        //     // Set up the FileReader onload event handler
        //     reader.onload = function(e) {
        //         var data = new Uint8Array(e.target.result);
        //         var workbook = XLSX.read(data, {
        //             type: 'array'
        //         });
        //         var sheetName = workbook.SheetNames[0];
        //         var worksheet = workbook.Sheets[sheetName];
        //         var jsonData = XLSX.utils.sheet_to_json(worksheet);

        //         validateAndGenerateReport(jsonData); // Call the validation function
        //     };

        //     // Read the file as an array buffer
        //     reader.readAsArrayBuffer(file);

        //     function validateAndGenerateReport(worksheetData) {
        //         const reportEntries = [];
        //         const smplNoTracker = {};
        //         const muValues = new Set();

        //         const validTextures = new Set(["sand", "sandyloam", "loam", "clayloam", "clay", "sandy loam", "clay loam"]);
        //         const validLandTypes = new Set(["HL", "MHL", "MLL", "LL", "VLL"]);

        //         worksheetData.forEach((rowData, rowIndex) => {
        //             const {
        //                 ph,
        //                 ec,
        //                 n,
        //                 texture: rawTexture,
        //                 land_type: landtype,
        //                 k,
        //                 smpl_no,
        //                 s,
        //                 ca,
        //                 mg,
        //                 zn,
        //                 b,
        //                 mu
        //             } = rowData;
        //             const texture = String(rawTexture).toLowerCase();

        //             if (smpl_no) {
        //                 if (smplNoTracker[smpl_no]) {
        //                     smplNoTracker[smpl_no].count++;
        //                     smplNoTracker[smpl_no].rows.push(rowIndex + 2);
        //                 } else {
        //                     smplNoTracker[smpl_no] = {
        //                         count: 1,
        //                         rows: [rowIndex + 2]
        //                     };
        //                 }
        //             }

        //             if (ph < 3 || ph > 9) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'I', ph, 'outside ph range (3 < ph < 9)'));
        //             }

        //             if (ec === 0) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'H', ec, 'EC is 0 (EC != 0)'));
        //             }

        //             if (n < 0 || n > 1) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'L', n, 'outside N range (0 < N < 1)'));
        //             }

        //             if (texture && !validTextures.has(texture)) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'G', rawTexture, 'invalid texture (sand, sandyloam, loam, clayloam, clay, sandy loam, clay loam)'));
        //             }

        //             if (landtype && !validLandTypes.has(landtype)) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'D', landtype, 'invalid land type (HL, MHL, MLL, LL, VLL)'));
        //             }

        //             if (k < 0 || k > 1) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'O', k, 'outside K range (0 < K < 1)'));
        //             }

        //             if (landtype == "HL") {
        //                 if (0 > s || 50 < s) {
        //                     reportEntries.push(buildReportEntry(rowIndex + 2, 'P', s, 'outside S range (0 < S < 50)'));
        //                 }
        //             }

        //             if (landtype == "VLL") {
        //                 if (0 > s || 400 < s) {
        //                     reportEntries.push(buildReportEntry(rowIndex + 2, 'P', s, 'outside S range (0 < S < 400)'));
        //                 }
        //             }

        //             if (ca < 0 || ca > 50) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'S', ca, 'outside Ca range (0 < Ca < 50)'));
        //             }

        //             if (mg < 0 || mg > 15) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'T', mg, 'outside Mg range (0 < Mg < 15)'));
        //             }

        //             if (ca < mg) {
        //                 const combinedNumbers = `${ca},${mg}`;
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'T', combinedNumbers, 'Ca > Mg, 0 stands false'));
        //             }

        //             if (zn < 0 || zn > 15) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'Q', zn, 'outside Zn range (0 < zn < 5)'));
        //             }

        //             if (b < 0 || b > 4) {
        //                 reportEntries.push(buildReportEntry(rowIndex + 2, 'R', b, 'outside B range (0 < b < 4)'));
        //             }

        //             muValues.add(mu);
        //             var muArray = Array.from(muValues);
        //             var muMin = Math.min(...muArray);
        //             var muMax = Math.max(...muArray);

        //             // Store missing mu values between muMin and muMax
        //             for (let mu = muMin + 1; mu < muMax; mu++) {
        //                 if (!muValues.has(mu)) {
        //                     // reportEntries.push(buildReportEntry(0, 'C', mu, `Missing Mapping Unit value`));
        //                 }
        //             }



        //         });


        //         for (const [smpl_no, {
        //                 count,
        //                 rows
        //             }] of Object.entries(smplNoTracker)) {
        //             if (count > 1) {
        //                 rows.forEach(row => {
        //                     reportEntries.push(buildReportEntry(row, 'A', smpl_no, 'duplicate smpl_no'));
        //                 });
        //             }
        //         }
        //         downloadReport(reportEntries);
        //     }

        //     function buildReportEntry(row, col, value, message) {
        //         return {
        //             row,
        //             col,
        //             value,
        //             message
        //         };
        //     }

        //     function downloadReport(reportEntries) {
        //         const newWorkbook = XLSX.utils.book_new();
        //         const newWorksheet = XLSX.utils.aoa_to_sheet([
        //             ['Row', 'Column', 'Value', 'Message']
        //         ]);

        //         reportEntries.forEach(entry => {
        //             XLSX.utils.sheet_add_aoa(newWorksheet, [
        //                 [entry.row, entry.col, entry.value, entry.message]
        //             ], {
        //                 origin: -1
        //             });
        //         });

        //         XLSX.utils.book_append_sheet(newWorkbook, newWorksheet, "Validation_Report");

        //         const wbout = XLSX.write(newWorkbook, {
        //             bookType: 'xlsx',
        //             type: 'binary'
        //         });
        //         const blob = new Blob([s2ab(wbout)], {
        //             type: 'application/octet-stream'
        //         });
        //         const url = URL.createObjectURL(blob);
        //         const a = document.createElement("a");

        //         document.body.appendChild(a);
        //         a.style.display = "none";
        //         a.href = url;
        //         a.download = "Validation_Report.xlsx";
        //         a.click();
        //         window.URL.revokeObjectURL(url);
        //         document.body.removeChild(a);
        //     }

        //     function s2ab(s) {
        //         const buf = new ArrayBuffer(s.length);
        //         const view = new Uint8Array(buf);
        //         for (let i = 0; i < s.length; i++) {
        //             view[i] = s.charCodeAt(i) & 0xFF;
        //         }
        //         return buf;
        //     }



        //     function buildReportEntry(row, col, value, message) {
        //         return {
        //             row: row,
        //             col: col,
        //             value: value,
        //             message: message
        //         };
        //     }

        //     function downloadReport(reportEntries) {
        //         // Create a new workbook
        //         var newWorkbook = XLSX.utils.book_new();
        //         var newWorksheet = XLSX.utils.aoa_to_sheet([
        //             ['Row', 'Column', 'Value', 'Message'] // Header row
        //         ]);

        //         // Add report entries to the worksheet
        //         reportEntries.forEach(function(entry) {
        //             XLSX.utils.sheet_add_aoa(newWorksheet, [
        //                 [entry.row, entry.col, entry.value, entry.message]
        //             ], {
        //                 origin: -1 // Append to the end of the worksheet
        //             });
        //         });

        //         // Add the worksheet to the workbook
        //         XLSX.utils.book_append_sheet(newWorkbook, newWorksheet, "Validation_Report");

        //         // Write the workbook to a binary string
        //         var wbout = XLSX.write(newWorkbook, {
        //             bookType: 'xlsx',
        //             type: 'binary'
        //         });

        //         // Convert binary string to Blob
        //         var blob = new Blob([s2ab(wbout)], {
        //             type: 'application/octet-stream'
        //         });

        //         // Create a download link for the Excel file
        //         var url = URL.createObjectURL(blob);
        //         var a = document.createElement("a");
        //         document.body.appendChild(a);
        //         a.style = "display: none";
        //         a.href = url;
        //         a.download = "Validation_Report.xlsx";
        //         a.click();
        //         window.URL.revokeObjectURL(url);
        //     }

        //     function s2ab(s) {
        //         var buf = new ArrayBuffer(s.length);
        //         var view = new Uint8Array(buf);
        //         for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        //         return buf;
        //     }
        // }
    </script>



</body>



</html>