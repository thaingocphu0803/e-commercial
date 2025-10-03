<x-frontend.dashboard.layout :seo="$seo">
    <div class="product-catalouge page-wrapper">
        <div class="container">
            <x-frontend.dashboard.breadcrumb
                :product_catalouge_id="$productCatalouge->id"
                :product_catalouge_name="$productCatalouge->name"
                :breadcrumbs="$breadcrumbs"
            />

            <x-frontend.dashboard.filter />

            <x-frontend.homepage.home.product :products="$products"/>

        </div>
    </div>
</x-frontend.dashboard.layout>
