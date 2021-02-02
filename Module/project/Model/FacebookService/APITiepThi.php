<?php

namespace Module\project\Model\FacebookService;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdPreview;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

class APITiepThi {

    static $access_token = "EAAKFlZAZCpY74BABjSPvnZCxNvcYiZA4ZCCBPVi86zNjIZAvfXUbhNt7KjNG2ZBFex3maF4QFTHbgwfJvtlUnVroRCrr3cPi5JsuG8kwC8nG40CCtlZAsaDY5hNarJLPqdXnjQvoSyUjyTZBAtvVmbVxgq3FIanhzZBwDXXsPJ5xFHPPMNlxwDuZB2uyapbGoAy4fQZD";

    public function __construct() {

    }

    function SendData2Facebook() {
        $access_token = 'EAAKFlZAZCpY74BAMh0KTr2k6hYbP7QVU8abirrvXhAQBfDkpfmmKLOSAfB3z8cNZCBRp4GyzOqhwn76Nvh37sW18t70UH5mFhvXZCkiretzkflyhFuLJROrT5Moey900UUDZC49BbLmdZBlbGBWJ6Lpp2I0bvZA0SQ99rNiX4cjBwC844sZAzMJ6ZAfbbi2VG4SjFGZAyqYuRMaQZDZD';
        $app_secret = 'e0c0de1dc81ffb9322327240506dcefd';
        $ad_account_id = '544561249315639';
        $audience_name = 'cau hinh 30 ngay';
        $audience_retention_days = '30';
        $pixel_id = '23845118157060419';
        $app_id = '709827632915390';

        $api = Api::init($app_id, $app_secret, $access_token);

        $api->setLogger(new CurlLogger());

        $fields = array(
        );
        $params = array(
            'name' => 'My Campaign',
            'buying_type' => 'AUCTION',
            'objective' => 'LINK_CLICKS',
            'status' => 'PAUSED',
            'special_ad_categories' => ["EMPLOYMENT"],
        );
        $campaign = (new AdAccount($ad_account_id))->createCampaign(
                $fields, $params
        );
        $campaign_id = $campaign->id;
        echo 'campaign_id: ' . $campaign_id . "\n\n";

        $fields = array(
        );
        $params = array(
            'pixel_id' => $pixel_id,
            'name' => $audience_name,
            'subtype' => 'WEBSITE',
            'retention_days' => $audience_retention_days,
            'rule' => array('url' => array('i_contains' => '')),
            'prefill' => true,
        );
        $custom_audience = (new AdAccount($ad_account_id))->createCustomAudience(
                $fields, $params
        );
        $custom_audience_id = $custom_audience->id;
        echo 'custom_audience_id: ' . $custom_audience_id . "\n\n";

        $fields = array(
        );
        $params = array(
            'name' => 'My AdSet',
            'optimization_goal' => 'REACH',
            'billing_event' => 'IMPRESSIONS',
            'bid_amount' => '20',
            'daily_budget' => '1000',
            'campaign_id' => $campaign_id,
            'targeting' => array('custom_audiences' => array(array('id' => $custom_audience_id)), 'geo_locations' => array('countries' => array('US'))),
            'status' => 'PAUSED',
        );
        $ad_set = (new AdAccount($ad_account_id))->createAdSet(
                $fields, $params
        );
        $ad_set_id = $ad_set->id;
        echo 'ad_set_id: ' . $ad_set_id . "\n\n";

        $fields = array(
        );
        $params = array(
            'name' => 'My Creative',
            'title' => 'My Page Like Ad',
            'body' => 'Like My Page',
            'object_url' => 'www.facebook.com',
            'link_url' => 'www.facebook.com',
            'image_url' => 'http://www.facebookmarketingdevelopers.com/static/images/resource_1.jpg',
        );
        $creative = (new AdAccount($ad_account_id))->createAdCreative(
                $fields, $params
        );
        $creative_id = $creative->id;
        echo 'creative_id: ' . $creative_id . "\n\n";

        $fields = array(
        );
        $params = array(
            'name' => 'My Ad',
            'adset_id' => $ad_set_id,
            'creative' => array('creative_id' => $creative_id),
            'status' => 'PAUSED',
        );
        $ad = (new AdAccount($ad_account_id))->createAd(
                $fields, $params
        );
        $ad_id = $ad->id;
        echo 'ad_id: ' . $ad_id . "\n\n";

        $fields = array(
        );
        $params = array(
            'ad_format' => 'DESKTOP_FEED_STANDARD',
        );
        echo json_encode((new Ad($ad_id))->getPreviews(
                        $fields, $params
                )->getResponse()->getContent(), JSON_PRETTY_PRINT);
    }

}
