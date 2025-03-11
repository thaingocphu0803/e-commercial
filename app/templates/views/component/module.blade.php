            <x-backend.dashboard.nav.module icon='fa-file' :title="__('dashboard.managerObject', ['object' => __('dashboard.{moduleName}')])">
                @can('modules', '{moduleName}.index')
                    <li>
                        <a class="text-capitalize"
                            href="{{ Route::has('{moduleName}.index') ? route('{moduleName}.index') : '#' }}">
                            {{ __('dashboard.{moduleName}') }}
                        </a>
                    </li>
                @endcan

                @can('modules', '{moduleName}.catalouge.index')
                    <li>
                        <a class="text-capitalize"
                            href="{{ Route::has('{moduleName}.catalouge.index') ? route('{moduleName}.catalouge.index') : '#' }}">
                            {{ __('dashboard.objectGroup', ['object' => __('dashboard.{moduleName}')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>
