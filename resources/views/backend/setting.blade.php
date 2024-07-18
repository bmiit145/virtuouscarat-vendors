<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Validation</title>
    <style>
        .toast {
            visibility: hidden;
            max-width: 50%;
            height: 50px;
            margin: auto;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            position: fixed;
            z-index: 1;
            left: 0;
            right: 0;
            bottom: 30px;
            font-size: 17px;
        }

        .toast #desc {
            padding: 16px;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
</head>
<body>

@extends('backend.layouts.master')

@section('main-content')
    <div class="card_main_row">
        <div class="toast" id="toast">
            <div id="desc">Toast Message</div>
        </div>
        <div class="card">
            <h5 class="card-header">Personal Information</h5>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="contact_person_name" class="col-form-label"><b>Contact Person Name</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="contact_person_name" value="{{ $data->name }}" name="contact_person_name" required>
                        @error('contact_person_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="contact_person_mobile" class="col-form-label"><b>Contact Person Mobile Number</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="contact_person_mobile" value="{{ $data->phone }}" name="contact_person_mobile" required>
                        @error('contact_person_mobile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="contact_person_email" class="col-form-label"><b>Contact Person Email</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="contact_person_email" value="{{ $data->email }}" name="contact_person_email" required disabled>
                        @error('contact_person_email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="contact_person_alternate_number" class="col-form-label"><b>Contact Person Alternate Number</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="contact_person_alternate_number" name="contact_person_alternate_number" required>
                        @error('contact_person_alternate_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="contact_person_alternate_email" class="col-form-label"><b>Contact Person Alternate Email</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="contact_person_alternate_email" name="contact_person_alternate_email" required>
                        @error('contact_person_alternate_email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <h5 class="card-header">Business Information</h5>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="business_name" class="col-form-label"><b>Business Name</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="business_name" name="business_name" required>
                        @error('business_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="business_type" class="col-form-label"><b>Business Type</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="business_type" name="business_type" required>
                        @error('business_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="bank_name" class="col-form-label"><b>Bank Name</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                        @error('bank_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="bank_account_number" class="col-form-label"><b>Bank Account Number</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" required>
                        @error('bank_account_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="ifsc_code" class="col-form-label"><b>IFSC Code</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" required>
                        @error('ifsc_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="brand_name" class="col-form-label"><b>Brand Name</b><span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" required>
                        @error('brand_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="gst_number" class="col-form-label"><b>GST Number</b><span class="text-danger"></span></label>
                        <input type="text" value="{{ $data->gst_number }}" id="gst_number" class="form-control" name="gst_number" required>
                        @error('gst_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success update_btn" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');
        $('#lfm1').filemanager('image');
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });

        $(document).ready(function() {
            $('#quote').summernote({
                placeholder: "Write short Quote.....",
                tabsize: 2,
                height: 100
            });
        });
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
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

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.update_btn').click(function(e) {
                e.preventDefault();

                var contact_person_name = $('#contact_person_name').val();
                var contact_person_mobile = $('#contact_person_mobile').val();
                var contact_person_alternate_number = $('#contact_person_alternate_number').val();
                var contact_person_alternate_email = $('#contact_person_alternate_email').val();
                var business_name = $('#business_name').val();
                var business_type = $('#business_type').val();
                var bank_name = $('#bank_name').val();
                var bank_account_number = $('#bank_account_number').val();
                var ifsc_code = $('#ifsc_code').val();
                var brand_name = $('#brand_name').val();
                var gst_number = $('#gst_number').val();
                var url = '{{ route('updateSetting') }}'; // Use route helper

                // Validation
                if (!contact_person_name || !contact_person_mobile || !contact_person_alternate_number || !contact_person_alternate_email || !business_name || !business_type || !bank_name || !bank_account_number || !ifsc_code || !brand_name || !gst_number) {
                    showToast('Please fill all the fields.');
                    return;
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        contact_person_name: contact_person_name,
                        contact_person_mobile: contact_person_mobile,
                        contact_person_alternate_number: contact_person_alternate_number,
                        contact_person_alternate_email: contact_person_alternate_email,
                        business_name: business_name,
                        business_type: business_type,
                        bank_name: bank_name,
                        bank_account_number: bank_account_number,
                        ifsc_code: ifsc_code,
                        brand_name: brand_name,
                        gst_number: gst_number
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status) {
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        showToast('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
@endpush

</body>
</html>
