@extends('admin._partials._master')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Promotions Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('promotions.index') }}">Promotions List</a>
                </li>
                <li class="breadcrumb-item active">Add/Edit Promotion</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Body Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    {{ Form::model($promotion, ['route' => 'promotion.store', 'class' => 'form', 'method' => 'post', 'id' => 'promotionForm']) }}
                    @csrf
                    <input type="hidden" name="id" value="{{ $promotion->id }}">

                    <div class="form-group m-t-40 row">
                        {{ Form::label('title', 'Title', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Promotion title', 'required' => 'required']) }}
                        </div>
                    </div>

                    {{--<div class="form-group row">
                        {{ Form::label('category_id', 'Category', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::select('category_id', $categories, null, ['class' => 'custom-select col-12', 'placeholder' => 'Select category']) }}
                        </div>
                    </div>--}}

                    <div class="form-group m-t-40 row">
                        {{ Form::label('trigger_amount', 'Threshold Amount', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::text('trigger_amount', null, ['class' => 'form-control', 'placeholder' => 'Enter purchase amount']) }}
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        {{ Form::label('start_date', 'Start Date', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::date('start_date', null, ['class' => 'form-control', 'id' => 'example-date-input', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-2 col-form-label">End Date</label>
                        <div class="col-10">
                            {{ Form::date('end_date', null, ['class' => 'form-control', 'id' => 'example-date-input', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('outcome', 'Award', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::select('outcome', ['voucher'=> 'Voucher', 'free_delivery' => 'Free Delivery', 'discount' => 'Discount'], null, ['class' => 'custom-select col-12', 'placeholder' => 'Select award']) }}
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        {{ Form::label('amount', 'Awarding Amount (Rs)', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::number('amount', null, ['class' => 'form-control', 'placeholder' => 'Enter awarding amount']) }}
                        </div>
                    </div>

                    <hr class="m-t-0 m-b-40"/>
                    <div class="form-group row">
                        <label for="status" class="col-2 col-form-label">Status</label>
                        <div class="col-10">
                            <div class="demo-checkbox">
                                <input type="checkbox" name="status" id="basic_checkbox_2" class="filled-in" @if($promotion->status) checked @endif />
                                <label for="basic_checkbox_2">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs-right">
                        <button type="submit"  value="0" class="btn btn-info">Save</button>
                        <a href="{{ route('promotions.index') }}" class="btn btn-inverse">Cancel</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script>
        var loader = null;

        jQuery(document).ready(function() {

            loader = $(".preloader");

            $("#promotionForm").on('submit', function (e) {
                e.preventDefault();
                loader.fadeIn();

                $(this).ajaxSubmit({
                    success: function(response) {
                        loader.fadeOut();
                        toast('success', 'Success', response.message);
                        window.location.href = '{{ route('promotions.index') }}';
                    },
                    error: function(err) {
                        console.error(err);
                        loader.fadeOut();
                        toast('error', 'Error', 'Internal Server Error.');
                    }
                });

            });//..... end of form-submit.
        });//..... end of ready() .....//
    </script>
@endsection
