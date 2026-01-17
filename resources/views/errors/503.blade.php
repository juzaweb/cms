@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('icon', 'fas fa-tools')
@section('message', __('Service Unavailable'))
@section('description', __('The service is temporarily unavailable. We are performing maintenance. Please check back soon.'))
