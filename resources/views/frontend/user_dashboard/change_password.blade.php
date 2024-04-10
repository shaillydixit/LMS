@extends('layouts.default')
@section('content')
@include('frontend.user_dashboard.body.top_css')

<body>

    <!-- start cssload-loader -->
    <div class="preloader">
        <div class="loader">
            <svg class="spinner" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        </div>
    </div>
    <!-- end cssload-loader -->

    @include('frontend.user_dashboard.body.header')
    <!-- end header-menu-area -->
    <div class="tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Change Password </h3>


            <form name="user_password_change_form" id="user_password_change_form" class="row pt-40px">

                <div class="input-box col-lg-12">
                    <label class="label-text"> Old Password</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="password" name="old_password" id="old_password">
                        <span class="la la-user input-icon"></span>

                    </div>
                </div>


                <div class="input-box col-lg-12">
                    <label class="label-text"> New Password</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="password" name="new_password" id="new_password">
                        <span class="la la-user input-icon"></span>
                    </div>
                </div><!-- end input-box -->

                <div class="input-box col-lg-12">
                    <label class="label-text"> Confirm New Password</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="password" name="new_password_confirmation"
                            id="new_password_confirmation">
                        <span class="la la-user input-icon"></span>
                    </div>
                </div><!-- end input-box -->



                <div class="input-box col-lg-12 py-2">
                    <a type="button" class="btn btn-primary" id="user_submit_password_btn">Save Changes</a>
                </div><!-- end input-box -->
            </form>
        </div><!-- end setting-body -->
    </div><!-- end tab-pane -->
    @include('frontend.user_dashboard.body.bottom_js')
    <script src="{{ asset('backend/assets/js/pages/user.js?v='.time()) }}"></script>
    <script src="{{ asset('backend/assets/js/pages/custom.js?v='.time()) }}"></script>

</body>
