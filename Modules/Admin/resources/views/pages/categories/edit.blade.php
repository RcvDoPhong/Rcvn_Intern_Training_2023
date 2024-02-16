@extends('admin::layouts.master')

@php
    $parentCategoryFlag = is_null($category->parent_categories_id);
@endphp

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    <form action="{{ route('admin.categories.update', $category->category_id) }}" method="post" id="handleFormInfo"
        class="pl-md-5 pr-md-5">
        @method('PUT')
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="exampleFormControlInput1">Category's name</label>
                    <input name="category_name" type="text" class="form-control" value="{{ $category->category_name }}"
                        placeholder="Type category's name">
                    <span name="category_name" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2" for="exampleFormControlInput1">Type of categories</label>
                    <select name="parent_flag" class="custom-select"
                        @if ($category->categories->count() > 0) disabled="disabled" @endif
                        onchange="categories.handleParentCategories(this)">
                        <option value="0" @if ($parentCategoryFlag) selected @endif>Parent</option>
                        <option value="1" @if (!$parentCategoryFlag) selected @endif>Child</option>
                    </select>
                    <span name="parent_flag" class="text-danger" style="font-size:80% !important"></span>
                </div>
                @if ($category->categories->count() === 0)
                    <div class="form-group @if ($parentCategoryFlag) d-none @endif" id="parent_categories_id">
                        <label class="mt-2" for="exampleFormControlInput1">Danh mục cha</label>
                        <select name="parent_categories_id" class="custom-select">
                            <option value="" @if ($parentCategoryFlag) selected @endif>
                                Select parent category
                            </option>
                            @foreach ($parentCategories as $parent)
                                @if ($parent->category_id !== $category->category_id)
                                    <option value="{{ $parent->category_id }}"
                                        @if (!$parentCategoryFlag && $parent->category_id === $category->parent_categories_id) selected @endif>
                                        {{ ucfirst($parent->category_name) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <span name="parent_categories_id" class="text-danger" style="font-size:80% !important"></span>
                    </div>
                @endif
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
