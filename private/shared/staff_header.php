<?php if (!isset($page_title)) {
  $page_title = 'User Area';
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->

  <title>CAAC</title>
  <!-- icon link -->
  <link rel="icon" href="<?php echo url_for('img/mainlogo.png" type="image/x-icon '); ?>">
  <!-- <link rel="stylesheet" href="<?php //echo url_for('css/fontawesome/all.css'); 
                                    ?>"> -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link rel="stylesheet" href="<?php echo url_for('css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo url_for('css/mdb.min.css'); ?>">
  <!-- <link rel="stylesheet" href="<?php //echo url_for('css/style.css'); 
                                    ?>" /> -->

  <!-- Bootstrap core CSS -->

  <!-- Custom styles for this template -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet"> -->
</head>

<body>
  <!-- <div class="container box-shadow"> -->
  <div>
    <!-- Navigation -->
    <style>
      html,
      body,
      header,
      .view {
        height: 100%;
      }

      @media (max-width: 740px) {

        html,
        body,
        header,
        .view {
          height: 1000px;
        }
      }

      @media (min-width: 800px) and (max-width: 850px) {

        html,
        body,
        header,
        .view {
          height: 650px;
        }
      }

      .top-nav-collapse {
        background-color: #3f51b5 !important;
      }

      .navbar:not(.top-nav-collapse) {
        background: transparent !important;
      }

      @media (max-width: 991px) {
        .navbar:not(.top-nav-collapse) {
          background: #3f51b5 !important;
        }
      }

      .rgba-gradient {
        background: linear-gradient(45deg, rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%);
      }

      .card {
        background-color: rgba(126, 123, 215, 0.2);
      }

      .md-form label {
        color: #ffffff;
      }

      h6 {
        line-height: 1.7;
      }
    </style>

    <!-- Main navigation -->
    <header>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
        <div class="container">
          <a class="navbar-brand" href="<?php echo url_for('index.php') ?>">
            <img src="<?php echo url_for('img/mainlogo.png'); ?>" alt="Mainlogo" class="img-fluid" width="40">
            <strong>CAAC</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item <?php if ($page_title == 'Home') {
                                    echo 'active';
                                  } ?>">
                <a class="nav-link" href="<?php echo url_for('index.php') ?>">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item <?php if ($page_title == 'About') {
                                    echo 'active';
                                  } ?>">
                <a class="nav-link" href="<?php echo url_for('about.php') ?>">About</a>
              </li>
            </ul>

          </div>
        </div>
      </nav>
      <!-- Navbar -->
      <!-- Full Page Intro -->