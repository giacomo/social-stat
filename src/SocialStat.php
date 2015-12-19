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
    protected function getFacebook()
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
        $facebook = $this->getFacebook();
        $response = $facebook->get(
            '/' . getenv('FB_PAGE_ID') . '?fields=link,likes,talking_about_count',
            $facebook->getApp()->getAccessToken()
        );

        return json_decode($response->getBody(), true);
    }

    protected function getTwitter() {
        return new \TwitterAPIExchange([
            'consumer_key' => getenv('TW_CONSUMER_KEY'),
            'consumer_secret' => getenv('TW_CONSUMER_SECRET'),
            'oauth_access_token' => getenv('TW_OAUTH_TOKEN'),
            'oauth_access_token_secret' => getenv('TW_OAUTH_SECRET')
        ]);
    }

    protected function getTrimmedTwitterResponse(\TwitterAPIExchange $twitter, array $showOnlyFields)
    {
        $url = 'https://api.twitter.com/1.1/users/show.json';
        $fields = '?screen_name=' . getenv('TW_ACCOUNT_NAME');
        $requestMethod = 'GET';

        $result = $twitter->setGetfield($fields)
                          ->buildOauth($url, $requestMethod)
                          ->performRequest(true, array(
                              CURLOPT_SSL_VERIFYPEER => false
                          ));

        $trimmedResult = [];
        foreach ($showOnlyFields as $field) {
            if (in_array($field, $jsonAsArray = json_decode($result, true))) {
                $trimmedResult[$field] =  $jsonAsArray[$field];
            }
        }

        return $trimmedResult;
    }

    public function getTwitterStats()
    {
        $twitter = $this->getTwitter();

        // Enable only some fields
        return $this->getTrimmedTwitterResponse($twitter, [
            'screen_name', 'followers_count', 'friends_count'
        ]);
    }

}