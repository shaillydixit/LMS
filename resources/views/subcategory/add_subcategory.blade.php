@extends('layouts.default')
@section('content')
@include('elements.top_css')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<body>
    <div class="wrapper">
        @include('elements.header')
        @include('elements.sidebar')
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Add Subcategory</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Add Subcategory</h5>
                        <form class="row g-3" name="add_subcategory_form" id="add_subcategory_form">
                            <input type="hidden" id="id" name="id"
                                value="{{!empty($subcategoryData) ? $subcategoryData->id : ''}}">
                            <div class="col-md-6 mb-4">
                                <label for="single-select-field" class="form-label">Select Category</label>
                                <select class="form-select" id="single-select-field" name="category_id"
                                    data-placeholder="Choose one thing">
                                    <option disabled>Select Category</option>
                                    @foreach($category as $row)
                                    <option value="{{ $row->id }}"
                                        {{ !empty($subcategoryData) && $subcategoryData->category_id == $row->id ? 'selected' : '' }}>
                                        {{ $row->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="input1" class="form-label">Subcategory Name</label>
                                <input type="text" name="subcategory_name" class="form-control" id="subcategory_name"
                                    value="{{!empty($subcategoryData) ? $subcategoryData->subcategory_name : ''}}"
                                    placeholder="Subcategory Name">
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" type="button" id="submit_btn_subcategory"
                                        class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('elements.footer')
        @include('elements.bottom_js')
        <script src="{{ asset('backend/assets/js/pages/subcategory.js?v='.time()) }}"></script>
        <script src="{{ asset('backend/assets/js/pages/custom.js?v='.time()) }}"></script>

    </div>
</body>
