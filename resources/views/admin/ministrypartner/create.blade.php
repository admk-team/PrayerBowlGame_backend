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
                                <a href="{{ route('ministryPartners.index') }}"
                                    class="btn btn-primary btn-sm float-right">Back to List</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('ministryPartners.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="name">Ministry Partner Name:</label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                        placeholder="Please Provide the Ministry Partner">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="link">Link:</label>
                                                    <input type="text" name="link" id="link" class="form-control"
                                                        placeholder="Please Provide the link">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="link">Order:</label>
                                                    <input type="number" name="order" id="order" class="form-control"
                                                        placeholder="Please Provide the Sorting Order">
                                                </div>
                                                <div class="col-lg-6 mt-2">
                                                    <label for="logo">Logo:</label>
                                                    <input type="file" name="logo" id="logo"
                                                        class="form-control-file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header">
                                        <h4 class="card-title">Social Media</h4>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="email">Email:</label>
                                                    <input type="email" name="email" id="email" class="form-control"
                                                        placeholder="Please Provide the Email">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="phone">Phone:</label>
                                                    <input type="number" name="phone" id="phone" class="form-control"
                                                        placeholder="Please Provide the Phone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="facebook">Facebook link:</label>
                                                    <input type="text" name="facebook" id="facebook"
                                                        class="form-control" placeholder="Please Provide the Facebook link">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="instagram">Instagram link:</label>
                                                    <input type="text" name="instagram" id="instagram"
                                                        class="form-control"
                                                        placeholder="Please Provide the Instagram link">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="twitter">Twitter link:</label>
                                                    <input type="text" name="twitter" id="twitter" class="form-control"
                                                        placeholder="Please Provide the Twitter link">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="youtube">YouTube link:</label>
                                                    <input type="text" name="youtube" id="youtube"
                                                        class="form-control"
                                                        placeholder="Please Provide the YouTube link">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="whatsApp">WhatsApp link:</label>
                                                    <input type="text" name="whatsApp" id="whatsApp"
                                                        class="form-control"
                                                        placeholder="Please Provide the WhatsApp link">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="tik_tok">TikTok link:</label>
                                                    <input type="text" name="tik_tok" id="tik_tok"
                                                        class="form-control" placeholder="Please Provide the TikTok link">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="linked_in">LinkedIn link:</label>
                                                    <input type="text" name="linked_in" id="linked_in"
                                                        class="form-control"
                                                        placeholder="Please Provide the LinkedIn link">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="christian_circle">Christian Circle link:</label>
                                                    <input type="text" name="christian_circle" id="christian_circle"
                                                        class="form-control"
                                                        placeholder="Please Provide the Christian Circle link">
                                                </div>
                                            </div>
                                        </div>
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
