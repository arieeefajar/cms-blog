@extends('layout.app')
@section('title', 'Data Approval Posts')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Approval Posts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Categories</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Categories</th>
                            <th>Description</th>
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
                                    <div class="justify-content-center">
                                        <a href="#" data-toggle="modal" data-target="#approveModal"
                                            class="btn btn-success btn-sm" onclick="approveData({{ $item->id }})"><i
                                                class="fas fa-upload"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#rejectModal"
                                            class="btn btn-danger btn-sm" onclick="rejectData({{ $item->id }})"><i
                                                class="fas fa-ban"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Approve Modal-->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="approveForm">
                        @csrf
                        @method('PUT')
                        Are you sure you want to approve this post?
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="approveForm">Yes! Approve</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal-->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="rejectPost">
                        @csrf
                        @method('PUT')
                        Are you sure you want to reject this post?
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="rejectPost">Yes! Reject</button>
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
        //function approve
        function approveData(id) {
            const form = document.getElementById('approveForm');
            form.action = "{{ route('approval-post.approve', ':id') }}".replace(':id', id);
        }

        //function reject
        function rejectData(id) {
            const form = document.getElementById('rejectPost');
            form.action = "{{ route('approval-post.reject', ':id') }}".replace(':id', id);
        }
    </script>
@endsection
