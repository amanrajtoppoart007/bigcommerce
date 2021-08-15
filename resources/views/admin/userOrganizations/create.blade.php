@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userOrganization.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-organizations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.userOrganization.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gst_number">{{ trans('cruds.userOrganization.fields.gst_number') }}</label>
                <input class="form-control {{ $errors->has('gst_number') ? 'is-invalid' : '' }}" type="text" name="gst_number" id="gst_number" value="{{ old('gst_number', '') }}">
                @if($errors->has('gst_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gst_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.gst_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="organization_name">{{ trans('cruds.userOrganization.fields.organization_name') }}</label>
                <input class="form-control {{ $errors->has('organization_name') ? 'is-invalid' : '' }}" type="text" name="organization_name" id="organization_name" value="{{ old('organization_name', '') }}" required>
                @if($errors->has('organization_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="representative_name">{{ trans('cruds.userOrganization.fields.representative_name') }}</label>
                <input class="form-control {{ $errors->has('representative_name') ? 'is-invalid' : '' }}" type="text" name="representative_name" id="representative_name" value="{{ old('representative_name', '') }}" required>
                @if($errors->has('representative_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="representative_designation">{{ trans('cruds.userOrganization.fields.representative_designation') }}</label>
                <input class="form-control {{ $errors->has('representative_designation') ? 'is-invalid' : '' }}" type="text" name="representative_designation" id="representative_designation" value="{{ old('representative_designation', '') }}" required>
                @if($errors->has('representative_designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.userOrganization.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="primary_contact">{{ trans('cruds.userOrganization.fields.primary_contact') }}</label>
                <input class="form-control {{ $errors->has('primary_contact') ? 'is-invalid' : '' }}" type="text" name="primary_contact" id="primary_contact" value="{{ old('primary_contact', '') }}" required>
                @if($errors->has('primary_contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('primary_contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.primary_contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="secondary_contact">{{ trans('cruds.userOrganization.fields.secondary_contact') }}</label>
                <input class="form-control {{ $errors->has('secondary_contact') ? 'is-invalid' : '' }}" type="text" name="secondary_contact" id="secondary_contact" value="{{ old('secondary_contact', '') }}" required>
                @if($errors->has('secondary_contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('secondary_contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.secondary_contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="work_area">{{ trans('cruds.userOrganization.fields.work_area') }}</label>
                <input class="form-control {{ $errors->has('work_area') ? 'is-invalid' : '' }}" type="text" name="work_area" id="work_area" value="{{ old('work_area', '') }}" required>
                @if($errors->has('work_area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('work_area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.work_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount_deposited_method">{{ trans('cruds.userOrganization.fields.amount_deposited_method') }}</label>
                <input class="form-control {{ $errors->has('amount_deposited_method') ? 'is-invalid' : '' }}" type="text" name="amount_deposited_method" id="amount_deposited_method" value="{{ old('amount_deposited_method', '') }}">
                @if($errors->has('amount_deposited_method'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount_deposited_method') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.amount_deposited_method_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount_deposited">{{ trans('cruds.userOrganization.fields.amount_deposited') }}</label>
                <input class="form-control {{ $errors->has('amount_deposited') ? 'is-invalid' : '' }}" type="text" name="amount_deposited" id="amount_deposited" value="{{ old('amount_deposited', '') }}">
                @if($errors->has('amount_deposited'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount_deposited') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.amount_deposited_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_address">{{ trans('cruds.userOrganization.fields.organization_address') }}</label>
                <textarea class="form-control {{ $errors->has('organization_address') ? 'is-invalid' : '' }}" name="organization_address" id="organization_address">{{ old('organization_address') }}</textarea>
                @if($errors->has('organization_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_street">{{ trans('cruds.userOrganization.fields.organization_street') }}</label>
                <input class="form-control {{ $errors->has('organization_street') ? 'is-invalid' : '' }}" type="text" name="organization_street" id="organization_street" value="{{ old('organization_street', '') }}">
                @if($errors->has('organization_street'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_street') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_street_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_address_line_two">{{ trans('cruds.userOrganization.fields.organization_address_line_two') }}</label>
                <textarea class="form-control {{ $errors->has('organization_address_line_two') ? 'is-invalid' : '' }}" name="organization_address_line_two" id="organization_address_line_two">{{ old('organization_address_line_two') }}</textarea>
                @if($errors->has('organization_address_line_two'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_address_line_two') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_address_line_two_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_district_id">{{ trans('cruds.userOrganization.fields.organization_district') }}</label>
                <select class="form-control select2 {{ $errors->has('organization_district') ? 'is-invalid' : '' }}" name="organization_district_id" id="organization_district_id">
                    @foreach($organization_districts as $id => $organization_district)
                        <option value="{{ $id }}" {{ old('organization_district_id') == $id ? 'selected' : '' }}>{{ $organization_district }}</option>
                    @endforeach
                </select>
                @if($errors->has('organization_district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_city_id">{{ trans('cruds.userOrganization.fields.organization_city') }}</label>
                <select class="form-control select2 {{ $errors->has('organization_city') ? 'is-invalid' : '' }}" name="organization_city_id" id="organization_city_id">
                    @foreach($organization_cities as $id => $organization_city)
                        <option value="{{ $id }}" {{ old('organization_city_id') == $id ? 'selected' : '' }}>{{ $organization_city }}</option>
                    @endforeach
                </select>
                @if($errors->has('organization_city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_state_id">{{ trans('cruds.userOrganization.fields.organization_state') }}</label>
                <select class="form-control select2 {{ $errors->has('organization_state') ? 'is-invalid' : '' }}" name="organization_state_id" id="organization_state_id">
                    @foreach($organization_states as $id => $organization_state)
                        <option value="{{ $id }}" {{ old('organization_state_id') == $id ? 'selected' : '' }}>{{ $organization_state }}</option>
                    @endforeach
                </select>
                @if($errors->has('organization_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_pincode">{{ trans('cruds.userOrganization.fields.organization_pincode') }}</label>
                <input class="form-control {{ $errors->has('organization_pincode') ? 'is-invalid' : '' }}" type="number" name="organization_pincode" id="organization_pincode" value="{{ old('organization_pincode', '') }}" step="1">
                @if($errors->has('organization_pincode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_pincode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_address">{{ trans('cruds.userOrganization.fields.representative_address') }}</label>
                <textarea class="form-control {{ $errors->has('representative_address') ? 'is-invalid' : '' }}" name="representative_address" id="representative_address">{{ old('representative_address') }}</textarea>
                @if($errors->has('representative_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_street">{{ trans('cruds.userOrganization.fields.representative_street') }}</label>
                <input class="form-control {{ $errors->has('representative_street') ? 'is-invalid' : '' }}" type="text" name="representative_street" id="representative_street" value="{{ old('representative_street', '') }}">
                @if($errors->has('representative_street'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_street') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_street_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_address_line_two">{{ trans('cruds.userOrganization.fields.representative_address_line_two') }}</label>
                <textarea class="form-control {{ $errors->has('representative_address_line_two') ? 'is-invalid' : '' }}" name="representative_address_line_two" id="representative_address_line_two">{{ old('representative_address_line_two') }}</textarea>
                @if($errors->has('representative_address_line_two'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_address_line_two') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_address_line_two_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_district_id">{{ trans('cruds.userOrganization.fields.representative_district') }}</label>
                <select class="form-control select2 {{ $errors->has('representative_district') ? 'is-invalid' : '' }}" name="representative_district_id" id="representative_district_id">
                    @foreach($representative_districts as $id => $representative_district)
                        <option value="{{ $id }}" {{ old('representative_district_id') == $id ? 'selected' : '' }}>{{ $representative_district }}</option>
                    @endforeach
                </select>
                @if($errors->has('representative_district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_city_id">{{ trans('cruds.userOrganization.fields.representative_city') }}</label>
                <select class="form-control select2 {{ $errors->has('representative_city') ? 'is-invalid' : '' }}" name="representative_city_id" id="representative_city_id">
                    @foreach($representative_cities as $id => $representative_city)
                        <option value="{{ $id }}" {{ old('representative_city_id') == $id ? 'selected' : '' }}>{{ $representative_city }}</option>
                    @endforeach
                </select>
                @if($errors->has('representative_city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_state_id">{{ trans('cruds.userOrganization.fields.representative_state') }}</label>
                <select class="form-control select2 {{ $errors->has('representative_state') ? 'is-invalid' : '' }}" name="representative_state_id" id="representative_state_id">
                    @foreach($representative_states as $id => $representative_state)
                        <option value="{{ $id }}" {{ old('representative_state_id') == $id ? 'selected' : '' }}>{{ $representative_state }}</option>
                    @endforeach
                </select>
                @if($errors->has('representative_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_pincode">{{ trans('cruds.userOrganization.fields.representative_pincode') }}</label>
                <input class="form-control {{ $errors->has('representative_pincode') ? 'is-invalid' : '' }}" type="number" name="representative_pincode" id="representative_pincode" value="{{ old('representative_pincode', '') }}" step="1">
                @if($errors->has('representative_pincode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_pincode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="representative_image">{{ trans('cruds.userOrganization.fields.representative_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('representative_image') ? 'is-invalid' : '' }}" id="representative_image-dropzone">
                </div>
                @if($errors->has('representative_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representative_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.representative_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aadhaar_card">{{ trans('cruds.userOrganization.fields.aadhaar_card') }}</label>
                <div class="needsclick dropzone {{ $errors->has('aadhaar_card') ? 'is-invalid' : '' }}" id="aadhaar_card-dropzone">
                </div>
                @if($errors->has('aadhaar_card'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aadhaar_card') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.aadhaar_card_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pan_card">{{ trans('cruds.userOrganization.fields.pan_card') }}</label>
                <div class="needsclick dropzone {{ $errors->has('pan_card') ? 'is-invalid' : '' }}" id="pan_card-dropzone">
                </div>
                @if($errors->has('pan_card'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pan_card') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.pan_card_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_address_proof">{{ trans('cruds.userOrganization.fields.organization_address_proof') }}</label>
                <div class="needsclick dropzone {{ $errors->has('organization_address_proof') ? 'is-invalid' : '' }}" id="organization_address_proof-dropzone">
                </div>
                @if($errors->has('organization_address_proof'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_address_proof') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.organization_address_proof_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="signature">{{ trans('cruds.userOrganization.fields.signature') }}</label>
                <div class="needsclick dropzone {{ $errors->has('signature') ? 'is-invalid' : '' }}" id="signature-dropzone">
                </div>
                @if($errors->has('signature'))
                    <div class="invalid-feedback">
                        {{ $errors->first('signature') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userOrganization.fields.signature_helper') }}</span>
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
    Dropzone.options.representativeImageDropzone = {
    url: '{{ route('admin.user-organizations.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="representative_image"]').remove()
      $('form').append('<input type="hidden" name="representative_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="representative_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($userOrganization) && $userOrganization->representative_image)
      var file = {!! json_encode($userOrganization->representative_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="representative_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
</script>
<script>
    Dropzone.options.aadhaarCardDropzone = {
    url: '{{ route('admin.user-organizations.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="aadhaar_card"]').remove()
      $('form').append('<input type="hidden" name="aadhaar_card" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="aadhaar_card"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($userOrganization) && $userOrganization->aadhaar_card)
      var file = {!! json_encode($userOrganization->aadhaar_card) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="aadhaar_card" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
</script>
<script>
    Dropzone.options.panCardDropzone = {
    url: '{{ route('admin.user-organizations.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="pan_card"]').remove()
      $('form').append('<input type="hidden" name="pan_card" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="pan_card"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($userOrganization) && $userOrganization->pan_card)
      var file = {!! json_encode($userOrganization->pan_card) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="pan_card" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
</script>
<script>
    Dropzone.options.organizationAddressProofDropzone = {
    url: '{{ route('admin.user-organizations.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="organization_address_proof"]').remove()
      $('form').append('<input type="hidden" name="organization_address_proof" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="organization_address_proof"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($userOrganization) && $userOrganization->organization_address_proof)
      var file = {!! json_encode($userOrganization->organization_address_proof) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="organization_address_proof" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
</script>
<script>
    Dropzone.options.signatureDropzone = {
    url: '{{ route('admin.user-organizations.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="signature"]').remove()
      $('form').append('<input type="hidden" name="signature" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="signature"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($userOrganization) && $userOrganization->signature)
      var file = {!! json_encode($userOrganization->signature) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="signature" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
</script>
@endsection