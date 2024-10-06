@include('developer')

@include('header')


@include('navigation')

@if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
<div class="container mt-2 box">
    <h4 class="mb-5" style="font-family: 'Times New Roman', Times, serif; text-align: center;">Soil Data Input Form</h4>
    <form action="{{route('PhpSpreadsheetController.uploadSoilPhysicalData')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="division" class="form-label">Division <span style="color:red">*</span></label>
                <select class="form-select" id="division" name="division" required>
                    <option value="">Select Division</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chattogram">Chattogram</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Barishal">Barishal</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Mymensingh">Mymensingh</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="district" class="form-label">District <span style="color:red">*</span></label>
                <select class="form-select" id="district" name="district" required>
                    <option value="">Select District</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="upazila" class="form-label">Upazila <span style="color:red">*</span></label>
                <select class="form-select" id="upazila" name="upazila" required>
                    <option value="">Select Upazila</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="year" class="form-label">Year <span style="color:red">*</span></label>
                <input type="number" class="form-control" id="year" name="year" min="1900" max="2500" step="1" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="land_type" class="form-label">Land Type</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="land_type" name="land_type" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="soil_group" class="form-label">Soil Group</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="soil_group" name="soil_group" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="sg_area" class="form-label">SG Area</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="sg_area" name="sg_area" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="texture" class="form-label">Texture</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="texture" name="texture" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="consistency" class="form-label">Soil Consistency</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="consistency" name="consistency" required>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="drainage" class="form-label">Soil Drainage</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="drainage" name="drainage" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="moisture" class="form-label">Soil Moisture</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="moisture" name="moisture" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="recession" class="form-label">Water Recession</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="recession" name="recession" required>
            </div>

        </div>
        <div class="row">

            <div class="col-md-4 mb-3">
                <label for="relief" class="form-label">Water Relief</label> <span style="color:red">*</span>
                <input type="text" class="form-control" id="relief" name="relief" required>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>


    </form>
</div>




<br>
<br>
<br>

