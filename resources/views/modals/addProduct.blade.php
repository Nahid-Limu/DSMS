
<!-- Modal start -->
<div class="modal fade" id="AddProductModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="color: red"></i> New Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="AddProductForm">  
                    @csrf
                    
                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <select name="company_id" id="company_id" class="form-control">
                                <option value="">Select Company</option>
                                @foreach ($Company as $c)
                                    <option value="{{$c->id}}">{{$c->company_name}}</option>
                                @endforeach
                            </select>
                            <span id="company_idError"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <select name="group_id" id="group_id" class="form-control" disabled>
                                <option value="">Select Group</option>
                                {{-- @foreach ($Group as $g)
                                    <option value="{{$g->id}}">{{$g->group_name}}</option>
                                @endforeach --}}
                            </select>
                            <span id="group_idError"></span>
                        </div>
                    </div>
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="product_name">Product Name</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="">
                            <span id="product_nameError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="size">Size</label>
                        </div>
                        <div class="form-group col-md-8">
                            <select name="size" id="size" class="form-control">
                                <option value="">Select Size</option>
                               
                                    <option value="carton ">1 Carton </option>
                                    <option value="poly">1 Poly</option>
                               
                            </select>
                            <span id="sizeError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="piece">Piece</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="piece" name="piece" placeholder="">
                            <span id="pieceError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="buy_price">Buy Price</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="buy_price" name="buy_price" placeholder="">
                            <span id="buy_priceError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="sell_price">Sell Price</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="sell_price" name="sell_price" placeholder="">
                            <span id="sell_priceError"></span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="addProduct()" type="button" class="btn btn-success float-right">Add</button>
                <button onclick="onCloseModal('AddProductForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>
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
            }
        });
});
</script>