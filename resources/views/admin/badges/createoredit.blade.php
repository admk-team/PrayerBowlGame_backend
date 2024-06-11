@extends('admin.layouts.layout')

@section('title', 'Admin | Badges')

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
                                <h4 class="card-title">{{ isset($badge) ? 'Update ' : 'Add New ' }}Badge</h4>
                                <a href="{{ route('badges.index') }}" class="btn btn-primary btn-sm float-right">Back to List</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ isset($badge) ? route('badges.update', $badge->id) : route('badges.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($badge))
                                        @method('PUT')
                                    @endif
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', isset($badge) ? $badge->title : '') }}" required>
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', isset($badge) ? $badge->description : '') }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="prayer" {{ old('type', isset($badge) && $badge->type == 'prayer' ? 'selected' : '') }}>Prayer</option>
                                            <option value="donation" {{ old('type', isset($badge) && $badge->type == 'donation' ? 'selected' : '') }}>Donation</option>
                                        </select>
                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="milestone_1">Milestone 1
                                            @if(isset($badge))
                                            <span style="color: red;">(Do not enter value less than {{$badge->milestone_1}})</span>
                                            @endif
                                        </label>
                                        <input type="number" class="form-control" id="milestone_1" name="milestone_1" value="{{ old('milestone_1', isset($badge) ? $badge->milestone_1 : '') }}" required>
                                        @error('milestone_1')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="milestone_2">Milestone 2
                                            @if(isset($badge))
                                            <span style="color: red;">(Do not enter value less than {{$badge->milestone_2}})</span>
                                            @endif
                                        </label>
                                        <input type="number" class="form-control" id="milestone_2" name="milestone_2" value="{{ old('milestone_2', isset($badge) ? $badge->milestone_2 : '') }}" required>
                                        @error('milestone_2')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="milestone_3">Milestone 3 
                                            @if(isset($badge))
                                            <span style="color: red;">(Do not enter value less than {{$badge->milestone_3}})</span>
                                            @endif
                                        </label>
                                        <input type="number" class="form-control" id="milestone_3" name="milestone_3" value="{{ old('milestone_3', isset($badge) ? $badge->milestone_3 : '') }}" required>
                                        @error('milestone_3')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <button type="submit" class="btn btn-primary">{{ isset($badge) ? 'Update ' : 'Add New ' }}</button>
                                    </div>
                                </form>
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
