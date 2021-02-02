<?php
/**
 * Copyright (c) 2015-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

require __DIR__ . '/vendor/autoload.php';

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdPreview;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

$access_token = 'EAAKFlZAZCpY74BAJtLSiDloI2Si8vpnXjZBWKCO83uO4fzsFVemZCzoebaw0tXmhSlpdmu6bxbk4f27jbiLInM3ZBcNdm1U0bRgk31Li3GvoAqDeMR2ZAyD8HNODe0OrtkVKrCGo8CsWf7mmJ7wWxIEWOsH8teE48eClpZBW41F2rP64lILsmZBXfGCtS3wZCk3cZD';
$app_secret = 'e0c0de1dc81ffb9322327240506dcefd';
$ad_account_id = 'act_394401308197267';
$audience_name = 'cau hinh 30 ngay';
$audience_retention_days = '30';
$pixel_id = '278547359909492';
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
);
$campaign = (new AdAccount($ad_account_id))->createCampaign(
  $fields,
  $params
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
  $fields,
  $params
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
  $fields,
  $params
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
  $fields,
  $params
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
  $fields,
  $params
);
$ad_id = $ad->id;
echo 'ad_id: ' . $ad_id . "\n\n";

$fields = array(
);
$params = array(
  'ad_format' => 'DESKTOP_FEED_STANDARD',
);
echo json_encode((new Ad($ad_id))->getPreviews(
  $fields,
  $params
)->getResponse()->getContent(), JSON_PRETTY_PRINT);

