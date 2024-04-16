@extends('admin.layouts.layout')

@section('title', 'Admin | All FAQs')

@section('meta')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>FAQs</h3>
                            <a href="{{ route('faqs.create') }}" class="btn btn-primary">Create FAQ</a>
                        </div>
                        <div class="accordion" id="accordionExample">
                            @foreach ($faqs as $item)    
                                <div class="accordion-item position-relative mb-3">
                                    <h2 class="accordion-header" id="headingOne{{ $loop->index }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $loop->index }}" aria-expanded="true" aria-controls="collapseOne{{ $loop->index }}">
                                        {{ $item->question }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="headingOne{{ $loop->index }}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{ $item->answer }}
                                        </div>
                                    </div>
                                    <div class="position-absolute d-flex gap-2" style="right: -76px; top: 10px;">
                                        <a href="{{ route('faqs.edit', $item->id) }}" class="btn btn-primary btn-sm" onclick="event.stopPropagation()"><i class="fa fa-pen"></i></a>
                                        <form action="{{ route('faqs.destroy', $item->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                          </div>

                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            @endsection