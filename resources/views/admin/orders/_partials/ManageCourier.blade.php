{{--Courier Modal--}}
<div class="modal fade" id="courierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Manage Courier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('save.order.courier') }}" method="post" id="courierForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Courier Name</label>
                        <input type="text" name="name" id="courierNameField" class="form-control" placeholder="Courier name..." required="required">
                    </div>
                    <div class="form-group">
                        <label>Order Id</label>
                        <input type="text" name="orderId" id="courierIdField" class="form-control" placeholder="Order Id..." required="required">
                    </div>
                </div>

                <input type="hidden" name="id" value="" id="idCourierHdnField"/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var courierModal = null;
    var courierForm = null;
    var idCourierHdnField = null;
    var courierNameField = null;
    var courierIdField = null;

    $('document').ready(function () {
        courierModal = $('#courierModal');
        courierForm = $('#courierForm');
        idCourierHdnField = $('#idCourierHdnField');
        courierNameField = $('#courierNameField');
        courierIdField = $('#courierIdField');

        $("body").on("click",".manageCourier",function(e) {
            e.preventDefault();
            var data = table.row( $(this).parents('tr') ).data();
            courierForm.trigger('reset');

            if(typeof data.courier == 'object') {
                courierNameField.val(data.courier.name);
                courierIdField.val(data.courier.orderId);
            }//..... end if() .....//

            idCourierHdnField.val(data.id);
            courierModal.modal('show');
        });

        $("#courierForm").on("submit", function(e) {
            e.preventDefault();
            var $this = $(this);

            $(this).ajaxSubmit({
                success: function(response) {
                    if (response.status) {
                        courierModal.modal('hide');
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
<?php
