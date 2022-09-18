@extends('layouts.app')
@section('title', 'Stock Details')
@section('css')
    
@endsection

@section('content')

<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Stock Details</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        {{-- <div class="dropdown no-arrow">
          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddProductModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div> --}}
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="StockListTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#NO</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Product</th>
                    <th class="text-center">Size = Piece</th>
                    {{-- <th class="text-center">Piece</th> --}}
                    <th class="text-center">DP</th>
                    <th class="text-center bg-success">%</th>
                    <th class="text-center">TP</th>
                    <th class="text-center bg-info">Stock Size</th>
                    <th class="text-center bg-info">Stock Piece</th>
                    <th class="text-center bg-info">BP</th>
                    <th class="text-center bg-info">SP</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
  
        </table>
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.stockProduct')
<!--Modals-->

@endsection

@section('script')
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script>
<script>
 
   $('#StockListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
    //   "bAutoWidth": false,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('stock') }}",
      },
      columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'company_name',
            name: 'company_name'
        },
        {
            data: 'group_name',
            name: 'group_name'
        },
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'sizePiece',
            name: 'sizePiece'
        },
        // {
        //     data: 'piece',
        //     name: 'piece'
        // },
        {
            data: 'buy_price',
            name: 'buy_price'
        },
        {
            data: 'percent',
            name: 'percent'
        },
        {
            data: 'sell_price',
            name: 'sell_price'
        },
        {
            data: 'stock_size',
            name: 'stock_size'
        },
        {
            data: 'stock_piece',
            name: 'stock_piece'
        },
        {
            data: 'invest',
            name: 'invest'
        },
        {
            data: 'sell',
            name: 'sell'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
      ]
  });

  function addStock() {
        // if ( $( "#company_id" ).val() != '' ) {
        //     $("#company_id").removeClass("errorInputBox");
        //     $( "#company_idError").text('').removeClass("ErrorMsg");
            
        // } else {
        //     $("#company_id").addClass("errorInputBox");
        //     $( "#company_idError").text('Company Name Is Required').addClass("ErrorMsg");
        // }

        

        // if ( $( "#company_id" ).val() && $( "#group_id" ).val() && $( "#product_name" ).val() && $( "#size" ).val() && $( "#piece" ).val() && $( "#buy_price" ).val() && $( "#sell_price" ).val() ) {
        //     $( "#company_idError,#group_idError,#product_nameError,#sizeError,#pieceError,#buy_priceError,#sell_priceError").text('');
        //     $( "#company_id,#group_id,#product_name,#size,#piece,#buy_price,#sell_price").removeClass("errorInputBox");
          
            var myData =  $('#StockProductForm').serialize();
            // alert(myData);
            $.ajax({
                type: 'POST', //THIS NEEDS TO BE GET
                url: "{{ route('addStock') }}",
                // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
                // data: {_token: _token, myData: myData},
                data: myData,
                // dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                      
                      $("#success_message").text(response.success);
                      $('#StockListTable').DataTable().ajax.reload();
                      $('#StockProductModal').modal('hide');
                      $("#StockProductForm").trigger("reset");
                      
                      SuccessMsg();
                    }

                },error:function(){ 
                    console.log(response);
                }
            });
        // }
  }

  function getStockProductViewData(Id) {
      $.ajax({
        type: 'GET',
        url: "{{url('viewStock')}}"+"/"+Id,
        success: function (response) {
            console.log(response);
            if (response) {
            $('#product_id').val(response.id);
            $('#company_id').val(response.company_id);
            $('#group_id').val(response.group_id);
            $('#piece').val(response.piece);

            $('#product_name').text(response.product_name);
            $('#size').text(response.size+' = '+response.piece+' Piece');
            

            // $('#old_stock_size').val(response.stock_size);
            // $('#total_stock_size').val(response.stock_size);
            $('#old_stock_size').val( (response.stock_piece / response.piece) );
            $('#total_stock_size').val( (response.stock_piece / response.piece) );

            
            
            $('#old_stock_piece').val(response.stock_piece);
            $('#total_stock_piece').val(response.stock_piece);
            $('#total_stock_piece_original').val(response.stock_piece);
            // $('#epiece').val(response.piece);
            // $('#ebuy_price').val(response.buy_price);
            // $('#esell_price').val(response.sell_price);
            }

        },error:function(){ 
            console.log(response);
        }
    });
  }
  
</script>

@endsection
