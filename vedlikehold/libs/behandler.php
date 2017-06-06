<?php
function visBehandler() {
  include("db.php");
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppe, bildenr FROM behandler";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>". $row['brukernavn'] ."</td>";
      echo "<td>". $row['behandlernavn'] ."</td>";
      echo "<td>". $row['yrkesgruppe'] ."</td>";
      echo "<td>". $row['bildenr'] ."</td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". $row['brukernavn'] ." />\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". $row['brukernavn'] ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>";
    }
  } else {
    echo "<tr><td>Ingen behandlere funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["regbrukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["regnavn"]);
  $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppe"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["velgBildenr"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppe) && !empty($bildenr)) {
    // Sett inn i databasen
    $sql = "INSERT INTO behandler (brukernavn, behandlernavn, yrkesgruppe, bildenr)
    VALUES ('$brukernavn', '$navn', '$yrkesgruppe', '$bildenr')";

    if(mysqli_query($conn, $sql)) {
      echo "$navn registrert i behandler databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function velgBehandler() {
  include("db.php");
  if(isset($_POST["velgBehandler"])) {
    $brukernavn = mysqli_real_escape_string($conn, $_POST["velgBehandler"]);
  }
  else if(isset($_POST["edit_id"])) {
    $brukernavn = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  $sql = "SELECT * FROM behandler WHERE brukernavn='$brukernavn'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  // Validering; onsubmit="return validerRegistrerBehandlerdata()"
  echo "<form method=\"post\" name=\"updatebehandler\" action=". $_SERVER['PHP_SELF'] .">\n";
  echo "<label>Brukernavn</label><input type=\"text\" name=\"brukernavn\" value='" . $row['brukernavn'] . "' readonly required /><br/>\n";
  echo "<label>Navn</label><input type=\"text\" name=\"navn\" value='" . $row['behandlernavn'] . "' required /><br/>\n";
  echo "<label>Yrkesgruppe</label><select name=\"yrkesgruppe\">";
  $sql2 = "SELECT yrkesgruppe FROM yrkesgruppe";
  $result2 = mysqli_query($conn, $sql2);

  if(mysqli_num_rows($result2) > 0) {
    while($row2 = mysqli_fetch_assoc($result2)) {
      if($row2['yrkesgruppe'] === $row['yrkesgruppe']) {
        echo "<option value=". $row2['yrkesgruppe'] ." selected=\"selected\">". $row2['yrkesgruppe'] ."</option>\n";
      } else {
        echo "<option value=". $row2['yrkesgruppe'] .">". $row2['yrkesgruppe'] ."</option>\n";
      }
    }
  } else {
    echo "<option value=\"NULL\">Ingen yrkesgruppe funnet</option>\n";
  }
  echo "</select><br/>\n";
  echo "<label>Bildenr</label><select name='bildenr'>";
  $sql3 = "SELECT bildenr FROM bilde";
  $result3 = mysqli_query($conn, $sql3);

  if(mysqli_num_rows($result3) > 0) {
    while($row3 = mysqli_fetch_assoc($result3)) {
      if($row3['bildenr'] === $row['bildenr']) {
        echo "<option value=". $row3['bildenr'] ." selected=\"selected\">". $row3['bildenr'] ."</option>\n";
      } else {
        echo "<option value=". $row3['bildenr'] .">". $row3['bildenr'] ."</option>\n";
      }
    }
  } else {
    echo "<option value=\"NULL\">Ingen bildenr funnet</option>\n";
  }
  echo "</select><br />\n";
  echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBehandler\"><br/><br/>\n";
  echo "</form>\n";
  echo "</p>";
  mysqli_close($conn);
}

function endreBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["brukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["navn"]);
  $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["yrkesgruppe"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["bildenr"]);
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppe) && !empty($bildenr)) {
    $sql = "UPDATE behandler SET behandlernavn='$navn', yrkesgruppe='$yrkesgruppe', bildenr='$bildenr' WHERE brukernavn='$brukernavn'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettBehandler() {
  include("db.php");
  if(isset($_POST["velgBehandlerSlett"])) {
    $brukernavn = mysqli_real_escape_string($conn, $_POST["velgBehandlerSlett"]);
  }
  else if(isset($_POST["delete_id"])) {
    $brukernavn = mysqli_real_escape_string($conn, $_POST["delete_id"]);
  }
  /* Kan ikke slette om lege har booket time med pasient?
  $sql = "SELECT bildenr FROM behandler WHERE brukernavn='$behandler'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Kan ikke slette behandler når bilde er valgt.<br />";
  } else {
  */
  if(!empty($brukernavn)) {
    $sql = "DELETE FROM behandler WHERE brukernavn='$brukernavn'";

    if (mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    }
    else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
  //}
}
?>