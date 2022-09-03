@extends('layouts.app')
@section('title', 'Group Setting')
@section('css')
    
@endsection

@section('content')

<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Group LIST</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        <div class="dropdown no-arrow">
          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddGroupModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="GroupListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Company</th>
                  <th class="text-center">Group</th>
                  <th class="text-center">Start Date</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>
  
      </table>
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.addGroup')
<!--Modals-->

@endsection

@section('script')
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script>
<script>
 
   $('#GroupListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('group') }}",
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

  function addGroup() {
        if ( $( "#company_id" ).val() != '' ) {
            $("#company_id").removeClass("errorInputBox");
            $( "#company_idError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#company_id").addClass("errorInputBox");
            $( "#company_idError").text('Company Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#group_name" ).val() != '' ) {
            $("#group_name").removeClass("errorInputBox");
            $( "#group_nameError").text('').removeClass("ErrorMsg");
            
        } else {
            $("#group_name").addClass("errorInputBox");
            $( "#group_nameError").text('Group Name Is Required').addClass("ErrorMsg");
        }

        if ( $( "#group_name" ).val() && $( "#company_id" ).val() ) {
            $( "#company_idError,#group_nameError").text('');
            $( "#company_id,#group_name").removeClass("errorInputBox");
          
            var myData =  $('#AddGroupForm').serialize();
            // alert(myData);
            $.ajax({
                type: 'POST', //THIS NEEDS TO BE GET
                url: "{{ route('addGroup') }}",
                // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
                // data: {_token: _token, myData: myData},
                data: myData,
                // dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                      
                      $("#success_message").text(response.success);
                      $('#GroupListTable').DataTable().ajax.reload();
                      $('#AddGroupModal').modal('hide');
                      $("#AddGroupForm").trigger("reset");
                      
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
          url: "{{url('deleteGroup')}}"+"/"+id,
          success: function (response) {
              console.log(response);
              if (response.success) {
                      
                $("#success_message").text(response.success);
                $('#GroupListTable').DataTable().ajax.reload();
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
