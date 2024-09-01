@include('developer');
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
            padding: 0;
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

        .table-responsive-container {
            position: relative;
            margin-bottom: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .btn-custom {
            height: 38px;
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-gap {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2" style="margin-top: 10px; display: flex; justify-content: flex-end;">
                <img src="http://apps.barc.gov.bd/flipbook/flipbook/images/barc-logo.png" width="100" height="100" alt="">
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 text-center" style="margin-top: 20px;">
                <h2>Bangladesh Agricultural Research Council (BARC)</h2>
                <h3>New Airport Road, Farmgate, Dhaka - 1215</h3>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1" style="margin-top: 10px; display: flex; justify-content: flex-end; align-items: left;">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <!-- Navbar Toggler for Mobile View -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/demo">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Soil Chemical Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/soilvalidation">Data Validate & Import</a>
                                <a class="dropdown-item" href="/soilvalidation">Soil Data Entry</a>
                                <a class="dropdown-item" href="/soilchemicaldata">Report</a>
                                <a class="dropdown-item" href="#">Download</a>
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
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif

        <div class="flex-container">
            <h4>Soil Chemical Data</h4>
        </div>

        <div class="table-wrapper">
            <div class="table-responsive-container">
                <table class="table" id="soilchemicaldata">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Division</th>
                            <th>District</th>
                            <th>Upazila</th>
                            <th>fid</th>
                            <th>smpl_no</th>
                            <th>mu</th>
                            <th>land_type</th>
                            <th>soil_series</th>
                            <th>soil group</th>
                            <th>texture</th>
                            <th>ec</th>
                            <th>ph</th>
                            <th>ea</th>
                            <th>om</th>
                            <th>n</th>
                            <th>po</th>
                            <th>pb</th>
                            <th>k</th>
                            <th>s</th>
                            <th>zn</th>
                            <th>b</th>
                            <th>ca</th>
                            <th>mg</th>
                            <th>cu</th>
                            <th>fe</th>
                            <th>mn</th>
                            <th>upz_code</th>
                            <th>year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $counter = 1;
                        @endphp
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $item->division }}</td>
                            <td>{{ $item->district }}</td>
                            <td>{{ $item->upazila }}</td>
                            <td>{{ $item->fid}}</td>
                            <td>{{ $item->smpl_no }}</td>
                            <td>{{ $item->mu }}</td>
                            <td>{{ $item->land_type }}</td>
                            <td>{{ $item->soil_series }}</td>
                            <td>{{ $item->soil_group }}</td>
                            <td>{{ $item->texture }}</td>
                            <td>{{ $item->ec }}</td>
                            <td>{{ $item->ph}}</td>
                            <td>{{ $item->ea }}</td>
                            <td>{{ $item->om }}</td>
                            <td>{{ $item->n }}</td>
                            <td>{{ $item->po}}</td>
                            <td>{{ $item->pb }}</td>
                            <td>{{ $item->k }}</td>
                            <td>{{ $item->s }}</td>
                            <td>{{ $item->zn}}</td>
                            <td>{{ $item->b }}</td>
                            <td>{{ $item->ca }}</td>
                            <td>{{ $item->mg }}</td>
                            <td>{{ $item->cu }}</td>
                            <td>{{ $item->fe }}</td>
                            <td>{{ $item->mn }}</td>
                            <td>{{ $item->upz_code }}</td>
                            <td>{{ $item->year }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{url('/editsoilchemicaldata', $item->id)}}" class="btn btn-primary me-2 btn-custom btn-gap editbtn">Edit</a>
                                    <form action="{{ url('/deletesoilchemicaldata', $item->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-custom btn-gap" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <footer>
        <span class="small"> Copyright &copy;
            <script>
                document.write(new Date().getFullYear())
            </script>, Bangladesh Agricultural Research Council.
            <br>
            Developed and maintained by Computer and GIS unit, Bangladesh Agricultural Research Council.
        </span>
    </footer>

    <script>
        $(document).ready(function() {
            $('#soilchemicaldata').DataTable();
        });
    </script>

</body>

</html>