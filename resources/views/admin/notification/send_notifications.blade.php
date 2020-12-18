@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Web Push notifications</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Web Notifications</li>
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
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title">Send web push notifications</h4>
                            <h6 class="card-subtitle"> Compose you message and push to all subscribers. </h6>
                        </div>
                    </div>

                    {{ Form::Open(['route' => 'send.web.push', 'class' => 'form', 'method' => 'post', 'id' => 'myProductForm']) }}

                    <div class="form-group m-t-40 row">
                        {{ Form::label('title', 'Title', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        <label for="body" class="col-2 col-form-label">Body</label>
                        <div class="col-10">
                            <input class="form-control" name="body" type="text" value="" required="required" placeholder="Body of the message"/>
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        <label for="click_action" class="col-2 col-form-label">URL</label>
                        <div class="col-10">
                            <input class="form-control" name="click_action" type="text" value="" required="required" placeholder="URL of the post"/>
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        <label for="icon" class="col-2 col-form-label">Icon url</label>
                        <div class="col-10">
                            <input class="form-control" name="icon" type="text" value="{{ asset('assets/frontend/image/favicon/gaicon.png') }}" required="required" placeholder="icon url"/>
                        </div>
                    </div>

                    <div class="text-xs-right">
                        <button type="submit" class="btn btn-info">Send</button>
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

            $("#myProductForm").on('submit', function (e) {
                e.preventDefault();
                loader.fadeIn();
                var $this = this;

                $($this).ajaxSubmit({
                    success: function(response) {
                        loader.fadeOut();
                        toast('success', 'Success', response.message);
                        $($this).trigger('reset');
                    },
                    error: function(err) {
                        toast('error', 'Error', "Internal Server error occurred. Please try later.");
                        loader.fadeOut();
                    }
                });

            });//..... end of form-submit.
        });//..... end of ready() .....//
    </script>
@endsection
