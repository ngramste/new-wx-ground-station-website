<html>
  <head>
    <title>Weather Station</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/w3.css">
    <link rel="stylesheet" href="./css/w3-theme-dark-grey.css">
    <link rel="stylesheet" href="./css/main.css">
    <script src="main.js"></script>
  </head>
  <body class="w3-theme-d4">
    <div class="w3-container">
      <?php
        $config = json_decode(file_get_contents("./config.json"));
      ?>

      <h1 class="w3-left-align w3-monospace w3-text-orange">Weather Station: <?php echo $config->stationName; ?></h1>
      <h2 class="w3-left-align w3-monospace" id="location"><?php echo $config->location->lat . ", " . $config->location->lon; ?></h2>

      <?php
        $files = preg_grep('/^([^.])/', scandir("./audio", SCANDIR_SORT_DESCENDING));

        $renamed = [];
        for ($i = 0; $i < sizeof($files); $i++) {
          array_push($renamed, explode("-", $files[$i])[1] . explode("-", $files[$i])[2] . "_" . $files[$i]);
        }
        rsort($renamed);

        $files = [];
        for ($i = 0; $i < sizeof($renamed); $i++) {
          array_push($files, explode("_", $renamed[$i])[1]);
        }

        if (0 < isset($_GET["file"])) {
          $current = $_GET["file"];
        } else {
          $current = $files[0];
        }

        $sat = explode("-", $current)[0];
        $timestamp = date ("F d, Y H:i:s", filemtime("./audio/" . $current));
        $fileBaseName = explode(".", $current)[0];

        echo "<h4 class='w3-monospace' >$sat: " . $timestamp . "</h4>";
      ?>

      <div class="w3-bar w3-black">
        <button class="w3-bar-item w3-button tablink w3-orange" onclick="openImg(event,'MCIR')">MCIR</button>
        <button class="w3-bar-item w3-button tablink" onclick="openImg(event,'MSA')">MSA</button>
        <button class="w3-bar-item w3-button tablink" onclick="openImg(event,'NO')">NO</button>
        <button class="w3-bar-item w3-button tablink" onclick="openImg(event,'THERM')">THERM</button>
        <button class="w3-bar-item w3-button tablink" onclick="openImg(event,'ZA')">ZA</button>
        <button class="w3-bar-item w3-button tablink" onclick='updateCalendar(event, 0, 0, <?php echo json_encode($files); ?>)'>Archive</button>
        <button class="w3-bar-item w3-button tablink"><a href="/" style="text-decoration: none;">Latest</a></button>
      </div>

      <div id="MCIR" class="map w3-container w3-border w3-border-black">
        <img class="w3-image" style="width:100%" src="./images/<?php echo $fileBaseName; ?>-MCIR.png">
      </div>

      <div id="MSA" class="map w3-container w3-border w3-border-black" style="display:none">
        <img class="w3-image" style="width:100%" src="./images/<?php echo $fileBaseName; ?>-MSA.png">
      </div>

      <div id="NO" class="map w3-container w3-border w3-border-black" style="display:none">
        <img class="w3-image" style="width:100%" src="./images/<?php echo $fileBaseName; ?>-NO.png">
      </div>

      <div id="THERM" class="map w3-container w3-border w3-border-black" style="display:none">
        <img class="w3-image" style="width:100%" src="./images/<?php echo $fileBaseName; ?>-THERM.png">
      </div>

      <div id="ZA" class="map w3-container w3-border w3-border-black" style="display:none">
        <img class="w3-image" style="width:100%" src="./images/<?php echo $fileBaseName; ?>-ZA.png">
      </div>

      <div id="Archive" class="map w3-border w3-border-black w3-theme" style="display:none;">
        <div id="calendar">

        </div>

        <div id="archiveListing">
          <?php
            $currentID = "";
            for ($i = 0; $i < sizeof($files); $i++) {
              $newID = substr($files[$i], 7, 8);
              if ($newID != $currentID) {
                if ($currentID != "") {
                  echo "</ul>";
                  echo "</div>";
                }
                $currentID = $newID;
                echo "<div id=\"$newID\" class=\"imageList w3-container w3-border w3-border-black\" style=\"display:none\">";
                echo "<ul>";

                $sat = explode("-", $files[$i])[0];
                $timestamp = date ("F d, Y H:i:s", filemtime("./audio/" . $files[$i]));

                echo "<a href='?file=$files[$i]'><li>$sat: $timestamp</li></a>";

              } else {
                echo "<a href='?file=$files[$i]'><li>$sat: $timestamp</li></a>";
              }
            }
            echo "</ul>";
            echo "</div>";
          ?>
        </div>

      </div>

    </div>
    <div style="padding-bottom: 100px;"></div>
  </body>
</html>
