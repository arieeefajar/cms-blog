@extends('layout.app')
@section('title', 'Data Post')
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
                            <th>Status</th>
                            <th>Published</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Kategory</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($posts as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        @foreach ($item->categories as $categoryPost)
                                            <li>
                                                {{ $categoryPost->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    @if ($item->status == 'published')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($item->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_published == 'active')
                                        <span class="badge badge-success">{{ $item->status_published }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $item->status_published }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="justify-content-center">
                                        <a href="#" data-toggle="modal" data-target="#updateModal"
                                            class="btn btn-warning btn-sm" onclick="updateData({{ $item }})"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#detailModal"
                                            class="btn btn-info btn-sm" onclick="detailData({{ $item }})"><i
                                                class="fas fa-info"></i></a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('post-data.store') }}" method="POST" id="addForm">
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
                            <label for="exampleKategory" class="form-label">Select Kategory</label>
                            <br>
                            @foreach ($categories as $item)
                                <div class="form-check d-inline">
                                    <input type="checkbox" class="form-check-input" id="addKategory_{{ $item->id }}"
                                        name="category_id[]" value="{{ $item->id }}">
                                    <label class="form-check-label"
                                        for="addKategory_{{ $item->id }}">{{ $item->name }}</label>
                                </div>
                            @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">Update Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleTitle" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-user" id="addTitleUpdate"
                                placeholder="Enter title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="addDescriptionUpdate" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group" id="divStatus">
                            <label for="exampleStatus" class="form-label">Status</label>
                            <select name="status_published" id="updateStatusPubished" class="form-control">
                                <option value="" selected disabled>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleKategory" class="form-label">Select Kategory</label>
                            <br>
                            @foreach ($categories as $item)
                                <div class="form-check d-inline">
                                    <input type="checkbox" class="form-check-input"
                                        id="addKategoryUpdate_{{ $item->id }}" name="category_id[]"
                                        value="{{ $item->id }}">
                                    <label class="form-check-label"
                                        for="addKategoryUpdate_{{ $item->id }}">{{ $item->name }}</label>
                                </div>
                            @endforeach
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

    <!-- detail Modal-->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="detailForm">
                        @csrf
                        <div class="form-group">
                            <label for="exampleUsers" class="form-label">Created By</label>
                            <input type="text" name="users" id="users" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleDescription" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        Are you sure you want to delete this post?
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
            console.log(data);
            const form = document.getElementById('updateForm');
            form.action = "{{ route('post-data.update', ':id') }}".replace(':id', data.id);
            form.querySelector('#addTitleUpdate').value = data.title;
            form.querySelector('#addDescriptionUpdate').value = data.description;

            if (data.status == 'published') {
                form.querySelector('#divStatus').style.display = 'block';
            } else {
                form.querySelector('#divStatus').style.display = 'none';
            }

            form.querySelector('#updateStatusPubished').value = data.status_published;

            data.kategory.forEach((item) => {
                form.querySelector('#addKategoryUpdate_' + item.id).checked = true;
            });
        }

        //function detail
        function detailData(data) {
            let date = new Date(data.updated_at);

            // Format tanggal menjadi YYYY-MM-DD
            let year = date.getFullYear();
            let month = ('0' + (date.getMonth() + 1)).slice(-2);
            let day = ('0' + date.getDate()).slice(-2);
            let formattedDate = `${year}-${month}-${day}`;
            const form = document.getElementById('detailForm');

            form.querySelector('#users').value = data.users.fullname;
            form.querySelector('#date').value = formattedDate
        }

        //function delete
        function deleteData(id) {
            const form = document.getElementById('deleteForm');
            form.action = "{{ route('post-data.destroy', ':id') }}".replace(':id', id);
        }
    </script>
@endsection
