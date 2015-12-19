<?php
/**
 * Project      social-stat
 * @author      Giacomo Barbalinardo <info@ready24it.eu>
 * @copyright   2015
 */

use Giacomo\SocialStat\SocialStat;

require '../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/../'));
$dotenv->load();


$stats = new SocialStat();

/**
 * FacebookStats
 *
 * array {
 *     "id"     => "some-page-id",
 *     "link"   => "https://www.facebook.com/some-page-url/",
 *     "likes"  => 201,
 *     "talking_about_count" => 10,
 * }
 */
//var_dump($stats->getFacebookStats());


var_dump($stats->getTwitterStats());