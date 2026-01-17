@extends('itube::layouts.main')

@section('title', __('itube::translation.profile'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/profile.min.css', 'themes/itube') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row" id="wrapper">
            @include('itube::profile.components.sidebar')

            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
                <h3 class="section-title">
                    <span>{{ __('itube::translation.profile') }}</span>
                </h3>

                <section>
                    <form action="" method="post" class="form-ajax">
                        {{ Field::text(__('itube::translation.name'), 'name', ['value' => $user->name]) }}

                        {{ Field::text(__('itube::translation.email'), 'email', ['disabled' => true, 'value' => $user->email]) }}

                        <hr>

                        {{ Field::password(__('itube::translation.password'), 'password', ['placeholder' => __('itube::translation.new_password')]) }}

                        {{ Field::password(__('itube::translation.confirm_password'), 'password_confirmation', ['placeholder' => __('itube::translation.confirm_new_password')]) }}

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('itube::translation.update_profile') }}
                        </button>
                    </form>
                </section>

                <div class="clearfix"></div>
            </main>

        </div>
    </div>
@endsection
