{{-- Expose the current locale's JSON translations to JavaScript (used by window.__) --}}
@php($translationFile = lang_path(app()->getLocale() . '.json'))
<script>
    window.translations = @json(file_exists($translationFile) ? json_decode(file_get_contents($translationFile), true) : []);
</script>
