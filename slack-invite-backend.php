<?php
include "constants.php";
require __DIR__ . '/vendor/autoload.php';
$recaptcha = new \ReCaptcha\ReCaptcha(SECRET, new \ReCaptcha\RequestMethod\CurlPost());

$email              = $_POST['email'];
$gRecaptchaResponse = $_POST['g-recaptcha-response'];
$remoteIp           = $_SERVER['REMOTE_ADDR'];

$out       = [];
$out["ok"] = false;

$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

if ($resp->isSuccess()) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $out["message"] = "Invalid Email";
    } else {
        $slackInviteUrl = 'https://' . SUBDOMAIN . '.slack.com/api/users.admin.invite?t=' . time();

        // add fileds
        $fields .= "email=" . urlencode($email) . "&";
        $fields .= "token=" . TOKEN . "&";
        $fields .= "set_active=true&";
        $fields .= "_attempts=1";

        // open connection
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $slackInviteUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        // send the request to Slack
        $reply = json_decode(curl_exec($ch), true);
        curl_close($ch);

        // output
        if ($reply['ok'] == false) {
            // error sending invite
            if ($reply['error'] == "already_in_team") {
                $out["message"] = "You have already joined this Slack!";
            } elseif ($reply['error'] == "already_invited") {
                $out["message"] = "Your invite has already been sent!";
            } else {
                $out["message"] = "Error Code: " . $reply['error'];
            }
        } else {
            // invitation was sent sucessfully
            $out["message"] = "Invitation sent!";
            $out["ok"]      = true;
        }
    }
    //send JSON response back
    echo(json_encode($out, JSON_PRETTY_PRINT));
} else {
    $out["message"] = "ReCAPTCHA Error. Refresh and try again!";
    echo(json_encode($out, JSON_PRETTY_PRINT));
}