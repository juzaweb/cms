@extends('layouts.backend')

@section('content')
    <div class="cui__utils__content">
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong class="text-uppercase font-size-16">Today Statistics</strong>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_movie }}</div>
                                <div class="text-uppercase">@lang('app.movies')</div>
                                <div class="kit__c11__chartContainer">
                                    <div class="kit__c11__chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_tvserie }}</div>
                                <div class="text-uppercase">@lang('app.tv_series')</div>
                                <div class="kit__c11-1__chartContainer">
                                    <div class="kit__c11-1__chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_user }}</div>
                                <div class="text-uppercase">@lang('app.users')</div>
                                <div class="kit__c11-2__chartContainer">
                                    <div class="kit__c11-2__chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection