<?php

/**
 * This file fetches all twitter accounts from the MegaMaker club
 * and outputs these data as json
 *
 * @author Henning Leutz (https://github.com/dehenne)
 */

// helper functions

/**
 * @param string $url
 * @return string
 */
function fetch($url)
{
    $ch      = curl_init();
    $timeout = 5;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * @param $username
 * @return string
 */
function fetchUser($username)
{
    return fetch('https://club.megamaker.co/admin/users/'.$username.'.json)');
}

/**
 * STUFF
 */

$twitterUser = [];


// get all users

$call   = 'https://club.megamaker.co/admin/users/list/active.json';
$result = fetch($call);
$users  = json_decode($result, true);


// get the profiles of each user

foreach ($users as $username) {
    $userData = fetchUser($username);
    $userData = json_decode($userData, true);

    if (!$userData) {
        continue;
    }

    if (!isset($userData['user_fields']) || !$userData['user_fields'][1]) {
        continue;
    }

    $twitterUser[] = $userData['user_fields'][1];
}

echo json_encode($twitterUser);
