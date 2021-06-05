@extends('installer.layout')

@section('title', 'Install - MyMo CMS')

@section('content')
    <form action="{{ route('install.submit') }}" method="post" class="form-ajax" data-success="install_submit_success">
        @csrf
        <div class="row pt-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white tab-title">Requirement</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-danger text-center font-weight-bold status"></p>
                            </div>
                        </div>

                        <div class="row">
                            @include('installer.install.component.requirement')

                            @include('installer.install.component.permission_tab')

                            @include('installer.install.component.admin_tab')

                            @include('installer.install.component.process_tab')
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-secondary back-button" disabled>&lsaquo;&lsaquo; Back</button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-primary next-button">Next &rsaquo;&rsaquo;</button>
                                <button type="submit" class="btn btn-primary submit-button box-hidden"><i class="fa fa-check-circle"></i> Install</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection