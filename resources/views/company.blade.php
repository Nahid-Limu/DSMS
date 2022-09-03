@extends('layouts.app')

@section('content')

<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Company LIST</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        <div class="dropdown no-arrow">
          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddCompanyModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="CompanytListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Company Name</th>
                  <th class="text-center">Start Date</th>
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
 
   $('#CompanytListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('company') }}",
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
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
      ]
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
