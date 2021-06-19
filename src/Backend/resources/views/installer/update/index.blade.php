@extends('installer.layout')

@section('title', 'Update - MyMo CMS')

@section('content')
    <form action="{{ route('update.submit') }}" method="post" class="form-ajax">
        @csrf
        <div class="row pt-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white tab-title">Update</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-danger text-center font-weight-bold status"></p>
                            </div>
                        </div>

                        <div class="row">
                            @if($update)
                                <h4>Make sure your database is backed up before updating</h4>
                            @else
                                <h4>No update yet</h4>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">
                                @if($update)
                                <button type="submit" class="btn btn-primary submit-button"><i class="fa fa-check-circle"></i> Update</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection