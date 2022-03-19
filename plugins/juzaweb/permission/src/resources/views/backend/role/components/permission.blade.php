<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @foreach($groups as $group)
                    <h3>
                        {{ trans("perm::content.groups.{$group->name}") }}
                    </h3>

                    <div class="row">
                        @foreach($group->permissions as $permission)
                            <div class="col-md-2 form-line">
                                <label>
                                    <input class="perm-check-item" value="{{ $permission->name }}" type="checkbox" name="permissions[]" @if($model->hasPermissionTo($permission->name)) checked @endif>
                                    <span>{{ trans("perm::content.permissions.{$permission->name}") }}</span>
                                </label>
                            </div>
                        @endforeach

                        <div class="col-md-2 form-line">
                            <label>
                                <input class="check-all-permissions" value="1" type="checkbox" >
                                <span>{{ trans("perm::content.check_all") }}</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>