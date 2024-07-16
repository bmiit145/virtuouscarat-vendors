@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login.storeRegister') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="name" placeholder="Name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="E-Mail Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="phone" type="text" placeholder="Mobile Number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="company_name" placeholder="Company Name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <div class="col-md-6">
                                <input id="address" placeholder="Address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
                                
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="pincode" type="text" placeholder="Pincode" class="form-control @error('pincode') is-invalid @enderror" name="pincode" value="{{ old('pincode') }}" required autocomplete="pincode">

                                @error('pincode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="city" type="text" placeholder="City" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="state" placeholder="State" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" required autocomplete="state">

                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="website" placeholder="Website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') }}" required autocomplete="website">

                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="gst_number" placeholder="GST Number" type="text" class="form-control @error('gst_number') is-invalid @enderror" name="gst_number" value="{{ old('gst_number') }}" required autocomplete="gst_number">
                                @error('gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span id="gst_message" class="form-text"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input   placeholder="GST Number" type="checkbox"  name="gst_number" value="{{ old('gst_number') }}" required >
                                <span>I Agree To The <a href="#">Terms & Conditions</a></span>
                                @error('gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span id="gst_message" class="form-text"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="registerButton">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Visit 'codeastro' for more projects -->
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pincode').on('input', function() {
            var pincode = $(this).val();
            if (pincode.length === 6) {
                $.ajax({
                    url: 'https://api.postalpincode.in/pincode/' + pincode,
                    method: 'GET',
                    success: function(response) {
                        if (response[0].Status === 'Success') {
                            var postOffice = response[0].PostOffice[0];
                            $('#city').val(postOffice.District);
                            $('#state').val(postOffice.State);
                        } else {
                            alert('Invalid Pincode');
                        }
                    },
                    error: function() {
                        alert('Error fetching pincode data');
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $('#gst_number').on('input', function() {
            var gst_number = $(this).val();

            // Check if the input has at least 5 characters
            if (gst_number.length >= 5) {
                $.ajax({
                    url: 'https://sheet.gstincheck.co.in/check/c46c3385037e8bfedbf2f0965ac96155/' + gst_number,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        if (response && !response.flag) { // Adjust according to the actual response structure
                            $('#gst_message').removeClass('text-success').addClass('text-danger').text(response.message);
                        } else  {
                            $('#gst_message').removeClass('text-danger').addClass('text-success').text(response.message);
                        }
                    },
                    error: function() {
                        console.error('An error occurred while validating the GST number.');
                    }
                });
            } else {
                $('#gst_message').removeClass('text-success').addClass('text-danger').text('GST Number must be at least 5 characters long.');
            }
        });
    });
</script>
