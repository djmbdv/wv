<?php
include "con.php";
require_once  "auth.php";
require_once "admin_actions.php";
  if(!is_login()){
    header('location: login.php');
    die();
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Work Counter</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/custom.css?43">
  <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">WC</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="nav-link" href="">Workers</a>
      </nav>
      <a class="btn btn-outline-primary" href="logout.php">Logout</a>
</div>
<div class="container py-5">
  <div class="col-lg-12 mx-auto mb-5  text-center">
      <h1 class="display-4">Work Counter</h1>
      </p>
  </div>
  <div class="row container">
    <div class="col-md-6">

    <div class="col-md-6">
    </div>
  </div>
</div>
</body>
</html>