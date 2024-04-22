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
                                <a href="{{ route('page.create') }}" class="btn btn-primary btn-sm float-right">Add
                                    Pages</a>
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
                                                        <button class="status btn btn-warning btn-sm rounded" data-id="{{ $item->id }}">{{ $item->status }}</button>
                                                    @elseif ($item->status == 'approved')
                                                        <button class="status btn btn-success btn-sm rounded" data-id="{{ $item->id }}">{{ $item->status }}</button>
                                                    @elseif ($item->status == 'rejected')
                                                        <button class="status btn btn-danger btn-sm rounded" data-id="{{ $item->id }}">{{ $item->status }}</button>
                                                    @endif
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
            @endsection
            <div id="statusModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title-delete">Confirmation</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h4 align="center" style="margin:0;">Are you sure you want to change status?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" name="confirm_status" id="confirm_status"
                                class="btn btn-danger">OK</button>
                            <button type="button" id="closemybt" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            @section('scripts')
            <script>
                $(document).ready(function() {
                    var itemId; // Variable to store the item ID
                    
                    // Click event for status buttons
                    $(document).on('click', '.status', function() {
                        itemId = $(this).data('id'); // Get the ID of the item
                        $('#statusModal').modal('show');
                        console.log(itemId); // Debugging: Check if itemId is properly set
                    });
        
                    // Click event for OK button in status modal
                    $('#confirm_status').click(function() {
                        $.ajax({
                            url: "test/" + itemId,
                            type: "GET",
                            success: function(response) {
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                console.error(xhr.responseText);
                            }
                        });
                        $('#statusModal').modal('hide');
                    });
        
                    // Click event for Cancel button in status modal
                    $('#closemybt').click(function() {
                        $('#statusModal').modal('hide');
                    });
                });
            </script>
        @endsection
        
        
        
        
        
