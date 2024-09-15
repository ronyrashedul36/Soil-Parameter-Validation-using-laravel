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
                                <a class="dropdown-item" href="#">Report</a>
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

    </script>



</body>



</html>