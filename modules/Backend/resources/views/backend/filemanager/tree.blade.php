<div class="m-3 d-block d-lg-none">
    <h1 style="font-size: 1.5rem;">File Manager</h1>
    <div class="row mt-3">
        <div class="col-4">
            <img src="{{ asset('jw-styles/juzaweb/images/logo.svg') }}" class="w-100" alt="Juzaweb logo" />
        </div>

        <div class="col-8">
            <p>Current usage:</p>
            <p>{{ format_size_units($storage) }} (Max: {{ format_size_units($total), 0 }})</p>
        </div>
    </div>
    <div class="progress mt-3" style="height: .5rem;">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-main" role="progressbar" aria-valuenow="{{ round($storage / $total, 2) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ round($storage / $total, 2) }}%;"></div>
    </div>
</div>

<ul class="nav nav-pills flex-column">
    @foreach($root_folders as $root_folder)
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)" data-type="0" data-path="{{ $root_folder->url }}">
                <i class="fa fa-folder fa-fw"></i> {{ $root_folder->name }}
            </a>
        </li>
        @foreach($root_folder->children as $directory)
            <li class="nav-item sub-item">
                <a class="nav-link" href="javascript:void(0)" data-type="0" data-path="{{ $directory->url }}">
                    <i class="fa fa-folder fa-fw"></i> {{ $directory->name }}
                </a>
            </li>
        @endforeach
    @endforeach
</ul>
