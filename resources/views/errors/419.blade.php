@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('icon', 'fas fa-clock')
@section('message', __('Page Expired'))
@section('description', __('Your session has expired. Please refresh the page and try again.'))
