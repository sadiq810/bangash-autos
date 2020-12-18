{{--Return Modal--}}
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Cancel and Return Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('order.return') }}" method="post" id="returnForm" class="floating-labels">
                <div class="modal-body">
                    <div class="form-group m-b-40">
                        <textarea type="text" name="remarks" class="form-control input-sm" id="input9"></textarea>
                        <span class="bar"></span>
                        <label for="input9">Remarks</label>
                    </div>

                    <div id="errorDiv" class="alert alert-danger" style="display: none;"></div>
                </div>

                <input type="hidden" name="id" value="" id="idHdnField"/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Return</button>
                </div>
            </form>
        </div>
    </div>
</div>
