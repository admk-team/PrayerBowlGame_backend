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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Banner Ad</h4>
                            <a href="{{ route('banners.index') }}" class="btn btn-primary btn-sm float-right">Back to List</a>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="company_name">Banner Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $banner->company_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required>{{ $banner->content }}</textarea>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $banner->start_date }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $banner->end_date }}" required>
                                </div> -->
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $banner->start_date }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $banner->end_date }}" required>
                                </div>


                                <div class="form-group">
                                    <label for="max_views">Max Views</label>
                                    <input type="number" class="form-control" id="max_views" name="max_views" value="{{ $banner->max_views }}" min="1">
                                </div>
                                <div class="form-group">
                                    <label for="max_clicks">Max Clicks</label>
                                    <input type="number" class="form-control" id="max_clicks" name="max_clicks" value="{{ $banner->max_clicks }}" min="1">
                                </div>
                                <div class="form-group">
                                    <label for="banner">Banner</label>
                                    <input type="file" class="form-control" id="banner" name="banner">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection