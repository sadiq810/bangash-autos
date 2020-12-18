@extends('admin._partials._master')
@section('content')
    <style>
        .dz-progress {
            /* progress bar covers file name */
            display: none !important;
        }
        .dz-details{
            cursor: move !important;
        }

        .sortable {
            padding: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .sortable div.dz-image-preview {
            float: left;
            width: 120px;
            height: 120px;
            overflow:hidden;
            border:1px solid red;
            text-align: center;
            margin:5px;
        }
        .el-card-item, .el-card-avatar {
            padding-bottom: 0 !important;
        }
        .mfp-wrap, .mfp-bg {
            z-index: 9999 !important;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Pages Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pages.index') }}">Pages List</a>
                </li>
                <li class="breadcrumb-item active">New Page</li>
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
                            <h4 class="card-title">Add pages as you want</h4>
                            <h6 class="card-subtitle"> Add/edit pages as you want. </h6>
                        </div>
                    </div>

                    {{ Form::model($page, ['route' => 'page.store', 'class' => 'form', 'method' => 'post', 'id' => 'myProductForm']) }}

                    <input type="hidden" name="id" value="{{ $page->id }}">

                    <div class="form-group m-t-40 row">
                        {{ Form::label('title', 'Name', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Page name', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('location', 'Category', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::select('location', ['header' => 'Header', 'footer' => 'Footer'], null, ['class' => 'custom-select col-12', 'placeholder' => 'Select position', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Description</label>
                        <div class="col-10">
                            <div class="summernote">{!! $page->detail !!}</div>
                        </div>
                    </div>
                    <hr class="m-t-0 m-b-40"/>
                    <div class="form-group row">
                        <label for="status" class="col-2 col-form-label">Status</label>
                        <div class="col-10">
                            <div class="demo-checkbox">
                                <input type="checkbox" name="status" id="basic_checkbox_2" class="filled-in" @if($page->status) checked @endif />
                                <label for="basic_checkbox_2">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs-right">
                        <button type="submit"  value="0" class="btn btn-info">Save</button>
                        <a href="{{ route('pages.index') }}" class="btn btn-inverse">Cancel</a>
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
                var description = $('.summernote').summernote('code');
                var $this = this;

                $($this).ajaxSubmit({
                    data: {detail: description},
                    success: function(response) {
                        loader.fadeOut();
                        toast('success', 'Success', response.message);
                        $($this).trigger('reset');
                        $('.summernote').summernote('code', '');

                        if (response.redirect)
                            window.location.href = '{{ route('pages.index') }}';
                    },
                    error: function(err) {
                        console.error(err);
                        loader.fadeOut();
                    }
                });

            });//..... end of form-submit.

            $('.summernote').summernote({
                height: 350, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });
        });//..... end of ready() .....//
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
