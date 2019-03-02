<?php

require 'vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));

session_start();

// print_r(CONSUMER_KEY);
// print_r(CONSUMER_SECRET);
// print_r(OAUTH_CALLBACK);

// die;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => OAUTH_CALLBACK]);

// var_dump($request_token);

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

file_put_contents('data.txt', json_encode($request_token));

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

header("Location: $url");
