<script type="text/javascript">
    /**
     * MYMO CMS - THE BEST LARAVEL CMS
     *
     * @package    mymocms/mymocms
     * @link       https://github.com/mymocms/mymocms
     * @license    MIT
     */

    var mymo = {
        adminPrefix: "{{ config('mymo.admin_prefix') }}",
        adminUrl: "{{ url(config('mymo.admin_prefix')) }}",
        lang: @json(trans('mymo_core::app'))
    }
</script>
