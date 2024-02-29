@extends('admin.layouts.layout')

@section('title', 'Admin | Donations')

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
                                <h4 class="card-title">Donations</h4>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-responsive-sm sortable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Donation Type</th>
                                                <th>Donation Amount</th>
                                                <th>Date</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($supporters as $supporter)
                                                <tr>
                                                    <td>{{ $supporter->id }}</td>
                                                    @if ($supporter->supporter_name)
                                                        <td>{{ $supporter->supporter_name }}</td>
                                                    @else
                                                        <td>Hidden Name</td>
                                                    @endif
                                                    <td>{{ $supporter->donation_type }}</td>
                                                    <td>{{ $supporter->donation_amount }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($supporter->date)->format('d F Y') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-supporter"
                                                            data-toggle="modal" data-target="#supporterModal"
                                                            data-supporter-id="{{ $supporter->id }}">
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
                                    <div class="modal fade" id="supporterModal" tabindex="-1" role="dialog"
                                        aria-labelledby="supporterModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="supporterModalLabel">Donations Details</h5>
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
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Donation Type</th>
                                                                <th>Donation Amount</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="modalSupportersBody">
                                                            @forelse ($supporters as $supporter)
                                                                <tr>
                                                                    <td>{{ $supporter->id }}</td>
                                                                    <td>{{ $supporter->supporter_name }}</td>
                                                                    <td>{{ $supporter->donation_type }}</td>
                                                                    <td>{{ $supporter->donation_amount }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($supporter->date)->format('d F Y') }}
                                                                    </td>
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
            @if ($supporters->hasPages())
                <div class="card-footer">
                    {{ $supporters->links() }}
                </div>
            @endif
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

    <!-- <script>
        $(document).ready(function() {
            $('.btn-info').on('click', function() {
                var supporterDetails = $(this).closest('tr').find('.supporter-details').html();
                $('#supporterModal .modal-body').html(supporterDetails);
            });
        });
    </script> -->


    <!-- <script>
        $(document).ready(function() {
            $('.btn-info').on('click', function() {
                // Clear previous data when the modal is opened
                $('#modalSupportersBody').html('');

                // Find the closest row and get the data
                var supporterDetails = $(this).closest('tr').html();
                $('#modalSupportersBody').html(supporterDetails);
            });
        });
    </script> -->

    <script>
        $(document).ready(function() {
            $('.view-supporter').on('click', function() {
                $('#modalSupportersBody').html('');

                var supporterId = $(this).data('supporter-id');
                $.ajax({
                    url: '/donations/' + supporterId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.data) {
                            var supporter = response.data;
                            var supporterHtml = `
                                <tr>
                                    <td>${supporter.id}</td>
                                    <td>${supporter.supporter_name ? supporter.supporter_name : 'Hidden name'}</td>
                                    <td>${supporter.donation_type}</td>
                                    <td>${supporter.donation_amount}</td>
                                    <td>${$supporter->date) }
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
