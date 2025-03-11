            <x-backend.dashboard.nav.module icon='fa-file' :title="__('dashboard.managerObject', ['object' => __('dashboard.{moduleName}')])">
                @if (Route::has('{moduleName}.index'))
                    @can('modules', '{moduleName}.index')
                        <li>
                            <a class="text-capitalize" href="{{ route('{moduleName}.index') }}">
                                {{ __('dashboard.{moduleName}') }}
                            </a>
                        </li>
                    @endcan
                @endif

                @if (Route::has('{moduleName}.catalouge.index'))
                    @can('modules', '{moduleName}.catalouge.index')
                        <li>
                            <a class="text-capitalize" href="{{ route('{moduleName}.catalouge.index') }}">
                                {{ __('dashboard.objectGroup', ['object' => __('dashboard.{moduleName}')]) }}
                            </a>
                        </li>
                    @endcan
                @endif
            </x-backend.dashboard.nav.module>
