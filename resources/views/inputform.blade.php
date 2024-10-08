@include('developer')
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- use version 0.20.2 -->
    <!-- <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script> -->
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"> -->
    <!-- DataTables JS -->
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script> -->


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
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
                                <a class="dropdown-item" href="/soilvalidation">Data Validate & Import</a>
                                <a class="dropdown-item" href="/soilsinglerowdataentry">Soil Data Entry</a>
                                @endif
                                <a class="dropdown-item" href="/soilchemicaldata">Soil Chemical Data</a>
                                <a class="dropdown-item" href="/reportofsoilchemicaldata">Report</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Upazila Nirdesika
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/demo">Nirdesika Management</a>
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
                                <a class="dropdown-item" href="/inputform">Upload</a>
                                @endif
                                <a class="dropdown-item" href="/upazilanirdesikareport">Report</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Soil Physical Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
                                <a class="dropdown-item" href="/soilPhysicalData">Upload Data</a>
                                @endif
                                <a class="dropdown-item" href="/soilPhysicalDataAll">Soil Physical Data</a>
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-3 text-center"> @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
    <div class="container mt-3 box">

        <h4 class="form-label-custom mb-4" style="font-family: 'Times New Roman', Times, serif;">Upazila Nirdesikha</h4>
        <form action="/submit" method="post" enctype="multipart/form-data">
            @csrf <!-- CSRF token -->
            <div class="row g-3">
                <!-- Division Name -->
                <div class="col-md-4 mb-4">
                    <label for="division" class="form-label mr-3">Division Name: <span class="text-danger">*</span></label>
                    <select class="form-select w-100" id="division" name="division" required>
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
                <!-- District Name -->
                <div class="col-md-4 mb-3">
                    <label for="district" class="form-label">District Name: <span class="text-danger">*</span></label>
                    <select class="form-select w-100" id="district" name="district" required>
                        <option value="">Select District</option>
                    </select>
                </div>
                <!-- Upazila Name -->
                <div class="col-md-4 mb-4">
                    <label for="upazila" class="form-label">Upazila Name: <span class="text-danger">*</span></label>
                    <select class="form-select w-100" id="upazila" name="upazila" required>
                        <option value="">Select Upazila</option>
                    </select>
                </div>

                <!-- Year (Label and Input in the Same Row, Consistent with Other Fields) -->
                <div class="col-md-4 mb-4">
                    <div class="row g-0 align-items-center">
                        <label for="year" class="col-sm-3 col-form-label">Year: <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="year" name="year" min="1900" max="2500" step="1" required>
                        </div>
                    </div>
                </div>
                <!-- PDF Upload (Label and Input in the Same Row, Consistent with Other Fields) -->
                <div class="col-md-4 mb-4">
                    <div class="row g-0 align-items-center">
                        <label for="pdf" class="col-sm-3 col-form-label">Upload PDF: <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="pdf" name="pdf" accept=".pdf" required>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success btn-lg">Submit</button>
                </div>
            </div>
        </form>
    </div>
    @else
    @include('visitors')
    @endif



    @include('institutionlogo')

    <!-- <footer>
        <span class="small"> Copyright &copy;
            <script>
                document.write(new Date().getFullYear())
            </script>, Bangladesh Agricultural Research Council.
            <br>
            Developed and maintained by Computer and GIS unit, Bangladesh Agricultural Research Council.
        </span>
    </footer> -->
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
    <!-- Bootstrap JS and dependencies (Optional if you require JS functionality) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script> -->
</body>


</html>