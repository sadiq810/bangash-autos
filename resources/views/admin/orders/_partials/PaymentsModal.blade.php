{{--Payments Modal--}}
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Manage Payment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('order.payment.received') }}" method="post" id="paymentForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Comment for Receiving</label>
                        <input type="text" name="comment" class="form-control" placeholder="Comment for payment receiving..." required="required">
                    </div>
                    <div class="form-group">
                        <label>Amount Rs</label>
                        <input type="number" name="amount" class="form-control" placeholder="Amount..." min="0" step="1" required="required">
                    </div>
                </div>

                <input type="hidden" name="id" value="" id="idPaymentHdnField"/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var paymentModal = null;
    var paymentForm = null;
    var idPaymentHdnField = null;

    $('document').ready(function () {
        paymentModal = $('#paymentModal');
        paymentForm = $('#paymentForm');
        idPaymentHdnField = $('#idPaymentHdnField');

        $("body").on("click",".manageReceive",function(e) {
            e.preventDefault();
            paymentForm.trigger('reset');
            var id = $(this).attr('data-id');
            idPaymentHdnField.val(id);
            paymentModal.modal('show');
        });

        $("#paymentForm").on("submit", function(e) {
            e.preventDefault();
            var $this = $(this);

            $(this).ajaxSubmit({
                success: function(response) {
                    if (response.status) {
                        paymentModal.modal('hide');
                        $this.trigger('reset');
                        toast('success', 'Success', response.message);
                        table.ajax.reload();
                    } else {
                        toast('error', 'Internal Server Error!', response.message);
                    }//..... end of if-else() .....//
                }, error: function(err) {
                    toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                }
            });
        });
    });
</script>
