<div class="btn-group btn-group-sm" role="group" aria-label="{{ __('Language') }}">
    @foreach (config('app.available_locales') as $locale)
        <a href="{{ route('lang.switch', $locale) }}"
            class="btn {{ app()->getLocale() === $locale ? 'btn-primary' : 'btn-outline-secondary' }}">
            {{ strtoupper($locale) }}
        </a>
    @endforeach
</div>
