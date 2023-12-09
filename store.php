<?php
session_start();
require_once('db/conn.php');
require_once('helpers/verification.php');
require_once('helpers/mail.php');
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if ($_POST['password'] === $_POST['cpassword']) {

    // Get the form data
    $email = htmlspecialchars($_POST['email']);
    $password = md5($_POST['password']);
    $captcha = $_POST['captcha'];
    $fullname = htmlspecialchars($_POST['fullname']);
    // Check if the captcha code is correct
    if ($captcha != $_SESSION['captcha']) {
      $_SESSION['error'] = 'Incorrect captcha code';
      header("Location: index.php", true, 302);
      exit();
    } else {
      // Check if the email already exists in the database
      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        // If the email already exists, redirect with an error message
        $_SESSION['error'] = 'An account with the same email already exists.';
        header("Location: index.php", true, 302);
        exit();
      } else {
        $verificationCode = generateVerificationCode();
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, pass, verification_code) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $email, $password, $verificationCode);

        // execute the SQL query
        if ($stmt->execute()) {
          $_SESSION['success'] = 'User created successfully!';
          sendVerificationEmail($email, $verificationCode);
          header("Location: index.php", true, 302);
          exit();
        } else {
          $_SESSION['error'] = 'Error creating user:' . $conn->error;
          header("Location: index.php", true, 302);
          exit();
        }
      }
    }
  } else {
    $_SESSION['error'] = 'Both password did not match.';
    header("Location: index.php", true, 302);
    exit();
  }
} else {
  header("Location: index.php", true, 302);
  session_abort();
  exit();
}
?>