<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @foreach($groups as $group)
                    <h3>
                        {{ __($group->get('description')) }}
                    </h3>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <th>{{ trans('cms::app.permissions') }}</th>
                                    <th style="width: 10%">
                                        <input class="check-all-permissions" value="1" type="checkbox" /> {{ trans("cms::app.check_all") }}
                                    </th>
                                </thead>

                                <tbody>
                                @foreach($group->get('permissions', []) as $permission)
                                    <tr>
                                        <td>{{ __($permission->get('description')) }}</td>
                                        <td>
                                            <input class="perm-check-item" value="{{ $permission->get('name') }}" type="checkbox" name="permissions[]" @if($model->hasPermissionTo($permission->get('name'))) checked @endif>
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
