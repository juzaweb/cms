<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @foreach($groups as $group)
                    <h3>
                        {{ __($group->description) }}
                    </h3>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <th>{{ trans('perm::content.permission') }}</th>
                                    <th width="10%">
                                        <input class="check-all-permissions" value="1" type="checkbox" /> {{ trans("perm::content.check_all") }}
                                    </th>
                                </thead>
                                <tbody>
                                @foreach($group->permissions as $permission)
                                    <tr>
                                        <td>{{ __($permission->description) }}</td>
                                        <td>
                                            <input class="perm-check-item" value="{{ $permission->name }}" type="checkbox" name="permissions[]" @if($model->hasPermissionTo($permission->name)) checked @endif>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>