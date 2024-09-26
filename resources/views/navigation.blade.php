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
    <br>


    @if(Session::has('success'))
    <div class="alert alert-success" role="alert" id="success-alert">
        {{ Session::get('success') }}
    </div>
    @endif

</div>

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