
<!-- Modal start -->
<div class="modal fade" id="AddCompanyModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="color: red"></i> New Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="AddCompanyForm">  
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="company_name">Company Name</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name [EX: Kokola] ">
                            <span id="company_nameError"></span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="addCompany()" type="button" class="btn btn-success float-right">Add</button>
                <button onclick="onCloseModal('AddCompanyForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>

</script>