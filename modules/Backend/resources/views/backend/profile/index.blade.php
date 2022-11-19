@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap flex-column align-items-center">
                        <div class="juzaweb__utils__avatar juzaweb__utils__avatar--size64 mb-3">
                            <img src="{{ $jw_user->getAvatar() }}" alt="{{ $jw_user->name }}" class="w-100">
                        </div>
                        <div class="text-center">
                            <div class="text-dark font-weight-bold font-size-18">{{ $jw_user->name }}</div>

                            <div class="text-uppercase font-size-12 mb-3">
                                {{ $jw_user->is_admin ? 'Administrator' : 'User' }}
                            </div>

                            {{--<button class="btn btn-primary btn-with-addon">
                                <span class="btn-addon">
                                    <i class="btn-addon-icon fa fa-plus-circle"></i>
                                </span>
                                Request Access
                            </button>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="card-title text-white">{{ trans('cms::profile.about_me') }}</h4>
                </div>

                <div class="card-body">
                    <strong>
                        <i class="fa fa-user mr-1"></i> {{ trans('cms::profile.full_name') }}
                    </strong>
                    <p class="text-muted">{{ $jw_user->name }}</p>

                    <hr>
                    <strong>
                        <i class="fa fa-envelope mr-1"></i> {{ trans('cms::profile.email') }}
                    </strong>
                    <p class="text-muted">{{ $jw_user->email }}</p>

                    <hr>
                    <strong><i class="fa fa-birthday-cake mr-1"></i> {{ trans('cms::profile.birthday') }}</strong>
                    <p class="text-muted">
                        {{ $jw_user->getMeta('birthday') ?? '_' }}
                    </p>
                    <hr>
                </div>

            </div>
        </div>

        <div class="col-xl-9 col-lg-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link @if(!isset($notification)) active @endif" href="#settings" data-toggle="tab">{{ trans('cms::app.settings') }}</a></li>
                        <li class="nav-item"><a class="nav-link @if(isset($notification)) active @endif" href="#notifications" data-toggle="tab">{{ trans('cms::app.notifications') }}</a></li>
                        <li class="nav-item text-capitalize"><a class="nav-link" href="#change-password" data-toggle="tab">{{ trans('cms::app.change_password') }}</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane @if(!isset($notification)) active @endif" id="settings">
                            @include('cms::backend.profile.components.info')
                        </div>

                        <div class="tab-pane @if(isset($notification)) active @endif" id="notifications">
                            @if(isset($notification))
                                <a href="{{ route('admin.profile') }}">
                                    <i class="fa fa-hand-o-left"></i> {{ trans('cms::app.notifications') }}
                                </a>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title">{{ $notification->subject }}</h5>
                                        <span class="time"><i class="fa fa-clock"></i> {{ $notification->created_at?->diffForHumans() }}</span>
                                    </div>

                                    <div class="card-body">
                                        {!! $notification->data['body'] !!}
                                    </div>
                                </div>

                            @else
                                {{ $dataTable->render() }}
                            @endif
                        </div>

                        <div class="tab-pane" id="change-password">
                            @include('cms::backend.profile.components.change_password')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <style>
        .card .card-header .time {
            right: 10px;
            position: absolute;
            top: 5px;
            font-size: 12px;
        }
    </style>
@endsection
