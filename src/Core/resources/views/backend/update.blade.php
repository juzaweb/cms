@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <p>You are using Mymo CMS Version: {{ \Mymo\Core\Version::getVersion() }}</p>
                <p>View CMS change logs: <a href="https://github.com/mymocms/mymocms/blob/master/CHANGELOG.md" target="_blank">click here</a></p>
            </div>

            <div class="alert alert-warning">Important: Before updating, please back up your database and files.</div>

            @if($updater->source()->isNewVersionAvailable())
                @php
                    $versionAvailable = $updater->source()->getVersionAvailable();
                @endphp

                <div class="alert alert-success">Version {{ $versionAvailable }} ready to update.</div>
                <form method="post" action="">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-cloud-upload"></i>
                        Update now
                    </button>
                </form>

            @else
                <div class="alert alert-secondary">{{ trans('mymo_core::app.no_new_version_available') }}</div>
            @endif
        </div>
    </div>
@endsection