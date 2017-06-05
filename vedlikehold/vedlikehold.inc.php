  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#vis">Registrer bruker</a></li>
    <li><a data-toggle="tab" href="#endre">Endre passord</a></li>
  </ul>

  <div class="tab-content">
    <div id="vis" class="tab-pane fade in active">
      <h3>
        Registrer bruker
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer ny administrator bruker"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="regbruker" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Brukernavn</label><input type="text" name="brukernavn" required /><br />
        <label>Passord</label><input type="password" name="passord" required /><br />
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegBruker"><br /><br />
      </form>
      </p>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre passord
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre passord på din nåværende bruker"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="endrepassord" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Passord</label><input type="password" name="endrepassord" required /><br />
        <label>&nbsp;</label><input class="btn btn-primary" type="submit" value="Endre" name="submitEndrePassord"><br /><br />
      </form>
      </p>
    </div>
  </div>

<?php
include("libs/bruker.php");
if(isset($_POST["submitRegBruker"])) {
  registrerBruker();
}
if(isset($_POST["submitEndrePassord"])) {
  endrePassord();
}
?>