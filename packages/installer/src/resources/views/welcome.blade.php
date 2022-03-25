@extends('juzaweb::installer.layouts.master')

@section('template_title')
    {{ trans('juzaweb::installer.welcome.template_title') }}
@endsection

@section('title')
    {{ trans('juzaweb::installer.welcome.title') }}
@endsection

@section('container')
    <p class="text-center">
      {{ trans('juzaweb::installer.welcome.message') }}
    </p>

    <p class="text-center">
      <a href="{{ route('installer.requirements') }}" class="button">
        {{ trans('juzaweb::installer.welcome.next') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
      </a>
    </p>
@endsection