@else
@include('visitors')
@endif
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Store districts and upazilas as arrays within an object
        const districtsByDivision = {
            'Dhaka': ['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail', 'Kishoreganj'],
            'Chattogram': ['Chattogram', "Cox's Bazar", 'Feni', 'Lakshmipur', 'Banderban'],
            'Khulna': ['Khulna', 'Jessore', 'Satkhira', 'Kushtia', 'Jhenidah'],
            'Rajshahi': ['Rajshahi', 'Natore', 'Bogra', 'Joypurhat', 'Pabna'],
            'Barishal': ['Barishal', 'Bhola', 'Patuakhali', 'Jhalokati', 'Barisal'],
            'Sylhet': ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj', 'Bholaganj'],
            'Rangpur': ['Rangpur', 'Dinajpur', 'Thakurgaon', 'Panchagarh', 'Lalmonirhat', 'Nilphamari'],
            'Mymensingh': ['Mymensingh', 'Jamalpur', 'Sherpur', 'Netrokona', 'Kishoreganj']
        };

        const upazilasByDistrict = {
            'Dhaka': ['Savar', 'Dhamrai', 'Keraniganj', 'Uttara', 'Gulshan'],
            'Gazipur': ['Tongi', 'Kaliakoir', 'Kapasia', 'Gazipur Sadar', 'Sreepur'],
            'Narayanganj': ['Rupganj', 'Sonargaon', 'Araihazar', 'Narayanganj Sadar', 'Bandar'],
            'Tangail': ['Tangail Sadar', 'Kalihati', 'Mirzapur', 'Basail', 'Nagarpur'],
            'Kishoreganj': ['Kishoreganj Sadar', 'Bajitpur', 'Hossainpur', 'Karimganj', 'Itna'],
            'Chattogram': ['Chattogram Sadar', 'Pahartali', 'Patenga', 'Anwara', 'Mirsharai'],
            "Cox's Bazar": ['Ukhia', 'Teknaf', 'Ramu', 'Maheshkhali', 'Cox’s Bazar Sadar'],
            'Feni': ['Feni Sadar', 'Daganbhuiyan', 'Parshuram', 'Chhagalnaiya', 'Fulgazi'],
            'Lakshmipur': ['Lakshmipur Sadar', 'Ramganj', 'Ramgati', 'Lakshmipur', 'Raipur'],
            'Banderban': ['Banderban Sadar', 'Thanchi', 'Ruma', 'Naikhongchhari', 'Ruma'],
            'Khulna': ['Khulna Sadar', 'Dumuria', 'Paikgachha', 'Rupsa', 'Koyra'],
            'Jessore': ['Jessore Sadar', 'Manirampur', 'Abhaynagar', 'Keshabpur', 'Chaugachha'],
            'Satkhira': ['Satkhira Sadar', 'Assasuni', 'Kaliganj', 'Satkhira', 'Shyamnagar'],
            'Kushtia': ['Kushtia Sadar', 'Kumarkhali', 'Bheramara', 'Mirpur', 'Khoksa'],
            'Jhenidah': ['Jhenidah Sadar', 'Kotchandpur', 'Shailkupa', 'Kaliganj', 'Harinakunda'],
            'Rajshahi': ['Rajshahi Sadar', 'Paba', 'Godagari', 'Bagmara', 'Tanore'],
            'Natore': ['Natore Sadar', 'Bagatipara', 'Lalpur', 'Naldanga', 'Baraigram'],
            'Bogra': ['Bogra Sadar', 'Shibganj', 'Gabtali', 'Dhamairhat', 'Sariakandi'],
            'Joypurhat': ['Joypurhat Sadar', 'Khetlal', 'Puranigati', 'Akkelpur', 'Kalai'],
            'Pabna': ['Pabna Sadar', 'Bera', 'Sujanagar', 'Ishwardi', 'Atghoria'],
            'Barishal': ['Barishal Sadar', 'Bakerganj', 'Muladi', 'Wazirpur', 'Barisal'],
            'Bhola': ['Bhola Sadar', 'Lalmohan', 'Daulatkhan', 'Chandpur', 'Tazumuddin'],
            'Patuakhali': ['Patuakhali Sadar', 'Dumki', 'Galachipa', 'Kuarakhali', 'Bauphal'],
            'Jhalokati': ['Jhalokati Sadar', 'Kachua', 'Nalchity', 'Rajapur', 'Jhalokati'],
            'Moulvibazar': ['Moulvibazar Sadar', 'Srimangal', 'Kamalganj', 'Juri', 'Rajnagar'],
            'Habiganj': ['Habiganj Sadar', 'Chunarughat', 'Madhabpur', 'Nabiganj', 'Ajmeriganj'],
            'Sunamganj': ['Sunamganj Sadar', 'Dharampasha', 'Biswambarpur', 'Jamalganj', 'Tahirpur'],
            'Bholaganj': ['Bholaganj Sadar', 'Bholaganj', 'Fenchuganj', 'Bishwanath', 'Sylhet'],
            'Rangpur': ['Rangpur Sadar', 'Badarganj', 'Pirganj', 'Dinajpur', 'Lalmonirhat'],
            'Dinajpur': ['Dinajpur Sadar', 'Birganj', 'Phulbari', 'Parbotipur', 'Kaharol'],
            'Thakurgaon': ['Thakurgaon Sadar', 'Ranisankail', 'Pirganj', 'Haripur', 'Baliadangi'],
            'Panchagarh': ['Panchagarh Sadar', 'Tetulia', 'Debiganj', 'Boda', 'Atwari'],
            'Lalmonirhat': ['Lalmonirhat Sadar', 'Aditmari', 'Hatibandha', 'Kaliganj', 'Patgram'],
            'Mymensingh': ['Mymensingh Sadar', 'Trishal', 'Gouripur', 'Nandail', 'Haluaghat'],
            'Jamalpur': ['Jamalpur Sadar', 'Islampur', 'Dewanganj', 'Madarganj', 'Jamalpur'],
            'Sherpur': ['Sherpur Sadar', 'Nalitabari', 'Sreebardi', 'Jhenaigati', 'Kawathe'],
            'Nilphamari': ['Nilphamari Sadar', 'Dimla', 'Kishoreganj', 'Jaldhaka', 'Domar', 'Syedpur'],
        };

        // Handle division selection change
        $('#division').on('change', function() {
            var selectedDivision = $(this).val();
            var $district = $('#district');
            var $upazila = $('#upazila');

            $district.empty(); // Clear previous district options
            $district.append('<option value="">Select District</option>'); // Add default option

            $upazila.empty(); // Clear previous upazila options
            $upazila.append('<option value="">Select Upazila</option>'); // Add default option

            if (selectedDivision && districtsByDivision[selectedDivision]) {
                districtsByDivision[selectedDivision].forEach(function(district) {
                    $district.append('<option value="' + district + '">' + district + '</option>');
                });
            }
        });

        // Handle district selection change
        $('#district').on('change', function() {
            var selectedDistrict = $(this).val();
            var $upazila = $('#upazila');

            $upazila.empty(); // Clear previous upazila options
            $upazila.append('<option value="">Select Upazila</option>'); // Add default option

            if (selectedDistrict && upazilasByDistrict[selectedDistrict]) {
                upazilasByDistrict[selectedDistrict].forEach(function(upazila) {
                    $upazila.append('<option value="' + upazila + '">' + upazila + '</option>');
                });
            }
        });
    });
</script>

@include('institutionlogo')