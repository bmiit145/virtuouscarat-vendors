<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Information Tabs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    @extends('backend.layouts.master')

    @section('main-content')
        <div class="card_main_row">
            <div class="toast" id="toast">
                <div id="desc">Toast Message</div>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="personal-info-tab" data-toggle="tab" href="#personal-info" role="tab" aria-controls="personal-info" aria-selected="true">Personal Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="business-info-tab" data-toggle="tab" href="#business-info" role="tab" aria-controls="business-info" aria-selected="false">Business Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="kyc-info-tab" data-toggle="tab" href="#kyc-info" role="tab" aria-controls="kyc-info" aria-selected="false">KYC Information</a>
                </li>
            </ul>


            <div class="tab-content" id="myTabContent">
                <!-- Personal Information Tab -->
                <div class="tab-pane fade show active" id="personal-info" role="tabpanel"
                    aria-labelledby="personal-info-tab">
                    <div class="card">
                        <h5 class="card-header">Personal Information</h5>
                        <div class="card-body">
                            <form id="personal_conatct_form">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="contact_person_name" class="col-form-label"><b>Contact Person Name</b><span
                                                class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="contact_person_name"
                                            value="{{ $data->name ?? '' }}" name="contact_person_name" required>
                                        @error('contact_person_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="contact_person_mobile" class="col-form-label"><b>Contact Person Mobile
                                                Number</b><span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="contact_person_mobile"
                                            value="{{ $data->phone ?? '' }}" name="contact_person_mobile" required>
                                        @error('contact_person_mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="contact_person_email" class="col-form-label"><b>Contact Person
                                                Email</b><span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="contact_person_email"
                                            value="{{ $data->email ?? '' }}" name="contact_person_email" required disabled>
                                        @error('contact_person_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="contact_person_alternate_number" class="col-form-label"><b>Contact Person
                                                Alternate Number</b><span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="contact_person_alternate_number"
                                            value="{{ $data->alternate_number ?? '' }}" name="contact_person_alternate_number"
                                            required>
                                        @error('contact_person_alternate_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="contact_person_alternate_email" class="col-form-label"><b>Contact Person
                                                Alternate Email</b><span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="contact_person_alternate_email"
                                            value="{{ $data->alternate_email ?? '' }}" name="contact_person_alternate_email"
                                            required>
                                        @error('contact_person_alternate_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-12 mb-3 d-flex justify-content-center">
                                        <button class="btn btn-info p_update_btn" type="button" onclick="sendUpdateOTP()">Update Personal
                                            Information</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Business Information Tab -->
                <div class="tab-pane fade" id="business-info" role="tabpanel" aria-labelledby="business-info-tab">
                    <div class="card mt-4">
                        <h5 class="card-header">Business Information</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="business_name" class="col-form-label"><b>Business Name</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" id="business_name"
                                        value="{{ $user->business_name ?? '' }}" name="business_name" required>
                                    @error('business_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="business_type" class="col-form-label"><b>Business Type</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->business_type ?? '' }}" class="form-control"
                                        id="business_type" name="business_type" required>
                                    @error('business_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="bank_name" class="col-form-label"><b>Bank Name</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->bank_name ?? '' }}" class="form-control"
                                        id="bank_name" name="bank_name" required>
                                    @error('bank_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="bank_account_number" class="col-form-label"><b>Bank Account
                                            Number</b><span class="text-danger"></span></label>
                                    <input type="number" value="{{ $user->account_number ?? '' }}" class="form-control"
                                        id="bank_account_number" name="bank_account_number" required>
                                    @error('bank_account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="ifsc_code" class="col-form-label"><b>IFSC Code</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->ifsc_code ?? '' }}" class="form-control"
                                        id="ifsc_code" name="ifsc_code" required>
                                    @error('ifsc_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="brand_name" class="col-form-label"><b>Brand Name</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->brand_name ?? '' }}" class="form-control"
                                        id="brand_name" name="brand_name" required>
                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="gst_number" class="col-form-label"><b>GST Number</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->gst ?? '' }}" id="gst_number"
                                        class="form-control" name="gst_number" required>
                                    @error('gst_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-12 mb-3 d-flex justify-content-center">
                                <button class="btn btn-info b_update_btn" type="button" onclick="sendUpdateOTP()">Update Business
                                    Information</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- KYC Information Tab -->
                <div class="tab-pane fade" id="kyc-info" role="tabpanel" aria-labelledby="kyc-info-tab">
                    <div class="card mt-4">
                        <h5 class="card-header">KYC Information</h5>
                        <div class="card-body">
                            <div class="row">
                                <!-- KYC Information Fields -->
                                <div class="form-group col-6">
                                    <label for="aadhaar_number" class="col-form-label"><b>Aadhaar Number</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" id="aadhaar_number"
                                        value="{{ $user->aadhaar_number ?? '' }}" name="aadhaar_number" required>
                                    @error('aadhaar_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="pan_number" class="col-form-label"><b>PAN Number</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" id="pan_number"
                                        value="{{ $user->pan_number ?? '' }}" name="pan_number" required>
                                    @error('pan_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="passport_number" class="col-form-label"><b>Passport Number</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" id="passport_number"
                                        value="{{ $user->passport_number ?? '' }}" name="passport_number" required>
                                    @error('passport_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="voter_id" class="col-form-label"><b>Voter ID</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" class="form-control" id="voter_id"
                                        value="{{ $user->voter_id ?? '' }}" name="voter_id" required>
                                    @error('voter_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-12 mb-3 d-flex justify-content-center">
                                    <button class="btn btn-info k_update_btn" type="submit">Update KYC
                                        Information</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- OTP Modal -->
            <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="otpForm">
                                <div class="form-group">
                                    <label for="otp">OTP Sent to your registered mail</label>
                                    <input type="text" class="form-control" id="otp" name="otp" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
        <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @endpush

    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

        <script>
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $(document).ready(function() {
                $('#summary').summernote({
                    placeholder: "Write short description.....",
                    tabsize: 2,
                    height: 150
                });
                $('#quote').summernote({
                    placeholder: "Write short Quote.....",
                    tabsize: 2,
                    height: 100
                });
                $('#description').summernote({
                    placeholder: "Write detailed description.....",
                    tabsize: 2,
                    height: 150
                });
            });
        </script>

        <script>
            function showToast(message) {
                var toast = $('#toast');
                $('#desc').text(message);
                toast.css('visibility', 'visible');
                setTimeout(function() {
                    toast.css('visibility', 'hidden');
                }, 3000);
            }
            function sendUpdateOTP() {
                // send OTP to the user by ajax route sendSettingOtp
                var url = '{{ route('sendSettingOtp') }}';
                var id = $('#id').val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#otpModal').modal('show');
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            }


            function updatePersonalInfo(){
                var url = '{{ route('updatePersonalInfo') }}';
                var formData = {
                    id : $('#id').val(),
                    contact_person_name: $('#contact_person_name').val(),
                    contact_person_mobile: $('#contact_person_mobile').val(),
                    contact_person_alternate_number: $('#contact_person_alternate_number').val(),
                    contact_person_alternate_email: $('#contact_person_alternate_email').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#otp').val('');
                        $('#otpModal').modal('hide');
                        toastr.success(response.message);
                    },
                    error: function(response) {
                        $('#otp').val('');
                        $('#otpModal').modal('hide');
                        let errors = response.responseJSON.errors;
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                toastr.error(errors[key][0]);
                            }
                        }
                    }
                });
            }

            function updateBusinessInfo(){
                var url = '{{ route('updateBusinessInfo') }}';
                var formData = {
                    id : $('#id').val(),
                    business_name: $('#business_name').val(),
                    business_type: $('#business_type').val(),
                    bank_name: $('#bank_name').val(),
                    bank_account_number: $('#bank_account_number').val(),
                    ifsc_code: $('#ifsc_code').val(),
                    brand_name: $('#brand_name').val(),
                    gst_number: $('#gst_number').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#otp').val('');
                        $('#otpModal').modal('hide');
                        toastr.success(response.message);
                    },
                    error: function(response) {
                        $('#otp').val('');
                        $('#otpModal').modal('hide');
                        let errors = response.responseJSON.errors;
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                toastr.error(errors[key][0]);
                            }
                        }
                    }
                });
            }

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#otpForm').submit(function(e) {
                    e.preventDefault();

                    // Create a new FormData object
                    var formData = new FormData(this);

                    // Append the OTP value
                    var otp = $('#otp').val();
                    formData.append('otp', otp);

                    $.ajax({
                        url: '{{ route('verifySettingOtp') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,  // Important for FormData
                        contentType: false,  // Important for FormData
                        success: function(response) {
                            // Call appropriate function to update the information by active tab
                            if ($('#personal-info-tab').hasClass('active')) {
                                updatePersonalInfo();
                            } else if ($('#business-info-tab').hasClass('active')) {
                                updateBusinessInfo();
                            } else if ($('#kyc-info-tab').hasClass('active')) {
                                updateKycInfo();
                            }
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        }
                    });
                });
            });

        </script>
    @endpush
</body>

</html>
