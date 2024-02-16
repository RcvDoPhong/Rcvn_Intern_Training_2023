@extends('admin::layouts.master')

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    <form enctype="multipart/form-data" action="{{ route('admin.brands.store') }}" method="post" id="handleFormInfo" class="pl-md-5 pr-md-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex">Brand's name</label>
                    <input name="brand_name" type="text" class="form-control" value="" placeholder="Type brand's name">
                    <span name="brand_name" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Founded</label>
                    <input name="founded" type="date" class="form-control d-flex" value="">
                    <span name="founded" class="error invalid-feedback"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row mt-5">
                    <div class="d-flex" style="height:300px">
                        <img name="preview" class="rounded float-right img-thumbnail img-fluid"
                            src="{{ asset('storage/brand_logo_placeholder.png') }}" alt="">
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <button value="" class="btn btn-danger rounded" type="button"
                                onclick="imageValidate.clearImage('brand_logo', 'brand')">
                                Remove image
                            </button>
                        </div>
                        <input class="form-control" type="file" name="brand_logo" accept="image/png, image/jpg, image/jpeg"
                            onchange="imageValidate.displayImage(this)">
                    </div>
                    <span name="brand_logo" class="text-danger" style="font-size:80% !important"></span>
                </div>
            </div>
        </div>
        <div class="mt-5 row justify-content-end">
            <div class="col-auto">
                <a href="{{ route('admin.brands.index') }}" class="btn btn-danger text-white">
                    <i class="fas fa-window-close mr-2"></i>
                    Cancel
                </a>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary"
                    onclick="common.handleCreateUpdate(event, this)">
                    <i class="fas fa-check mr-2"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/images.js') }}"></script>
@endsection
