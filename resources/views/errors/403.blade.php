@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('icon', 'fas fa-ban')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('description', __('You do not have permission to access this resource. Please contact the administrator if you believe this is an error.'))
