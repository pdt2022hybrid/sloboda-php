<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            margin-left: 40%;
        }
        .data {
            justify-content: left;
        }
    </style>
</head>
<body>

    <h1 style="margin-left: 8%;">Príchody</h1>
    <form name="form" method="post" action="">
        <!--<label for="nameInput">Name:</label>-->
        <input type="text" name="nameInput" id="nameInput" value="Jozko">
        <!--<label for="dateInput">Arrival:</label>-->
        <input type="text" name="dateInput" id="dateInput" value="19.11.2022 7:53:00">
        <input type="button" name="addInput" id="addInput" value="Add">
    </form><br><br>
    <?php echo $_POST["nameInput"]; ?>
    <table>
        <tr>
            <?php
            foreach ($data->content->ths as $th) {
                ?>
                <th> <?= $th ?></th>
                <?php
            }
            ?>
        </tr>

    
<?php

    date_default_timezone_set("Europe/Bratislava");
    $filename = "prichody.json";
    $file = fopen($filename, "w+") or die("Unable to open file!");
    $date = date("d.m.Y H:i:s");
    $name = "Jozko";
    $prichody = [getArray($name, $date), getArray("Ferko", date("d.m.Y 7:53:26")), getArray("Jozko2", date("17.11.2022 8:05:54"))];
    fwrite($file, json_encode($prichody));
    $json_data = file_get_contents($filename);
    $data = json_decode($json_data);
    $content = "<table>";
    $unixTime = strtotime($data[0][1]);
    display($data);
    //echo $data[0]." - ".$data[1];
    //echo date("d.m.Y H:i:s", strtotime($data[1]))."  ";
    //echo getDelay("$data[1]");
    //add();
    fclose($file);

    function add($name, $date) {
        $prichody[count($prichody)] = [$name, $date, getDelay($date)];
    }

    function resetFile() {
        $prichody = [getArray($name, $date)];
    }

    function display($data) {
        $temp = "<span class='data'>";
        for ($i = 0; $i < count($data); $i++) {
            for($j = 0; $j < count($data[$i]); $j++) {
                $temp = $temp . $data[$i][$j]."  ";
            }
            $temp = $temp . "<br>";
        }
        echo $temp . "</span>";
    }

    function getDelay($date) {
        $unixTime = strtotime($date);
        if(date('H', $unixTime) >= 8) {
            if(date('H', $unixTime) > 20) return "<span style='color:Red;'><b> Invalid Time!</b></span>";
            return "<span style='color:Tomato;'> Delay: " . date("H:i:s", $unixTime - strtotime(date('d.m.Y 9:00:00', $unixTime))) . "</span>"; //time - 8h
        } else return "";
    }

    function getArray($name, $date) { return [$name, $date, getDelay($date)]; }

?>

</body>
</html>