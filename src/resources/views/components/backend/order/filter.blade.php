@push('backend-link')
    <link href="{{asset('backend/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
@endpush

@push('backend-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('backend/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
@endpush

<form action="{{ route('order.index') }}">
    @csrf

    @php
        $perpage = request('perpage') ?? old('perpage');
        $confirm_stt = request('confirm_stt') ?? old('confirm_stt');
        $payment_stt = request('payment_stt') ?? old('payment_stt');
        $delivery_stt = request('delivery_stt') ?? old('delivery_stt');
        $date_range = request('date_range') ?? old('date_range');
        $method = request('method') ?? old('method');
    @endphp

    <div class="filter">
        <div class="flex flex-middle flex-space-between">

            <div class="action flex gap-10">
                <div class="perpage gap-10">
                    <select name="perpage" class="form-control perpage filter select2 ">
                        @for ($i = 10; $i <= 100; $i += 10)
                            <option value={{ $i }} @selected($perpage == $i)>
                                {{ $i . ' ' . __('custom.records') }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- time datepicker --}}
                <div class="gap-10">
                    <input type="text" name="date_range" id="date_range" value="{{$date_range}}" placeholder="{{__('custom.selectCreatedDateRange')}}" class="rangepicker form-control fake-select2">
                </div>

                {{-- select confirm status --}}
                <div class="gap-10">
                    <select name="confirm_stt" class="form-control  select2">
                        <option value="nonce" {{ empty($confirm_stt) ? 'selected disabled' : '' }}>
                            {{ __('custom.chooseConfirmStatus') }}
                        </option>

                        @foreach (__('module.confirm_stt') as $key => $val)
                            <option value="{{ $key }}" @selected($confirm_stt == $key)>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- select payment status --}}
                <div class="gap-10">
                    <select name="payment_stt" class="form-control  select2">
                        <option value="nonce" {{ empty($payment_stt) ? 'selected disabled' : '' }}>
                            {{ __('custom.choosePaymentStatus') }}
                        </option>
                        @foreach (__('module.payment_stt') as $key => $val)
                            <option value="{{ $key }}" @selected($payment_stt == $key)>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- select delivery status --}}
                <div class="gap-10">
                    <select name="delivery_stt" class="form-control  select2">
                        <option value="nonce" {{ empty($delivery_stt) ? 'selected disabled' : '' }}>
                            {{ __('custom.chooseDeliveryStatus') }}
                        </option>
                        @foreach (__('module.delivery_stt') as $key => $val)
                            <option value="{{ $key }}" @selected($delivery_stt == $key)>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- select payment method --}}
                <div class="gap-10">
                    <select name="method" class="form-control  select2">
                        <option value="nonce" {{ empty($method) ? 'selected disabled' : '' }}>
                            {{ __('custom.choosePaymentMethod') }}
                        </option>
                        @foreach (__('module.payment') as $methodObj)
                            <option value="{{ $methodObj['id'] }}" @selected($method == $methodObj['id'])>
                                {{ __($methodObj['title']) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-middle gap-10">
                    <div class="input-group">
                        <input class="form-control" type="text" name="keyword"
                            value="{{ request('keyword') ?? old('keyword') }}"
                            placeholder="{{ __('custom.searchBy', ['attribute' => __('custom.code')]) }}...">

                        <span class="input-group-btn">
                            <button class="btn btn-primary search-btn" type="submit">
                                {{ __('custom.search') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            {{-- @can('modules', 'order.create')
                <a href="{{ route('order.create') }}" class="btn btn-danger">
                    <i class="fa fa-plus">
                        {{ __('custom.addObject', ['attribute' => __('custom.order')]) }}
                    </i>
                </a>
            @endcan --}}

        </div>
    </div>

</form>
