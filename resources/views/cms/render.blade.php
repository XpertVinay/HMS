@extends('layouts.public')

@section('title', $page->title)

@push('styles')
<style>
    {!! $page->css !!}
</style>
@endpush

@section('content')
    {!! $page->html !!}
@endsection
