@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('icon', 'fas fa-exclamation-circle')
@section('message', __('Too Many Requests'))
@section('description', __('You have made too many requests in a short period. Please wait a moment and try again.'))
