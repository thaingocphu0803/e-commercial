<x-backend.dashboard.nav.module icon='fa-cubes' :title="__('dashboard.managerObject', ['object' => __('dashboard.{moduleName}')])">
    @can('modules', '{moduleViewName}.index')
        <li>
            <a class="text-capitalize" href="{{ route('{moduleViewName}.index') }}">
                {{ __('dashboard.{moduleName}') }}
            </a>
        </li>
    @endcan

    @can('modules', '{moduleViewName}.index')
        <li>
            <a class="text-capitalize" href="{{ route('{moduleViewName}.index') }}">
                {{ __('dashboard.objectGroup', ['object' => __('dashboard.{moduleName}')]) }}
            </a>
        </li>
    @endcan
</x-backend.dashboard.nav.module>
