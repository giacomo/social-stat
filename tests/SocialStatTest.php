<?php
/**
 * Project      social-stat
 * @author      Giacomo Barbalinardo <info@ready24it.eu>
 * @copyright   2015
 */

namespace Giacomo\SocialStat\Tests;


use Giacomo\SocialStat\SocialStat;

class SocialStatTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFacebookStats()
    {
        $json = '{"id":"some-page-id","link":"https:\/\/www.facebook.com\/some-page-url\/","likes":201,"talking_about_count":10}';
        $response = $this->getMock('stdClass', array('getBody'));
        $response->expects($this->once())
                 ->method('getBody')
                 ->willReturn($json);

        $fbMock = $this->getMock('stdClass', array('get', 'getApp', 'getAccessToken'));
        $fbMock->expects($this->once())
               ->method('get')
               ->willReturn($response);
        $fbMock->expects($this->once())
               ->method('getApp')
               ->willReturnSelf();
        $fbMock->expects($this->once())
               ->method('getAccessToken')
               ->willReturn('some-token');

        /** @var SocialStat|\PHPUnit_Framework_MockObject_MockObject $stats */
        $stats = $this->getMock('Giacomo\SocialStat\SocialStat', array('getFacebook'));
        $stats->expects($this->once())
              ->method('getFacebook')
              ->willReturn($fbMock);

        $expected = array(
            "id"     => "some-page-id",
            "link"   => "https://www.facebook.com/some-page-url/",
            "likes"  => 201,
            "talking_about_count" => 10,
        );

        $this->assertEquals($expected, $stats->getFacebookStats());
    }

    public function testGetTwitterStats()
    {
        $json = '{"screen_name":"screen-name","followers_count":20,"friends_count":10}';

        $twitterMock = $this->getMock('\TwitterAPIExchange', array('buildOauth', 'performRequest'), array(), '', false);
        $twitterMock->expects($this->once())
                    ->method('buildOauth')
                    ->willReturnSelf();
        $twitterMock->expects($this->once())
                    ->method('performRequest')
                    ->willReturn($json);

        /** @var SocialStat|\PHPUnit_Framework_MockObject_MockObject $stats */
        $stats = $this->getMock('Giacomo\SocialStat\SocialStat', array('getTwitter'));
        $stats->expects($this->once())
              ->method('getTwitter')
              ->willReturn($twitterMock);

        $expected = array(
            "screen_name"     => "screen-name",
            "followers_count" => 20,
            "friends_count" => 10
        );

        $this->assertEquals($expected, $stats->getTwitterStats());
    }

    public function testGetInstagramStats()
    {
        $response = array(
            'user' => array(
                'following_count' => 121,
                'follower_count'  => 67
            )
        );

        $instagramMock = $this->getMock('\Instagram', array('login', 'getSelfUsernameInfo'), array(), '', false);
        $instagramMock->expects($this->once())
                      ->method('login');
        $instagramMock->expects($this->once())
                      ->method('getSelfUsernameInfo')
                      ->willReturn($response);

        /** @var SocialStat|\PHPUnit_Framework_MockObject_MockObject $stats */
        $stats = $this->getMock('Giacomo\SocialStat\SocialStat', array('getInstagram'));
        $stats->expects($this->once())
              ->method('getInstagram')
              ->willReturn($instagramMock);

        $expected = array(
            'following_count' => 121,
            'follower_count'  => 67
        );

        $this->assertEquals($expected, $stats->getInstagramStats());
    }
}
