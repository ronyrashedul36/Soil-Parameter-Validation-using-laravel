@include('header')
@include('navigation')

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<style>
    #upazila_nirdesikas th,
    #feedback th,
    #upazila_nirdesikas td,
    #feedback td {
        text-align: center;
        vertical-align: middle;
    }
    .alert {
        display: none; /* Initially hidden */
    }
</style>

@if (Auth::check() && Auth::user()->role == 'super admin')
<div class="container">
    <h4 style="font-family: 'Times New Roman', Times, serif;">Soil Chemical Data Approval</h4>
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
            <tbody></tbody>
        </table>
    </div>
</div>
@endif

@if (Auth::check() && Auth::user()->role == 'admin')
<div class="container">
    <h4 style="font-family: 'Times New Roman', Times, serif;">Soil Chemical Data Approval</h4>
    <div>
        <table class="table" id="feedback">
            <thead>
                <tr>
                    <th>Division</th>
                    <th>District</th>
                    <th>Upazila</th>
                    <th>Year</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endif


<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionModalLabel">Rejection Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rejectionForm">
                    @csrf
                    <div class="form-group">
                        <label for="rejectionMessage">Reason for Rejection:</label>
                        <textarea class="form-control" id="rejectionMessage" name="rejectionMessage" rows="3" required></textarea>
                    </div>
                    <input type="hidden" id="rejectionUrl" name="rejectionUrl">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="sendRejection">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var userRole = "{{ Auth::check() ? Auth::user()->role : '' }}";

        // Fetch appropriate data based on user role
        if (userRole === 'super admin') {
            fetchSuperAdminData();
        } else if (userRole === 'admin') {
            fetchAdminData();
        }

        // Rejection Modal Logic
        $(document).on('click', '.rejectBtn', function() {
            let rejectUrl = $(this).data('url');
            $('#rejectionUrl').val(rejectUrl);
            $('#rejectionModal').modal('show');
        });

        $('#sendRejection').click(function() {
            let rejectionMessage = $('#rejectionMessage').val();
            let rejectionUrl = $('#rejectionUrl').val();

            if (rejectionMessage.trim() === '') {
                alert('Please provide a reason for rejection.');
                return;
            }

            $.ajax({
                url: rejectionUrl,
                type: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    message: rejectionMessage
                },
                success: function(response) {
                    $('#rejectionModal').modal('hide');
                    alert('Rejection message sent successfully.');

                    // Refresh data based on user role
                    if (userRole === 'super admin') {
                        fetchSuperAdminData();
                    } else if (userRole === 'admin') {
                        fetchAdminData();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                    alert('Failed to send the rejection message. Please try again.');
                }
            });
        });
    });

    function fetchSuperAdminData() {
        $.ajax({
            url: "{{ route('PhpSpreadsheetController.getData') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                let tableBody = $('#upazila_nirdesikas tbody');
                tableBody.empty();

                $.each(data, function(index, item) {
                    if (item.division && item.district && item.upazila && item.year) {
                        let downloadUrl = `{{ url('/download')}}/${item.division}/${item.district}/${item.upazila}/${item.year}`;
                        let approveUrl = `{{ url('/updateMessageAndsoilData') }}/${item.division}/${item.district}/${item.upazila}/${item.year}`;
                        let rejectUrl = `{{url('/rejectMessage')}}/${item.division}/${item.district}/${item.upazila}/${item.year}`;
                        let row = `<tr>
                            <td>${item.division}</td>
                            <td>${item.district}</td>
                            <td>${item.upazila}</td>
                            <td><a href="${downloadUrl}">Download</a></td>
                            <td>${item.year}</td>
                            <td>
                                <a href="${approveUrl}" class="btn btn-primary m-0">Approve</a>
                                <button type="button" class="btn btn-danger m-0 rejectBtn" data-url="${rejectUrl}">Reject</button>
                            </td>
                        </tr>`;
                        tableBody.append(row);
                    }
                });

                if (!$.fn.DataTable.isDataTable('#upazila_nirdesikas')) {
                    $('#upazila_nirdesikas').DataTable();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }

    function fetchAdminData() {
        $.ajax({
            url: "{{ route('PhpSpreadsheetController.getData') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                let tableBody = $('#feedback tbody');
                tableBody.empty();

                $.each(data, function(index, item) {
                    if (item.division && item.district && item.upazila && item.year) {
                        let deleteUrl = `{{ url('/deleteMessage')}}/${item.id}`;
                        let row = `<tr>
                            <td>${item.division}</td>
                            <td>${item.district}</td>
                            <td>${item.upazila}</td>
                            <td>${item.year}</td>
                            <td>${item.message}</td>
                            <td>
                                <form action="${deleteUrl}" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger m-0" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                </form>
                            </td>
                        </tr>`;
                        tableBody.append(row);
                    }
                });

                if (!$.fn.DataTable.isDataTable('#feedback')) {
                    $('#feedback').DataTable();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }

    // Hide success alerts after 5 seconds
    var successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 5000);
    }
</script>

@include('institutionlogo')
