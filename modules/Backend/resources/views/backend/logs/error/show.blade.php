@extends('cms::layouts.backend')

@section('header')
    <style>
        /*
         * Log Entry
         */

        .stack-content {
            color: #AE0E0E;
            font-family: consolas, Menlo, Courier, monospace;
            white-space: pre-line;
            font-size: .8rem;
        }

        /*
         * Colors: Badge & Infobox
         */

        .badge.badge-env,
        .badge.badge-level-all,
        .badge.badge-level-emergency,
        .badge.badge-level-alert,
        .badge.badge-level-critical,
        .badge.badge-level-error,
        .badge.badge-level-warning,
        .badge.badge-level-notice,
        .badge.badge-level-info,
        .badge.badge-level-debug,
        .badge.empty {
            color: #FFF;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
        }

        .badge.badge-level-all,
        .box.level-all {
            background-color: {{ log_styler()->color('all') }};
        }

        .badge.badge-level-emergency,
        .box.level-emergency {
            background-color: {{ log_styler()->color('emergency') }};
        }

        .badge.badge-level-alert,
        .box.level-alert  {
            background-color: {{ log_styler()->color('alert') }};
        }

        .badge.badge-level-critical,
        .box.level-critical {
            background-color: {{ log_styler()->color('critical') }};
        }

        .badge.badge-level-error,
        .box.level-error {
            background-color: {{ log_styler()->color('error') }};
        }

        .badge.badge-level-warning,
        .box.level-warning {
            background-color: {{ log_styler()->color('warning') }};
        }

        .badge.badge-level-notice,
        .box.level-notice {
            background-color: {{ log_styler()->color('notice') }};
        }

        .badge.badge-level-info,
        .box.level-info {
            background-color: {{ log_styler()->color('info') }};
        }

        .badge.badge-level-debug,
        .box.level-debug {
            background-color: {{ log_styler()->color('debug') }};
        }

        .badge.empty,
        .box.empty {
            background-color: {{ log_styler()->color('empty') }};
        }

        .badge.badge-env {
            background-color: #6A1B9A;
        }

        /*#entries {
            overflow-wrap: anywhere;
        }*/
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- Log Details --}}
            <div class="card mb-4">
                <div class="card-header">
                    @lang('Log info'):
                    <div class="group-btns pull-right">
                        <a href="{{ route('admin.logs.error.download', [$log->date]) }}" class="btn btn-sm btn-success">
                            <i class="fa fa-download"></i> {{ trans('Download') }}
                        </a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-log">
                            <i class="fa fa-trash-o"></i> {{ trans('Delete') }}
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed mb-0">
                        <tbody>
                        <tr>
                            <td>@lang('File path') :</td>
                            <td colspan="7">{{ $log->getPath() }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Log entries') :</td>
                            <td>
                                <span class="badge badge-primary">{{ $entries->total() }}</span>
                            </td>
                            <td>{{ trans('Size') }} :</td>
                            <td>
                                <span class="badge badge-primary">{{ $log->size() }}</span>
                            </td>
                            <td>@lang('Created at') :</td>
                            <td>
                                <span class="badge badge-primary">{{ $log->createdAt() }}</span>
                            </td>
                            <td>@lang('Updated at') :</td>
                            <td>
                                <span class="badge badge-primary">{{ $log->updatedAt() }}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{-- Search --}}
                    <form action="{{ route('admin.logs.error.search', [$log->date, $level]) }}" method="GET">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="query" name="query" class="form-control" value="{{ $query }}" placeholder="@lang('Type here to search')" autocomplete="off">
                                <div class="input-group-append">
                                    @unless (is_null($query))
                                        <a href="{{ route('admin.logs.error.show', [$log->date]) }}" class="btn btn-secondary">
                                            (@lang(':count results', ['count' => $entries->count()])) <i class="fa fa-fw fa-times"></i>
                                        </a>
                                    @endunless
                                    <button id="search-btn" class="btn btn-primary">
                                        <span class="fa fa-fw fa-search"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Log Entries --}}
            <div class="card mb-4">
                @if ($entries->hasPages())
                    <div class="card-header">
                        <span class="badge badge-info float-right">
                            {{ __('Page :current of :last', ['current' => $entries->currentPage(), 'last' => $entries->lastPage()]) }}
                        </span>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="entries" class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ trans('ENV') }}</th>
                                <th style="width: 120px;">{{ trans('Level') }}</th>
                                <th style="width: 65px;">{{ trans('Time') }}</th>
                                <th>{{ trans('Header') }}</th>
                                <th class="text-right">{{ trans('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($entries as $key => $entry)
                            <tr>
                                <td>
                                    <span class="badge badge-env">{{ $entry->env }}</span>
                                </td>
                                <td>
                                        <span class="badge badge-level-{{ $entry->level }}">
                                            {!! $entry->level() !!}
                                        </span>
                                </td>
                                <td>
                                        <span class="badge badge-secondary">
                                            {{ $entry->datetime->format('H:i:s') }}
                                        </span>
                                </td>
                                <td>
                                    {{ $entry->header }}
                                </td>
                                <td class="text-right">
                                    @if ($entry->hasStack())
                                        <a class="btn btn-sm btn-light" role="button" data-toggle="collapse"
                                           href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                            <i class="fa fa-toggle-on"></i> {{ trans('Stack') }}
                                        </a>
                                    @endif

                                    @if ($entry->hasContext())
                                        <a class="btn btn-sm btn-light" role="button" data-toggle="collapse"
                                           href="#log-context-{{ $key }}" aria-expanded="false" aria-controls="log-context-{{ $key }}">
                                            <i class="fa fa-toggle-on"></i> {{ trans('Context') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @if ($entry->hasStack() || $entry->hasContext())
                                <tr>
                                    <td colspan="5" class="stack py-0">
                                        @if ($entry->hasStack())
                                            <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                {!! $entry->stack() !!}
                                            </div>
                                        @endif

                                        @if ($entry->hasContext())
                                            <div class="stack-content collapse" id="log-context-{{ $key }}">
                                                {{ $entry->context() }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <span class="badge badge-secondary">@lang('The list of logs is empty!')</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {!! $entries->appends(compact('query'))->render() !!}
        </div>
    </div>

    <script>
        $(function () {
            let btnDelete = $('#delete-log');

            btnDelete.on('click', function() {
                confirm_message(
                    "{{ trans('Are you sure you want to delete this log file: :date ?', ['date' => $log->date]) }}",
                    function (result) {
                        if (!result) {
                            return false;
                        }

                        $.ajax({
                            url: "{{ route('admin.logs.error.delete') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                date: '{{ $log->date }}'
                            },
                            success: function(data) {
                                if (data.result === 'success') {
                                    location.replace("{{ route('admin.logs.error.index') }}");
                                } else {
                                    alert('OOPS ! This is a lack of coffee exception !')
                                }
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                alert('AJAX ERROR ! Check the console !');
                                console.error(errorThrown);
                            }
                        });

                        return false;
                    }
                );

                return false;
            });

            @unless (empty(log_styler()->toHighlight()))
            @php
                $htmlHighlight = join('|', log_styler()->toHighlight());
            @endphp

            $('.stack-content').each(function() {
                var $this = $(this);
                var html = $this.html().trim()
                    .replace(/({!! $htmlHighlight !!})/gm, '<strong>$1</strong>');

                $this.html(html);
            });
            @endunless
        });
    </script>
@endsection
