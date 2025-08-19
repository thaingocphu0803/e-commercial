<x-frontend.dashboard.layout>
    <main class="main" id="main-section">
        <div class="ck-content">
            <div>
                <x-frontend.homepage.home.slide :settings="$slideSettings" :slides="$slideItems"/>
            </div>
            <div>
                <x-frontend.homepage.home.productcatagory :categories="$productCategories"/>
            </div>
            <div>
                <x-frontend.homepage.home.banner :banners="$bannerItems"/>
            </div>
            <div>
                <x-frontend.homepage.home.product :products="$products"/>
            </div>
        </div>
    </main>

    {{-- modal --}}
    <x-frontend.homepage.home.modal/>
</x-frontend.dashboard.layout>
