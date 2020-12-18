@extends('admin._partials._master')
@section('content')
    <style>
        table{
            margin: 0 auto;
            width: 100%;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap:break-word;
        }

        table.dataTable.nowrap th, table.dataTable.nowrap td {
            white-space: normal;
        }

        .tooltip-item {
            background: none !important;
        }
        .editableform .control-group{
            z-index: 100;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Orders Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Orders Management</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Body Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <div class="form-group row">
                            <div class="col-3">
                                {{ Form::select('status', ['0' => 'Pending ('.$pending.')', '1' => 'Processing ('.$processing.')', '2' => 'Completed ('.$completed.')', '3' => 'Returned ('.$returned.')'], null, ['class' => 'custom-select col-12', 'placeholder' => 'Filter by status', 'id' => 'statusFilter']) }}
                            </div>
                            <div class="col-4">
                                <label for="from_date" class="col-4 col-form-label">From Date</label>
                                {{ Form::date('from_date', null, ['class' => 'form-control col-7', 'id' => 'fromDate']) }}
                            </div>
                            <div class="col-4">
                                <label for="to_date" class="col-4 col-form-label">To Date</label>
                                {{ Form::date('to_date', null, ['class' => 'form-control col-7', 'id' => 'toDate']) }}
                            </div>
                        </div>
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Customer</th>
                                <th>Order No</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Net Total</th>
                                <th>Received</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.orders._partials.ReturnModal')

    @include('admin.orders._partials.SubReturnModal')

    @include('admin.orders._partials.ChangeStatusModal')

    @include('admin.orders._partials.PaymentsModal')

    @include('admin.orders._partials.ManageCourier')
@endsection
@section('footer')
    <script>
        var returnModal = null;
        var changeStatusModal = null;
        var returnForm = null;
        var returnItemForm = null;
        var idHdnField = null;
        var subIdHdnField = null;
        var subMainIdHdnField = null;
        var errorDiv = null;
        var errorSubDiv = null;
        var returnItemModal = null;
        var quantityField = null;
        var statusFilter = null;
        var fromDate = null;
        var toDate = null;
        var changeStatusIdHdnField = null;
        var changeStatusErrorDiv = null;
        var loader = null;
        var table = null;

        $(document).ready(function(e) {
            returnModal = $('#returnModal');
            changeStatusModal = $('#changeStatusModal');
            returnItemModal = $('#returnItemModal');
            returnForm = $("#returnForm");
            returnItemForm = $("#returnItemForm");
            idHdnField = $("#idHdnField");
            subIdHdnField = $("#subIdHdnField");
            subMainIdHdnField = $("#subMainIdHdnField");
            errorDiv = $("#errorDiv");
            errorSubDiv = $("#errorSubDiv");
            quantityField = $("#quantityField");
            statusFilter = $("#statusFilter");
            fromDate = $("#fromDate");
            toDate = $("#toDate");
            changeStatusIdHdnField = $("#changeStatusIdHdnField");
            changeStatusErrorDiv = $("#changeStatusErrorDiv");
            loader = $(".preloader");

            table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                stateSave: true,
                "ajax": {
                    "url": "{{ route('datatables.admin.order.list') }}",
                    "type": "GET",
                    "data": function(d) {
                        d.statusFilter = statusFilter.val();
                        d.fromDate = fromDate.val();
                        d.toDate = toDate.val();
                        return d;
                    }
                },
                "columns": [
                    {
                        "class":          "details-control",
                        "data":           null,
                        "defaultContent": "",
                        orderable: false,
                        searchable: false
                    },
                    {data: "cname", name: "cname" },
                    {data: "id", name: "id" },
                    {data: "total", name: "total" },
                    {data: "discount", name: "discount" },
                    {data: "total", name: "total", render: function (data, type, row) {
                            return (parseFloat(row.total) + parseFloat(row.shipping_cost)) - parseFloat(row.discount) - parseFloat(row.receivedAmount);
                        } },
                    {data: "receivedAmount", name: "receivedAmount", orderable: false, searchable: false },
                    {data: "type", name: "type", render: function(data) {
                        if (data == 0)
                            return 'Website';
                        else
                            return 'Custom';
                        } },
                    {data: "status", name: "status", render: function (data) {
                            if (data == 0)
                                return `<span style="color: greenyellow; font-weight: bold;">Pending</span>`;
                            else if(data == 1)
                                return `<span style="color: green; font-weight: bold;">InProcess</span>`;
                            else if(data == 2)
                                return `<span style="color: darkblue; font-weight: bold;">Completed</span>`;
                            else if(data == 3)
                                return `<span style="color: #8a6d3b; font-weight: bold;">Returned</span>`;
                            else
                                return 'Unknown';

                        } },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });//..... end of dataTables.

            $("#returnForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);
                errorDiv.hide();

                $(this).ajaxSubmit({
                    success: function(response) {
                        if (response.status) {
                            returnModal.modal('hide');
                            $this.trigger('reset');
                            toast('success', 'Success', response.message);
                            table.ajax.reload();
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                            if (response.validationError)
                                errorDiv.html(response.validationError).show();
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });

            $("#returnItemForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);
                errorSubDiv.hide();

                $(this).ajaxSubmit({
                    success: function(response) {
                        if (response.status) {
                            returnItemModal.modal('hide');
                            toast('success', 'Success', response.message);
                            $('#dataTable-'+subMainIdHdnField.val()).DataTable().ajax.reload();
                            $this.trigger('reset');
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                            if (response.validationError)
                                errorDiv.html(response.validationError).show();
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });

            $("#changeStatusForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);
                changeStatusErrorDiv.hide();
                loader.fadeIn();

                $(this).ajaxSubmit({
                    success: function(response) {
                        loader.fadeOut();
                        if (response.status) {
                            changeStatusModal.modal('hide');
                            toast('success', 'Success', response.message);
                            table.ajax.reload();
                            $this.trigger('reset');
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                            if (response.validationError)
                                changeStatusErrorDiv.html(response.validationError).show();
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        loader.fadeOut();
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });

            $("body").on("click",".returnOrder",function(e) {
                e.preventDefault();
                returnForm.trigger('reset');
                errorDiv.html('').hide();
                var id = $(this).attr('data-id');
                idHdnField.val(id);
                returnModal.modal('show');
            });

            $("body").on("click",".changeStatus",function(e) {
                e.preventDefault();
                changeStatusIdHdnField.val( $(this).attr('data-id') );
                changeStatusModal.modal('show');
            });

            $("body").on("click",".returnItemOfOrder",function(e) {
                e.preventDefault();
                returnItemForm.trigger('reset');
                errorSubDiv.html('').hide();

                var id = $(this).attr('data-id');
                var order_id = $(this).attr('data-main');
                var quantity = $(this).attr('data-quantity');
                var rquantity = $(this).attr('data-return_quantity');
                quantity = quantity - rquantity;
                quantityField.val(quantity);
                quantityField.attr('max', quantity);
                subIdHdnField.val(id);
                subMainIdHdnField.val(order_id);

                returnItemModal.modal('show');
            });

            // Add event listener for opening and closing details
            $('#dataTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                    initializeDataTable(row.data().id)
                }
            } );

            $('body').on('change', '#fromDate, #toDate, #statusFilter', function () {
                table.ajax.reload();
            })
        });//.... end of ready function ....//

        function format ( d ) {
            // `d` is the original data object for the row
            return `
            <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="dataTable-${d.id}" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Weight (Kg)</th>
                                <th>Total Dimension</th>
                                <th>Unit Price</th>
                                <th>Discount</th>
                                <th>Return Quantity</th>
                                <th width="100">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            `;
        }

        function initializeDataTable(id) {
            $('#dataTable-'+id).DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.orders.details.list') }}",
                    "type": "GET",
                    "data":{_id: id},
                },
                "columns": [
                  //  {data: "product.title", name: "product.title", orderable: false, searchable: false  },
                    {data: "product.title", name: "product.title", render: function (data, type, row) {
                            if (row.product.image) {
                                var image = row.product.image[0];
                                return `<span class="mytooltip tooltip-effect-5">
                                    <span class="tooltip-item">${data}</span>
                                      <span class="tooltip-content clearfix custom-tooltip-content">
                                      <img src="{{ asset('uploads/thumbs') }}/${image}" />
                                    </span>
                                   </span>`
                            } else
                                return '';
                        } },
                    {data: "quantity", name: "quantity" },
                    {data: "weightInKg", name: "weightInKg", orderable: false, searchable: false },
                    {data: "totalDimension", name: "totalDimension", orderable: false, searchable: false },
                    {data: "unit_price", name: "unit_price" },
                    {data: "discount", name: "discount" },
                    {data: "return_quantity", name: "return_quantity" },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

    </script>
@endsection
