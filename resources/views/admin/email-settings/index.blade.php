@extends('admin.layouts.layout')

@section('title', 'Admin | Email Settings')

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
                <h4 class="card-title">Email Settings</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control input-default" placeholder="android app link (playstore)">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-default" placeholder="ios app link (applestore)">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="4" id="comment" placeholder="email bottom message"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection