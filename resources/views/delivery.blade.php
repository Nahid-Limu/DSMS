@extends('layouts.app')
@section('title', 'Delivery')
@section('css')
    
@endsection

@section('content')

<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
    <form id="DeleveryProductInfoForm">  
        @csrf

      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Product LIST</i></h6>
        <strong id="success_message" class="text-success">okkk</strong>
        
        <div class="col-md-2">
            <input type="date" class="form-control" id="select_date" name="date"  data-toggle="tooltip" data-placement="top" title="Select Date"  required>
        </div>

        <div class="col-md-2">
            <select name="company_id" id="company_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Select Company" disabled>
                <option value="">Select Company</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="group_id" id="group_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Select Group" disabled>
                <option value="">Select Group</option>
            </select>
        </div>

      </div>

    </form>
      <!-- Card Body -->
      <div class="card-body" id="tbldata">
        <table id="ProductListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Product Name</th>
                  <th class="text-center">Stock</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>
  
      </table>
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.addCompany')
<!--Modals-->

@endsection

@section('script')
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script>
<script>

    $('#select_date').on('change',function () {
            
            // alert(111);
            // if (id) {
            //     $("#company_id").prop('disabled', false);
            // } else {
            //     $("#company_id").prop('disabled', true);
            //     $("#company_id").val('');
            // }
            $("#company_id").prop('disabled', false);
            $.ajax({
                type: "GET",
                url:"{{url('/ajax/all_company')}}",
                success:function (response) {
                    //console.log(response);
                    $("#company_id").prop('disabled', false);
                    $('#company_id').html(response);
                    // $("#employee_id").select2({
                    //     placeholder: "Select Employee"
                    // });
                }
            });
    });

    $('#company_id').on('change',function () {
        var id = $("#company_id").val();
        // alert(id);
        if (id) {
            $("#group_id").prop('disabled', false);
        } else {
            $("#group_id").prop('disabled', true);
            $("#group_id").val('');
        }
        $.ajax({
            type: "GET",
            url:"{{url('/ajax/company_wise_group')}}"+"/"+id,
            success:function (response) {
                //console.log(response);
                $("#group_id").prop('disabled', false);
                $('#group_id').html(response);
                // $("#employee_id").select2({
                //     placeholder: "Select Employee"
                // });
                $("#tbldata").load(location.href + " #tbldata");
            }
        });
    });

    $('#group_id').on('change',function () {
        // $('#ProductListTable').DataTable().ajax.reload();
        var c_id = $("#company_id").val();
        var g_id = $("#group_id").val();
        // console.log(c_id,g_id);
        if (c_id && g_id) {
console.log(c_id,g_id);
            // $.ajax({
            //     type: "GET",
            //     url:"{{url('/getProduct')}}"+"/"+c_id+"/"+g_id,
            //     success:function (response) {
            //         //console.log(response);
                    
            //     }
            // });

            $('#ProductListTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "order": [[ 0, "asc" ]],
                ajax:{
                    url: "{{url('/getProduct')}}"+"/"+c_id+"/"+g_id,
                },
                columns:[
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex' 
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'stock_size',
                        name: 'stock_size'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });
        } else {
            // console.log('xxx');
            $("#tbldata").load(location.href + " #tbldata");
        }
        


        
    });
 
   

  function addCompany() {
        if ( $( "#company_name" ).val() != '' ) {
            $("#company_name").removeClass("errorInputBox");
            $( "#company_nameError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#company_name").addClass("errorInputBox");
            $( "#company_nameError").text('Company Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#company_name" ).val() ) {
            $( "#company_nameError").text('');
            $( "#company_name").removeClass("errorInputBox");
          
            var myData =  $('#AddCompanyForm').serialize();
            // alert(myData);
            $.ajax({
                type: 'POST', //THIS NEEDS TO BE GET
                url: "{{ route('addCompany') }}",
                // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
                // data: {_token: _token, myData: myData},
                data: myData,
                // dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                      
                      $("#success_message").text(response.success);
                      $('#CompanytListTable').DataTable().ajax.reload();
                      $('#AddCompanyModal').modal('hide');
                      $("#AddCompanyForm").trigger("reset");
                      
                      SuccessMsg();
                    }

                },error:function(){ 
                    console.log(response);
                }
            });
        }
  }

  function deleteTableData(id) {
      // alert(TestId);
      $.ajax({
          type: 'GET',
          url: "{{url('deleteCompany')}}"+"/"+id,
          success: function (response) {
              console.log(response);
              if (response.success) {
                      
                $("#success_message").text(response.success);
                $('#CompanytListTable').DataTable().ajax.reload();
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
