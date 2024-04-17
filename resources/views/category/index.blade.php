@extends('layouts.default')
@section('content')
@include('elements.top_css')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<body>
    <!--wrapper-->
    <div class="wrapper">
        @include('elements.header')
        @include('elements.sidebar')
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">All Category</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="ms-auto">
                            <div class="btn-group">
                                <a href="{{route('add.category')}}" class="btn btn-primary px-5">Add Category </a>
                            </div>
                        </div>
                    </div>
                    <!--end breadcrumb-->

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Category Image </th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            @include('elements.footer')
            @include('elements.bottom_js')
            <script src="{{ asset('backend/assets/js/pages/category.js?v='.time()) }}"></script>
            <script src="{{ asset('backend/assets/js/pages/custom.js?v='.time()) }}"></script>

        </div>
</body>
