@extends('admin.layouts.layout')

@section('title', 'Admin | Email Settings')

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
                                <h4 class="card-title">Email Settings</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{ route('email-settings') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control input-default"
                                                placeholder="Android app link" name="androidLink" value="{{ $emailSettings->androidLink ?? '' }}">
                                            @error('androidLink')
                                                <span class="text-danger mt-1 d-inline-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control input-default"
                                                placeholder="IOS app link" name="iosLink" value="{{ $emailSettings->iosLink ?? '' }}">
                                            @error('iosLink')
                                                <span class="text-danger mt-1 d-inline-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" id="comment" placeholder="Email bottom message" name="message">{{ $emailSettings->message ?? '' }}</textarea>
                                            @error('message')
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
