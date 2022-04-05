@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <p>You are using Juzaweb CMS Version: {{ \Juzaweb\Version::getVersion() }}</p>
                <p>View CMS change logs: <a href="https://github.com/juzaweb/cms/releases" target="_blank">click here</a></p>
            </div>

            @if($checkUpdate)
                <div class="alert alert-success">Version {{ $versionAvailable }} ready to update.</div>
                <form method="post" action="" class="form-ajax" data-success="update_success">
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-cloud-upload"></i>
                        {{ trans('cms::app.update_now') }}
                    </button>
                </form>

            @else
                <div class="alert alert-secondary">{{ trans('cms::app.no_new_version_available') }}</div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        function update_success() {
            window.location = "";
            return false;
        }
    </script>
@endsection