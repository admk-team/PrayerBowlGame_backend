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
                                <a href="{{ route('ministryPartners.index') }}"
                                    class="btn btn-primary btn-sm float-right">Back to List</a>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('ministryPartners.update', $ministryPartner->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Add this line for the update method -->

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="name">Ministry Partner Name:</label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                        placeholder="Please Provide the Ministry Partner"
                                                        value="{{ $ministryPartner->name }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="link">Link:</label>
                                                    <input type="text" name="link" id="link" class="form-control"
                                                        placeholder="Please Provide the link"
                                                        value="{{ $ministryPartner->link }}">
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
                                                        placeholder="Please Provide the Sorting Order"
                                                        value="{{ $ministryPartner->order }}">
                                                </div>
                                                <div class="col-lg-6 mt-2">
                                                    <label for="logo">Logo:</label>
                                                    <input type="file" name="logo" id="logo"
                                                        class="form-control-file"
                                                        value="{{ basename($ministryPartner->logo) }}">
                                                    @if ($ministryPartner->logo)
                                                        <img src="{{ asset($ministryPartner->logo) }}" alt="Current Logo"
                                                            class="img-thumbnail mt-2" style="max-width: 150px;">
                                                    @endif
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
                                                        placeholder="Please Provide the Email"
                                                        value="{{ $ministryPartner->email }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="phone">Phone:</label>
                                                    <input type="number" name="phone" id="phone" class="form-control"
                                                        placeholder="Please Provide the Phone"
                                                        value="{{ $ministryPartner->phone }}">
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
                                                        class="form-control" placeholder="Please Provide the Facebook link"
                                                        value="{{ $ministryPartner->facebook }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="instagram">Instagram link:</label>
                                                    <input type="text" name="instagram" id="instagram"
                                                        class="form-control" placeholder="Please Provide the Instagram link"
                                                        value="{{ $ministryPartner->instagram }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="twitter">Twitter link:</label>
                                                    <input type="text" name="twitter" id="twitter"
                                                        class="form-control" placeholder="Please Provide the Twitter link"
                                                        value="{{ $ministryPartner->twitter }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="youtube">YouTube link:</label>
                                                    <input type="text" name="youtube" id="youtube"
                                                        class="form-control" placeholder="Please Provide the YouTube link"
                                                        value="{{ $ministryPartner->youtube }}">
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
                                                        placeholder="Please Provide the WhatsApp link"
                                                        value="{{ $ministryPartner->whatsApp }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="tik_tok">TikTok link:</label>
                                                    <input type="text" name="tik_tok" id="tik_tok"
                                                        class="form-control" placeholder="Please Provide the TikTok link"
                                                        value="{{ $ministryPartner->tik_tok }}">
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
                                                        placeholder="Please Provide the LinkedIn link"
                                                        value="{{ $ministryPartner->linked_in }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="christian_circle">Christian Circle link:</label>
                                                    <input type="text" name="christian_circle" id="christian_circle"
                                                        class="form-control"
                                                        placeholder="Please Provide the Christian Circle link"
                                                        value="{{ $ministryPartner->christian_circle }}">
                                                </div>
                                            </div>
                                        </div>
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
