<?php

namespace App\Classes;

class System
{
    public function config()
    {
        $data['homepage'] = [
            'title' => 'custom.commoninfor',
            'description' => 'custom.systemcofig',
            'value' => [
                'company' => ['type' => 'text', 'label' => 'custom.companyName'],
                'brand' => ['type' => 'text', 'label' => 'custom.brand'],
                'slogan' => ['type' => 'text', 'label' => 'custom.slogan'],
                'copyright' => ['type' => 'text', 'label' => 'custom.copyright'],
                'website_status' => [
                    'type' => 'select',
                    'label' =>  'custom.webStatus',
                    'option' => [
                        'open' => 'custom.open',
                        'close' => 'custom.maintenance'
                    ]
                ],
                'logo' => ['type' => 'image', 'label' => 'custom.logo'],
                'favicon' => ['type' => 'image', 'label' => 'custom.favicon'],
                'short_intro' => ['type' => 'textarea', 'label' => 'custom.shortIntro']


            ]
        ];

        $data['contact'] = [
            'title' => 'custom.contactinfor',
            'description' => 'custom.contactcofig',
            'value' => [
                'office' => ['type' => 'text', 'label' => 'custom.office'],
                'address' => ['type' => 'text', 'label' => 'custom.address'],
                'countrycode' => ['type' => 'text', 'label' => 'custom.countrycode'],
                'hotline' => ['type' => 'text', 'label' => 'custom.hotline'],
                'technical_phone' => ['type' => 'text', 'label' => 'custom.techPhone'],
                'sell_phone' => ['type' => 'text', 'label' => 'custom.sellPhone'],
                'phone' => ['type' => 'text', 'label' => 'custom.phone'],
                'fax' => ['type' => 'text', 'label' => 'custom.fax'],
                'email' => ['type' => 'text', 'label' => 'custom.email'],
                'tax' => ['type' => 'text', 'label' => 'custom.tax'],
                'website' => ['type' => 'text', 'label' => 'custom.website'],
                'map' => [
                    'type' => 'map',
                    'label' => 'custom.map',
                    'link' => [
                        'text' => 'custom.guideConfigMap',
                        'href' => 'https://manhan.vn/hoc-website-nang-cao/huong-dan-nhung-ban-do-vao-website/',
                        'target' => '_blank'
                    ]
                ],
            ]
        ];

        $data['seo'] = [
            'title' => 'custom.seoHomeInfor',
            'description' => 'custom.seoHomeConfig',
            'value' => [
                'title_seo' => ['type' => 'text', 'label' => 'custom.titleSeo'],
                'keyword_seo' => ['type' => 'text', 'label' => 'custom.keySeo'],
                'desciption_seo' => ['type' => 'text', 'label' => 'custom.descSeo'],
                'image_seo' => ['type' => 'image', 'label' => 'custom.imgSeo'],
            ]
        ];

        return $data;
    }
}
