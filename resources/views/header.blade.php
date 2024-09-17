<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<div class="container align-items-center" style="position: relative; background-color: #fff; padding: 20px;">

    <h3 style="font-family: 'Verdana', sans-serif; font-size: 24px; color: #333; text-align: center;">
        Soil Data Management System
    </h3>


    @if (Auth::check())
    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); display: flex; align-items: center;">
        <!-- @if (Auth::user()->role == 'admin')
        <p>Role is admin</p>
        @else
        <p>Role: {{ Auth::user()->role }}</p>
        @endif -->

        @if (Auth::user()->role == 'admin')
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown" id="approvalSection">
                <a class="nav-link mr-2" data-toggle="dropdown" href="#" data-toggle="tooltip" data-placement="bottom" title="Pending Request">
                    <i class="fas fa-check-square"></i>
                    <span class="badge badge-danger" id="requestCount"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="approvalMenu" style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                    <div class="dropdown-item">
                        <p class="text-center" id="requestNumber"></p>
                    </div>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
        </ul>
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

<script type="text/javascript">
    // $("#selectAll").click(function() {
    //   $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    // });
    var userID = "{{ auth()->id() }}";
    console.log(userID);

    // $(document).ready(function() {
    //     // approvalDropdown_show();
    //     // requestCount();

    // });
</script>

<script>
    function requestCount() {
        $.ajax({
            url: route('PhpSpreadsheetController/requestCount'),
            type: "get",
            dataType: "json",
            success: function(response) {
                if (response.success === true) {
                    $('#requestCount').text(response.data.totalRow);
                    if (response.data.totalRow > 0) {
                        $('#requestNumber').text(response.data.totalRow + ' Pending Request');
                    } else {
                        $('#requestNumber').text('Pending Request');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching request count: " + textStatus, errorThrown);
                $('#requestNumber').text('Error fetching request count');
            }
        });
    }
</script>