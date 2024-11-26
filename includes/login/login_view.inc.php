<?php

declare(strict_types=1);

function output_username()
{
  if (isset($_SESSION["user_id"])) {
    echo "You are logged in as " . $_SESSION["user_username"];
  } else {
    echo "You are not logged in";
  }
}

function check_login_errors()
{
  if (isset($_SESSION["login_errors"])) {
    $errors = $_SESSION["login_errors"];

    echo "<br>";

    foreach ($errors as $error) {
      echo '<p class="form-error">' . $error . '</p>';
    }

    unset($_SESSION['login_errors']);
  } else if (isset($_GET['login']) && $_GET['login'] === "success") {
    echo '<br>';
    echo '<p class="form-success">Login success!</p>';
  }
}
