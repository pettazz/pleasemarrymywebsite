<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Please Marry My Rose</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
      tr.clickable:hover{
        cursor: pointer;
      }
    </style>
  </head>
  <body>

    <div class="container">

      <div class="page-header">
        <h1>Please Marry My Rose <small>please god just marry it</small></h1>
      </div>

      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="<?php echo (!isset($page) || $page == 'league')? 'active' : ''; ?>"><a href="/index.php">League</a></li>
            <li role="presentation" class="<?php echo (isset($page) && $page == 'team')? 'active' : ''; ?>"><a href="/team.php">My Team</a></li>
            <li role="presentation" class="<?php echo (isset($page) && $page == 'boys')? 'active' : ''; ?>"><a href="/boys.php">Boys</a></li>
            <li role="presentation" class="<?php echo (isset($page) && $page == 'scoring')? 'active' : ''; ?>"><a href="/scoring.php">Scoring</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">&nbsp;</h3>
      </div>