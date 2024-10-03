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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            flex-direction: column;
            align-items: center;
            font-family: 'Times New Roman', Times, serif;
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

        #soilPieChart,
        #nirdesikhaPieChart {
            width: 250px;
            height: 250px;
            margin-top: 20px;
        }

        #chart-label {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('header')

    <div class="container mt-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
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
        <br>

        @if(Session::has('success'))
        <div class="alert alert-success" role="alert" id="success-alert">
            {{ Session::get('success') }}
        </div>
        @endif
    </div>

    <div class="container mt-5">
        <div class="flex-container d-flex justify-content-center">
            <div class="row" style="font-family: 'Times New Roman', Times, serif; text-align: center;">
                <div class="col-md-6 mb-4">
                    <h4>Soil Chemical Data</h4>
                    <!-- <div id="upazilaCount" style="font-size: 18px; margin-top: 10px;"></div> -->
                    <canvas id="soilPieChart"></canvas>
                </div>

                <div class="col-md-6">
                    <h4>Upazila Nirdesikha Data</h4>
                    <!-- <div id="upazilaNirdesikhaCount" style="font-size: 18px; margin-top: 10px;"></div> -->
                    <canvas id="nirdesikhaPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>



    <br>
    <br>
    <br>

    <script>
        // Function to fetch the uploaded upazilas from Laravel
        fetch('/getUpazilaNirdesikhaCount')
            .then(response => response.json())
            .then(data => {
                const totalDistinctUpazilas = 495 - data.totalDistinctUpazilaNirdesikha; // Total distinct upazilas in Bangladesh
                const uploadedUpazilas = data.totalDistinctUpazilaNirdesikha; // Ensure this property exists in the response
                const ctx = document.getElementById('nirdesikhaPieChart').getContext('2d');

                const nirdesikhaPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Total No. of Upazila', 'Uploaded No. of Upazila'], // Labels for the pie chart
                        datasets: [{
                            label: 'No. of Upazila',
                            data: [totalDistinctUpazilas, uploadedUpazilas], // Data for the chart
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)', // Color for total upazilas
                                'rgba(255, 99, 132, 0.2)' // Color for uploaded upazilas
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)', // Border color for total upazilas
                                'rgba(255, 99, 132, 1)' // Border color for uploaded upazilas
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true, // Enable responsiveness
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom', // Position of the legend
                                align: 'middle',
                                labels: {
                                    usePointStyle: true, // Use point style for labels
                                    padding: 20 // Add padding between legend items
                                }
                            },
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('There was an issue fetching the Nirdesikha data. Please try again later.'); // User-friendly error message
            });
    </script>

    <script>
        // Function to fetch the uploaded upazilas from Laravel
        fetch('/getSoilChemicalDataCount')
            .then(response => response.json())
            .then(data => {
                const totalDistinctUpazilas = 495 - data.totalDistinctUpazilas; // Total distinct upazilas in Bangladesh
                const uploadedUpazilas = data.totalDistinctUpazilas; // Fetch uploaded upazila count
                const ctx = document.getElementById('soilPieChart').getContext('2d');
                const soilPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Total No. of Upazila', 'Uploaded No. of Upazila'], // Labels for the pie chart
                        datasets: [{
                            label: 'No. of Upazila',
                            data: [totalDistinctUpazilas, uploadedUpazilas], // Data for the chart
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)', // Color for total upazilas
                                'rgba(255, 99, 132, 0.2)' // Color for uploaded upazilas
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)', // Border color for total upazilas
                                'rgba(255, 99, 132, 1)' // Border color for uploaded upazilas
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false, // Disable responsiveness to honor canvas size
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom', // Position of the legend
                                align: 'middle',
                                labels: {
                                    usePointStyle: true, // Use point style for labels
                                    padding: 20 // Add padding between legend items
                                }
                            },
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>




    @include('institutionlogo')

    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            var successAlert = document.getElementById('success-alert');
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