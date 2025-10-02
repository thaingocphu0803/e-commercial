<x-frontend.dashboard.layout :seo="$seo">
    <div class="product-catalouge page-wrapper">
        <div class="container">
            <x-frontend.dashboard.breadcrumb :productCatalouge="$productCatalouge" :breadcrumbs="$breadcrumbs"/>

            <x-frontend.dashboard.filter />

            <x-frontend.homepage.home.product :products="$products"/>

        </div>
    </div>
</x-frontend.dashboard.layout>
