@extends('admin.layouts.layout')

@section('title', 'Admin | Users')

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
                <h4 class="card-title">Contact Messages</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($messages as $item)
                                <tr>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->last_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->message }}</td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal d-flex gap-3">
                                            <form action="{{ route('contact-messages.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </p>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        @if ($messages->hasPages())
        <div class="card-footer">
            {{ $messages->links() }}
        </div>
    @endif
    </div>
    </div>
@endsection