@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.franchisee.title_singular') }}
    </div>

    <div class="card-body">
        <h6 class="text-danger">{{ trans('global.required_header') }}</h6>
        <form method="POST" action="{{ route("admin.franchisees.update", [$franchisee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">{{ trans('cruds.franchisee.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $franchisee->name) }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.franchisee.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="required" for="email">{{ trans('cruds.franchisee.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $franchisee->email) }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.franchisee.fields.email_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="password">{{ trans('cruds.franchisee.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.franchisee.fields.password_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="required" for="mobile">{{ trans('cruds.franchisee.fields.mobile') }}</label>
                        <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $franchisee->mobile) }}" required>
                        @if($errors->has('mobile'))
                            <div class="invalid-feedback">
                                {{ $errors->first('mobile') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.franchisee.fields.mobile_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>{{ trans('cruds.franchisee.fields.role') }}</label>
                        <select class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role" id="role">
                            <option value disabled {{ old('role', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Franchisee::ROLE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('role', $franchisee->role) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('role'))
                            <div class="invalid-feedback">
                                {{ $errors->first('role') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.franchisee.fields.role_helper') }}</span>
                    </div>
                </div>
            </div>
            <hr>
            <h5>{{ trans('cruds.serviceArea.title') }}</h5>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('cruds.district.fields.state') }}</label>
                        <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state"
                                id="state">
                            <option value
                                    disabled {{ old('state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach($states as $state)
                                <option
                                    value="{{ $state->id }}" {{ old('state', $stateId) ==  $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('cruds.block.fields.district') }}</label>
                        <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}" name="district"
                                id="district">
                            <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>{{ trans('cruds.pincode.fields.block') }}</label>
                        <select class="form-control select2 {{ $errors->has('block') ? 'is-invalid' : '' }}" name="block"
                                id="block">
                            <option value disabled >{{ trans('global.pleaseSelect') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row" id="pincode-section"></div>
                </div>
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
    @parent
    <script>
        $(function () {
            let stateId = {{ old('state', $stateId ?? 0) }};
            let districtId = {{ old('district', $districtId ?? 0) }};
            let blockId = {{ old('block', $blockId ?? 0) }};
            let franchiseeAreas = <?= json_encode($franchiseeAreas)?>;

            $.get("{{ route('admin.get.districts.by.state') }}", {stateId}, result => {
                let districts = `<option value="" selected disabled>{{ trans('global.pleaseSelect') }}</option>`
                if(result.data != ''){
                    $.each(result.data, (i, e) => {
                        districts += `<option value="${e.id}">${e.name}</option>`;
                    });
                }
                $('#district').html(districts);
                $('#district').val(districtId).trigger('change');
            }, 'json');

            $('#state').change(function () {
                let stateId = $(this).val();
                $.get("{{ route('admin.get.districts.by.state') }}", {stateId}, result => {
                    let districts = `<option value="" selected disabled>{{ trans('global.pleaseSelect') }}</option>`
                    if(result.data != ''){
                        $.each(result.data, (i, e) => {
                            districts += `<option value="${e.id}">${e.name}</option>`;
                        });
                    }
                    $('#district').html(districts);
                }, 'json');
            });

            $('#district').change(function () {
                let districtId = $(this).val();
                $.get("{{ route('admin.get.blocks.by.district') }}", {districtId}, result => {
                    let blocks = `<option value="" selected disabled>{{ trans('global.pleaseSelect') }}</option>`
                    if(result.data != ''){
                        $.each(result.data, (i, e) => {
                            blocks += `<option value="${e.id}">${e.name}</option>`;
                        });
                    }
                    $('#block').html(blocks);
                    $('#block').val(blockId).trigger('change');
                }, 'json');
            });

            const isExists = (value, whatToCheck = 'pincode') => {
                return franchiseeAreas.some(function(el) {
                    return whatToCheck == 'area' ? el.area_id === value : el.pincode_id === value;;
                    return el.pincode_id === value;
                });
            }

            const renderPincodesAndAreas = (data) => {
                let pincodes = '';
                $.each(data, (i,e) => {
                    let pincodeExists = isExists(e.id);
                    pincodes += `<div class="col-6">`+
                        `<div class="form-group">`+
                        `<div class="form-check">`+
                        `<input class="form-check-input pincode" type="checkbox" id="pincode-${e.id}" value="${e.id}" ${ pincodeExists ? 'checked' : '' }>`+
                        `<label class="form-check-label" for="pincode-${e.id}">${e.pincode}</label>`+
                        `</div>`+
                        `</div>`;

                    let areas = `<div class="row" id="areas-${e.id}">`
                    $.each(e.areas, (ai, ae) => {
                        areas += `<div class="col-4">` +
                            `<div class="form-group">` +
                            `<div class="form-check">` +
                            `<input class="form-check-input" type="checkbox" name="area[${e.id}][]" id="area-${ae.id}" value="${ae.id}" ${ !pincodeExists ? 'disabled' : '' } ${ isExists(ae.id, 'area')  ? 'checked' : '' }>` +
                            `<label class="form-check-label" for="area-${ae.id}">${ae.area}</label>` +
                            `</div>` +
                            `</div>` +
                            `</div>`;
                    });
                    areas += '</div>';

                    pincodes += areas + '<hr></div>';
                })
                $('#pincode-section').html(pincodes)
            }

            $('#block').change(function () {
                let blockId = $(this).val();
                $.get("{{ route('admin.get.pincodes.and.areas.by.block') }}", {blockId}, result => {
                    renderPincodesAndAreas(result.data)
                }, 'json');
            });
            $(document).on('change', '.pincode', function (){
                let pincode = $(this).val();
                if(this.checked){
                    $(`#areas-${pincode} input`).prop('disabled', false);
                }else{
                    $(`#areas-${pincode} input`).prop('disabled', true);
                }

            });

        });

    </script>
@endsection
