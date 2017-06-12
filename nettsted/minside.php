<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Min side | Bjarum Medical</title>

  <link rel="icon" href="images/favicon.ico">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

<?php include("libs/menu.php"); ?>
<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Bjarum Medical</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><span class="glyphicon glyphmenuadjust glyphicon-home"></span><a href="index.php">Hjem</a></li>
        <li class="active"><span class="glyphicon glyphmenuadjust glyphicon-calendar"></span><a href="timebestilling.php">Bestill time</a></li>
        <li class="dropdown">
          <span class="glyphicon glyphmenuadjust glyphicon-user"></span>
          <a href="ansatte.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ansatte<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php populateMenu(); ?>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><span class="glyphicon glyphmenuadjust glyphicon-cog"></span><a href="minside.php">Min side</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php
include("libs/listeboks.php");
include("libs/minside.php");
?>
<!-- Jumbotron -->
<div class="jumbotron-minside">
  <div class="container bg-jumbo">
    <h1>Min side</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="form-group">
        <label>Personnr</label><input type="text" class="form-control" name="personnr" required />
        <label>Passord</label><input type="text" class="form-control" name="passord" required />
      </div>
      <a class="btn btn-primary btn-lg" type="submit" name="submitLogin" role="button"><strong>Logg inn &raquo;</strong></a>
    </form>
    <p>Har du ikke brukerkonto? Registrer deg <a href="#registrer" onclick="ajaxMinsideRegistrering()">her</a></p>
  </div>
</div>
<?php
if(isset($_POST["submitLogin"])) {
  include("libs/db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["personnr"]);
  $passord = mysqli_real_escape_string($conn, $_POST["passord"]);
  if(!sjekkLogin($personnr, $passord)) {
    echo "Feil brukernavn eller passord.";
  } else {
    $_SESSION["personnr"] = $personnr;
    echo "<meta http-equiv=\"refresh\" content=\"0;url=minside.php\">";
  }
  mysqli_close($conn);
}
?>
<!-- Columns -->
<div class="cover-bottom">
  <div class="container">
    <div class="bg-bottom">
      <div class="row">
        <div class="col-md-12" id="ajax">
          <h2>Bestill time</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/ajax.js"></script>

</body>
</html>