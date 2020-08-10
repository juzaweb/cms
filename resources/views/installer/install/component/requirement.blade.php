<div class="col-md-12 tabs tab-1">
    <div class="tab-name box-hidden">Requirement</div>
    <ul class="list-group">
        <li class="list-group-item {{ $php_support['supported'] ? 'success' : 'error' }}">
            <strong>PHP</strong>
                <strong>
                    <small>
                        (version {{ $php_support['minimum'] }} required)
                    </small>
                </strong>
                <span class="float-right">
                    <strong>
                        {{ $php_support['current'] }}
                    </strong>
                    <i class="fa fa-fw fa-{{ $php_support['supported'] ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
                </span>
        </li>
        @foreach($requirements['requirements']['php'] as $extention => $enabled)
            <li class="list-group-item {{ $enabled ? 'success' : 'error' }}">
                {{ $extention }}
                <span><i class="fa fa-fw fa-{{ $enabled ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i></span>
            </li>
        @endforeach
    </ul>
</div>