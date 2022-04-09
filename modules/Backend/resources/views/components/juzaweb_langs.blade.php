@php
$langs = array_merge(trans('cms::app', [], 'en'), trans('cms::app'));
@endphp
<script type="text/javascript">
    /**
     * JUZAWEB CMS - THE BEST CMS FOR LARAVEL PROJECT
     *
     * @package    juzaweb/juzacms
     * @link       https://juzaweb.com/cms
     * @license    MIT
     */
    var juzaweb = {
        adminPrefix: "{{ config('juzaweb.admin_prefix') }}",
        adminUrl: "{{ url(config('juzaweb.admin_prefix')) }}",
        lang: JSON.parse(`@json($langs)`)
    }
</script>
