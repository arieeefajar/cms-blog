@extends('layout.app')
@section('title', 'Profile')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('updateProfile') }}" method="POST" id="profileForm">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Fullname</label>
                            <input type="text" class="form-control form-control-user" id="updateFullName"
                                placeholder="Enter fullname" name="fullname" value="{{ Auth::user()->fullname }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-user" id="updateUsername"
                                placeholder="Enter username" name="username" value="{{ Auth::user()->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-user" id="updateEmail"
                                placeholder="Enter email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="form-group text-right">
                            <a class="btn btn-link" onclick="showPassword()">Change Password?</a>
                        </div>
                        <hr>
                        <div class="" id="divPassword" style="display: none">
                            <div class="form-group">
                                <label for="exampleFullName" class="form-label">Old Password</label>
                                <input type="password" class="form-control form-control-user" id="updateOldPassword"
                                    placeholder="Enter old password" name="oldpassword">
                            </div>
                            <div class="form-group">
                                <label for="exampleFullName" class="form-label">New Password</label>
                                <input type="password" class="form-control form-control-user" id="updatePassword"
                                    placeholder="Enter password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="exampleFullName" class="form-label">Repeat Password</label>
                                <input type="password" class="form-control form-control-user" id="updateRepeatPassword"
                                    placeholder="Enter repeat password" name="repeatpassword">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary" form="profileForm">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        //show input password
        function showPassword() {
            const form = document.getElementById('profileForm');
            form.querySelector('#divPassword').style.display = 'block';
        }
    </script>
@endsection
