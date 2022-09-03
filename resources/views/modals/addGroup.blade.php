
<!-- Modal start -->
<div class="modal fade" id="AddGroupModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="color: red"></i> New Group</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="AddGroupForm">  
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="compay_id">Company</label>
                        </div>
                        <div class="form-group col-md-8">
                            <select name="company_id" id="company_id" class="form-control">
                                <option value="">Select Company</option>
                                @foreach ($Company as $c)
                                    <option value="{{$c->id}}">{{$c->company_name}}</option>
                                @endforeach
                            </select>
                            <span id="company_idError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="group_name">Group Name</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" id="group_name" name="group_name" placeholder="">
                            <span id="group_nameError"></span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="addGroup()" type="button" class="btn btn-success float-right">Add</button>
                <button onclick="onCloseModal('AddGroupForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>

</script>