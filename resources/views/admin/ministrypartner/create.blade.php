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
                            <h4 class="card-title">Add Ministry Partner</h4>
                            <a href="{{ route('ministryPartners.index') }}" class="btn btn-primary btn-sm float-right">Back to List</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('ministryPartners.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Ministry Partner Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Please Provide the Ministry Partner">
                                </div>
                                <div class="form-group">
                                    <label for="link">Link:</label>
                                    <input type="text" name="link" id="link" class="form-control" placeholder="Please Provide the link">
                                </div>
                                <div class="form-group">
                                    <label for="link">Order:</label>
                                    <input type="number" name="order" id="order" class="form-control" placeholder="Please Provide the Sorting Order">
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo:</label>
                                    <input type="file" name="logo" id="logo" class="form-control-file">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Ministry Partner</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
