@extends('cms::layouts.backend')

@section('content')
    <form action="" method="post" class="form-ajax">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right">
                <div class="btn-group">
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                    </button>

                    <button type="button" class="btn btn-warning cancel-button px-3">
                        <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div id="container" style="width: 100%; height: 600px"></div>
                <script src="{{ asset('jw-styles/juzaweb/monaco-editor/min/vs/loader.js') }}"></script>
                <script>
                    require.config({ paths: { vs: '{{ asset('jw-styles/juzaweb/monaco-editor/min/vs') }}' } });

                    require(['vs/editor/editor.main'], function () {
                        let editor = monaco.editor.create(document.getElementById('container'), {
                            value: ['function x() {', '\tconsole.log("Hello world!");', '}'].join('\n'),
                            language: 'javascript',
                            theme: 'vs-dark'
                        });

                        var oldModel = editor.getModel();
                        var newModel = monaco.editor.createModel(data, mode.modeId);
                        editor.setModel(newModel);
                        if (oldModel) {
                            oldModel.dispose();
                        }

                        window.onresize = function () {
                            editor.layout();
                        };
                    });
                </script>
            </div>

            <div class="col-md-3">
                <div class="treeview-animated w-20 border">
                    <h6 class="pt-3 pl-3">Folders</h6>
                    <hr>
                    <ul class="treeview-animated-list mb-3">
                        <li class="treeview-animated-items">
                            <a class="closed">
                                <i class="fa fa-angle-right"></i>
                                <span><i class="fa fa-envelope-open ic-w mx-1"></i>Mail</span>
                            </a>
                            <ul class="nested">
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-bell ic-w mr-1"></i>Offers</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-address-book ic-w mr-1"></i>Contacts</div>
                                </li>
                                <li class="treeview-animated-items">
                                    <a class="closed"><i class="fa fa-angle-right"></i>
                                        <span><i class="fa fa-calendar-alt ic-w mx-1"></i>Calendar</span></a>
                                    <ul class="nested">
                                        <li>
                                            <div class="treeview-animated-element"><i class="fa fa-clock ic-w mr-1"></i>Deadlines</div>
                                        </li>
                                        <li>
                                            <div class="treeview-animated-element"><i class="fa fa-users ic-w mr-1"></i>Meetings</div>
                                        </li>
                                        <li>
                                            <div class="treeview-animated-element"><i class="fa fa-basketball-ball ic-w mr-1"></i>Workouts</div>
                                        </li>
                                        <li>
                                            <div class="treeview-animated-element"><i class="fa fa-mug-hot ic-w mr-1"></i>Events</div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview-animated-items">
                            <a class="closed">
                                <i class="fa fa-angle-right"></i>
                                <span><i class="fa fa-folder-open ic-w mx-1"></i>Inbox</span>
                            </a>
                            <ul class="nested">
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-folder-open ic-w mr-1"></i>Admin</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-folder-open ic-w mr-1"></i>Corporate</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-folder-open ic-w mr-1"></i>Finance</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-folder-open ic-w mr-1"></i>Other</div>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview-animated-items">
                            <a class="closed">
                                <i class="fa fa-angle-right"></i>
                                <span><i class="fa fa-gem mx-1"></i>Favourites</span>
                            </a>
                            <ul class="nested">
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-pepper-hot ic-w mr-1"></i>Restaurants</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-eye ic-w mr-1"></i>Places</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-gamepad ic-w mr-1"></i>Games</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-cocktail ic-w mr-1"></i>Coctails</div>
                                </li>
                                <li>
                                    <div class="treeview-animated-element"><i class="fa fa-pizza-slice ic-w mr-1"></i>Food</div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="treeview-animated-element"><i class="fa fa-comment ic-w mr-1"></i>Notes</div>
                        </li>
                        <li>
                            <div class="treeview-animated-element"><i class="fa fa-cogs ic-w mr-1"></i>Settings</div>
                        </li>
                        <li>
                            <div class="treeview-animated-element"><i class="fa fa-desktop ic-w mr-1"></i>Devices</div>
                        </li>
                        <li>
                            <div class="treeview-animated-element"><i class="fa fa-trash-alt ic-w mr-1"></i>Deleted Items</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
@endsection
