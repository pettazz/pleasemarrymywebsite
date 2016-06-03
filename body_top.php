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
      .clickable:hover{
        cursor: pointer;
        background-color: #eee;
      }
      .jumbotron .img-responsive{
        width: 100%;
      }
      .team-link.media{
        padding: 10px;
      }
      .team-link .media-body h4{
        margin: 0px;
      }
      .team-link .media-body h1{
        margin: 0px;
      }
      ul#boys{
        list-style-type: none;
      }
      li.boy{
        background-color: #d9edf7;
        width: 140px;
        height: 270px;
        margin: 5px;
        padding: 15px;
        float: left;
        text-align: center;
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