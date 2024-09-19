@include('header')

@include('navigation')

<style>
    #upazila_nirdesikas th,
    #upazila_nirdesikas td {
        text-align: center;
        vertical-align: middle;
        /* Optional: Vertically center content as well */
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
            <tbody>
            </tbody>
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
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@endif
<script type="text/javascript">
    $(document).ready(function() {
        function fetchData() {
            $.ajax({
                url: "{{ route('PhpSpreadsheetController.getData') }}", // The Laravel route
                type: "GET", // HTTP method
                dataType: "json", // The type of data expected back from the server
                success: function(data) {
                    let tableBody = $('#upazila_nirdesikas tbody');
                    tableBody.empty(); // Clear any existing rows

                    $.each(data, function(index, item) {
                        if (item.division && item.district && item.upazila && item.year) {
                            let approveUrl = `{{ url('/updateMessageAndsoilData') }}/${item.division}/${item.district}/${item.upazila}/${item.year}`;
                            let row = `<tr>
                            <td>${item.division}</td>
                            <td>${item.district}</td>
                            <td>${item.upazila}</td>
                            <td><a href="#">Download</a></td>
                            <td>${item.year}</td>
                            <td>
                                <a href="${approveUrl}" class="btn btn-primary editbtn m-0" style="font-size:15px; display: inline-block;">Approve</a>
                                <form action="#" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger m-0" style="font-size:15px;" onclick="return confirm('Are you sure you want to delete this item?')">Reject</button>
                                </form>
                            </td>
                        </tr>`;
                            tableBody.append(row);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                }
            });
        }

        // Fetch data when the document is ready
        fetchData();
    });
</script>

<script>
    $(document).ready(function() {
        $('#upazila_nirdesikas').DataTable();
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        function fetchData() {
            $.ajax({
                url: "{{ route('PhpSpreadsheetController.getData') }}", // The Laravel route
                type: "GET", // HTTP method
                dataType: "json", // The type of data expected back from the server
                success: function(data) {
                    let tableBody = $('#feedback tbody');
                    tableBody.empty(); // Clear any existing rows

                    $.each(data, function(index, item) {
                        if (item.division && item.district && item.upazila && item.year) {
                            let approveUrl = `{{ url('/updateMessageAndsoilData') }}/${item.division}/${item.district}/${item.upazila}/${item.year}`;
                            let row = `<tr>
                            <td>${item.division}</td>
                            <td>${item.district}</td>
                            <td>${item.upazila}</td>
                            <td>${item.year}</td>
                            <td>${item.message}</td>
                            <td>
                                <form action="#" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger m-0" style="font-size:15px;" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                </form>
                            </td>
                        </tr>`;
                            tableBody.append(row);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                }
            });
        }

        // Fetch data when the document is ready
        fetchData();
    });
</script>

<script>
    $(document).ready(function() {
        $('#feedback').DataTable();
    });
</script>

@include('institutionlogo')