@extends('cms::installer.layouts.master')

@section('template_title')
    {{ trans('cms::installer.welcome.template_title') }}
@endsection

@section('title')
    {{ trans('cms::installer.welcome.title') }}
@endsection

@section('container')
    <p class="text-center">
      {{ trans('cms::installer.welcome.message') }}
    </p>

    <p class="text-center">
      <a href="{{ route('installer.requirements') }}" class="button">
        {{ trans('cms::installer.welcome.next') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
      </a>
    </p>
@endsection
