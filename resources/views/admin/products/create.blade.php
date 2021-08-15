@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
        </div>

        <div class="card-body">
            <form id="productForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           type="text"
                                           name="name" id="name" value="{{ old('name', '') }}" required>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="categories">{{ trans('cruds.product.fields.category') }}</label>
                                    <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all"
                                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all"
                                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select
                                        class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}"
                                        name="categories[]" id="categories" multiple>
                                        @foreach($categories as $id => $category)
                                            <option
                                                value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('categories'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('categories') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.category_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="sub_categories">{{ trans('cruds.product.fields.sub_category') }}</label>
                                    <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all"
                                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all"
                                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select
                                        class="form-control select2 {{ $errors->has('sub_categories') ? 'is-invalid' : '' }}"
                                        name="sub_categories[]" id="sub_categories" multiple>
                                        @foreach($subCategories as $id => $subCategory)
                                            <option
                                                value="{{ $id }}" {{ in_array($id, old('sub_categories', [])) ? 'selected' : '' }}>{{ $subCategory }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('sub_categories'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sub_categories') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.sub_category_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tags">{{ trans('cruds.product.fields.tag') }}</label>
                                    <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all"
                                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all"
                                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                            name="tags[]" id="tags" multiple>
                                        @foreach($tags as $id => $tag)
                                            <option
                                                value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('tags'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tags') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.tag_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="brand_id">{{ trans('cruds.product.fields.brand') }}</label>
                                    <select class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                                            name="brand_id" id="brand_id">
                                        @foreach($brands as $id => $brand)
                                            <option
                                                value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>{{ $brand }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('brand'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('brand') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.brand_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="images">{{ trans('cruds.product.fields.images') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}"
                                         id="images-dropzone">
                                    </div>
                                    @if($errors->has('images'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('images') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.images_helper') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">{{ trans('cruds.product.fields.description') }}</label>
                                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                              name="description" id="description">{{ old('description') }}</textarea>
                                    @if($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.product.fields.description_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-12 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('cruds.productPrice.fields.unit_type') }}</th>
                                        <th>{{ trans('cruds.productPrice.fields.quantity') }}</th>
                                        <th>{{ trans('cruds.productPrice.fields.purchase_price') }}</th>
                                        <th>{{ trans('cruds.productPrice.fields.price') }}</th>
                                        <th>{{ trans('cruds.productPrice.fields.bulk_price') }}</th>
                                        <th>{{ trans('cruds.productPrice.fields.discount') }}</th>
                                        <th>{{ trans('cruds.productPrice.fields.bulk_discount') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="unit[]" style="min-width: 100px;" required>
                                                @foreach($unitTypes as $unitType)
                                                    <option
                                                        value="{{ $unitType->name }}" {{ old('unit') == $unitType->name ? 'selected' : '' }}>{{ $unitType->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" style="min-width: 100px" type="number" step="1" name="quantity[]" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" step="0.01"
                                                   name="purchase_price[]" style="min-width: 100px" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" step="0.01"
                                                   name="price[]" style="min-width: 100px" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" step="0.01"
                                                   name="bulk_price[]" style="min-width: 100px" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" min="0" max="100" step="1"
                                                   name="discount[]" style="min-width: 100px" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" min="0" max="100" step="1"
                                                   name="bulk_discount[]" style="min-width: 100px" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success add-button"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">


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
        var uploadedImagesMap = {}
        Dropzone.options.imagesDropzone = {
            url: '{{ route('admin.products.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                uploadedImagesMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedImagesMap[file.name]
                }
                $('form').find('input[name="images[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($product) && $product->images)
                var files =
                {!! json_encode($product->images) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        const addProductUnitTemplate = () => {
            let unitTypes = <?= json_encode($unitTypes) ?>;
            let unitSelect = `<select class="form-control" name="unit[]" style="min-width: 100px" required>`;
            $.each(unitTypes, (i, e) => {
                unitSelect += `<option value="${e.name}">${e.name}</option>`;
            })
            unitSelect += "</select>";

            let template = `<tr>`+
                `<td>${unitSelect}</td>`+
                `<td><input class="form-control" type="number" step="1" name="quantity[]" style="min-width: 100px" required></td>`+
                `<td><input class="form-control" type="number" step="0.01" name="purchase_price[]" style="min-width: 100px" required></td>`+
                `<td><input class="form-control" type="number" step="0.01" name="price[]" style="min-width: 100px" required></td>`+
                `<td><input class="form-control" type="number" step="0.01" name="bulk_price[]" style="min-width: 100px" required></td>`+
                `<td><input class="form-control" type="number" step="1" name="discount[]" style="min-width: 100px" required></td>`+
                `<td><input class="form-control" type="number" step="1" name="bulk_discount[]" style="min-width: 100px" required></td>`+
                `<td><button type="button" class="btn btn-sm btn-success add-button"><i class="fa fa-plus"></i></button></td>`+
                `</tr>`;

            $('table tbody').append(template)
        }

        $(document).on('click', '.add-button', function (){
            let tr = $(this).closest('tr');

            let isNotEmpty = $($(tr).find('input')).filter(function () {
                return $.trim($(this).val()).length == 0
            }).length == 0;

            if(isNotEmpty){
                addProductUnitTemplate()
                let deleteButton = '<button type="button" class="btn btn-danger btn-sm delete-button"><i class="fa fa-trash"></i></button>';
                $(this).parent().append(deleteButton);
                $(this).remove();
            }else{
                alert('Please enter values then add more')
            }
        });

        $(document).on('click', '.delete-button', function (){
            let tr = $(this).closest('tr');
            $(tr).remove()
        });

        $(document).on('submit', '#productForm', function(e) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{route('admin.products.add')}}",
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.status) {
                        alert(result.msg);
                        setTimeout(function() {
                            window.location = "{{ route('admin.products.index') }}"
                        }, 100);
                    } else {
                        alert(result);
                    }
                },
                error: function(result) {
                    console.log(result);
                }
            });

            e.preventDefault();
        });
    </script>
@endsection
