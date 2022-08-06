<form method="post" action="{{ route('admin.profile.change-password') }}" class="form-ajax" data-success="changePasswordSuccess">
    <div class="row">
        <div class="col-md-6">
            {{ Field::text(trans('cms::app.current_password'), 'current_password', [
                'type' => 'password',
                'required' => true
            ]) }}

            {{ Field::text(trans('cms::app.password'), 'password', [
                'type' => 'password',
                'required' => true
            ]) }}

            {{ Field::text(trans('cms::app.password_confirmation'), 'password_confirmation', [
                'type' => 'password',
                'required' => true
            ]) }}

            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-success">{{ trans('cms::app.update') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function changePasswordSuccess(form, response)
    {
        form.find('input').val('');
    }
</script>
