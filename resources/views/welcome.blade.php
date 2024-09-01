<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel File</title>
</head>
<body>
    <h1>Upload Excel File</h1>
    <form action="{{ route('phpspreadsheet.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="excel">Choose Excel file:</label>
        <input type="file" id="excel" name="excel" accept=".xlsx">
        <br><br>
        <button type="submit">Upload and Process</button>
    </form>
</body>
</html>
