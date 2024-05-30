@extends('admin.layouts.layout')

@section('title', 'Admin | Prayer Request')

@section('content')
    <div class="container-fluid">

        <div class="content-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Prayer Request</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Name</th>
                                                <th>Prayer Section</th>
                                                <th>Request Type</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->category->title }}</td>
                                                    <td>{{ $item->request_type ? 'Private' : 'Public' }}</td>
                                                    <td>{!! Str::limit(strip_tags($item->message), 100, '...') !!}</td>
                                                    <td class="border-bottom-0">
                                                        <button class="btn btn-sm btn-info view-supporter"
                                                            data-toggle="modal" data-target="#supporterModal"
                                                            data-supporter-id="{{ $item->id }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <form action="{{ route('prayrequest.destroy', $item->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="delete ri-delete-bin-line text-danger m-2"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No Content found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- Modal Eye Button -->
                                    <div class="modal fade" id="supporterModal" tabindex="-1" role="dialog"
                                        aria-labelledby="supporterModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="supporterModalLabel">Prayer Request Details
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-hover table-responsive-sm sortable"
                                                        id="supporterTable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>User Name</th>
                                                                <th>Prayer Section</th>
                                                                <th>Request Type</th>
                                                                <th>Message</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="modalSupportersBody">
                                                            <!-- Data will be dynamically loaded here -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal Eye Button -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.view-supporter').on('click', function() {
                $('#modalSupportersBody').html('');

                var supporterId = $(this).data('supporter-id');
                $.ajax({
                    url: 'prayrequest/' + supporterId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.data) {
                            var supporter = response.data;
                            var supporterHtml = `
                            <tr>
                                <td>${supporter.id}</td>
                                <td>${supporter.user.name}</td>
                                <td>${supporter.category.title}</td>
                                <td>${supporter.request_type ? 'Private' : 'Public'}</td>
                                <td>${supporter.message}</td>
                            </tr>
                        `;
                            $('#modalSupportersBody').html(supporterHtml);
                        } else {
                            console.error('Invalid response format');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
