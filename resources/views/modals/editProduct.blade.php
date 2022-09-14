
<!-- Modal start -->
<div class="modal fade" id="EditProductModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-edit" aria-hidden="true" style="color: red"></i> Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="EditProductForm">  
                    @csrf
                    <input type="hidden" id="edit_product_id" name="id">

                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <label class="form-control" id="ecompany_name"> </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-control" id="egroup_name"> </label>
                        </div>
                    </div>
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control">Product Name</label>
                        </div>
                        <div class="form-group col-md-8">
                            <label class="form-control" id="eproduct_name"> </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="size">Size</label>
                        </div>
                        <div class="form-group col-md-8">
                            <label class="form-control" id="esize"> </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="piece">Piece</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="epiece" name="piece" placeholder="">
                            <span id="epieceError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="ebuy_price">Buy Price</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="ebuy_price" name="buy_price" placeholder="">
                            <span id="ebuy_priceError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="esell_price">Sell Price</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="esell_price" name="sell_price" placeholder="">
                            <span id="esell_priceError"></span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="updateProduct()" type="button" class="btn btn-success float-right">Update</button>
                <button onclick="onCloseModal('EditProductForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>

</script>