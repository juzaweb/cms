@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('icon', 'fas fa-server')
@section('message', __('Internal Server Error'))
@section('description', __('Something went wrong on our end. We are working to fix the issue. Please try again later.'))
