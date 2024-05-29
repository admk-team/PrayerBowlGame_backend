@extends('admin.layouts.layout')

@section('title', 'Admin | SubCategory')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@section('content')

    <div class="container-fluid">
        <div class="content-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ isset($data) ? 'Update ' : 'Add New ' }}SubCategory</h4>
                                <a href="  {{ route('category.show',  isset($data) ? $data->cat_id : $categoryId ) }}" class="btn btn-primary btn-sm float-right">Back to List</a>
                              
                            </div>

                            <div class="card-body">
                                <form
                                    action="{{ isset($data) ? route('subcategory.update', $data->id) : route('subcategory.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($data))
                                        @method('PUT')
                                    @endif

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ isset($data) ? $data->title : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="content">Content:</label>
                                                    <div id="editor" class="col-lg-12"
                                                        style="overflow: hidden;
                                                    color: black;">
                                                    </div>
                                                    <textarea style="display:none" id="content" name="content" value="{{ isset($data) ? $data->content : '' }}"></textarea>
                                                    @error('content')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="cat_id"
                                        value="{{ isset($data) ? $data->cat_id : $categoryId }}">
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Get the hidden textarea
        const contentInput = document.querySelector('#content');

        // Populate the Quill editor with existing content if available
        var editdata = null;
        @if (isset($data))
            editdata = {!! json_encode($data->content) !!};
        @endif

        if (editdata !== null) {
            quill.clipboard.dangerouslyPasteHTML(editdata);
            // Set the hidden textarea's value to the existing content
            contentInput.value = editdata;
        }

        // Update the hidden textarea whenever there's a change in Quill editor
        quill.on('text-change', function() {
            contentInput.value = quill.root.innerHTML;
        });
    </script>
@endsection
