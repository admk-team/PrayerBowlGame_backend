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
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Registred Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <p>{{ $item->email }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        @if ($users->hasPages())
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    @endif
    </div>
    </div>
@endsection