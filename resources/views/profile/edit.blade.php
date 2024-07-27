@extends('layouts.app')
@section('page_title', 'My Profile')

@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about"
                                        role="tab" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">Setting</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#password" role="tab"
                                        aria-selected="false">Password</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="row">
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Company Name</strong>
                                            <br>
                                            <p class="text-muted">{{ $my_profile->company_name }}</p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Form of organization</strong>
                                            <br>
                                            <p class="text-muted">{{ $my_profile->form_of_organization }}</p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Form of income taxes</strong>
                                            <br>
                                            <p class="text-muted">{{ $my_profile->form_of_income_taxes }}</p>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <strong>Password</strong>
                                            <br>
                                            <p class="text-muted">***********</p>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <strong>Contact with us</strong>
                                            <br>
                                            <p class="text-muted">{{ $my_profile->contact_with_us }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                                    <form method="post" class="needs-validation" action="{{ route('profile.update') }}">
                                        @csrf
                                        <div class="card-header">
                                            <h4>Edit Profile</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Company Name</label>
                                                    <input type="text" class="form-control" name="company_name"
                                                        value="{{ $my_profile->company_name }}" required>
                                                </div>
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Form of organization</label>
                                                    <input type="text" class="form-control" name="form_of_organization"
                                                        value="{{ $my_profile->form_of_organization }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Form of income taxes</label>
                                                    <input type="text" class="form-control" name="form_of_income_taxes"
                                                        value="{{ $my_profile->form_of_income_taxes }}" required>
                                                </div>
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Contact us</label>
                                                    <input type="text" class="form-control" name="contact_with_us"
                                                        value="{{ $my_profile->contact_with_us }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="profile-tab2">
                                    <form method="post" class="needs-validation"
                                        action="{{ route('profile.update-password') }}">
                                        @csrf
                                        <div class="card-header">
                                            <h4>Update Password</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Update Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('script')
    <script type="text/javascript"></script>
@endsection
@endsection
