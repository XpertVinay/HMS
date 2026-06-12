@extends('layouts.portal')

@section('title', 'Create CMS Page')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create CMS Page</h1>
        <a href="{{ route('admin.cms.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.cms.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="title">Page Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="slug">URL Slug</label>
                    <div class="input-group">
                        <span class="input-group-text">{{ url('/') }}/</span>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="about-us" required>
                    </div>
                    <small class="text-muted">Use '/' for the home page.</small>
                    @error('slug')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Page</button>
            </form>
        </div>
    </div>
</div>
@endsection
