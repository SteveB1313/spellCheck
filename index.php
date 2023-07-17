<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.dnd5eapi.co/api/spells",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$response = json_decode($response, true); //because of true, it's in an array
$count = $response["count"];
$spell = rand(0, $count);
$index = $response["results"][$spell]["index"];


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.dnd5eapi.co/api/spells/" . $index,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$response = json_decode($response, true); //because of true, it's in an array
$spellInfo = $response;



?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Welcome to Spell Check!</title>
    <style>
	#header > * {
		color: #d81921;
		text-align: center;
	}
	#header {
		background-color: #171717;
	}
	#main {
		text-align: center;
	}
    </style>
	
  </head>

  <div id="header">
    <h2>Spell Check</h2>
    <h3>The game that's kinda sweeping the nation (slowly)!</h3></br>
  </div>
  <div class="container" id="main">

    <button type="button" class="btn btn-danger" onClick="window.location.reload();">Check a new Spell</button>
<?php
if ($spellInfo["material"]) {
	echo "<h3><b>Your materials are</b>: ". $spellInfo["material"] . "</h3><br>";
} else {
	echo "<h3><b>No materials for this spell! Good luck!</b></h3><br>";
}

echo "<h4><b>Level</b>: ". $spellInfo["level"] . '</h4><br>';
echo "<h4><b>Range</b>: ". $spellInfo["range"] . '</h4><br>';
if ($spellInfo["concentration"]) {
	echo "<h4><b>Concentration</b>: True</h4><br>";
} else {
	echo "<h4><b>Concentration</b>: False</h4><br>";
}
echo "<h4><b>Components</b>: ";
foreach($spellInfo["components"] as $c) { echo $c; }
echo '</h4><br>';
echo "<h4><b>School</b>: " . $spellInfo["school"]["name"] . '</h4><br>';
echo "<h4><b>Description</b>: ". $spellInfo["desc"][0] . '</h4><br>';
echo "<h3><b>The spell is</b>: " . $spellInfo["name"] . '</h4><br>';
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</div>
</html>
