<x-slot:heading>
    <link href="{{ asset('frontend/css/plugins/nice-select.css') }}" rel="stylesheet">
</x-slot:heading>

<x-slot:script>
    <script src="{{ asset('frontend/js/plugins/jquery.nice-select.js') }}"></script>
</x-slot:script>

<div class="filter">
    <div class="d-flex justify-content-between my-2">
        <div class="widget">
            <div class="d-flex gap-2 justify-content-strench align-items-center">
                <a href="#" class="widget-item view-grid">
                    <i class="fi-rs-grid"></i>
                </a>

                <a href="#" class="widget-item view-list">
                    <i class="fi-rs-list"></i>
                </a>

                <a href="#" class="widget-item view-filter">
                    <i class="fi-rs-filter"></i>
                </a>

                <div class=" view-perpage">
                    <select name="perpage" class="nice-select">
                        @for ($i = 10; $i <= 100; $i += 10)
                            <option value={{ $i }}>
                                {{ $i . ' ' . __('custom.product') }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="sorting">
            <div class=" view-perpage">
                <select name="perpage" class="nice-select">
                    <option disabled selected >{{__('custom.sortBy')}}</option>
                    @foreach(__('module.sort_by') as $key => $val)
                        <option value={{ $key }}>
                            {{__($val) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
