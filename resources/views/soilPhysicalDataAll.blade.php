@include('developer')

@include('header')


@include('navigation')


<style>
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

    #soilchemicaldata1 th,
        #soilchemicaldata1 td {
            text-align: center;
            vertical-align: middle;
            /* Optional: Vertically center content as well */
        }
</style>

<div class="container mt-3">
    <div class="flex-container" style="font-family: 'Times New Roman', Times, serif;">
        <h4>Soil Chemical Data</h4>
    </div>

    <div class="table-wrapper">
        <div class="table-responsive-container">
            <table class="table" id="soilchemicaldata1">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Division</th>
                        <th>District</th>
                        <th>Upazila</th>
                        <th>Year</th>
                        <th>Land Type</th>
                        <th>Soil Group</th>
                        <th>Soil Group Area</th>
                        <th>Texture</th>
                        <th>Consistency</th>
                        <th>Drainage</th>
                        <th>Moisture</th>
                        <th>Recession</th>
                        <th>Relief</th>
                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
                        <th>Action</th>
                        @endif
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
                        <td>{{ $item->year }}</td>

                        <td>{{ $item->land_type }}</td>
                        <td>{{ $item->soil_group }}</td>
                        <td>{{ $item->sg_area }}</td>
                        <td>{{ $item->texture }}</td>
                        <td>{{ $item->consistency }}</td>
                        <td>{{ $item->drainage }}</td>
                        <td>{{ $item->moisture }}</td>
                        <td>{{ $item->recession }}</td>
                        <td>{{ $item->relief }}</td>
                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin'))
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
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>


</div>

<script>
    $(document).ready(function() {
        $('#soilchemicaldata1').DataTable();
    });
</script>

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