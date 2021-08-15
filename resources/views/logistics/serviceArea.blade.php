@extends('logistics.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            सदस्यता फॉर्म
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('logistics.service.area.save') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>{{ trans('cruds.district.fields.state') }}</label>
                            <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                    name="state"
                                    id="state" required>
                                <option value=""
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
                            <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}"
                                    name="district"
                                    id="district" required>
                                <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>{{ trans('cruds.pincode.fields.block') }}</label>
                            <select class="form-control select2 {{ $errors->has('block') ? 'is-invalid' : '' }}"
                                    name="block"
                                    id="block" required>
                                <option value="" selected>{{ trans('global.pleaseSelect') }}</option>
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
            let stateId = {{ $stateId ?? 0 }};
            let districtId = {{ $districtId ?? 0 }};
            let blockId = {{ $blockId ?? 0 }};
            let franchiseeAreas = <?= json_encode($franchiseeAreas)?>;

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
            setTimeout(() => {
                $('#state').val(stateId).trigger('change');
            }, 500);

            $("#state").on("change", function () {

                $("#district").empty();
                $.ajax({
                    url: "{{route('ajax.district.list')}}",
                    type: 'POST',
                    data: {'state_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">{{ trans('global.pleaseSelect') }}</option>`));
                            $("#district").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#district").append($option);
                            });

                            $("#district").select2();
                            $("#district").val(districtId).trigger('change');
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#district").on("change", function () {

                $("#block").empty();
                $.ajax({
                    url: "{{route('ajax.block.list')}}",
                    type: 'POST',
                    data: {'district_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">{{ trans('global.pleaseSelect') }}</option>`));
                            $("#block").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#block").append($option);
                            });

                            $("#block").select2();
                            $("#block").val(blockId).trigger('change');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
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
                $.get("{{ route('ajax.pincodes.and.areas.list') }}", {blockId}, result => {
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
