<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .form-label-custom {
            font-weight: bold;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    @include('developer')
    @include('header')

    <div class="container mt-2">
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
                                <a class="dropdown-item" href="#">Upload Data</a>
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
    <div class="container mt-2">
        <div class="row justify-content-center">
            <!-- Login Form -->
            <div class="col-md-4">
                <h2 class="text-center mb-4">Login</h2>
                <form action="{{ route('PhpSpreadsheetController.login') }}" method="POST">
                @csrf    
                <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="loginEmail" placeholder="Enter your email" onblur="check_email(this.id)" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>

            <!-- Sign Up Form -->
            <div class="col-md-6 offset-md-1">
                <h2 class="text-center mb-4">Sign Up</h2>
                <form action="{{ route('PhpSpreadsheetController.signin') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- First Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label for="organization" class="form-label">Organization</label>
                                <input type="text" name="organization" class="form-control" id="organization" placeholder="Enter your organization" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email (Must be valid and it will be verified)" onblur="check_email1(this.id)" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                            </div>
                            
                        </div>
                        <!-- Second Column -->
                        <div class="col-md-6">
                        <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <div class="form-group">
                                    <select name="country" class="form-control" id="country" required>
                                        <option value="" label="Select Country...." selected>Select Country....</option>
                                        <option value="Afghanistan" label="Afghanistan">Afghanistan</option>
                                        <option value="Aland Islands" label="Aland Islands">Aland Islands</option>
                                        <option value="Albania" label="Albania">Albania</option>
                                        <option value="Algeria" label="Algeria">Algeria</option>
                                        <option value="American Samoa" label="American Samoa">American Samoa</option>
                                        <option value="Andorra" label="Andorra">Andorra</option>
                                        <option value="Angola" label="Angola">Angola</option>
                                        <option value="Anguilla" label="Anguilla">Anguilla</option>
                                        <option value="Antarctica" label="Antarctica">Antarctica</option>
                                        <option value="Antigua and Barbuda" label="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina" label="Argentina">Argentina</option>
                                        <option value="Armenia" label="Armenia">Armenia</option>
                                        <option value="Aruba" label="Aruba">Aruba</option>
                                        <option value="Australia" label="Australia">Australia</option>
                                        <option value="Austria" label="Austria">Austria</option>
                                        <option value="Azerbaijan" label="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas" label="Bahamas">Bahamas</option>
                                        <option value="Bahrain" label="Bahrain">Bahrain</option>
                                        <option value="Bangladesh" label="Bangladesh" selected="selected">Bangladesh</option>
                                        <option value="Barbados" label="Barbados">Barbados</option>
                                        <option value="Belarus" label="Belarus">Belarus</option>
                                        <option value="Belgium" label="Belgium">Belgium</option>
                                        <option value="Belize" label="Belize">Belize</option>
                                        <option value="Benin" label="Benin">Benin</option>
                                        <option value="Bermuda" label="Bermuda">Bermuda</option>
                                        <option value="Bhutan" label="Bhutan">Bhutan</option>
                                        <option value="Bolivia" label="Bolivia">Bolivia</option>
                                        <option value="Bosnia and Herzegovina" label="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                        <option value="Botswana" label="Botswana">Botswana</option>
                                        <option value="Bouvet Island" label="Bouvet Island">Bouvet Island</option>
                                        <option value="Brazil" label="Brazil">Brazil</option>
                                        <option value="British Indian Ocean territory" label="British Indian Ocean territory">British Indian Ocean territory</option>
                                        <option value="Brunei Darussalam" label="Brunei Darussalam">Brunei Darussalam</option>
                                        <option value="Bulgaria" label="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso" label="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi" label="Burundi">Burundi</option>
                                        <option value="Cambodia" label="Cambodia">Cambodia</option>
                                        <option value="Cameroon" label="Cameroon">Cameroon</option>
                                        <option value="Canada" label="Canada">Canada</option>
                                        <option value="Cape Verde" label="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands" label="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic" label="Central African Republic">Central African Republic</option>
                                        <option value="Chad" label="Chad">Chad</option>
                                        <option value="Chile" label="Chile">Chile</option>
                                        <option value="China" label="China">China</option>
                                        <option value="Christmas Island" label="Christmas Island">Christmas Island</option>
                                        <option value="Cocos (Keeling) Islands" label="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                        <option value="Colombia" label="Colombia">Colombia</option>
                                        <option value="Comoros" label="Comoros">Comoros</option>
                                        <option value="Congo" label="Congo">Congo</option>
                                        <option value="Cook Islands" label="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica" label="Costa Rica">Costa Rica</option>
                                        <option value="Croatia (Hrvatska)" label="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                                        <option value="Cuba" label="Cuba">Cuba</option>
                                        <option value="Cyprus" label="Cyprus">Cyprus</option>
                                        <option value="Czech Republic" label="Czech Republic">Czech Republic</option>
                                        <option value="Democratic Republic" label="Democratic Republic">Democratic Republic</option>
                                        <option value="Denmark" label="Denmark">Denmark</option>
                                        <option value="Djibouti" label="Djibouti">Djibouti</option>
                                        <option value="Dominica" label="Dominica">Dominica</option>
                                        <option value="Dominican Republic" label="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor" label="East Timor">East Timor</option>
                                        <option value="Ecuador" label="Ecuador">Ecuador</option>
                                        <option value="Egypt" label="Egypt">Egypt</option>
                                        <option value="El Salvador" label="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea" label="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea" label="Eritrea">Eritrea</option>
                                        <option value="Estonia" label="Estonia">Estonia</option>
                                        <option value="Ethiopia" label="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands" label="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands" label="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji" label="Fiji">Fiji</option>
                                        <option value="Finland" label="Finland">Finland</option>
                                        <option value="France" label="France">France</option>
                                        <option value="French Guiana" label="French Guiana">French Guiana</option>
                                        <option value="French Polynesia" label="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Territories" label="French Southern Territories">French Southern Territories</option>
                                        <option value="Gabon" label="Gabon">Gabon</option>
                                        <option value="Gambia" label="Gambia">Gambia</option>
                                        <option value="Georgia" label="Georgia">Georgia</option>
                                        <option value="Germany" label="Germany">Germany</option>
                                        <option value="Ghana" label="Ghana">Ghana</option>
                                        <option value="Gibraltar" label="Gibraltar">Gibraltar</option>
                                        <option value="Greece" label="Greece">Greece</option>
                                        <option value="Greenland" label="Greenland">Greenland</option>
                                        <option value="Grenada" label="Grenada">Grenada</option>
                                        <option value="Guadeloupe" label="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam" label="Guam">Guam</option>
                                        <option value="Guatemala" label="Guatemala">Guatemala</option>
                                        <option value="Guinea" label="Guinea">Guinea</option>
                                        <option value="Guinea-Bissau" label="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana" label="Guyana">Guyana</option>
                                        <option value="Haiti" label="Haiti">Haiti</option>
                                        <option value="Heard and McDonald Islands" label="Heard and McDonald Islands">Heard and McDonald Islands</option>
                                        <option value="Honduras" label="Honduras">Honduras</option>
                                        <option value="Hong&nbsp;Kong" label="Hong&nbsp;Kong">Hong&nbsp;Kong</option>
                                        <option value="Hungary" label="Hungary">Hungary</option>
                                        <option value="Iceland" label="Iceland">Iceland</option>
                                        <option value="India" label="India">India</option>
                                        <option value="Indonesia" label="Indonesia">Indonesia</option>
                                        <option value="Iran" label="Iran">Iran</option>
                                        <option value="Iraq" label="Iraq">Iraq</option>
                                        <option value="Ireland" label="Ireland">Ireland</option>
                                        <option value="Israel" label="Israel">Israel</option>
                                        <option value="Italy" label="Italy">Italy</option>
                                        <option value="Ivoire (Ivory Coast)" label="Ivoire (Ivory Coast)">Ivoire (Ivory Coast)</option>
                                        <option value="Jamaica" label="Jamaica">Jamaica</option>
                                        <option value="Japan" label="Japan">Japan</option>
                                        <option value="Jordan" label="Jordan">Jordan</option>
                                        <option value="Kazakhstan" label="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya" label="Kenya">Kenya</option>
                                        <option value="Kiribati" label="Kiribati">Kiribati</option>
                                        <option value="Korea (north)" label="Korea (north)">Korea (north)</option>
                                        <option value="Korea (south)" label="Korea (south)">Korea (south)</option>
                                        <option value="Kuwait" label="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan" label="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao People\'s Democratic Republic">Lao People\'s Democratic Republic</option>
                                        <option value="Latvia" label="Latvia">Latvia</option>
                                        <option value="Lebanon" label="Lebanon">Lebanon</option>
                                        <option value="Lesotho" label="Lesotho">Lesotho</option>
                                        <option value="Liberia" label="Liberia">Liberia</option>
                                        <option value="Libyan Arab Jamahiriya" label="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                        <option value="Liechtenstein" label="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania" label="Lithuania">Lithuania</option>
                                        <option value="Luxembourg" label="Luxembourg">Luxembourg</option>
                                        <option value="Macao" label="Macao">Macao</option>
                                        <option value="Macedonia" label="Macedonia">Macedonia</option>
                                        <option value="Madagascar" label="Madagascar">Madagascar</option>
                                        <option value="Malawi" label="Malawi">Malawi</option>
                                        <option value="Malaysia" label="Malaysia">Malaysia</option>
                                        <option value="Maldives" label="Maldives">Maldives</option>
                                        <option value="Mali" label="Mali">Mali</option>
                                        <option value="Malta" label="Malta">Malta</option>
                                        <option value="Marshall Islands" label="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique" label="Martinique">Martinique</option>
                                        <option value="Mauritania" label="Mauritania">Mauritania</option>
                                        <option value="Mauritius" label="Mauritius">Mauritius</option>
                                        <option value="Mayotte" label="Mayotte">Mayotte</option>
                                        <option value="Mexico" label="Mexico">Mexico</option>
                                        <option value="Micronesia" label="Micronesia">Micronesia</option>
                                        <option value="Moldova" label="Moldova">Moldova</option>
                                        <option value="Monaco" label="Monaco">Monaco</option>
                                        <option value="Mongolia" label="Mongolia">Mongolia</option>
                                        <option value="Montserrat" label="Montserrat">Montserrat</option>
                                        <option value="Morocco" label="Morocco">Morocco</option>
                                        <option value="Mozambique" label="Mozambique">Mozambique</option>
                                        <option value="Myanmar" label="Myanmar">Myanmar</option>
                                        <option value="Namibia" label="Namibia">Namibia</option>
                                        <option value="Nauru" label="Nauru">Nauru</option>
                                        <option value="Nepal" label="Nepal">Nepal</option>
                                        <option value="Netherlands" label="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles" label="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia" label="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand" label="New Zealand">New Zealand</option>
                                        <option value="Nicaragua" label="Nicaragua">Nicaragua</option>
                                        <option value="Niger" label="Niger">Niger</option>
                                        <option value="Nigeria" label="Nigeria">Nigeria</option>
                                        <option value="Niue" label="Niue">Niue</option>
                                        <option value="Norfolk Island" label="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands" label="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway" label="Norway">Norway</option>
                                        <option value="Oman" label="Oman">Oman</option>
                                        <option value="Pakistan" label="Pakistan">Pakistan</option>
                                        <option value="Palau" label="Palau">Palau</option>
                                        <option value="Palestinian Territories" label="Palestinian Territories">Palestinian Territories</option>
                                        <option value="Panama" label="Panama">Panama</option>
                                        <option value="Papua New Guinea" label="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay" label="Paraguay">Paraguay</option>
                                        <option value="Peru" label="Peru">Peru</option>
                                        <option value="Philippines" label="Philippines">Philippines</option>
                                        <option value="Pitcairn" label="Pitcairn">Pitcairn</option>
                                        <option value="Poland" label="Poland">Poland</option>
                                        <option value="Portugal" label="Portugal">Portugal</option>
                                        <option value="Puerto Rico" label="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar" label="Qatar">Qatar</option>
                                        <option value="Reacute union" label="Reacute union">Reacute union</option>
                                        <option value="Romania" label="Romania">Romania</option>
                                        <option value="Russian Federation" label="Russian Federation">Russian Federation</option>
                                        <option value="Rwanda" label="Rwanda">Rwanda</option>
                                        <option value="Saint Helena" label="Saint Helena">Saint Helena</option>
                                        <option value="Saint Kitts and Nevis" label="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                        <option value="Saint Lucia" label="Saint Lucia">Saint Lucia</option>
                                        <option value="Saint Pierre and Miquelon" label="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                        <option value="Saint Vincent and the Grenadines" label="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                        <option value="Samoa" label="Samoa">Samoa</option>
                                        <option value="San Marino" label="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe" label="Sao Tome and Principe">Sao Tome and Principe</option>
                                        <option value="Saudi Arabia" label="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal" label="Senegal">Senegal</option>
                                        <option value="Serbia and Montenegro" label="Serbia and Montenegro">Serbia and Montenegro</option>
                                        <option value="Seychelles" label="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone" label="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore" label="Singapore">Singapore</option>
                                        <option value="Slovakia" label="Slovakia">Slovakia</option>
                                        <option value="Slovenia" label="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands" label="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia" label="Somalia">Somalia</option>
                                        <option value="South Africa" label="South Africa">South Africa</option>
                                        <option value="South Georgia and the South Sandwich Islands" label="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                        <option value="Spain" label="Spain">Spain</option>
                                        <option value="Sri Lanka" label="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan" label="Sudan">Sudan</option>
                                        <option value="Suriname" label="Suriname">Suriname</option>
                                        <option value="Svalbard and Jan Mayen Islands" label="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                                        <option value="Swaziland" label="Swaziland">Swaziland</option>
                                        <option value="Sweden" label="Sweden">Sweden</option>
                                        <option value="Switzerland" label="Switzerland">Switzerland</option>
                                        <option value="Syria" label="Syria">Syria</option>
                                        <option value="Taiwan" label="Taiwan">Taiwan</option>
                                        <option value="Tajikistan" label="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania" label="Tanzania">Tanzania</option>
                                        <option value="Thailand" label="Thailand">Thailand</option>
                                        <option value="Togo" label="Togo">Togo</option>
                                        <option value="Tokelau" label="Tokelau">Tokelau</option>
                                        <option value="Tonga" label="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago" label="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia" label="Tunisia">Tunisia</option>
                                        <option value="Turkey" label="Turkey">Turkey</option>
                                        <option value="Turkmenistan" label="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos Islands" label="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                        <option value="Tuvalu" label="Tuvalu">Tuvalu</option>
                                        <option value="Uganda" label="Uganda">Uganda</option>
                                        <option value="Ukraine" label="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates" label="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom" label="United Kingdom">United Kingdom</option>
                                        <option value="United States of America" label="United States of America">United States of America</option>
                                        <option value="Uruguay" label="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan" label="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu" label="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City" label="Vatican City">Vatican City</option>
                                        <option value="Venezuela" label="Venezuela">Venezuela</option>
                                        <option value="Vietnam" label="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (British)" label="Virgin Islands (British)">Virgin Islands (British)</option>
                                        <option value="Virgin Islands (US)" label="Virgin Islands (US)">Virgin Islands (US)</option>
                                        <option value="Wallis and Futuna Islands" label="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                                        <option value="Western Sahara" label="Western Sahara">Western Sahara</option>
                                        <option value="Yemen" label="Yemen">Yemen</option>
                                        <option value="Zaire" label="Zaire">Zaire</option>
                                        <option value="Zambia" label="Zambia">Zambia</option>
                                        <option value="Zimbabwe" label="Zimbabwe">Zimbabwe</option>
                                    </select>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="profession" class="form-label">Profession</label>
                                <input type="text" name="profession" class="form-control" id="profession" placeholder="Enter your profession" required>
                            </div>
                            <div class="mb-3">
                                <label for="purpose" class="form-label">Purpose</label>
                                <input type="text" name="purpose" class="form-control" id="purpose" placeholder="Enter the purpose of your signup" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>
            </div>
        </div>
    </div>


    <br>

    @include('institutionlogo')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function check_email1(id) {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email = document.getElementById('email').value;
            if (email != '' && reg.test(email) == false) {
                alert('Please Enter Valid Email Address.');
                document.form_name.email.value = "";
                //document.getElementById("email").reset();

            }
        }
    </script>
    <script>
        function check_email(id) {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email = document.getElementById('loginEmail').value;
            if (email != '' && reg.test(email) == false) {
                alert('Please Enter Valid Email Address.');
                document.form_name.loginEmail.value = "";
                //document.getElementById("email").reset();

            }
        }
    </script>

    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Find the success alert element
            var successAlert = document.getElementById('success-alert');
            // If the success alert exists, set a timeout to hide it after 5 seconds (5000 milliseconds)
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>
</body>

</html>