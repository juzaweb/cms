@extends('installer::layouts.master')

@section('template_title')
    {{ trans('installer::installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! trans('installer::installer_messages.environment.wizard.title') !!}
@endsection

@section('container')
    <form method="post" action="{{ route('Installer::environmentSaveWizard') }}" class="tabs-wrap" autocomplete="off">
        @csrf

        <div class="form-group">
            <label for="database_connection">
                {{ trans('installer::installer_messages.environment.wizard.form.db_connection_label') }}
            </label>
            <select id="database_connection" disabled>
                <option value="mysql" selected>{{ trans('installer::installer_messages.environment.wizard.form.db_connection_label_mysql') }}</option>
            </select>
        </div>

        <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
            <label for="database_hostname">
                {{ trans('installer::installer_messages.environment.wizard.form.db_host_label') }}
            </label>
            <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.db_host_placeholder') }}" autocomplete="off" />
            @if ($errors->has('database_hostname'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('database_hostname') }}
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
            <label for="database_port">
                {{ trans('installer::installer_messages.environment.wizard.form.db_port_label') }}
            </label>
            <input type="number" name="database_port" id="database_port" value="3306" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.db_port_placeholder') }}" autocomplete="off" />
            @if ($errors->has('database_port'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('database_port') }}
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
            <label for="database_name">
                {{ trans('installer::installer_messages.environment.wizard.form.db_name_label') }}
            </label>
            <input type="text" name="database_name" id="database_name" value="" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.db_name_placeholder') }}" autocomplete="off" />
            @if ($errors->has('database_name'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('database_name') }}
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
            <label for="database_username">
                {{ trans('installer::installer_messages.environment.wizard.form.db_username_label') }}
            </label>
            <input type="text" name="database_username" id="database_username" value="" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.db_username_placeholder') }}" autocomplete="off" />
            @if ($errors->has('database_username'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('database_username') }}
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
            <label for="database_password">
                {{ trans('installer::installer_messages.environment.wizard.form.db_password_label') }}
            </label>
            <input type="password" name="database_password" id="database_password" value="" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.db_password_placeholder') }}" autocomplete="off" />
            @if ($errors->has('database_password'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('database_password') }}
                </span>
            @endif
        </div>

        <div class="buttons">
            <button class="button">
                {{ trans('installer::installer_messages.environment.wizard.form.buttons.setup_application') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element=document.getElementById('environment_text_input');
            if(val=='other') {
                element.style.display='block';
            } else {
                element.style.display='none';
            }
        }
        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }
        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
    </script>
@endsection
