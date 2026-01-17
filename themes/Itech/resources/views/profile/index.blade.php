@extends('itech::layouts.main')

@section('title', __('itech::translation.profile'))

@section('head')
    <link rel="stylesheet" href="{{ mix('assets/css/profile.min.css', 'themes/itech') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row" id="wrapper">
            @include('itech::profile.components.sidebar')

            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
                <h3 class="section-title">
                    <span>{{ __('itech::translation.profile') }}</span>
                </h3>

                <section>
                    <form action="" method="post" class="form-ajax">
                        {{ Field::text(__('itech::translation.name'), 'name', ['value' => $user->name]) }}

                        {{ Field::text(__('itech::translation.email'), 'email', ['disabled' => true, 'value' => $user->email]) }}

                        <hr>

                        {{ Field::password(__('itech::translation.password'), 'password', ['placeholder' => __('itech::translation.new_password')]) }}

                        {{ Field::password(__('itech::translation.confirm_password'), 'password_confirmation', ['placeholder' => __('itech::translation.confirm_new_password')]) }}

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('itech::translation.update_profile') }}
                        </button>
                    </form>
                </section>

                <div class="clearfix"></div>
            </main>

        </div>
    </div>
@endsection
