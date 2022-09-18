
<!-- Modal start -->
<div class="modal fade" id="StockProductModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-database" aria-hidden="true" style="color: red"></i> New Stock</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="StockProductForm">  
                    @csrf
                    <input type="hidden" id="product_id" name="id">
                    <input type="hidden" id="company_id" name="company_id">
                    <input type="hidden" id="group_id" name="group_id">
                    <input type="hidden" id="old_stock_size" name="">
                    <input type="hidden" id="old_stock_piece" name="">
                    <input type="hidden" id="piece" name="">
                    <input type="hidden" id="total_stock_piece_original" name="">
                    <h6 class="text-center text-success">Product Details</h6>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="product_name">Product Name</label>
                        </div>
                        <div class="form-group col-md-8">
                            <label class="form-control" id="product_name"></label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="size">Size</label>
                        </div>
                        <div class="form-group col-md-8">
                            <label class="form-control" id="size"></label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-control" for="total_stock_size">Total Stock (Carton / Poly) </label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="total_stock_size" name="total_stock_size" readonly>
                            <span id="total_stock_sizeError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-control" for="total_stock_piece">Total Stock Piece</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="total_stock_piece" name="total_stock_piece" readonly>
                            <span id="total_stock_pieceError"></span>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-center text-success">New Stock</h6>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-control" for="stock_size">New Stock (Carton / Poly) </label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="stock_size" name="" value="0" min="0" >
                            <span id="stock_sizeError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-control" for="stock_piece">New Stock Piece</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="stock_piece" name="" value="0" min="0" >
                            <span id="stock_pieceError"></span>
                        </div>
                    </div>

                    

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="addStock()" type="button" class="btn btn-success float-right">Add</button>
                <button onclick="onCloseModal('StockProductForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>
$('#stock_size').on('keyup',function () {
    // alert();
        var old_stock_size = $("#old_stock_size").val();
        var old_stock_piece = $("#old_stock_piece").val();
        var piece = $("#piece").val();

        if ( $("#stock_size").val() > 0 && $.isNumeric($("#stock_size").val()) ) {
            //size update
            var now_stock_size = parseFloat(old_stock_size) + parseInt( $("#stock_size").val() ) ;
            $('#total_stock_size').val( now_stock_size );
            // alert( (now_stock_size * piece) );

            //piece update
            $('#total_stock_piece').val( now_stock_size * piece );
            $('#total_stock_piece_original').val( now_stock_size * piece );

        }else {
            $('#total_stock_size').val( parseFloat(old_stock_size));
            $('#total_stock_piece').val( parseInt(old_stock_piece) );
            $('#total_stock_piece_original').val( parseInt(old_stock_piece) );
        }
        console.log(old_stock_size,old_stock_piece,piece);
       
    });

    $('#stock_piece').on('keyup',function () {
        var old_stock_size = $("#old_stock_size").val();
        var old_stock_piece = $("#old_stock_piece").val();
        var piece = $("#piece").val();
        var total_stock_piece_original = $("#total_stock_piece_original").val();

        // var total_stock_piece = $("#total_stock_piece").val();
        
        if ( $("#stock_piece").val() > 0 && $.isNumeric($("#stock_piece").val()) ) {
            
            //piece update
            var now_stock_piece =  ( parseInt( total_stock_piece_original ) + parseInt( $("#stock_piece").val() ) ) ;
            $('#total_stock_piece').val( now_stock_piece  );

            // $('#total_stock_piece').val( parseInt(old_stock_piece )  );
            
            //size update
            $('#total_stock_size').val( now_stock_piece / piece );
        } else {
            var now_stock_size = parseFloat(old_stock_size) + parseInt( $("#stock_size").val() ) ;
            $('#total_stock_piece').val( now_stock_size * piece );
            $('#total_stock_size').val( now_stock_size );
        }
       
    });

    
</script>