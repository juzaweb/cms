import {__} from "@/helpers/functions";

export default function Install() {
    return (
        <>
            <div className="row box-hidden mb-2" id="form-theme-upload">
                <div className="col-md-12">
                    <form action="{{ route('admin.theme.install.upload') }}" role="form" id="themeUploadForm"
                          name="themeUploadForm" method="post" className="dropzone" encType="multipart/form-data">
                        <div className="form-group">
                            <div className="controls text-center">
                                <div className="input-group w-100">
                                    <a className="btn btn-primary w-100 text-white" id="theme-upload-button">
                                        {__('cms::filemanager.message-choose')}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    </form>
                </div>
            </div>

            <div className="row">
                <div className="col-md-8"></div>

                <div className="col-md-4 text-right">
                    <button type="button" className="btn btn-success" id="upload-theme">
                        {__('cms::app.upload_theme')}
                    </button>
                </div>
            </div>

            <div className="row" id="theme-list"></div>
        </>
    );
}
