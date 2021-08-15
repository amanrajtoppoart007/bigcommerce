@extends('helpCenter.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.membership.title_singular') }} {{ trans('global.form') }}
        </div>

        <div class="card-body">
            <form id="membershipForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @isset($membership)
                            @if($membership->membership_status == 'INACTIVE')
                                <p class="text-danger">आपकी सदस्यता योजना व्यवस्थापक द्वारा अनुमोदित नहीं है कृपया व्यवस्थापक से संपर्क करें।</p>
                            @elseif($membership->membership_status == 'ACTIVE' && $membership->expiry_date >= date('Y-m-d'))
                                <p class="text-success">आपके पास पहले से ही एक सक्रिय सदस्यता योजना है।</p>
                            @else
                                <p class="text-danger">आपकी कोई सक्रिय सदस्यता योजना नहीं है, कृपया सदस्यता फॉर्म भरें।</p>
                            @endif
                        @else
                            <p class="text-danger">आपकी कोई सक्रिय सदस्यता योजना नहीं है, कृपया सदस्यता फॉर्म भरें।</p>
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="gst_number">{{ trans('cruds.helpCenterProfile.fields.gst_number') }}</label>
                            <input class="form-control {{ $errors->has('gst_number') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="gst_number" id="gst_number" value="{{ $profile->gst_number ?? '' }}">

                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="work_area">{{ trans('cruds.helpCenterProfile.fields.work_area') }}</label>
                            <input class="form-control {{ $errors->has('work_area') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="work_area" id="work_area" value="{{ $profile->work_area ?? '' }}">

                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required">{{ trans('cruds.membership.fields.plan_type') }}</label>
                            <select class="form-control select2" name="plan_type" id="plan_type" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach($membershipPlans as $plan)
                                    <option
                                        data-amount="{{ $plan->fees }}"
                                        value="{{ $plan->id }}" {{ $membership->plan_type ?? '' == $plan->plan_type ? 'selected' : '' }}>{{ $plan->plan_type }}
                                        - {{ $plan->fees }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required">{{ trans('cruds.membership.fields.payment_method') }}</label>
                            <select class="form-control select2" name="payment_method" id="payment_method" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\HelpCenterProfile::PAYMENT_METHOD_RADIO as $key => $label)
                                    <option
                                        value="{{ $key }}" {{ ($membership->payment_method ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    @isset($membership)
                        @if(!($membership->membership_status == 'INACTIVE') && ($membership->membership_status == 'ACTIVE' && $membership->expiry_date < date('Y-m-d')))
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        @endif
                    @else

                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    @endisset
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        let amount = "{{ $membership->membership_fees ?? '' }}";
        let name = "{{ auth()->user()->name ?? '' }}";
        let email = "{{ auth()->user()->email ?? '' }}";
        let mobile = "{{ auth()->user()->mobile ?? '' }}";


            const makePayment = (lastResponse) => {
                let amount = parseFloat($('option:selected', '#plan_type').data('amount'));
                let totalAmount = amount * 100;
                var options = {
                    "key": "{{ env('RAZOR_KEY') }}",
                    "amount": totalAmount,
                    "currency": "INR",
                    "name": "Krishak Vikas",
                    "description": "Membership payment",
                    "image": "",
                    "order_id": "",
                    "handler": function (response) {
                        storeMembership(response.razorpay_payment_id)
                    },
                    "prefill": {
                        "name": name,
                        "email": email,
                        "contact": mobile
                    },
                    "theme": {
                        "color": "#008000"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }

        const storeMembership = (razorpay_payment_id = '') => {
            $.post("{{ route('helpCenter.store.membership') }}", $('#membershipForm').serialize() + '&razorpay_payment_id='+razorpay_payment_id, result => {
                if (result.errors) {
                    $.each(result.errors, function (index, item) {
                        $(`#${index}`).addClass("is-invalid");
                        $(`#${index}`).next('.invalid-feedback').text(item[0]);
                    })
                }else{
                    alert(result.message);
                    if(result.status){
                        window.location = "{{ route('helpCenter.dashboard') }}"
                    }else{

                    }
                }
            }, 'json');
        }

            $('#membershipForm').submit(function (event) {
                event.preventDefault();

                if ($('option:selected', '#payment_method').val() == "ONLINE") {
                    makePayment()
                }else{
                    storeMembership()
                }
            });
    </script>
@endsection
