            <x-backend.dashboard.nav.module icon='{moduleIcon}' :title="__('custom.managerObject', ['attribute' => __('custom.{moduleName}')])">
                @can('modules', '{moduleName}.index')
                    <li>
                        <a class="text-capitalize"
                            href="/{moduleName}/index">
                            {{ __('custom.{moduleName}') }}
                        </a>
                    </li>
                @endcan

                @can('modules', '{moduleName}.catalouge.index')
                    <li>
                        <a class="text-capitalize"
                            href="/{moduleName}/catalouge/index">
                            {{ __('custom.objectGroup', ['attribute' => __('custom.{moduleName}')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>
