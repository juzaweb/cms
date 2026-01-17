@extends('itube::layouts.main')

@section('title', __('itube::translation.upload_video'))

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ mix('css/upload.min.css', 'themes/itube') }}" type="text/css" />
@endsection

@section('content')
    <div class="container full-height">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-4">{{ __('itube::translation.upload_video') }}</h1>

                <form action="{{ url('upload') }}"
                      role='form'
                      id='uploadForm'
                      name='uploadForm'
                      method='post'
                      enctype='multipart/form-data'
                      class="dropzone"
                >
                    <div class="form-group" id="attachment">
                        <div class="controls text-center">
                            <div class="input-group w-100">
                                <a class="btn btn-primary w-100 text-white" id="upload-button">
                                    {{ __('itube::translation.choose_files') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="previews-container">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/html" id="template-container">
        @component('itube::components.preview-template')
        @endcomponent
    </script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        let uploadHidden = false;
        let updateUrl = '{{ url('videos/__CODE__') }}';
        const lang = {
            dictDefaultMessage: '{{ __('itube::translation.or_drop_files_here_to_upload') }}',
        };
        const acceptedFiles = "{{ implode(',', ['video/mp4']) }}";
        const maxFilesize = 1024 * 1024; // 1 GB in MB

        Dropzone.options.uploadForm = {
            paramName: "upload",
            uploadMultiple: false,
            parallelUploads: 5,
            timeout: 0,
            clickable: '#upload-button',
            dictDefaultMessage: lang.dictDefaultMessage,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json',
            },
            acceptedFiles: acceptedFiles,
            maxFilesize: maxFilesize,
            chunking: true,
            forceChunking: true,
            chunkSize: 1048576,
            previewTemplate: document.querySelector('#template-container').innerHTML,
            previewsContainer: '#previews-container',
            init: function () {
                this.on('success', function (file, response) {
                    const form = file.previewElement.querySelector('.dz-form');
                    form.action = updateUrl.replace('__CODE__', response.code);
                    form.querySelector('button[type="submit"]').disabled = false;
                    form.querySelector('select[name="mode"]').disabled = false;
                });

                this.on('addedfile', function (file) {
                    const uniqueId = file.upload.uuid;

                    // Replace __ID__ in preview HTML
                    if (file.previewElement) {
                        const html = file.previewElement.innerHTML;
                        file.previewElement.innerHTML = html.replace(/__ID__/g, uniqueId);
                        // Optional: set data-id for later reference
                        file.previewElement.dataset.fileId = uniqueId;
                    }

                    if (! uploadHidden) {
                        document.getElementById('uploadForm').style.display = 'none';
                        uploadHidden = true;
                    }

                    const titleInput = file.previewElement.querySelector('.video-title');
                    if (titleInput) {
                        titleInput.value = file.name.replace(/\.[^/.]+$/, "");
                    }
                });

                this.on('thumbnail', function (file, dataUrl) {
                    //
                });

                this.on('uploadprogress', function (file, progress, bytesSent) {
                    console.log(`Uploading: ${progress}%`);
                });

                this.on('error', function (file, response) {
                    let message = '';

                    if (typeof response === 'string') {
                        message = response;
                    } else if (response.message) {
                        message = response.message;
                    } else if (response.errors) {
                        message = Object.values(response.errors).flat().join(' ');
                    } else {
                        message = '{{ __('itube::translation.upload_failed') }}';
                    }

                    file.previewElement.classList.add('dz-error');
                    const errorMessageElements = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                    errorMessageElements.forEach(el => el.textContent = message);
                });
            }
        };

        $(function () {
            function upload(file, output) {
                if (!file) return;

                const chunkSize = 1024 * 1000; // 1MB
                const totalChunks = Math.ceil(file.size / chunkSize);
                let currentChunk = 0;

                const uploadChunk = () => {
                    const start = currentChunk * chunkSize;
                    const end = Math.min(start + chunkSize, file.size);
                    const chunk = file.slice(start, end);

                    const formData = new FormData();
                    formData.append('upload', chunk, file.name);
                    formData.append('chunkNumber', currentChunk + 1);
                    formData.append('chunkSize', chunkSize);
                    formData.append('totalChunks', totalChunks);
                    formData.append('fileName', file.name);
                    formData.append('fileSize', file.size);
                    formData.append('mimeType', file.type);
                    formData.append('originalName', file.name);
                    formData.append('identifier', file.name + '-' + file.size);

                    $.ajax({
                        url: '{{ url('upload/thumbnail') }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            currentChunk++;
                            if (currentChunk < totalChunks) {
                                uploadChunk();
                            } else {
                                output.closest('.col-md-3').find('.thumb-img').html(
                                    `<img src="${response.url}" class="img-fluid" alt="Thumbnail">`
                                );
                                output.closest('.col-md-3').find('.thumbnail-input').val(response.path);
                                output.closest('.col-md-3').find('.thumbnail-disk').val(response.disk);
                            }
                        },
                        error: function(xhr, status, error) {
                            output.closest('.col-md-3')
                                .find('.thumbnail-error')
                                .text('❌ {{ __('itube::translation.upload_failed') }}: '+ (get_message_response(xhr) || '{{ __('itube::translation.unknown_error') }}'));
                            output.closest('.col-md-3').find('.thumb-img').html(
                                '<i class="fas fa-file-video fa-3x text-secondary mb-3"></i>'
                            );
                        }
                    }).done(
                        function() {
                            output.closest('.choose-thumbnail-label').removeClass('disabled');
                            output.closest('.col-md-3').find('.thumbnail-error').text('');
                        }
                    );
                };

                uploadChunk();
            }

            $(document).on('change', '.thumbnail-hidden-input', function (e) {
                const file = e.target.files[0];
                const output = $(e.target);

                output.closest('.col-md-3').find('.thumb-img').html('<i class="fas fa-spinner fa-spin fa-3x text-secondary"></i>');
                output.closest('.choose-thumbnail-label').addClass('disabled');

                upload(file, output);
            });

            $(document).on('click', '.add-to-playlist', function (e) {
                e.preventDefault();
                const form = $(this).closest('.dz-form');
            });
        });
    </script>
@endsection
