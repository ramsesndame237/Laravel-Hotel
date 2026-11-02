@extends('template.master')
@section('title', __('User'))
@section('content')
    <div class="container">
        <h1>{{ __('User Activity Log') }}</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('By') }}</th>
                    <th>{{ __('Logged At') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->causer->name ?? 'System' }}</td>
                        <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
