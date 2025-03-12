            <x-backend.dashboard.nav.module icon='{moduleIcon}' :title="__('dashboard.managerObject', ['object' => __('dashboard.{moduleName}')])">
                @can('modules', '{moduleName}.index')
                    <li>
                        <a class="text-capitalize"
                            href="/{moduleName}/index">
                            {{ __('dashboard.{moduleName}') }}
                        </a>
                    </li>
                @endcan

                @can('modules', '{moduleName}.catalouge.index')
                    <li>
                        <a class="text-capitalize"
                            href="/{moduleName}/catalouge/index">
                            {{ __('dashboard.objectGroup', ['object' => __('dashboard.{moduleName}')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>
