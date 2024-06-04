@extends('admin.layouts.layout')

@section('title', 'Admin | Prayer Request Category')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
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
                                <h4 class="card-title">{{ isset($data) ? 'Update ' : 'Add New ' }}Category</h4>
                                <a href="{{ route('reqcategory.index') }}" class="btn btn-primary btn-sm float-right">Back to
                                    List</a>
                            </div>

                            <div class="card-body">
                                <form action="{{ isset($data) ? route('reqcategory.update', $data->id) : route('reqcategory.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($data))
                                        @method('PUT')
                                    @endif
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ isset($data) ? $data->title : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <button type="submit"
                                            class="btn btn-primary">{{ isset($data) ? 'Update ' : 'Add New ' }}</button>
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
