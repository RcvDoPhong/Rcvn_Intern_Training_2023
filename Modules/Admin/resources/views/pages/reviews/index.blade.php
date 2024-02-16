@extends('admin::layouts.master')

@php
    $iToValue = intval($reviews->currentPage() * $reviews->perPage());
    $iFromValue = $iToValue - $reviews->perPage() + 1;
@endphp
@section('head')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.reviews.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="title">Review title</label>
                    <input name="title" type="text" class="form-control d-flex" id="title"
                        value="{{ request()->input('title') }}" placeholder="Type review title">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="rating">Rating</label>
                    <select name="rating" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select rating</option>
                        @foreach (range(1, 5) as $rating)
                            <option value="{{ $rating }}" @if (intval(request()->input('rating')) === $rating) selected @endif>
                                <span>{{ $rating }} *</span>
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="is_approved">Status</label>
                    <select name="is_approved" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select status</option>
                        @foreach ($statusList as $status)
                            <option value="{{ $status['id'] }}" @if (is_numeric(request()->input('is_approved')) && intval(request()->input('is_approved')) === $status['id']) selected @endif>
                                {{ $status['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="user_id">Creator</label>
                    <select name="user_id" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select customer</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}" @if (intval(request()->input('user_id')) === $user->user_id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="updated_by">Updated by</label>
                    <select name="updated_by" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select user</option>
                        @foreach (adminList() as $admin)
                            <option value="{{ $admin->admin_id }}" @if (intval(request()->input('updated_by')) === $admin->admin_id) selected @endif>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3 w-100">
            <div class="d-flex justify-content-end">
                <div class="col-auto">
                    <button name="" type="submit" class="btn btn-primary">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
                <div class="col-auto">
                    <button name="clear" type="button" class="btn btn-success"
                        onclick="common.clearSearchResult('{{ route('admin.reviews.index') }}')">
                        <i class="fas fa-window-close mr-2"></i>
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 d-flex justify-content-start">
                    <ul class="pagination pagination-sm m-0">
                        {{ $reviews->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $reviews->total() }} reviews
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Updated by</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                    @if ($reviews->total() > 0)
                        @foreach ($reviews as $review)
                            @if ($review->user->is_delete)
                                <tr>
                                    <td>{{ $review->review_id }}</td>
                                    <td>
                                        <a href="#" class="text-decoration-none"
                                            id="review_id_{{ $review->review_id }}" data-id="{{ $review->review_id }}"
                                            data-modal="#modalGlobal" onclick="reviews.renderModal(this)">
                                            {{ $review->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-decoration-none" data-id="{{ $review->user_id }}"
                                            data-modal="#modalGlobal" onclick="reviews.renderModalUser(this)">
                                            {{ $review->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            <span class="fa fa-star checked"></span>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $review->rating; $i++)
                                            <span class="fa fa-star"></span>
                                        @endfor
                                    </td>
                                    <td>
                                        @switch($review->is_approved)
                                            @case(0)
                                                <span class="text-danger">Pending</span>
                                            @break

                                            @case(1)
                                                <span class="text-success">Approved</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $review->admin ? $review->admin->name : null }}
                                    </td>
                                    <td>
                                        @if (checkRoleHasPermission('review.update'))
                                            <div class="form-group">
                                                <select name="status" class="custom-select pl-2 pr-2"
                                                    data-id="{{ $review->review_id }}"
                                                    onchange="reviews.updateStatus(this)">
                                                    @foreach ($statusList as $status)
                                                        <option class="text-center" value="{{ $status['id'] }}"
                                                            @if ($review->is_approved === $status['id']) selected @endif>
                                                            {{ ucfirst($status['name']) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan=10>
                                <div class="text-center">
                                    No data found
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <ul class="pagination pagination-sm m-0">
                    {{ $reviews->links() }}
                </ul>
            </div>
        </div>
    </div>
    <div>
        @include('admin::layouts.modal')
    </div>
@endsection
@section('main-scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('admin/js/reviews.js') }}"></script>
@endsection
