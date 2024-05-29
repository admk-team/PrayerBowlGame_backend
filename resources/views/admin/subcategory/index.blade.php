@extends('admin.layouts.layout')

@section('title', 'Admin | SubCategories')

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
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ $category['title'] }}</h4>
                                <div class="float-right">
                                    <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm ">Back to
                                        List</a>
                                    <a href="{{ route('subcategory.create', ['category' => $category['id']]) }}" class="btn btn-primary btn-sm ">Add SubCategory</a>
                                </div>
                               
                                {{--  <a href="{{ route('subcategory.create', ['category' => $category['id']]) }}"
                                        class="btn btn-success btn-sm">{{__('Create Media')}}</a>  --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Content</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($category['subCategories'] as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>
                                                        @if ($item->image)
                                                            <img src="{{ asset($item->image) }}"
                                                                alt="Category Image"
                                                                style="max-width: 50px; max-height: 50px;">
                                                        @else
                                                            No Image
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {!! Str::limit(strip_tags($item->content), 130, '...') !!}
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <a href="{{ route('subcategory.edit', $item->id) }}"
                                                            class="btn btn-sm">
                                                            <i class="edit ri-pencil-line text-info m-2"></i>
                                                        </a>
                                                        <form action="{{ route('subcategory.destroy', $item->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="delete ri-delete-bin-line text-danger m-2"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">No categories found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
