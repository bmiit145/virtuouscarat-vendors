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
      <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered table-hover" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th>Order Date</th>
              <th>Order No.</th>
              <th>Customer Name</th>
                <th>Product Name</th>
                <th>QTY</th>
{{--                <th>Vendor Name</th>--}}
{{--              <th>Email</th>--}}
{{--              <th>Charge</th>--}}
              <th>Order Value</th>
                <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
    @foreach($orders as $order)
        @php
            // Filter products based on vendor_id
            $filteredProducts = $order->products->whereIn('is_fulfilled',[1 , 2 , 3 , 5])->filter(function($product) {
                return $product->product && $product->product->vendor_id == Auth::id();
            });

            // Calculate rowspan for cells that need to span multiple rows
            $rowspan = $filteredProducts->count();
        @endphp

        @foreach($filteredProducts as $index => $product)
            <tr data-order_id="{{ $order->order_id }}">
                @if($index == 0)
                    <td rowspan="{{ $rowspan }}">{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $order->order_id }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $order->billing_first_name }} {{ $order->billing_last_name }}</td>
                @endif
                <td>
                    <span>{{ $product->product->name ?? '' }}
                        <sub>{{ $product->product->sku ?? '' }}</sub>
                    </span><br/>
                </td>
                <td>
                    <span>{{ $product->quantity }}</span><br/>
                </td>
                @if($index == 0)
                    <td rowspan="{{ $rowspan }}">₹{{ number_format($order->total, 2) }}</td>
                    @endif
                    <td>
                        @if($product->is_fulfilled == 1)
                            <span class="btn btn-sm btn-success">Approved</span>
                        @elseif($product->is_fulfilled == 2)
                            <span class="btn btn-sm btn-danger">Rejected</span>
                        @elseif($product->is_fulfilled == 3)
                            <span class="btn btn-sm btn-warning">Pending</span>
                        @elseif($product->is_fulfilled == 5)
                            <span class="btn btn-sm btn-dark">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        @php
                                $is_actionable = $product->is_fulfilled == 1 ? false : true;
                        @endphp
                        @if($product->is_fulfilled != 5)
                        <form action="{{route('order.update.product.status') }}" class="order-product-action-btn-form" method="POST" style="display: flex; align-items: center;">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <select name="order-action-select" class="form-control" style="margin-right: 10px;" onchange="enableSubmitButton(this)" onfocus="enableSubmitButton(this)">
                                        @if($is_actionable)
                                            <option value="1" {{ $product->is_fulfilled == 1 ? 'selected' : '' }}>Approved</option>
                                        @endif
                                        <option value="2" {{ $product->is_fulfilled == 2 ? 'selected' : '' }}>Rejected</option>
                                    </select>
                            <button id="submit-button-{{ $order->order_id }}" style="background: #132644; color: white; border-radius: 6px;" type="submit" disabled>Submit</button>
                        </form>
                        @endif
                    </td>
            </tr>
        @endforeach
    @endforeach
</tbody>

        </table>
        <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
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

      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8]
                }
            ]
        } );

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
{{--  Order status--}}
    <script>
        $(document).ready(function(){
            $('.order-action-btn-form').submit(function(){
              var order_id = $(this).closest('tr').data('order_id');
              var status = $(this).find('select[name="order-action-select"]').val();

                var url = "{{ route('order.update.status') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        order_id: order_id,
                        status: status
                    },
                    success: function(data){
                        if(data.status){
                            location.reload();
                        }
                    }
                });
            });

            $('.order-product-action-btn-form').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var order_id = form.find('input[name="order_id"]').val();
                var product_id = form.find('input[name="product_id"]').val();
                var status = form.find('select[name="order-action-select"]').val();

                var url = "{{ route('order.update.product.status') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        order_id: order_id,
                        product_id: product_id,
                        status: status
                    },
                    success: function(data){
                        if(data.status){
                            location.reload();
                        }
                    }
                });
            });
          });
          
          function enableSubmitButton(selectElement) {
          const submitButton = $(selectElement).closest('form').find('button[type="submit"]');
          submitButton.prop('disabled', false);
      }

        $(document).ready(function() {
      $('#order-dataTable').DataTable();
  });

    </script>
@endpush
