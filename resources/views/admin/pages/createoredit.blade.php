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
                                <h4 class="card-title">{{ isset($data) ? 'Update ' : 'Add New ' }}Page</h4>
                                <a href="{{ route('page.index') }}" class="btn btn-primary btn-sm float-right">Back to
                                    List</a>
                            </div>

                            <div class="card-body">
                                <form action="{{ isset($data) ? route('page.update', $data->id) : route('page.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($data))
                                        @method('PUT')
                                    @endif

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="type">Page type:</label>
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="about_us"
                                                            {{ (old('type') ?? ($data->type ?? '')) == 'about_us' ? 'selected' : '' }}>
                                                            About Us</option>
                                                        <option value="privacy_policy"
                                                            {{ (old('type') ?? ($data->type ?? '')) == 'privacy_policy' ? 'selected' : '' }}>
                                                            Privacy Policy</option>
                                                        <option value="terms_conditions"
                                                            {{ (old('type') ?? ($data->type ?? '')) == 'terms_conditions' ? 'selected' : '' }}>
                                                            Terms and Conditions</option>
                                                    </select>
                                                    @error('type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="content">Content:</label>
                                                    <textarea name="content" id="content" class="form-control" rows="8" placeholder="Enter the content here">{{ old('content') ?? ($data->content ?? '') }}</textarea>
                                                    @error('content')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($data) ? 'Update ' : 'Add New ' }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
