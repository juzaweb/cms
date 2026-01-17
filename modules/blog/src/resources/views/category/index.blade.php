@extends('core::layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @can('post-categories.create')
                <x-card title="{{ __('core::translation.add_category') }}">
                    <form action="{{ admin_url('post-categories') }}" method="post" class="form-ajax" data-success="quickCreateSuccess" id="quick-create-form">
                        {{ Field::text(__('core::translation.name'), 'name', ['required' => true]) }}

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> {{ __('core::translation.add_category') }}
                            </button>
                        </div>
                    </form>
                </x-card>
            @endcan
        </div>

        <div class="col-md-9">
            <x-card title="{{ __('core::translation.categories') }}">
                {{ $dataTable->table() }}
            </x-card>
        </div>
    </div>
@endsection

@section('scripts')
    {{ $dataTable->scripts(null, ['nonce' => csp_script_nonce()]) }}

    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        function quickCreateSuccess(response) {
            $('#quick-create-form')[0].reset();
            $('#jw-datatable').DataTable().ajax.reload();
        }

        $(function () {
            $('input[name="name"]').on('blur', function() {
                var name = $(this).val();
                var slug = name.toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-');
                $('input[name="slug"]').val(slug);
            });
        });
    </script>
@endsection
