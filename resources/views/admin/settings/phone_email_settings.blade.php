@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Settings</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Setting</li>
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
                            <h4 class="card-title">Settings</h4>
                            <h6 class="card-subtitle"> Please set the contact details as you want. </h6>
                        </div>
                    </div>
                    {{ Form::open(['route' => 'phone.email.settings.save', 'class' => 'form', 'method' => 'post', 'id' => 'myProductForm', 'files' => true]) }}
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <form>
                                    <div class="form-group">
                                        <label for="phone">Contact No (as shown in the frontend)</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone No" value="{{ optional($phone)->value }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="contactEmail">Contact Email (as shown in the footer of the frontend)</label>
                                        <input type="email" name="contactEmail" class="form-control" placeholder="Enter Email"  value="{{ optional($contactEmail)->value }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="officeAddress">Office Address (as shown in the frontend)</label>
                                        <input type="text" name="officeAddress" class="form-control" placeholder="Enter Office Address"  value="{{ optional($officeAddress)->value }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="adminEmail">Email (this email will be used for administration purposes, all notifications will be forwarded.)</label>
                                        <input type="email" name="adminEmail" class="form-control" placeholder="Enter Email"  value="{{ optional($adminEmail)->value }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="adminEmail">Facebook Page URL</label>
                                        <input type="text" name="facebookPageUrl" class="form-control" placeholder="Enter facebook page url"  value="{{ optional($facebookPageUrl)->value }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="adminEmail">Twitter URL</label>
                                        <input type="text" name="twitterUrl" class="form-control" placeholder="Enter twitter url"  value="{{ optional($twitterUrl)->value }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="adminEmail">Pinterest Url</label>
                                        <input type="text" name="pinterestUrl" class="form-control" placeholder="Enter pintereset url"  value="{{ optional($pinterestUrl)->value }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="adminEmail">Youtube Channel Url</label>
                                        <input type="text" name="youtubeUrl" class="form-control" placeholder="Enter youtube channel url"  value="{{ optional($youtubeUrl)->value }}">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" accept="image/*">
                                            <label class="custom-file-label">Choose Sale Category Image(of size 271*555)</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('shipCostMethod', 'Shipping Cost Calculation Method') }}
                                        {{ Form::select('shipCostMethod', [1 => 'Dimension', 2 => 'KG'], optional($shipCostMethod)->value, ['class' => 'custom-select col-12', 'placeholder' => 'Select shipping cost calculation method']) }}
                                    </div>

                                    <div class="form-group">
                                        <label for="adminEmail">Per KG Shipping Charges</label>
                                        <input type="text" name="perKgCharges" class="form-control" placeholder="Enter per kg shipping charges"  value="{{ optional($perKgCharges)->value }}">
                                    </div>

                                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Save</button>
                                </form>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer')
    <script>
        $('document').ready(function () {
            $('#range').on('change', function () {
                $('#watermarkImage').css('opacity', $(this).val()/100);
            });
        });
    </script>
@endsection
