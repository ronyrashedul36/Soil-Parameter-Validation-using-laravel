<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Data Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .message-icon {
            position: relative;
            cursor: pointer;
        }

        .badge-danger {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 12px;
            padding: 5px 7px;
            border-radius: 50%;
        }

        .dropdown-menu {
            min-width: 200px;
            /* Adjust width as needed */
            z-index: 1050;
        }
    </style>
</head>

<body>
    <div class="container align-items-center" style="position: relative; background-color: #fff; padding: 20px;">
        <h3 style="font-family: 'Verdana', sans-serif; font-size: 24px; color: #333; text-align: center;">
            Soil Data Management System
        </h3>

        @if (Auth::check())
        <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); display: flex; align-items: center;">
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin')
            <!-- Message Icon with Count -->
            <a href="/notifications" class="message-icon mr-3">
                <i class="fas fa-envelope"></i> <!-- Font Awesome envelope icon -->
                <span class="badge badge-danger" id="messageCount"></span> <!-- Display count as a badge -->
            </a>
            @endif

            <span style="margin-right: 10px;">
                {{ Auth::user()->name }}
            </span>

            <form action="{{ route('PhpSpreadsheetController.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn">
                    Logout
                </button>
            </form>
        </div>
        @else
        <a href="/login" class="btn" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
            Login
        </a>
        @endif
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- AJAX Script to Update Messages -->
    <script>
        $(document).ready(function() {
            function updateMessages() {
                $.ajax({
                    url: "{{ route('PhpSpreadsheetController.getMessages') }}",
                    method: 'GET',
                    success: function(data) {
                        $('#messageCount').text(data.messageCount);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching messages:', status, error);
                    }
                });
            }

            // Initial call to populate data
            updateMessages();

            // Call updateMessages function periodically
            setInterval(updateMessages, 60000); // Update every minute
        });
    </script>
</body>

</html>