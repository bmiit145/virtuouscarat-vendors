@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
     <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
        <div class="float-right d-flex">

            @if(Auth::user()->status != 'inactive')
{{--            <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data" class="mr-1">--}}
{{--                @csrf--}}
{{--                <label for="importFile" class="btn btn-primary btn-sm mx-1 bg-success border-0" data-toggle="tooltip" data-placement="bottom" title="Import Products" style="height: 102%;">--}}
{{--                    <i class="fas fa-file"></i> Import File--}}
{{--                    <input id="importFile" type="file" name="import_file" accept=".csv,.xlsx" style="display: none;" onchange="this.form.submit()">--}}
{{--                </label>--}}
{{--            </form>--}}
                <a href="{{ route('product.import.form') }}"  class="btn btn-primary btn-sm mx-1 bg-success border-0" data-toggle="tooltip" data-placement="bottom" title="Import Products" style="">
                    <i class="fas fa-file"></i><span> Import File </span>
                </a>
            @endif
            @if(Auth::user()->status != 'inactive')
        <a href="{{route('product.create')}}" class="btn btn-primary btn-sm mx-1" data-toggle="tooltip" data-placement="bottom" title="Add Product"><i class="fas fa-plus"></i> Add Product</a>
            @endif
            <form method="post" action="{{ route('product.clearAll') }}">
                @csrf
                <button type="submit" class="btn btn-primary bg-danger btn-sm mx-1 border-0" data-toggle="tooltip" data-placement="bottom" title="Delete All Products">
                <span class="py-1">    <i class="fas fa-trash"></i> Delete All </span>
                </button>
            </form>
        <a href="#" class="btn btn-primary btn-sm mx-1 refresh_btn" >   <i class="fas fa-sync"></i></a>
        </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">

        <table class="table table-bordered table-hover" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Certificate Number</th>
              <th>Product Name</th>
              {{-- <th>Category</th> --}}
                <th>RAP</th>
                <th>Total Price</th>
                <th>Dis%</th>
                <th>DisPrice</th>
{{--                <th>List Price</th>--}}
{{--              <th>Stock Quantity</th>--}}
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($products as $product)
            @php
              if($product->stock_status == 1)
              $stock_status = "In Stock";
              else if ($product->stock_status == 0 ) {
              $stock_status = "Out of Stock";
              }else{
              $stock_status = "On Backorder";
              }

              $productAttributes = $product->attributes->pluck('value','name');
              $ProdColor = $productAttributes->get('Color', '');
              $prodClarity = $productAttributes->get('Clarity', '');
              $prodCut = $productAttributes->get('Cut', '');
              $prodMeasurement = $productAttributes->get('Measurement', '');
            @endphp
                <tr>
                  <td>{{$product->sku}}
{{--                      <sub>{{$product->Category->title}}</sub>--}}
                  </td>
                    <td>
                        {{$product->name}} <br>
                        <span>( Color : {{$ProdColor . ', Clarity : ' . $prodClarity . ', Cut : ' . $prodCut . ', Measurement : ' . $prodMeasurement}} )</span> </td>
                    </td>
                    <td>${{$product->RAP}}</td>
                    <td>${{$product->price}}</td>
                    <td>${{$product->discount}}%</td>
                    <td>${{$product->discounted_price}}</td>
{{--                    <td>${{$product->sale_price}}--}}
{{--                        <sub>${{$product->regular_price}}</sub>--}}
                    </td>
{{--                    <td>  {{$product->quantity }}</td>--}}

                    <td>  @if($product->is_approvel == 0)
                              <button class="badge bg-warning-light rounded-pill" style="cursor: unset; border:0">Pending</button>
                          @elseif($product->is_approvel == 1)
                          <button class="badge bg-success-light rounded-pill" style="cursor: unset; border:0">Approved</button>
                         @else
                             <button class="badge bg-danger-light rounded-pill" style="cursor: unset; border:0">Rejected</button>
                         @endif
                    </td>

                    <td>
                        @if($product->is_approvel == 0)
                     <div style="text-align: center">
                    <a  id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="actionMenu">
                      <a class="dropdown-item" href="{{route('product.edit', $product->id)}}" data-toggle="tooltip" title="Edit" data-placement="bottom">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form method="POST" action="{{route('product.destroy', $product->id)}}" style="display:inline;">
                        @csrf
                        @method('delete')
                        <button class="dropdown-item" type="submit" data-id={{$product->id}} data-toggle="tooltip" data-placement="bottom" title="Delete">
                          <i class="fas fa-trash-alt"></i> Delete
                        </button>
                      </form>
                    </div>
                  </div>
                        @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
</div><!-- Visit 'codeastro' for more projects -->
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

  <style>
      span.toggle-handle.btn.btn-default {
          background: #fff !important;
      }
      .toggle-off {
          background: #e6e6e6 !important;
          box-shadow: inset 0 3px 5px rgba(0,0,0,.125) !important;
          border: 1px solid #adadad !important;
      }

      .fixed-text {
          white-space: nowrap;
      }
      .table  tr th {
          font-size: 12px;
          font-weight: 600 !important;
          color: rgb(63 66 82);
          line-height: 20px !important;
          font-style: normal !IMPORTANT;
          font-family: "Poppins", sans-serif;
          text-transform: uppercase;
      }
      .table tbody tr td {
          font-size: 13px;
          /*font-weight: 600 !important;*/
          color: rgb(63 66 82);
          line-height: 20px !important;
          font-style: normal !IMPORTANT;
          font-family: "Poppins", sans-serif;
      }
      .table .toggle-off.btn {
          padding-left: 20px !important;
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
   <script>
    document.querySelector('.refresh_btn').addEventListener('click', function(event) {
        event.preventDefault();
        location.reload();
    });
</script>

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
