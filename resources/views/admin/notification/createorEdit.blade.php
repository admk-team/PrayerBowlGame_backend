@extends('admin.layouts.layout')

@section('title', 'Admin | Notification')
<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Include Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                                <h4 class="card-title">{{ isset($data) ? 'Edit' : 'New' }} Notification</h4>
                                <a href="{{ route('notification.index') }}" class="btn btn-primary btn-sm float-right">Back
                                    to List</a>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ isset($data) ? route('notification.update', $data->id) : route('notification.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($data))
                                        @method('PUT')
                                    @endif
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="3" required>{{ isset($data) ? $data->content : old('content') }}</textarea>
                                        @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="text" class="form-control" id="start_date" name="start_date"
                                            required
                                            value="{{ isset($data) ? date('Y-m-d H:i', strtotime($data->start_date)) : old('start_date') }}">
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="text" class="form-control" id="end_date" name="end_date" required
                                            value="{{ isset($data) ? date('Y-m-d H:i', strtotime($data->end_date)) : old('end_date') }}">
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($data) ? 'Update' : 'Create' }}</button>
                                </form>
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
    <script>
        flatpickr('#start_date', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        flatpickr('#end_date', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>

@endsection
