{{--sub return Modal--}}
<div class="modal fade" id="returnItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel12">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel12">Return Order Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('order.detail.return') }}" method="post" id="returnItemForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="example-email">Quantity to return</label>
                        <input type="number" id="quantityField" name="quantity" class="form-control" placeholder="Quantity" min="0">
                    </div>

                    <div id="errorSubDiv" class="alert alert-danger" style="display: none;"></div>
                </div>

                <input type="hidden" name="id" value="" id="subIdHdnField"/>
                <input type="hidden" name="order_id" value="" id="subMainIdHdnField"/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Return</button>
                </div>
            </form>
        </div>
    </div>
</div>
