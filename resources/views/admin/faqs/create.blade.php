@extends('admin.layouts.layout')

@section('title', 'Admin | Create FAQ')

@section('content')
    <div class="container-fluid">
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create FAQ</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ route('faqs.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control input-default"
                                                placeholder="Question" name="question" value="{{ old('question') }}">
                                            @error('question')
                                                <span class="text-danger mt-1 d-inline-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control"
                                                placeholder="Answer" name="answer" rows="6">{{ old('answer') }}</textarea>
                                            @error('answer')
                                                <span class="text-danger mt-1 d-inline-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
