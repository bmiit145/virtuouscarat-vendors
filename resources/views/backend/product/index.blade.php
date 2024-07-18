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
      <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">

        <table class="table table-bordered table-hover" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>SKU ID</th>
              <th>name</th>
              <th>Category</th>
              <th>Regular price</th>
              <th>Sale Price</th>
              {{-- <th>Size</th> --}}
              <th>Stock Status</th>
              <th>Stock</th>
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
            @endphp
                <tr>
                  <td>{{$product->sku}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->Category->title}}
                    </td>
                    <td>₹{{$product->regular_price}}</td>
                    <td>₹{{$product->sale_price}}</td>
                    <td>{{$stock_status}}</td>
                    <td>  {{$product->quantity }}</td>
                    <td>  @if($product->is_approvel == 0)
                              <button style="    color: black;border: none;background: red;border-radius: 10px;">Not approval</button>
                         @else
                             <button style=" color: black;border: none;background: green;border-radius: 10px;">approval</button>
                         @endif
                    </td>
                    <td>
                        <a href="{{route('product.edit',$product->id)}}" class="btn  btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                      @csrf
                      @method('DELETE')
                          <button class="btn  btn-sm dltBtn" data-id={{$product->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
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
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
