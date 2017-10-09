<?php

/*
var_dump($_POST);
// input params
array(6) {
  ["name"]=>
  string(11) "Jude Santos"
  ["email"]=>
  string(22) "jude.msantos@gmail.com"
  ["phone"]=>
  string(12) "213-505-5400"
  ["date"]=>
  string(10) "11/23/2018"
  ["tenant"]=>
  string(6) "Debrah"
  ["tenantType"]=>
  string(5) "Witch"
}
*/
function getArg($params, $key) {
  if (!isset($params[$key])) {
    return '';
  }

  $value = $params[$key];
  unset($params[$key]);

  return $value;
}

$status = 0;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!count($_POST) || !isset($_POST)) {
    $status = -1;
    $error = "Invalid Post request. Aborted.";
  }
  else
  {
    $params = $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $type = getArg($params, 'type');
    $name = getArg($params, 'name');
    $from = getArg($params, 'email');

    if (empty($name)) {
      $status = -3;
      $error = "Name is required\n";
    } else {
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $status = -4;
        $error .= "Only letters and white space allowed\n";
      }
    }

    if (empty($from)) {
      $status = -5;
      $error .= "Email is required\n";
    } else {
      // check if e-mail address is well-formed
      if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
        $status = -6;
        $error .= "Invalid email format\n";
      }
    }

    forEach($params as $key=>$val) {
      $message .= "$key: $val\n";
    }
  }
}
else {
  $status = -2;
  $error = "Request Type not supported. Aborted.";
}

if ($status == 0)
{
  $to = "jude.msantos@gmail.com, debimortola@gmail.com";
  if ($type === 'retail') {
    $subject = 'Retail';
  } else {
    $subject = 'Residential';
  }

  $subject .= " Newhall-Crossings interest from $name";
  $message = "\n\n\nRequest Details:\n\n$message";

  if (mail($to, $subject, $message, "From: $from")) {
    $error = "Thank you for your interest. We will be in touch soon.";
  } else {
    $status = -8;
    $error = 'An error occurred while trying to send email. Aborted.';
  }
}


echo json_encode(array(
  "status" => $status,
  "error" => $error
));
