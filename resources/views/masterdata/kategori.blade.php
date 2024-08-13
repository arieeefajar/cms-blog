@extends('layout.app')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-icon-split mb-3">
                    <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                    <span class="text">Add Kategory</span>
                </a>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Position</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($kategory as $index => $item)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td class="text-capitalize">{{ $item->name }}</td>
                                <td>
                                    <div class="justify-content-center">
                                        <a href="#" data-toggle="modal" data-target="#updateModal"
                                            class="btn btn-warning btn-sm" onclick="updateData({{ $item }})">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#deleteModal"
                                            onclick="deleteData({{ $item->id }})" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Kategory</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kategory.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="form-group">
                            <label for="exampleName" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-user" id="addName"
                                placeholder="Enter name" name="name" value="{{ old('name') }}" required>
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
                    <h5 class="modal-title" id="exampleModalLabel">Update Kategory</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleName" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-user" id="updateName"
                                placeholder="Enter name" name="name" value="{{ old('name') }}" required>
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Kategory</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        Are you sure you want to delete this kategory?
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
            form.action = "{{ route('kategory.update', ':id') }}".replace(':id', data.id);
            form.querySelector('#updateName').value = data.name;
        }

        //function delete
        function deleteData(id) {
            const form = document.getElementById('deleteForm');
            form.action = "{{ route('kategory.destroy', ':id') }}".replace(':id', id);
        }
    </script>
@endsection
