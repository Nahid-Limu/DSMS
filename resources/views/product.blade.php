@extends('layouts.app')
@section('title', 'Product Setting')
@section('css')
    
@endsection

@section('content')

<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Product LIST</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        <div class="dropdown no-arrow">
          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddProductModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="ProductListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Company</th>
                  <th class="text-center">Group</th>
                  <th class="text-center">Product</th>
                  <th class="text-center">Size</th>
                  <th class="text-center">Piece</th>
                  <th class="text-center">Buy</th>
                  <th class="text-center">%</th>
                  <th class="text-center">Sell</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>
  
      </table>
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.addProduct')
@include('modals.editProduct')
<!--Modals-->

@endsection

@section('script')
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script>
<script>
 
   $('#ProductListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      "autoWidth": false,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('product') }}",
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
            data: 'size',
            name: 'size'
        },
        {
            data: 'piece',
            name: 'piece'
        },
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
            data: 'action',
            name: 'action',
            orderable: false
        }
      ]
  });

  function addProduct() {
        if ( $( "#company_id" ).val() != '' ) {
            $("#company_id").removeClass("errorInputBox");
            $( "#company_idError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#company_id").addClass("errorInputBox");
            $( "#company_idError").text('Company Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#group_id" ).val() != '' ) {
            $("#group_id").removeClass("errorInputBox");
            $( "#group_idError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#group_id").addClass("errorInputBox");
            $( "#group_idError").text('Company Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#product_name" ).val() != '' ) {
            $("#product_name").removeClass("errorInputBox");
            $( "#product_nameError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#product_name").addClass("errorInputBox");
            $( "#product_nameError").text('Group Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#size" ).val() != '' ) {
            $("#size").removeClass("errorInputBox");
            $( "#sizeError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#size").addClass("errorInputBox");
            $( "#sizeError").text('Group Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#piece" ).val() != '' ) {
            $("#piece").removeClass("errorInputBox");
            $( "#pieceError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#piece").addClass("errorInputBox");
            $( "#pieceError").text('Group Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#buy_price" ).val() != '' ) {
            $("#buy_price").removeClass("errorInputBox");
            $( "#buy_priceError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#buy_price").addClass("errorInputBox");
            $( "#buy_priceError").text('Group Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#percent" ).val() != '' ) {
            $("#percent").removeClass("errorInputBox");
            $( "#percentError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#percent").addClass("errorInputBox");
            $( "#percentError").text('Percent Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#company_id" ).val() && $( "#group_id" ).val() && $( "#product_name" ).val() && $( "#size" ).val() && $( "#piece" ).val() && $( "#buy_price" ).val() && $( "#percent" ).val() ) {
            $( "#company_idError,#group_idError,#product_nameError,#sizeError,#pieceError,#buy_priceError,#percentError").text('');
            $( "#company_id,#group_id,#product_name,#size,#piece,#buy_price,#percent").removeClass("errorInputBox");
          
            var myData =  $('#AddProductForm').serialize();
            // alert(myData);
            $.ajax({
                type: 'POST', //THIS NEEDS TO BE GET
                url: "{{ route('addProduct') }}",
                // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
                // data: {_token: _token, myData: myData},
                data: myData,
                // dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                      
                      $("#success_message").text(response.success);
                      $('#ProductListTable').DataTable().ajax.reload();
                      $('#AddProductModal').modal('hide');
                      $("#AddProductForm").trigger("reset");
                      
                      SuccessMsg();
                    }

                },error:function(){ 
                    console.log(response);
                }
            });
        }
  }

  function editProduct(Id) {
      $.ajax({
        type: 'GET',
        url: "{{url('editProduct')}}"+"/"+Id,
        success: function (response) {
            console.log(response);
            if (response) {
            $('#edit_product_id').val(response.id);
            $('#ecompany_name').text(response.company_name);
            $('#egroup_name').text('GROUP -> '+response.group_name);
            $('#eproduct_name').text(response.product_name);
            $('#esize').text(response.size);
            $('#epiece').val(response.piece);
            $('#ebuy_price').val(response.buy_price);
            $('#epercent').val(response.percent);
            }

        },error:function(){ 
            console.log(response);
        }
    });
  }

  function updateProduct (params) {
   
        // if ($( "#eexpence_name" ).val() ) {
        
        // $("#eexpence_nameError").text('');
        // $("#eexpence_name" ).removeClass("errorInputBox");

        var myData =  $('#EditProductForm').serialize();
            // console.log(myData);
            $.ajax({
                type: 'POST',
                url: "{{ route('updateProduct') }}",
                data: myData,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        
                        $("#success_message").text(response.success);
                        $('#ProductListTable').DataTable().ajax.reload();
                        $('#EditProductModal').modal('hide');
                        $("#EditProductForm").trigger("reset");
                        
                        SuccessMsg();
                    }

                },error:function(){ 
                    console.log(response);
                }
            });
                

        // } else {

        // if ( !$("#eexpence_name" ).val()) {
        //     $("#eexpence_name").addClass("errorInputBox");
        //     $("#eexpence_nameError").text('Expence Name Is Required').addClass("ErrorMsg");
        // } else {
        //     $("#eexpence_name").removeClass("errorInputBox");
        //     $("#eexpence_nameError").text('').removeClass("ErrorMsg");
        // }
        // }
  }


  function deleteTableData(id) {
      // alert(TestId);
      $.ajax({
          type: 'GET',
          url: "{{url('deleteProduct')}}"+"/"+id,
          success: function (response) {
              console.log(response);
              if (response.success) {
                      
                $("#success_message").text(response.success);
                $('#ProductListTable').DataTable().ajax.reload();
                $('#DeleteConfirmationModal').modal('hide');

                SuccessMsg();
              }

          },error:function(){ 
              console.log(response);
          }
      });
  }
  
</script>

@endsection
