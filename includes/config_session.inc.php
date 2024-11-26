<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
  'lifetime' => 1800,
  'domain' => '',
  'path' => '/',
  'secure' => false,
  'httponly' => true
]);

session_start();

if (isset($_SESSION["user_id"])) {
  if (!isset($_SESSION["last_regeneration"])) {
    regenerate_session_loggedIn();
  } else {
    $interval = 60 * 30;
    if (time() - $_SESSION["last_regeneration"] >= $interval) {
      regenerate_session_loggedIn();
    }
  }
} else {
  if (!isset($_SESSION["last_regeneration"])) {
    regenerate_session();
  } else {
    $interval = 60 * 30;
    if (time() - $_SESSION["last_regeneration"] >= $interval) {
      regenerate_session();
    }
  }
}

function regenerate_session_loggedIn()
{

  $userId = $_SESSION["user_id"];
  $username = $_SESSION["user_username"];
  session_regenerate_id(true);
  $newSessionId = session_create_id();
  $sessionId = $newSessionId . "_" . $userId;
  session_id($sessionId);
  $_SESSION["user_id"] = $userId;
  $_SESSION["user_username"] = $username;
  $_SESSION["last_regeneration"] = time();
}

function regenerate_session()
{
  session_regenerate_id(true);
  $_SESSION["last_regeneration"] = time();
}
