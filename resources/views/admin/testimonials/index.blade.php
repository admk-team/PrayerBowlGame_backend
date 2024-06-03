@extends('admin.layouts.layout')

@section('title', 'Admin | Users')

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
                                <h4 class="card-title">Testimonial</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Email</th>
                                                <th>Testimonial</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->user->email }}</td>
                                                    <td>{{ Str::limit($item->testimonial, 130, '...') }}</td>
                                                    <td>
                                                        @if ($item->status == 'pending')
                                                            <button class="status btn btn-warning btn-sm rounded"
                                                                data-id="{{ $item->id }}">Pending</button>
                                                        @elseif ($item->status == 'approved')
                                                            <button class="status btn btn-success btn-sm rounded"
                                                                data-id="{{ $item->id }}">Approved</button>
                                                        @elseif ($item->status == 'rejected')
                                                            <button class="status btn btn-danger btn-sm rounded"
                                                                data-id="{{ $item->id }}">Rejected</button>
                                                        @endif
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <button class="btn btn-sm btn-info view-supporter"
                                                            data-toggle="modal" data-target="#supporterModal"
                                                            data-supporter-id="{{ $item->id }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <form action="{{ route('testimonials.destroy', $item->id) }}"
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
                                                    <td colspan="3">No Content found.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Eye Button -->
    <div class="modal fade" id="supporterModal" tabindex="-1" role="dialog" aria-labelledby="supporterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supporterModalLabel">Prayer Request Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-responsive-sm sortable" id="supporterTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Testimonial</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="modalSupportersBody">
                            <!-- Data will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Eye Button -->
    <!-- Modal status -->
    <div id="statusModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title-delete">Confirmation</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to change status?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" id="approve_status" class="btn btn-success">Approve</button>
                    <button type="button" id="reject_status" class="btn btn-danger">Reject</button>
                    <button type="button" id="closemybt" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal status -->
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('.view-supporter').on('click', function() {
                $('#modalSupportersBody').html('');

                var supporterId = $(this).data('supporter-id');
                $.ajax({
                    url: 'testimonials/' + supporterId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.data) {
                            var supporter = response.data;
                            var statusHtml = '';

                            if (supporter.status === 'pending') {
                                statusHtml =
                                    '<button class="status btn btn-warning btn-sm rounded">Pending</button>';
                            } else if (supporter.status === 'approved') {
                                statusHtml =
                                    '<button class="status btn btn-success btn-sm rounded">Approved</button>';
                            } else if (supporter.status === 'rejected') {
                                statusHtml =
                                    '<button class="status btn btn-danger btn-sm rounded">Rejected</button>';
                            }

                            var supporterHtml = `
                                <tr>
                                    <td>${supporter.id}</td>
                                    <td>${supporter.user.email}</td>
                                    <td>${supporter.testimonial}</td>
                                    <td>${statusHtml}</td>
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

            var itemId; // Variable to store the item ID

            // Click event for status buttons
            $(document).on('click', '.status', function() {
                itemId = $(this).data('id'); // Get the ID of the item
                $('#statusModal').modal('show');
                console.log(itemId); // Debugging: Check if itemId is properly set
            });

            // Click event for Approve button in status modal
            $('#approve_status').click(function() {
                updateStatus(itemId, 'approved');
            });

            // Click event for Reject button in status modal
            $('#reject_status').click(function() {
                updateStatus(itemId, 'rejected');
            });

            // Click event for Cancel button in status modal
            $('#closemybt').click(function() {
                $('#statusModal').modal('hide');
            });

            function updateStatus(id, status) {
                $.ajax({
                    url: "testimonial/" + id,
                    type: "GET",
                    data: {
                        status: status
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
                $('#statusModal').modal('hide');
            }
        });
    </script>
@endsection
