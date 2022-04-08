@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.ajax', ['imports']) }}" method="post">
                @csrf

                <div class="form-group form-url">
                    <label class="col-form-label" for="url">File</label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="file" id="url" class="form-control" autocomplete="off" value="">
                        </div>

                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="btn btn-primary file-manager" data-input="url" data-type="file"><i class="fa fa-upload"></i> Choose File</a>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Import</button>
            </form>
        </div>
    </div>
@endsection
