@extends('stores::layouts.master')

@section('content')
    <div class="app-content" onload="initialize()">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('stores::global.NewCustomer')</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">@lang('modules.Stores')</li>
                <li class="breadcrumb-item"><a href="#">@lang('stores::global.NewCustomer')</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('Store.Customers.store',['id' => encode($store->id)])}}">
                    {{csrf_field()}}

                    <div class="tile">
                        <h3 class="tile-title">@lang('global.Add')</h3>
                        <div class="tile-body ">
                            <div class="row">
                                <div class="col-sm col-md-6">

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.FirstName')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                               type="text" name="first_name"
                                               value="{{old('first_name')}}" placeholder="">
                                        @if ($errors->has('first_name'))
                                            <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.LastName')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                               type="text" name="last_name"
                                               value="{{old('last_name')}}" placeholder="">
                                        @if ($errors->has('last_name'))
                                            <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.Email')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               type="text" name="email" value="{{old('email')}}"
                                               placeholder="">
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.PhoneNumber')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                               type="text" name="phone_number" value="{{old('phone_number')}}"
                                               placeholder="">
                                        @if ($errors->has('phone_number'))
                                            <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.Password')}}<strong>*</strong></label>
                                        <label class="pull-right">
                                            <span class="badge badge-primary">
                                                <i role="button" id="passtoggle" class="fa fa-eye-slash fa-lg p-1"></i>
                                            </span>
                                        </label>
                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="" name="password" value="{{old('password')}}">
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm col-md-6">

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.StreetAddress')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('street_address') ? ' is-invalid' : '' }}"
                                               type="text" name="street_address" value="{{old('street_address')}}"
                                               placeholder="">
                                        @if ($errors->has('street_address'))
                                            <div class="invalid-feedback">{{ $errors->first('street_address') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.City')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                               type="text" name="city" value="{{old('city')}}" placeholder="">
                                        @if ($errors->has('city'))
                                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="control-label">{{trans('stores::global.Country')}} <strong>*</strong></label>
                                        <select id="country" name="country" class="form-control">
                                            <option value="AF">Afghanistan</option>
                                            <option value="AX">Åland Islands</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia, Plurinational State of</option>
                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, the Democratic Republic of the</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Côte d'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">Curaçao</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard Island and McDonald Islands</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao</option>
                                            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PS">Palestinian Territory, Occupied</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RE">Réunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BL">Saint Barthélemy</option>
                                            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="MF">Saint Martin (French part)</option>
                                            <option value="PM">Saint Pierre and Miquelon</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SX">Sint Maarten (Dutch part)</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UM">United States Minor Outlying Islands</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="VG">Virgin Islands, British</option>
                                            <option value="VI">Virgin Islands, U.S.</option>
                                            <option value="WF">Wallis and Futuna</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.PostalCode')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}"
                                               type="text" name="postal_code" value="{{old('postal_code')}}"
                                               placeholder="">
                                        @if ($errors->has('postal_code'))
                                            <div class="invalid-feedback">{{ $errors->first('postal_code') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{trans('stores::global.ConfirmPassword')}}
                                            <strong>*</strong></label>
                                        <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                               type="password" placeholder="" name="password_confirmation"
                                               value="{{old('password_confirmation')}}">

                                        @if ($errors->has('password_confirmation'))
                                            <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tile-footer text-center">
                            <button type="submit" class="btn btn-primary" type="button">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>@lang('global.Confirm')</button>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="{{url()->previous()}}">
                                <i class="fa fa-fw fa-lg fa-times-circle"></i>@lang('global.Cancel')
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearix"></div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('js/plugins/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $('#gender').select2();
        $('#country').select2();
        $('#birth-date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            endDate: '0d'
        });

        //Show password and confirmation on eye click
        $('#passtoggle').click(function () {
            if ($(this).hasClass('fa-eye-slash')) {
                $("[name='password']").prop('type', 'text');
                $("[name='password_confirmation']").prop('type', 'text');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                $("[name='password']").prop('type', 'password');
                $("[name='password_confirmation']").prop('type', 'password');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    </script>
@endsection
