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
                    <a class="nav-link" id="finance-info-tab" data-toggle="tab" href="#finance-info" role="tab" aria-controls="Finance-info" aria-selected="false">Finance Information</a>
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
                                        <label for="company_name" class="col-form-label"><b>Company Name</b><span
                                                class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="company_name"
                                            value="{{ $data->company_name ?? '' }}" name="company_name" required>
                                        @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
                                            value="{{ $data->alternate_mail ?? '' }}" name="contact_person_alternate_email"
                                            required>
                                        @error('contact_person_alternate_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-12 mb-3 d-flex justify-content-center">
                                        <button class="btn btn-info p_update_btn" type="button" onclick="sendUpdateOTP($(this))">Update Personal
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
                                    <label for="gst_number" class="col-form-label"><b>GST Number</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->gst ?? '' }}" id="gst_number"
                                           class="form-control" name="gst_number" required>
                                    @error('gst_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label for="website" class="col-form-label"><b>Website</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->user->website ?? '' }}" class="form-control"
                                           id="website" name="website" required>
                                    @error('website')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="communication_address" class="col-form-label"><b>Communication Address</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->communication_address ?? '' }}" id="communication_address"
                                           class="form-control" name="communication_address" required>
                                    @error('communication_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="city" class="col-form-label"><b>City</b><span
                                            class="text-danger"></span></label>

                                    <input type="text"  class="form-control"
                                        id="city" name="city" value="{{ $user->user->city ?? '' }}" required>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="state" class="col-form-label"><b>State</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->user->state ?? '' }}" class="form-control"
                                        id="state" name="state" required>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="pincode" class="col-form-label"><b>Pincode</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->user->pincode ?? '' }}" class="form-control"
                                        id="pincode" name="pincode" required>
                                    @error('pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-12 mb-3 d-flex justify-content-center">
                                <button class="btn btn-info b_update_btn" type="button" onclick="sendUpdateOTP($(this))">Update Business
                                    Information</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Finance Information Tab -->
                <div class="tab-pane fade" id="finance-info" role="tabpanel" aria-labelledby="finance-info-tab">
                    <div class="card mt-4">
                        <h5 class="card-header">Bank Information</h5>
                        <div class="card-body">
                            <div class="row">
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
                                    <label for="branch_name" class="col-form-label"><b>Branch Name</b><span
                                            class="text-danger"></span></label>
                                    <input type="text" value="{{ $user->branch_name ?? '' }}" class="form-control"
                                           id="branch_name" name="branch_name" required>
                                    @error('branch_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-12 mb-3 d-flex justify-content-center">
                                <button class="btn btn-info b_update_btn" type="button" onclick="sendUpdateOTP($(this))">Update Bank
                                    Information</button>
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
    <!-- Include Bootstrap JS after jQuery -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
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
            function sendUpdateOTP(btn) {
                // disable the button
                btn.attr('disabled', true);
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
                        // enable the button
                        btn.attr('disabled', false);
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
                    company_name: $('#company_name').val(),
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
                    gst_number: $('#gst_number').val(),
                    // bank_name: $('#bank_name').val(),
                    // bank_account_number: $('#bank_account_number').val(),
                    // ifsc_code: $('#ifsc_code').val(),
                    // branch_name: $('#branch_name').val(),
                    city: $('#city').val(),
                    state: $('#state').val(),
                    pincode: $('#pincode').val(),
                    website: $('#website').val(),
                    communication_address: $('#communication_address').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Main response:', response); // Log the entire response to the console

                        if (response.success) {
                            $('#otp').val('');
                            $('#otpModal').modal('hide');
                            toastr.success(response.message);

                            // Ensure the response contains the user object and its properties
                            if (response.user) {
                                console.log(response.user.city , "User data"); // Log the user object to the console
                                $('#city').val(response.user.city ?? '');
                                $('#state').val(response.user.state ?? '');
                                $('#pincode').val(response.user.pincode ?? '');
                                $('#website').val(response.user.website ?? '');
                            } else {
                                console.error('User data is not present in the response');
                            }
                        }
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

            function updateFinanceInfo(){
                var url = '{{ route('updateFinanceInfo') }}';
                var formData = {
                    id : $('#id').val(),
                    bank_name: $('#bank_name').val(),
                    bank_account_number: $('#bank_account_number').val(),
                    ifsc_code: $('#ifsc_code').val(),
                    branch_name: $('#branch_name').val(),
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
                            } else if ($('#finance-info-tab').hasClass('active')) {
                                updateFinanceInfo();
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
