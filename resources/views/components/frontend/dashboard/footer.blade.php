@props([
    'system' => []
])

<footer class="main">
    <section class="newsletter mb-15 wow animate__ animate__fadeIn animated"
        style="visibility: visible; animation-name: fadeIn;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative newsletter-inner page_speed_1126849881">
                        <div class="newsletter-content">
                            <h2 class="mb-50">
                                {{__('custom.footerMessage')}}
                            </h2>

                            <form method="POST" action="https://nest.botble.com/vi/newsletter/subscribe"
                                accept-charset="UTF-8" id="botble-newsletter-forms-fronts-newsletter-form"
                                class="newsletter-form dirty-check"><input name="_token" type="hidden"
                                    value="kbD4pJ3azyMyAqv5V62O0EWIrTUiRc7IyMNpbOYx">
                                <div class="form-subscribe d-flex"><input class="form-control"
                                        placeholder="{{__('custom.enterEmail')}}" id="newsletter-email" required="required"
                                        name="email" type="email">
                                        <button class="btn" type="submit">{{__('custom.register')}}</button>
                                    </div>
                                <div class="newsletter-message newsletter-success-message page_speed_1541029914"></div>
                                <div class="newsletter-message newsletter-error-message page_speed_1541029914"></div>
                                <div class="captcha-render-section"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-frontend.dashboard.footer.footerfeature/>
    <x-frontend.dashboard.footer.footermenu :system="$system" :footerMenu="$footerMenu"/>
    <div class="container pb-30 wow animate__ animate__fadeInUp animated" data-wow-delay="0"
        style="visibility: visible; animation-name: fadeInUp;">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <p class="font-sm mb-0">{{__('custom.copyrightBy', ['attribute' => $system['homepage_copyright']]);}}</p>
            </div>
            <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                <div class="hotline d-lg-inline-flex w-full align-items-center justify-content-center"><img
                        src="https://nest.botble.com/themes/nest/imgs/theme/icons/phone-call.svg" alt="hotline">
                    <p>{{$system['contact_phone']}} <span>{{__('custom.supportCenter')}}</span></p>
                </div>
            </div>
            <div class="col-lg-6 text-end d-none d-md-block col-xl-4">
                <div class="mobile-social-icon">
                    <p class="font-heading h6 me-2 text-capitalize">{{__('custom.followUs')}}:</p><a href="https://www.facebook.com"
                        title="Facebook"><img src="https://nest.botble.com/storage/general/facebook.png"
                            data-bb-lazy="true" loading="lazy" alt="Facebook"></a><a href="https://www.twitter.com"
                        title="Twitter"><img src="https://nest.botble.com/storage/general/twitter.png"
                            data-bb-lazy="true" loading="lazy" alt="Twitter"></a><a
                        href="https://www.instagram.com" title="Instagram"><img
                            src="https://nest.botble.com/storage/general/instagram.png" data-bb-lazy="true"
                            loading="lazy" alt="Instagram"></a><a href="https://www.pinterest.com"
                        title="Pinterest"><img src="https://nest.botble.com/storage/general/pinterest.png"
                            data-bb-lazy="true" loading="lazy" alt="Pinterest"></a><a href="https://www.youtube.com"
                        title="Youtube"><img src="https://nest.botble.com/storage/general/youtube.png"
                            data-bb-lazy="true" loading="lazy" alt="Youtube"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
