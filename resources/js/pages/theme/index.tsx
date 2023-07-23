import {__} from "@/helpers/functions";

export default function Index({ currentTheme }) {
    return (
        <>
            <div className="row mb-4">
                <div className="col-md-6"></div>
                <div className="col-md-6">
                    <div className="btn-group float-right">
                        {/*@if(config('juzaweb.theme.enable_upload'))
                        <a href="{{ route('admin.theme.install') }}" className="btn btn-success"
                           data-turbolinks="false"><i className="fa fa-plus-circle"></i> {{trans('cms::app.add_new')}}
                        </a>
                        @endif*/}
                    </div>
                </div>
            </div>

            <div className="row" id="theme-list">
                {currentTheme ? (
                    <div className="col-md-4 p-2 theme-list-item">
                        <div className="card">
                            <div className="height-200 d-flex flex-column jw__g13__head">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     data-src={ currentTheme.screenshot }
                                     alt={ currentTheme.title } className="lazyload w-100 h-100"/>
                            </div>

                            <div className="card card-bottom card-borderless mb-0">
                                <div className="card-header border-bottom-0">
                                    <div className="d-flex">
                                        <div className="text-dark text-uppercase font-weight-bold mr-auto">
                                            {currentTheme.title}
                                        </div>
                                        <div className="text-gray-6">
                                            <button className="btn btn-secondary" disabled>
                                                { __('cms::app.activated') }
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ) : ''}
            </div>
        </>
    );
}
