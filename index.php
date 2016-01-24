<?php
  $db = mysqli_connect('localhost','root','password','virunee');
  if (!$db) {
    die("Unable to connect to database: ".mysqli_connect_error());
  }
 ?>

 <html>
    <head><title>Accessing mySQL Databases</title></head>

    <body>
      <h1>Accessing mySQL Databases</h1>

      <?php

if ($_POST['_handle_']) {
  handleForm();
} else {
  printForm("","","","");
}

function handleForm() {
  global $db;

  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $email=$_POST['email'];
  $role=$_POST['role'];

  $f = $s = $e = $r = "";

  if ($_POST['save']) {
    //save one record
    $statement = "INSERT INTO users (firstname, lastname, email, type) VALUES
    ('$firstname','$lastname','$email','$role')";
        if ($result = mysqli_query($db, $statement)) {
      echo "<h3 style='color: green'>One row added to the database</h3>";
        } else {
      echo "<h3 style='color: red'>There was a problem saving your data</h3>";
        };
} elseif ($_POST['amend']) {
  //alter one record
  $statement = "UPDATE users SET firstname='$firstname', lastname='$lastname', type='$role' WHERE email='$email'";
      if ($result = mysqli_query($db, $statement)) {
    echo "<h3 style='color: green'>Database updated successfully</h3>";
      } else {
    echo "<h3 style='color: red'>There was a problem updating your data</h3>";
      }
} elseif ($_POST['delete']) {
    //delete one record
    $statement = "DELETE FROM users WHERE email='$email'";
        if ($result = mysqli_query($db, $statement)) {
      echo "<h3 style='color: green'>One row deleted from the database</h3>";
        } else {
      echo "<h3 style='color: red'>There was a problem deleting your data. Make sure that you entered the correct email address.</h3>";
        }
} elseif ($_POST['view']) {
  //view one record
  $statement="SELECT * FROM users WHERE email='$email'";
        if ($result=mysqli_query($db, $statement)) {
      echo "<h3>Your query returned</h3>";
      $data = mysqli_fetch_object($result);
      $f = $data->firstname;
      $s = $data->lastname;
      $e = $data->email;
      $r = $data->type;
        } else {
        echo "<h3 style='color: red'>There was a problem finding the row. Please check that you entered the correct email address</h3>";
        }
} else {
  //must be showall
  $statement = "SELECT * FROM users";
      if ($result = mysqli_query($db, $statement)) {
        echo "<h3>Your query returned</h3><table border='1'>";
        while ($data = mysqli_fetch_object($result)) {
          echo "<tr><td>$data->email</td><td>$data->type</td></tr>";
      }
      echo "</table>";
    }
      else {
        echo "<h3 style='color: red'>There was a problem retrieving data.</h3>";
      }
    }
printForm($f, $s, $e, $r);
}//checkForm
