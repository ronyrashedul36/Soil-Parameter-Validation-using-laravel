@include('developer')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Rashedul Islam">
    <title>Upazila Nirdesika</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- XLSX Library -->
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
    <style>
        .content {
            flex: 1;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

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
            /* Push footer to the bottom */
            width: 100%;
            /* Full width */
        }

        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 0px;
            padding-top: 0px;
            /* Adjust top margin */
        }

        .form-label-custom {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-group {
            text-align: center;
        }

        .btn-success {
            align-items: center;
            /* Align button to center horizontally */
            margin-top: 10px;
            /* Add some top margin for spacing */
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

    @include('header')
    <div class="container mt-2">

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
                                <a class="dropdown-item" href="/soilPhysicalData">Upload Data</a>
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

    </div>
    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2" style="margin-top: 10px; display: flex; justify-content: flex-start;">
                <!-- <a href="/demo" class="btn btn-secondary">Home</a> -->
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6"></div>
            <div class="col-lg-4 col-md-4 col-sm-4" style="margin-top: 10px; display: flex; justify-content: flex-end;">
                <a href="{{ asset('soil.xlsx') }}" download class="btn btn-danger">Excel File Format</a>
                <a href="{{ asset('rules.pdf') }}" download class="btn btn-danger ml-2">Rules</a>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- <form action="{{ route('PhpSpreadsheetController.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm"> -->
                <form action="{{ route('PhpSpreadsheetController.processFile') }}" method="POST" enctype="multipart/form-data" id="uploadForm">

                    @csrf
                    <div class="form-group">
                        <label for="excel_file" class="form-label-custom">Upload Excel File</label>
                        <input type="file" class="form-control-file" name="excel_file" id="excel_file" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" onclick="visibleDownload()">Process File</button>
                </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <button id="downloadButton" name="download" value="download" class="btn btn-success btn-block" onclick="downloadFile()" style="display:none">Download File</button>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="responseMessage" class="mt-3 text-center"></div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-3 text-center"> @if (session('success'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h4 class="form-label-custom mb-4">Soil Data Input Form</h4>
        <form action="{{ route('PhpSpreadsheetController.storeSoilData') }}" method="POST" id="uploadForm1" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="division" class="form-label">Division <span style="color:red">*</span></label>
                    <select class="form-select" id="division" name="division" required>
                        <option value="">Select Division</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chattogram">Chattogram</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Barishal">Barishal</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Rangpur">Rangpur</option>
                        <option value="Mymensingh">Mymensingh</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="district" class="form-label">District <span style="color:red">*</span></label>
                    <select class="form-select" id="district" name="district" required>
                        <option value="">Select District</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="upazila" class="form-label">Upazila <span style="color:red">*</span></label>
                    <select class="form-select" id="upazila" name="upazila" required>
                        <option value="">Select Upazila</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Year <span style="color:red">*</span></label>
                    <input type="number" class="form-control" id="year" name="year" min="1900" max="2500" step="1" required>
                </div>
                <div class="d-flex align-items-center col-md-5">
                    <div class="col-md-10">
                        <label for="upz_code" class="form-label">Upload Excel file</label>
                        <input type="file" class="form-control-file" id="excel" name="excel" accept=".xls|.xlsx">
                    </div>
                </div>


            </div>
            <button type="submit" class="btn btn-primary mt-4 mb-4">Submit</button>
        </form>
    </div>
    @else
    @include('visitors')
    @endif

    @include('institutionlogo')

    <!-- <footer>
        <span class="small">
            Copyright &copy; <script>
                document.write(new Date().getFullYear())
            </script>,
            Bangladesh Agricultural Research Council.<br>
            Developed and maintained by Computer and GIS unit, Bangladesh Agricultural Research Council.
        </span>
    </footer> -->

    <script>
        document.getElementById('uploadForm1').addEventListener('submit', function(event) {
            var fileInput = document.getElementById('excel');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.xls|\.xlsx)$/i;
            if (filePath) {
                if (!allowedExtensions.exec(filePath)) {
                    alert('Please upload a valid Excel file (.xls or .xlsx)');
                    event.preventDefault(); // Prevent form submission
                }
            }
        });
    </script>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var fileInput = document.getElementById('excel_file');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.xls|\.xlsx)$/i;

            if (!allowedExtensions.exec(filePath)) {
                document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Please upload a valid Excel file (.xls or .xlsx)</div>';
                return; // Exit function to prevent AJAX call
            }

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('PhpSpreadsheetController.processFile') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-success">' + response.message + '</div>';
                },
                error: function(xhr) {
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">' + xhr.responseJSON.message + '</div>';
                }
            });
        });
    </script>

    <script>
        function downloadFile() {
            window.location.href = "{{ route('PhpSpreadsheetController.downloadFile') }}";
            document.getElementById('responseMessage').innerHTML = '<div class="alert alert-success">File Downloaded successfully.</div>';
        }
    </script>



    <script>
        function visibleDownload() {
            var fileInput = document.getElementById('excel_file');
            if (fileInput.files.length) {
                document.getElementById('downloadButton').style.display = 'block';
            }

        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Store districts and upazilas as arrays within an object
            const districtsByDivision = {
                'Dhaka': ['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail', 'Kishoreganj'],
                'Chattogram': ['Chattogram', "Cox's Bazar", 'Feni', 'Lakshmipur', 'Banderban'],
                'Khulna': ['Khulna', 'Jessore', 'Satkhira', 'Kushtia', 'Jhenidah'],
                'Rajshahi': ['Rajshahi', 'Natore', 'Bogra', 'Joypurhat', 'Pabna'],
                'Barishal': ['Barishal', 'Bhola', 'Patuakhali', 'Jhalokati', 'Barisal'],
                'Sylhet': ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj', 'Bholaganj'],
                'Rangpur': ['Rangpur', 'Dinajpur', 'Thakurgaon', 'Panchagarh', 'Lalmonirhat', 'Nilphamari'],
                'Mymensingh': ['Mymensingh', 'Jamalpur', 'Sherpur', 'Netrokona', 'Kishoreganj']
            };

            const upazilasByDistrict = {
                'Dhaka': ['Savar', 'Dhamrai', 'Keraniganj', 'Uttara', 'Gulshan'],
                'Gazipur': ['Tongi', 'Kaliakoir', 'Kapasia', 'Gazipur Sadar', 'Sreepur'],
                'Narayanganj': ['Rupganj', 'Sonargaon', 'Araihazar', 'Narayanganj Sadar', 'Bandar'],
                'Tangail': ['Tangail Sadar', 'Kalihati', 'Mirzapur', 'Basail', 'Nagarpur'],
                'Kishoreganj': ['Kishoreganj Sadar', 'Bajitpur', 'Hossainpur', 'Karimganj', 'Itna'],
                'Chattogram': ['Chattogram Sadar', 'Pahartali', 'Patenga', 'Anwara', 'Mirsharai'],
                "Cox's Bazar": ['Ukhia', 'Teknaf', 'Ramu', 'Maheshkhali', 'Cox’s Bazar Sadar'],
                'Feni': ['Feni Sadar', 'Daganbhuiyan', 'Parshuram', 'Chhagalnaiya', 'Fulgazi'],
                'Lakshmipur': ['Lakshmipur Sadar', 'Ramganj', 'Ramgati', 'Lakshmipur', 'Raipur'],
                'Banderban': ['Banderban Sadar', 'Thanchi', 'Ruma', 'Naikhongchhari', 'Ruma'],
                'Khulna': ['Khulna Sadar', 'Dumuria', 'Paikgachha', 'Rupsa', 'Koyra'],
                'Jessore': ['Jessore Sadar', 'Manirampur', 'Abhaynagar', 'Keshabpur', 'Chaugachha'],
                'Satkhira': ['Satkhira Sadar', 'Assasuni', 'Kaliganj', 'Satkhira', 'Shyamnagar'],
                'Kushtia': ['Kushtia Sadar', 'Kumarkhali', 'Bheramara', 'Mirpur', 'Khoksa'],
                'Jhenidah': ['Jhenidah Sadar', 'Kotchandpur', 'Shailkupa', 'Kaliganj', 'Harinakunda'],
                'Rajshahi': ['Rajshahi Sadar', 'Paba', 'Godagari', 'Bagmara', 'Tanore'],
                'Natore': ['Natore Sadar', 'Bagatipara', 'Lalpur', 'Naldanga', 'Baraigram'],
                'Bogra': ['Bogra Sadar', 'Shibganj', 'Gabtali', 'Dhamairhat', 'Sariakandi'],
                'Joypurhat': ['Joypurhat Sadar', 'Khetlal', 'Puranigati', 'Akkelpur', 'Kalai'],
                'Pabna': ['Pabna Sadar', 'Bera', 'Sujanagar', 'Ishwardi', 'Atghoria'],
                'Barishal': ['Barishal Sadar', 'Bakerganj', 'Muladi', 'Wazirpur', 'Barisal'],
                'Bhola': ['Bhola Sadar', 'Lalmohan', 'Daulatkhan', 'Chandpur', 'Tazumuddin'],
                'Patuakhali': ['Patuakhali Sadar', 'Dumki', 'Galachipa', 'Kuarakhali', 'Bauphal'],
                'Jhalokati': ['Jhalokati Sadar', 'Kachua', 'Nalchity', 'Rajapur', 'Jhalokati'],
                'Moulvibazar': ['Moulvibazar Sadar', 'Srimangal', 'Kamalganj', 'Juri', 'Rajnagar'],
                'Habiganj': ['Habiganj Sadar', 'Chunarughat', 'Madhabpur', 'Nabiganj', 'Ajmeriganj'],
                'Sunamganj': ['Sunamganj Sadar', 'Dharampasha', 'Biswambarpur', 'Jamalganj', 'Tahirpur'],
                'Bholaganj': ['Bholaganj Sadar', 'Bholaganj', 'Fenchuganj', 'Bishwanath', 'Sylhet'],
                'Rangpur': ['Rangpur Sadar', 'Badarganj', 'Pirganj', 'Dinajpur', 'Lalmonirhat'],
                'Dinajpur': ['Dinajpur Sadar', 'Birganj', 'Phulbari', 'Parbotipur', 'Kaharol'],
                'Thakurgaon': ['Thakurgaon Sadar', 'Ranisankail', 'Pirganj', 'Haripur', 'Baliadangi'],
                'Panchagarh': ['Panchagarh Sadar', 'Tetulia', 'Debiganj', 'Boda', 'Atwari'],
                'Lalmonirhat': ['Lalmonirhat Sadar', 'Aditmari', 'Hatibandha', 'Kaliganj', 'Patgram'],
                'Mymensingh': ['Mymensingh Sadar', 'Trishal', 'Gouripur', 'Nandail', 'Haluaghat'],
                'Jamalpur': ['Jamalpur Sadar', 'Islampur', 'Dewanganj', 'Madarganj', 'Jamalpur'],
                'Sherpur': ['Sherpur Sadar', 'Nalitabari', 'Sreebardi', 'Jhenaigati', 'Kawathe'],
                'Nilphamari': ['Nilphamari Sadar', 'Dimla', 'Kishoreganj', 'Jaldhaka', 'Domar', 'Syedpur'],
            };

            // Handle division selection change
            $('#division').on('change', function() {
                var selectedDivision = $(this).val();
                var $district = $('#district');
                var $upazila = $('#upazila');

                $district.empty(); // Clear previous district options
                $district.append('<option value="">Select District</option>'); // Add default option

                $upazila.empty(); // Clear previous upazila options
                $upazila.append('<option value="">Select Upazila</option>'); // Add default option

                if (selectedDivision && districtsByDivision[selectedDivision]) {
                    districtsByDivision[selectedDivision].forEach(function(district) {
                        $district.append('<option value="' + district + '">' + district + '</option>');
                    });
                }
            });

            // Handle district selection change
            $('#district').on('change', function() {
                var selectedDistrict = $(this).val();
                var $upazila = $('#upazila');

                $upazila.empty(); // Clear previous upazila options
                $upazila.append('<option value="">Select Upazila</option>'); // Add default option

                if (selectedDistrict && upazilasByDistrict[selectedDistrict]) {
                    upazilasByDistrict[selectedDistrict].forEach(function(upazila) {
                        $upazila.append('<option value="' + upazila + '">' + upazila + '</option>');
                    });
                }
            });
        });
    </script>

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
</body>

</html>