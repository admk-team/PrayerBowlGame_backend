@extends('admin.layouts.layout')

@section('title', 'Admin | Badges')

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
                                <h4 class="card-title">Badges</h4>
                                <a href="{{ route('badges.create') }}" class="btn btn-primary btn-sm float-right">Add Badge</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Milestone 1</th>
                                                <th>Milestone 2</th>
                                                <th>Milestone 3</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($badges as $badge)
                                                <tr>
                                                    <td>{{ $badge->id }}</td>
                                                    <td>{{ $badge->title }}</td>
                                                    <td>
                                                        @if ($badge->image)
                                                            <img src="{{ asset($badge->image) }}" alt="Badge Image" style="max-width: 50px; max-height: 50px;">
                                                        @else
                                                            No Image
                                                        @endif
                                                    </td>
                                                    <td>{!! Str::limit(strip_tags( $badge->description), 80, '...') !!}</td>
                                                    <td>{{ $badge->type }}</td>
                                                    <td>{{ $badge->milestone_1 }}</td>
                                                    <td>{{ $badge->milestone_2 }}</td>
                                                    <td>{{ $badge->milestone_3 }}</td>
                                                    <td class="border-bottom-0">
                                                        <a href="{{ route('badges.edit', $badge->id) }}" class="btn btn-sm">
                                                            <i class="edit ri-pencil-line text-info m-2"></i>
                                                        </a>
                                                        <form action="{{ route('badges.destroy', $badge->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm">
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
                                                    <td colspan="9">No badges found</td>
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

@section('scripts')

@endsection
