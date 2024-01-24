@extends('admin.layouts.layout')

@section('title', 'Admin | Ministry Partners')

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
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Ministry Partners</h4>
                            <a href="{{ route('ministryPartners.create') }}" class="btn btn-primary btn-sm float-right">Add Ministry Partner</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-responsive-sm sortable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ministry Partners</th>
                                            <th>Logo</th>
                                            <th>Sort Order</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-ministrypartner">
                                        @forelse ($ministryPartners as $ministryPartner)
                                        <tr class="sortable-row" style="cursor: grab" data-id="{{ $ministryPartner->id }}">
                                            <td>{{ $ministryPartner->id }}</td>
                                            <td>{{ $ministryPartner->name }}</td>
                                            <td>
                                                <img src="{{ asset('' . $ministryPartner->logo) }}" alt="Logo" style="max-width: 50px; max-height: 50px;">
                                            </td>
                                            <td>{{ $ministryPartner->order }}</td>
                                            <td class="border-bottom-0">
                                                <a href="{{ route('ministryPartners.edit', $ministryPartner->id) }}" class="btn btn-sm">
                                                    <i class="edit ri-pencil-line text-info m-2"></i>
                                                </a>
                                                <form action="{{ route('ministryPartners.destroy', $ministryPartner->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this Ministry Partner?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="delete ri-delete-bin-line text-danger m-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">No Ministry Partners found.</td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.1/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
    var el = document.getElementById('sortable-ministrypartner');
    var sortable = new Sortable(el, {
        onUpdate: function(evt) {
            var newOrder = [];
            var rows = el.getElementsByClassName('sortable-row');
            for (var i = 0; i < rows.length; i++) {
                newOrder.push(rows[i].getAttribute('data-id'));
            }
            updateOrder(newOrder);
        },
    })

    function updateOrder(newOrder) {
        let action_url = "{{ route('ministrypartner.reorder') }}";
        let formdata = new FormData();
        formdata.append('order', JSON.stringify(newOrder));
        $('.result').html("");
        $.ajax({
            url: action_url,
            method: "POST",
            data: formdata,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data) {
                var html = '';
                if (data.message) {
                    html = '<div class="alert alert-success">' + data.message +
                        '</div>';
                }
                $('.result').append(html);
            },
            error: function(data) 
            {
                if (data.responseJSON.message) 
                {
                    html = '<div class="alert alert-danger">';
                    html += '<span>' + data.responseJSON.message + '</span>'
                    html += '</div>';
                    $('.result').append(html);
                }
            }
        });
    }
</script>
@endsection