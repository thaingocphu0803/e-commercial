<x-frontend.dashboard.layout>
    <main class="main" id="main-section">
        <div class="ck-content">
                <x-frontend.homepage.home.slide :settings="$slideSettings" :slides="$slideItems"/>

                <x-frontend.homepage.home.productcatagory :categories="$productCategories"/>

                <x-frontend.homepage.home.banner :banners="$bannerItems"/>

                <x-frontend.homepage.home.product :products="$products"/>
        </div>
    </main>
</x-frontend.dashboard.layout>
