@php
$langs = array_merge(trans('cms::app', [], 'en'), trans('cms::app'));
$plugins = \Juzaweb\CMS\Facades\Plugin::all(true)->map(
    fn($item) => Arr::only($item, ['name', 'description'])
)->values();
$themeKeys = get_config("theme_activation_codes", []);
$themes = \Juzaweb\CMS\Facades\Theme::all(true)->map(
    function ($item) use ($themeKeys) {
        $results = Arr::only($item, ['name', 'title', 'description', 'version']);
        $results['active'] = jw_current_theme() == $item['name'];
        if ($key = Arr::get($themeKeys, \Illuminate\Support\Str::snake($item['name']))) {
            $results['key'] = Arr::only($key, ['token', 'certificate']);
        }

        return $results;
    }
)->values();
@endphp
<script type="text/javascript">
    /**
     * JUZAWEB CMS - THE BEST CMS FOR LARAVEL PROJECT
     *
     * @package    juzaweb/cms
     * @link       https://juzaweb.com
     * @license    GNU V2
     */
    const juzaweb = {
        adminPrefix: "{{ config('juzaweb.admin_prefix') }}",
        adminUrl: "{{ url(config('juzaweb.admin_prefix')) }}",
        lang: @json($langs),
        plugins: @json($plugins),
        themes: @json($themes)
    }
</script>
