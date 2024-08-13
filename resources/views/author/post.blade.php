@extends('layout.app')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Posts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-icon-split mb-3">
                    <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                    <span class="text">Add Post</span>
                </a>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Kategory</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Kategory</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td>Tiger Nixon</td>
                            <td>
                                <ul class="list-unstyled">
                                    <li>
                                        testing
                                    </li>
                                    <li>
                                        testing
                                    </li>
                                    <li>
                                        testing
                                    </li>
                                </ul>
                            </td>
                            <td>Edinburgh</td>
                            <td>
                                <div class="justify-content-center">
                                    <a href="#" data-toggle="modal" data-target="#updateModal"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#deleteModal"
                                        class="btn btn-danger btn-sm""><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="form-group">
                            <label for="exampleTitle" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-user" id="addTitle"
                                placeholder="Enter title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="addDescription" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleKategory" class="form-label">Kategory</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addKategory" name="kategory_id[]"
                                    value="1">
                                <label class="form-check-label">tes</label>
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
@endsection
