@extends('admin::layouts.master')

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    <form action="{{ route('admin.categories.store') }}" method="post" id="handleFormInfo" class="pl-md-5 pr-md-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex">Category's name</label>
                    <input name="category_name" type="text" class="form-control" value="" placeholder="Type category's name">
                    <span name="category_name" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2">Type of categories</label>
                    <select name="parent_flag" class="custom-select" aria-label="Default select example"
                        onchange="categories.handleParentCategories(this)">
                        <option value="0">Parent</option>
                        <option value="1">Child</option>
                    </select>
                    <span name="parent_flag" class="text-danger" style="font-size:80% !important"></span>
                </div>
                <div class="form-group d-none" id="parent_categories_id">
                    <label class="mt-2">Parent categories</label>
                    <select name="parent_categories_id" class="custom-select" aria-label="Default select example">
                        <option value="" selected>Select parent category</option>
                        @foreach ($parentCategories as $parent)
                            <option value="{{ $parent->category_id }}">
                                {{ ucfirst($parent->category_name) }}
                            </option>
                        @endforeach
                    </select>
                    <span name="parent_categories_id" class="text-danger" style="font-size:80% !important"></span>
                </div>
            </div>
        </div>
        <div class="mt-2 row justify-content-start">
            <div class="col-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger text-white">
                    <i class="fas fa-window-close mr-2"></i>
                    Cancel
                </a>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" onclick="common.handleCreateUpdate(event, this)">
                    <i class="fas fa-check mr-2"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/categories.js') }}"></script>
@endsection
