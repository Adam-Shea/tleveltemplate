<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST["username"];
  $pwd = $_POST["pwd"];

  echo $username;

  try {
    require_once 'dbh.inc.php';
    require_once 'login/login_model.inc.php';
    require_once 'login/login_contr.inc.php';

    $errors = [];

    if (is_input_empty($username, $pwd)) {
      $errors["empty_input"] = "Fill in all fields!";
      header("Location: ../index.php?login=error1");
    }

    $result = get_user($pdo, $username);

    if (is_username_wrong($result)) {
      $errors["login_incorrect"] = "Incorrect login info!";
      header('Location: ../index.php?login=error2');
    }
    if (!is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])) {
      $errors["login_incorrect"] = "Incorrect login info!";
      header('Location: ../index.php?login=error3');
    }

    require_once 'config_session.inc.php';


    if (count($errors) > 0) {
      $_SESSION["login_errors"] = $errors;


      header('Location: ../index.php?login=error4');
      die();
    }

    $newSessionId = session_create_id();

    $sessionId = $newSessionId . "_" . $result["id"];
    session_id($sessionId);

    $_SESSION["user_id"] = $result["id"];
    $_SESSION["user_username"] = htmlspecialchars($result["username"]);
    $_SESSION["last_regeneration"] = time();

    header('Location: ../index.php?login=success&' . $result["username"] . "&" . $result["id"]);
    $pdo = null;
    $stmt = null;
    die();
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
} else {
  header("Location: ../index.php?login=error5");
  die();
}
