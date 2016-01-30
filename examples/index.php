<?php
/**
 * Project      social-stat
 * @author      Giacomo Barbalinardo <info@ready24it.eu>
 * @copyright   2015
 */

require '../vendor/autoload.php';
use Giacomo\SocialStat\SocialStat;

$dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/../'));
$dotenv->load();


$stats = new SocialStat();

/**
 * FacebookStats
 *
 * array (
 *     "id"     => "some-page-id",
 *     "link"   => "https://www.facebook.com/some-page-url/",
 *     "likes"  => 201,
 *     "talking_about_count" => 10,
 * )
 */
//var_dump($stats->getFacebookStats());

/**
 * TwitterStats
 *
 * array(
 *      "screen_name"     => "screen-name",
 *      "followers_count" => 20,
 *      "friends_count"   => 10,
 * )
 */
//var_dump($stats->getTwitterStats());

/**
 * InstagramStats
 *
 * array (
 *      "following_count" => 41,
 *      "follower_count"] => 67,
 * )
 */
//var_dump($stats->getInstagramStats());