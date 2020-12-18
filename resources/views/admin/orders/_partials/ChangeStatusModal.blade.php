{{--change status Modal--}}
<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Change Status of the Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('order.change.status') }}" method="post" id="changeStatusForm">
                <div class="modal-body">
                    <div class="form-group m-b-40">
                        {{ Form::select('status', ['0' => 'Pending', '1' => 'Processing', '2' => 'Completed'], null, ['class' => 'custom-select col-12', 'placeholder' => 'Select status']) }}
                    </div>

                    <div id="changeStatusErrorDiv" class="alert alert-danger" style="display: none;"></div>
                </div>

                <input type="hidden" name="id" value="" id="changeStatusIdHdnField"/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
