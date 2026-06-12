@extends('layouts.portal')
@section('title', __('Admin Dashboard'))

@section('content')
<div class="overview-boxes">
    @foreach($widgets as $widget)
    <div class="box">
        <div class="right-side">
            <div class="box-topic">{{ __($widget['title']) }}</div>
            <div class="number">{{ $widget['value'] }}</div>
            @if(isset($widget['subtitle']))
                <div style="font-size: 12px; color: #888;">{{ __($widget['subtitle']) }}</div>
            @endif
        </div>
        <i class='bx {{ $widget['icon'] }} icon {{ $widget['color_class'] ?? '' }}' {!! isset($widget['style']) ? 'style="'.$widget['style'].'"' : '' !!}></i>
    </div>
    @endforeach
</div>

<div class="sales-boxes">
    @foreach($tables as $table)
    <div class="box">
        <div class="box-title">{{ __($table['title']) }}</div>
        <table class="data-table">
            <thead>
                <tr>
                    @foreach($table['columns'] as $col)
                    <th>{{ __($col) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($table['data'] as $row)
                <tr>
                    @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(isset($table['action_url']) && $table['action_url'])
        <div style="margin-top: 15px;">
            <a href="{{ $table['action_url'] }}" class="btn-modern">{{ __('See All') }}</a>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
