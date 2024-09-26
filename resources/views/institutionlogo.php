<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo and Footer at the Bottom</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS CDN -->
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .main-content {
            flex: 1;
            /* Flex-grow to push footer and logo to the bottom */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            /* Add padding around main content */
        }

        .bottom-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: auto;
            /* Push this section to the bottom */
        }

        .footer {
            background: #111;
            padding: 10px;
            text-align: center;
            color: #ffffff;
            font-size: 20px;
            width: 100%;
        }

        .footer-text {
            font-size: 16px;
        }
        .logo {
            background-color: transparent; /* No background color */
        }

    </style>
</head>

<body>
    <div class="bottom-section">
        <div class="container text-center">
            <img src="http://srdi.teletalk.com.bd/images/sdri_logo.png" class="logo" height="100" width="100" alt="SDRI Logo">
            <img src="http://apps.barc.gov.bd/flipbook/flipbook/images/barc-logo.png?%3E" class="logo" height="100" width="100" alt="BARC Logo">
        </div>
        <footer class="footer mt-2">
            <span class="footer-text">
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>, Bangladesh Agricultural Research Council.
                <br>
                Developed and maintained by Computer and GIS unit, Bangladesh Agricultural Research Council.

            </span>
        </footer>
    </div>

    <!-- jQuery and Bootstrap JS CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable(); // Initialize DataTables on your table
        });
    </script>
</body>

</html>
