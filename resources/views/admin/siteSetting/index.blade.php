@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            Site {{ trans('cruds.setting.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($siteSetting) ? route("admin.site-setting.update", $siteSetting) : route("admin.site-setting.store") }}"
                  enctype="multipart/form-data">
                @isset($siteSetting)
                    @method('PUT')
                @endisset
                @csrf
                <div class="form-group">
                    <label class="required" for="about_us">About Us</label>
                    <textarea class="form-control ckeditor {{ $errors->has('about_us') ? 'is-invalid' : '' }}"
                              name="about_us" id="about_us">{!! old('about_us', $siteSetting->about_us ?? '') !!}</textarea>
                    @if($errors->has('about_us'))
                        <div class="invalid-feedback">
                            {{ $errors->first('about_us') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="t_and_c">Terms & Conditions</label>
                    <textarea class="form-control ckeditor {{ $errors->has('t_and_c') ? 'is-invalid' : '' }}"
                              name="t_and_c" id="t_and_c">{!! old('t_and_c', $siteSetting->t_and_c ?? '') !!}</textarea>
                    @if($errors->has('t_and_c'))
                        <div class="invalid-feedback">
                            {{ $errors->first('t_and_c') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="privacy_policy">Privacy Policy</label>
                    <textarea class="form-control ckeditor {{ $errors->has('privacy_policy') ? 'is-invalid' : '' }}"
                              name="privacy_policy" id="privacy_policy">{!! old('privacy_policy', $siteSetting->privacy_policy ?? '') !!}</textarea>
                    @if($errors->has('privacy_policy'))
                        <div class="invalid-feedback">
                            {{ $errors->first('privacy_policy') }}
                        </div>
                    @endif

                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return {
                        upload: function () {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function (resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/admin/site-setting/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${file.name}.`;
                                        xhr.addEventListener('error', function () {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function () {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function () {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({default: response.url});
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $contentPage->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

@endsection
