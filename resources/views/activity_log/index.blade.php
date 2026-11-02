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

        <!-- Custom pagination links with only Previous, Next, and Numbers -->
        <nav aria-label="{{ __('Page navigation') }}">
            <ul class="pagination">
                <!-- Previous Link -->
                @if ($activities->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">{{ __('Previous') }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $activities->previousPageUrl() }}" rel="prev">{{ __('Previous') }}</a>
                    </li>
                @endif

                <!-- Pagination Numbers -->
                @for ($i = 1; $i <= $activities->lastPage(); $i++)
                    <li class="page-item {{ $i == $activities->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $activities->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Link -->
                @if ($activities->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $activities->nextPageUrl() }}" rel="next">{{ __('Next') }}</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">{{ __('Next') }}</span>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Option to view all logs -->
        <a href="{{ route('activity-log.all') }}" class="btn btn-primary">{{ __('See All') }}</a>
    </div>
@endsection
