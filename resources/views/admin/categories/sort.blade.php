@extends('admin._partials._master')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
    </style>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Sort Categories</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">Categories</a>
                </li>
                <li class="breadcrumb-item active">Sort Categories</li>
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
                        <ul class="list-group" id="sortable">
                            @foreach($categories as $category)
                                <li class="list-group-item" id="{{ $category->id }}">
                                    <span class="fa fas fa-arrows-alt"></span>{{ $category->title }}
                                </li>
                            @endforeach
                        </ul>
                        <hr/>
                        <div class="text-xs-right">
                            <button type="button"  value="0" class="btn btn-info" id="saveBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer')
    <script>
        $(document).ready(function(e) {
            $( "#sortable" ).sortable();

            $("body").on("click","#saveBtn",function(e) {
                e.preventDefault();
                var sortedIDs = $( "#sortable" ).sortable( "toArray" );
                $.ajax({
                    url: '{{ route('categories.sort.save') }}',
                    type: 'post',
                    data: {ids: sortedIDs},
                    success: function(response) {
                        Swal.fire('Saved !', response.message, 'success');
                    },
                    error: function (err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });
        });//.... end of ready function ....//
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
