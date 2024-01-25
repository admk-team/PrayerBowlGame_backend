@extends('admin.layouts.layout')

@section('title', 'Admin | Supporters')

@section('content')
<div class="container-fluid">
    @if (session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Supporters</h4>
                            <!-- <a href="{{ route('ministryPartners.create') }}" class="btn btn-primary btn-sm float-right">Add Supporters</a> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-responsive-sm sortable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Email</th>
                                            <th>Payment ID</th>
                                            <th>Donation Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($supporters as $supporter)
                                        <tr>
                                            <td>{{ $supporter->id }}</td>
                                            <td>{{ $supporter->name }}</td>
                                            <td>{{ $supporter->country }}</td>
                                            <td>{{ $supporter->email }}</td>
                                            <td>{{ $supporter->payment_id }}</td>
                                            <td>{{ $supporter->amount }}</td>
                                            <td>{{ $supporter->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($supporter->date)->format('d F Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#supporterModal">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9">No Supporters found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Modal Eye Button -->
                                <div class="modal fade" id="supporterModal" tabindex="-1" role="dialog" aria-labelledby="supporterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="supporterModalLabel">Supporter Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-hover table-responsive-sm sortable" id="supporterTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Country</th>
                                                            <th>Email</th>
                                                            <th>Payment ID</th>
                                                            <th>Donation Amount</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="modalSupportersBody">
                                                        @forelse ($supporters as $supporter)
                                                        <tr>
                                                            <td>{{ $supporter->id }}</td>
                                                            <td>{{ $supporter->name }}</td>
                                                            <td>{{ $supporter->country }}</td>
                                                            <td>{{ $supporter->email }}</td>
                                                            <td>{{ $supporter->payment_id }}</td>
                                                            <td>{{ $supporter->amount }}</td>
                                                            <td>{{ $supporter->status }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($supporter->date)->format('d F Y') }}</td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="9">No Supporters found.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                <div class="pagination justify-content-center" id="modalPagination">
                                                    <!-- Pagination links will be dynamically loaded here -->
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        @if ($supporters->hasPages())
        <div class="card-footer">
            {{ $supporters->links() }}
        </div>
        @endif
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('.btn-info').on('click', function() 
        {
            var supporterDetails = $(this).closest('tr').find('.supporter-details').html();
            $('#supporterModal .modal-body').html(supporterDetails);
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        $('.btn-info').on('click', function() {
            // Clear previous data when the modal is opened
            $('#modalSupportersBody').html('');
            $('#modalPagination').html('');

            // Fetch paginated data using AJAX
            var supporterId = $(this).data('supporter-id');
            $.ajax({
                url: '/supporters/' + supporterId + '/paginate', // Adjust the URL based on your route
                method: 'GET',
                success: function(response) {
                    // Populate modal body with paginated data
                    $('#modalSupportersBody').html(response.data);

                    // Populate pagination links
                    $('#modalPagination').html(response.links);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script> -->


@endsection