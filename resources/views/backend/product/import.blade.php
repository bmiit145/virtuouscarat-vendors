
@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mx-5">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <div class="float-left">
            <h6 class="m-0 font-weight-bold text-primary">Import Products</h6>
            <span class="text-muted"> Import Existing Data through excel file</span>
            </div>
            <div class="float-right d-flex">
                <button type="button" class="btn btn-dark mt-3"> <i class="fas fa-backward"></i> <a href="{{route('product.index')}}" class="text-white text-decoration-none">Back</a> </button>
            </div>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
              <form action="{{route('product.import')}}" method="post" enctype="multipart/form-data">
                @csrf
                        <div class="form-group mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" name="import_file" class="form-control" accept=".xls, .xlsx, .csv" required>
                            <small class="text-muted">Only .xls, .xlsx and csv file allowed</small>
                            <button type="submit" class="btn btn-primary mt-3"> <i class="fas fa-save"></i> Import </button>
                        </div>
            </form>
                    </div>
                    <div class="col-md-6">
                        <h5>Sample Files</h5>
                        <div class="d-flex flex-wrap">
                            <a href="{{asset('excel/sample/NIVODA-sample.xlsx')}}" class="btn btn-success mx-2 mt-1"> <i class="fas fa-download"></i> Format 1 </a>
                            <a href="{{asset('excel/sample/Dhanlaxmi_Exports-sample.xlsx')}}" class="btn btn-success mx-2 mt-1"> <i class="fas fa-download"></i> Format 2</a>
                            <a href="{{asset('excel/sample/vdb-sample.xlsx')}}" class="btn btn-success mx-2 mt-1"> <i class="fas fa-download"></i> Format 3</a>
                        </div>
                        <div class="mt-2">
                            <ol>
                                <li>Download the sample file to see the format</li>
                                <li>Fill the data in the same format</li>
                                <li>Upload the file</li>
                            </ol>
                        </div>
                    </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Include SweetAlert2 CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <style>
        div.dataTables_wrapper div.dataTables_paginate{
            /*display: none;*/
        }
        .zoom {
            transition: transform .2s; /* Animation */
        }

        .zoom:hover {
            transform: scale(5);
        }

        .btn {
            display: flex;
            align-items: center;
        }

        .btn i {
            margin-right: 8px; /* Adjust spacing between icon and text */
        }
    </style>
@endpush

@push('scripts')

    <!-- Page level plugins -->
    <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Include SweetAlert2 JavaScript from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Page level custom scripts -->
    {{--  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>--}}

    <script>

        $(document).ready(function() {
            $('#product-dataTable').DataTable({
                "paging": true,    // Enable pagination
                "ordering": false, // Disable sorting
                "info": true
            });
        });

        // Sweet alert

        function deleteData(id){

        }
    </script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e){
                var form=$(this).closest('form');
                var dataID=$(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal.fire("Your data is safe!");
                        }
                    });
            })
        })
    </script>
{{--    <script>--}}
{{--        document.querySelector('.refresh_btn').addEventListener('click', function(event) {--}}
{{--            event.preventDefault();--}}
{{--            location.reload();--}}
{{--        });--}}
{{--    </script>--}}

    <script>
        // duplicate SKUs model which will be shown when duplicate SKUs are found in the uploaded file as got by duplicateSkus session of laravel
        @if(session('duplicateSkus'))
        var duplicateSkus = @json(session('duplicateSkus'));

        // Create table with multiple columns
        var tableHtml = '<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">';
        tableHtml += '<tbody>';

        // Define the number of columns
        var numColumns = 4; // Adjust as needed
        var rows = Math.ceil(duplicateSkus.length / numColumns);

        for (var i = 0; i < rows; i++) {
            tableHtml += '<tr>';
            for (var j = 0; j < numColumns; j++) {
                var index = i * numColumns + j;
                var sku = duplicateSkus[index] || ''; // Handle if there are fewer SKUs than columns
                tableHtml += '<td style="border: 1px solid #ddd; padding: 8px; text-align: left;">' + sku + '</td>';
            }
            tableHtml += '</tr>';
        }

        tableHtml += '</tbody></table>';

        swal.fire({
            title: "Duplicate SKUs Found",
            // content: {
            //     element: 'div',
            //     attributes: {
            //         innerHTML: tableHtml
            //     }
            // },
            html: tableHtml,
            icon: "warning",
            dangerMode: true,
            backdrop: true,
            // closeOnClickOutside: false,
            allowOutsideClick: false,
            width: '80%',
        });
        @endif
    </script>

@endpush
