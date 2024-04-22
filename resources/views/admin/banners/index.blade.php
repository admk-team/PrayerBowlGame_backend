@extends('admin.layouts.layout')

@section('title', 'Admin | Banner Add')

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
                                <h4 class="card-title">Banners</h4>
                                <a href="{{ route('banners.create') }}" class="btn btn-primary btn-sm float-right">Add
                                    Banner</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-responsive-sm sortable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Banner Name</th>
                                                <th>Banner</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                {{--  <th>Status</th>  --}}
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($banners as $banner)
                                                <tr>
                                                    <td>{{ $banner->id }}</td>
                                                    <td>{{ $banner->company_name }}</td>
                                                    <td>
                                                        @if ($banner->banner)
                                                            <img src="{{ asset('admin_assets/banner_ad/' . $banner->banner) }}"
                                                                alt="Banner Image"
                                                                style="max-width: 50px; max-height: 50px;">
                                                        @else
                                                            No Image
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($banner->start_date)
                                                            {{ \Carbon\Carbon::parse($banner->start_date)->format('Y-m-d H:i:s') }}
                                                        @else
                                                            No Start Date
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($banner->end_date)
                                                            {{ \Carbon\Carbon::parse($banner->end_date)->format('Y-m-d H:i:s') }}
                                                        @else
                                                            No End Date
                                                        @endif
                                                    </td>
                                                    {{--  <td>
                                                @php
                                                    $startDateTime = \Carbon\Carbon::parse($banner->start_date);
                                                    $endDateTime = \Carbon\Carbon::parse($banner->end_date);
                                                    $now = \Carbon\Carbon::now();
                                                    $maxViews = $banner->max_views;
                                                    $maxClicks = $banner->max_clicks;
                                                    $views = $banner->views;
                                                    $clicks = $banner->clicks;
                                                @endphp
                                            
                                                @if ($now->eq($startDateTime) || ($now->gt($startDateTime) && $now->lt($endDateTime) && $views < $maxViews && $clicks < $maxClicks))
                                                    <span class="badge rounded-pill bg-success">
                                                        Active
                                                    </span>
                                                @elseif ($now->lt($startDateTime))
                                                    <span class="badge rounded-pill bg-warning">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">
                                                        Expired
                                                    </span>
                                                @endif
                                            </td>  --}}


                                                    <td class="border-bottom-0">
                                                        <a href="{{ route('banners.edit', $banner->id) }}"
                                                            class="btn btn-sm">
                                                            <i class="edit ri-pencil-line text-info m-2"></i>
                                                        </a>
                                                        <form action="{{ route('banners.destroy', $banner->id) }}"
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
                                                    <td colspan="4">No Banner Ad found.</td>
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
@endsection
