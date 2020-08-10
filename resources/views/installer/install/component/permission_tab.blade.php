<div class="col-md-12 box-hidden tabs tab-2">
    <div class="tab-name box-hidden">Permission</div>
    <ul class="list-group">
        @foreach($permissions['permissions'] as $permission)
            <li class="list-group-item {{ $permission['isSet'] ? 'success' : 'error' }}">
                {{ $permission['folder'] }}
                <span>
                    {{ $permission['permission'] }}
                    <i class="fa fa-fw fa-{{ $permission['isSet'] ? 'check-circle-o' : 'exclamation-circle' }}"></i>
                </span>
            </li>
        @endforeach
    </ul>
</div>