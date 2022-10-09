<div
    class="modal fade"
    id="login_or_enter_key-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="login_or_enter_key-title"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="login_or_enter_key-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">JuzaWeb Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="enter-key-tab" data-toggle="tab" href="#enter-key" role="tab" aria-controls="enter-key" aria-selected="false">Activation Code</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
                        @if($accessToken)
                            @include('cms::components.modals.tabs.select_key_tab')
                        @else
                            @include('cms::components.modals.tabs.login_tab')
                        @endif

                        <div class="text-right">
                            <a href="https://juzaweb.com/product/{{ $name }}-{{ $module }}" target="_blank" class="btn btn-success btn-sm">Buy {{ $moduleName }}</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="enter-key" role="tabpanel" aria-labelledby="enter-key-tab">
                        @include('cms::components.modals.tabs.enter_key_tab')

                        <div class="text-right">
                            <a href="https://juzaweb.com/product/{{ $name }}-{{ $module }}" target="_blank" class="btn btn-success btn-sm">Buy {{ $moduleName }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
