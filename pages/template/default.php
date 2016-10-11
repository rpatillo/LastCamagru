
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="Camagru project | 42 school">
  <meta name="author" content="rpatillo">

  <title><?= App::getInstance()->title; ?></title>

  <!-- CSS -->
  <link rel="stylesheet" href="public/css/main.css">
  <link rel="stylesheet" href="public/css/normalize.min.css">
  <link rel="stylesheet" href="public/css/grid12.css">
</head>

<body>
<!-- HEADER -->
<div class="header-container">
  <header class="wrapper clearfix">
    <h1 class="title"><a href="index.php" style="color: white; text-decoration: none">Camagru</a></h1>
    <nav>
      <ul>
        <?PHP
        $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
        if (isset($_SESSION['auth'])) {
          echo "<li><a href=\"index.php?p=photo\">Photo</a></li>";
        }
        echo "<li><a href=\"index.php?p=gallery\">Gallery</a></li>";
        if (isset($_SESSION['auth'])) {
          echo "<li><a class=\"navbar-brand\" href=\"index.php?p=logout\" \">Logout</a></li>";
        }
        ?>
      </ul>
    </nav>
  </header>
</div>

<!-- CONTENT -->
<div class="main-container" style="margin: 0 0 163px;">
  <div class="main wrapper clearfix" style="padding-top: 100px; position: relative;">
    <?= $content; ?>
  </div>
</div>

<!-- FOOTER -->
<div class="footer-container" style="bottom: 0; position: fixed; width: 100%">
  <footer class="wrapper">
    <?php
    if (isset($_SESSION['auth'])) {
      echo "<h4 style='margin-left: 10%'>" . ucfirst($_SESSION['auth']) . "</h4>";
    }
    ?>
    <h6 style="margin-left: 90% !important;">rpatillo | 42 school</h6>
  </footer>
</div>
</body>
</html>