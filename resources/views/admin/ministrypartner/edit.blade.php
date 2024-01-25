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
                            <h4 class="card-title">Edit Ministry Partner</h4>
                            <a href="{{ route('ministryPartners.index') }}" class="btn btn-primary btn-sm float-right">Back to List</a>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('ministryPartners.update', $ministryPartner->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Add this line for the update method -->

                                <div class="form-group">
                                    <label for="name">Ministry Partner Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $ministryPartner->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="link">Link:</label>
                                    <input type="url" name="link" id="link" class="form-control" value="{{ $ministryPartner->link }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="link">Order:</label>
                                    <input type="number" name="order" id="order" class="form-control" value="{{ $ministryPartner->order }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="logo">Logo:</label>
                                    <input type="file" name="logo" id="logo" class="form-control" value="{{ basename($ministryPartner->logo) }}" required>
                                    @if($ministryPartner->logo)
                                        <img src="{{ asset($ministryPartner->logo) }}" alt="Current Logo" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Update Ministry Partner</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
