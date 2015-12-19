<?php
/**
 * Project      social-stat
 * @author      Giacomo Barbalinardo <info@ready24it.eu>
 * @copyright   2015
 */

namespace Giacomo\SocialStat;


use Facebook\Facebook;

class SocialStat
{
    public function getFacebook()
    {
        return new Facebook([
            'app_id' => getenv('FB_APP_ID'),
            'app_secret' => getenv('FB_APP_SECRET')
        ]);
    }

    /**
     * Get Facebook properties from the Graph-API
     *
     * @return array
     */
    public function getFacebookStats()
    {
        $fb = $this->getFacebook();
        $response = $fb->get(
            '/' . getenv('FB_PAGE_ID') . '?fields=link,likes,talking_about_count',
            $fb->getApp()->getAccessToken()
        );

        return json_decode($response->getBody(), true);
    }


}