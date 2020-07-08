<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>IDR - logowanie</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/green.ico" />

    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link rel="stylesheet" href="style_form.css" type="text/css"/>
    <link rel="stylesheet" href="css/fontello.css" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

</head>

<body>
    <div id="main">
        <div id="toolbar">
            <a href="index.php"><div class="tyt"><i class="demo-icon icon-tencent-weibo"></i>JAS</div></a>
            <div class="nav">
                <?php
                    require_once "menu.php";
                ?>
            </div>
            <div style="clear:both"></div>
        </div>
<div id="pgst">
        </br>
    <?php

        //require_once "connect.php";
        $con = mysqli_connect("localhost", "user", "password", "homster");
        if (mysqli_connect_errno()){
            echo "Error: ".mysqli_connect_errno();
        }else {
            $conw = mysqli_connect("localhost", "user", "password", "homsweather");
            if( isset($_POST['tmax']) ) {
                mysqli_query($conw, 'UPDATE cnf SET valu=' . $_POST['tmax'] . ' WHERE comm="temp_max"' );
            }
            if( isset($_POST['tmin']) ) {
                mysqli_query($conw, 'UPDATE cnf SET valu=' . $_POST['tmin'] . ' WHERE comm="temp_min"' );
            }
            if( isset($_POST['hmax']) ) {
                mysqli_query($conw, 'UPDATE cnf SET valu=' . $_POST['hmax'] . ' WHERE comm="humi_max"' );
            }
            if( isset($_POST['hmin']) ) {
                mysqli_query($conw, 'UPDATE cnf SET valu=' . $_POST['hmin'] . ' WHERE comm="humi_min"' );
            }
            if( isset($_POST['min_delay']) ) {
                mysqli_query($conw, 'UPDATE cnf SET valu=' . $_POST['min_delay'] . ' WHERE comm="min_delay"' );
            }
            echo '<div class="dpList">'. "\n";
            $wym=mysqli_query($conw, 'SELECT * FROM bme ORDER BY id;');
            while ( $wym_row=mysqli_fetch_assoc($wym) ){
                if($wym_row['para']=="temp"){
                    $temper=$wym_row['valu'];
                } else{
                    if($wym_row['para']=="humi"){
                        $humir=$wym_row['valu'];
                    }
                }
            }
            $wym=mysqli_query($conw, 'SELECT comm, valu FROM cnf ORDER BY id;');
            $i=0;
            while ( $wym_row=mysqli_fetch_assoc($wym) ){
                switch($wym_row['comm']){
                case "temp_max":
                    $temp_max=$wym_row['valu'];
                    break;
                case "temp_min":
                    $temp_min=$wym_row['valu'];
                    break;
                case "humi_max":
                    $humi_max=$wym_row['valu'];
                    break;
                case "humi_min":
                    $humi_min=$wym_row['valu'];
                    break;
                case "min_delay":
                    $min_delay=$wym_row['valu'];
                    break;
                }
            }
            #lewa
            echo '  <div class="mCol">' . "\n";
            echo '      <div class="cafelT">Tęperatura: '. $temper . '&deg;C</div>'. "\n";
            echo '  </div>'. "\n";
            #prawa
            echo '  <div class="mCor">'. "\n";
            echo '      <div class="cafel"><a href="?tmin=1">Min: '. $temp_min . '&deg;C</a></div>'. "\n";
            echo '      <div class="cafer"><a href="?tmax=1">Max: '. $temp_max . '&deg;C</a></div>'. "\n";
            echo '      <div style="clear:both"></div>'. "\n";
            echo '  </div>'. "\n";

            echo '<div class="cafForm">' . "\n";
            if ( isset($_GET['tmax']) || isset($_GET['tmin']) ){
                if( isset($_GET['tmax']) ){
                    $et="Max:". "\n";
                    $styl="cafer". "\n";
                    $nam="tmax";
                    $val=$temp_max;
                }else{
                    $nam="tmin";
                    $et="Min:". "\n";
                    $styl="cafel". "\n";
                    $val=$temp_min;
                }
            #formularz
                echo '		<div class="' . $styl .'">'. "\n";
                echo '      <form action="us_param.php" method="POST">' . "\n";
                echo            $et . "\n";
                echo '          <input type="number" name="' . $nam .'" value="' . $val . '">' . "\n";
                echo '          <input type="submit" value="Zmień">' . "\n";
                echo "      </form>\n";
                echo '     </div>'. "\n";
                echo   '    <div style="clear:both"></div>'. "\n";
            }
            echo '</div>'. "\n";
            # ---- WILGOTNOSC
            echo '  <div class="mCol">' . "\n";
            echo '      <div class="cafelH">Wilgotność: '. $humir . '%</div>'. "\n";
            echo '  </div>'. "\n";
            #prawa
            echo '  <div class="mCor">'. "\n";
            echo '      <div class="cafel"><a href="?hmin=1">Min: '. $humi_min . '%</a></div>'. "\n";
            echo '      <div class="cafer"><a href="?hmax=1">Max: '. $humi_max . '%</a></div>'. "\n";
            echo '      <div style="clear:both"></div>'. "\n";
            echo '  </div>'. "\n";

            echo '<div class="cafForm">' . "\n";
            if ( isset($_GET['hmax']) || isset($_GET['hmin']) ){
                if( isset($_GET['hmax']) ){
                    $et="Max:". "\n";
                    $styl="cafer". "\n";
                    $nam="hmax";
                    $val=$humi_max;
                }else{
                    $nam="hmin";
                    $et="Min:". "\n";
                    $styl="cafel". "\n";
                    $val=$humi_min;
                }
            #formularz
                echo '		<div class="' . $styl .'">'. "\n";
                echo '      <form action="us_param.php" method="POST">' . "\n";
                echo            $et . "\n";
                echo '          <input type="number" name="' . $nam .'" value="' . $val . '">' . "\n";
                echo '          <input type="submit" value="Zmień">' . "\n";
                echo "      </form>\n";
                echo '     </div>'. "\n";
                echo   '    <div style="clear:both"></div>'. "\n";
            }
            echo '</div>'. "\n";
            # ---- MIN_DELAY
            echo '  <div class="mCol">' . "\n";
            echo '      <div class="cafelX">Czas [s]</br>pomiarów:</div>'. "\n";
            echo '  </div>'. "\n";
            #prawa
            echo '  <div class="mCor">'. "\n";
            echo '      <div class="cafex"><a href="?min_delay=1">'. $min_delay . 's</a></div>'. "\n";
            echo '      <div style="clear:both"></div>'. "\n";
            echo '  </div>'. "\n";

            echo '<div class="cafForm">' . "\n";
            if ( isset($_GET['min_delay']) ){
            #formularz
                echo '		<div class="cafex">'. "\n";
                echo '      <form action="us_param.php" method="POST">' . "\n";
                echo           "Sekund:\n";
                echo '          <input type="number" name="min_delay" value="' . $min_delay . '">' . "\n";

                echo '          <input type="submit" value="Zmień">' . "\n";
                echo "      </form>\n";
                echo '     </div>'. "\n";
                echo   '    <div style="clear:both"></div>'. "\n";
            }
            echo '</div>'. "\n";
            unset($wym);
            mysqli_close($con);
        }
    ?>
        </div>
        <div class="footer">
            <?php
                echo '<div class="stPlay">2020</div> <div class="stStop">Copyright Piotr Michna</div>';
            ?>
            <div style="clear:both"></div>
        </div>
    </div>
</body>
</html>
