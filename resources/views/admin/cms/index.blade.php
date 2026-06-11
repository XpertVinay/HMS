@extends('layouts.portal')

@section('title', 'CMS Pages')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">CMS Pages</h1>
        <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Page
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $page->title }}</td>
                                <td><code>{{ $page->slug }}</code></td>
                                <td>
                                    @if($page->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $page->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.cms.builder', $page->id) }}" class="btn btn-sm btn-info" target="_blank" title="Edit in Builder">
                                        <i class="fas fa-paint-brush"></i> Builder
                                    </a>
                                    <form action="{{ route('admin.cms.togglePublish', $page->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $page->is_published ? 'btn-warning' : 'btn-success' }}">
                                            {{ $page->is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>
                                    <a href="{{ url($page->slug) }}" class="btn btn-sm btn-secondary" target="_blank" title="View Page">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No CMS pages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
