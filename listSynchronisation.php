<?php

/**
 * This file synchronize the twitter users from MegaMaker to a Twitter List
 *
 * @author Henning Leutz (https://github.com/dehenne)
 */

require 'vendor/autoload.php';

$settings = require 'etc/settings.php';


/**
 * get twitter username from twitter list
 */

$Twitter    = new TwitterAPIExchange($settings);
$userResult = [];

$fetchMembers = function () {
};

$fetchMembers = function ($cursor = false) use (
    $Twitter,
    $settings,
    &$fetchMembers,
    &$userResult
) {
    $username = $settings['twitter_user'];
    $list     = $settings['twitter_list'];

    $query = [
        "slug"              => $list,
        "owner_screen_name" => $username
    ];

    if ($cursor) {
        $query['cursor'] = $cursor;
    }

    try {
        $result = $Twitter->setGetfield(http_build_query($query))->buildOauth(
            'https://api.twitter.com/1.1/lists/members.json',
            'GET'
        )->performRequest();
    } catch (\Exception $Exception) {
        echo $Exception->getMessage();
        exit;
    }

    $result = json_decode($result, true);

    if (isset($result['errors'])) {
        return;
    }

    $userResult = array_merge($userResult, $result['users']);

    if (!empty($result['next_cursor'])) {
        $fetchMembers($result['next_cursor']);
    }
};

$fetchMembers();

// filter
$twitterUsers = [];

foreach ($userResult as $entry) {
    $twitterUsers[] = $entry['screen_name'];
}

// get twitter users from MegaMaker


// add newest users
