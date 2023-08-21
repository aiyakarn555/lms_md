<?php
require_once __DIR__.'/protected/vendors/google/autoload.php';
session_start();
$client = new Google_Client();
$client->setAuthConfigFile(__DIR__.'/protected/vendors/client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/lms_airasia/oauth2callback.php');
$client->addScope(array('https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/moderator','https://www.googleapis.com/auth/plus.profile.language.read','https://www.googleapis.com/auth/plus.profile.agerange.read'));
// "openid email profile https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/moderator https://www.googleapis.com/auth/plus.profile.language.read https://www.googleapis.com/auth/plus.profile.agerange.read"
if (!isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/lms_airasia/login/loginlms';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}