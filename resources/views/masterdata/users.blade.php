@extends('layout.app')
@section('title', 'Data Author')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Author</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-icon-split mb-3">
                    <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                    <span class="text">Add Author</span>
                </a>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Fullname</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Fullname</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($authors as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->status == 'active')
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="justify-content-center">
                                        <a href="#" data-toggle="modal" data-target="#updateModal"
                                            class="btn btn-warning btn-sm" onclick="updateData({{ $item }})"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#deleteModal"
                                            class="btn btn-danger btn-sm" onclick="deleteData({{ $item->id }})"><i
                                                class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Author</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Fullname</label>
                            <input type="text" class="form-control form-control-user" id="addFullName"
                                placeholder="Enter fullname" name="fullname" value="{{ old('fullname') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-user" id="addUsername"
                                placeholder="Enter username" name="username" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-user" id="addEmail"
                                placeholder="Enter email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="exampleFullName" class="form-label">Password</label>
                                <input type="password" class="form-control form-control-user" id="addPassword"
                                    placeholder="Enter password" name="password" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFullName" class="form-label">Repeat Password</label>
                                <input type="password" class="form-control form-control-user" id="addRepeatPassword"
                                    placeholder="Enter repeat password" name="repeatpassword" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="addForm">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Author</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Fullname</label>
                            <input type="text" class="form-control form-control-user" id="updateFullName"
                                placeholder="Enter fullname" name="fullname" value="{{ old('fullname') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-user" id="updateUsername"
                                placeholder="Enter username" name="username" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFullName" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-user" id="updateEmail"
                                placeholder="Enter email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleStatus">Status</label>
                            <select name="status" id="updateStatus" class="form-control">
                                <option value="" selected disabled>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="updateForm">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Author</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        Are you sure you want to delete this author?
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="deleteForm">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

    <script>
        //function update
        function updateData(data) {
            const form = document.getElementById('updateForm');
            form.action = "{{ route('users.update', ':id') }}".replace(':id', data.id);
            form.querySelector('#updateFullName').value = data.fullname;
            form.querySelector('#updateUsername').value = data.username;
            form.querySelector('#updateEmail').value = data.email;
            form.querySelector('#updateStatus').value = data.status;
        }

        //function delete
        function deleteData(id) {
            const form = document.getElementById('deleteForm');
            form.action = "{{ route('users.destroy', ':id') }}".replace(':id', id);
        }
    </script>
@endsection
