<?php
    $today_tim = date("H:i:s");
    $today = date("Y-m-d");
    if ( isset($_POST['dat_od']) ) {
        $dat_od=$_POST['dat_od'];
    }else{
        $dat_od= date("Y-m-d", strtotime( $doday ." -1 day"));
    }
    $unix_sec_od = strtotime("$dat_od"." 00:00:00");

    if ( isset($_POST['dat_do']) ) {
        $dat_do=$_POST['dat_do'];
    }else{
        $dat_do= date("Y-m-d");
    }
    $unix_sec_do = strtotime("$dat_do"." 24:59:59");

    $con = mysqli_connect("localhost", "pituEl", "hi24biscus", "homsens");
    if (mysqli_connect_errno()){
        echo "Error: ".mysqli_connect_errno();
    } else {

        $wym=mysqli_query($con, 'SELECT dattim, temp FROM bme_temp_ave WHERE dattim>='.$unix_sec_od.' AND dattim<='.$unix_sec_do.' ORDER BY dattim;');
        $i=0;
        $dataPointsT = array();
        while ( $wym_row=mysqli_fetch_assoc($wym) ){
            $dtim=$wym_row['dattim']*1000;
            array_push($dataPointsT, array("x" => $dtim, "y" => $wym_row['temp']));
            $i++;
        }
        echo "t=$i";
        $wym=mysqli_query($con, 'SELECT dattim, pres FROM bme_pres_ave WHERE dattim>='.$unix_sec_od.' AND dattim<='.$unix_sec_do.' ORDER BY dattim;');
        $i=0;
        $dataPointsP = array();
        while ( $wym_row=mysqli_fetch_assoc($wym) ){
            $dtim=$wym_row['dattim']*1000;
            array_push($dataPointsP, array("x" => $dtim, "y" => $wym_row['pres']));
            $i++;
        }
        echo "p=$i";
        $wym=mysqli_query($con, 'SELECT dattim, humi FROM bme_humi_ave WHERE dattim>='.$unix_sec_od.' AND dattim<='.$unix_sec_do.' ORDER BY dattim;');
        $i=0;
        $dataPointsH = array();
        while ( $wym_row=mysqli_fetch_assoc($wym) ){
            $dtim=$wym_row['dattim']*1000;
            array_push($dataPointsH, array("x" => $dtim, "y" => $wym_row['humi']));
            $i++;
        }
        echo "h=$i";

        $wym=mysqli_query($con, 'SELECT dattim, ligh FROM bme_ligh_ave WHERE dattim>='.$unix_sec_od.' AND dattim<='.$unix_sec_do.' ORDER BY dattim;');
        $i=0;
        $dataPointsL= array();
        while ( $wym_row=mysqli_fetch_assoc($wym) ){
            $dtim=$wym_row['dattim']*1000;
            array_push($dataPointsL, array("x" => $dtim, "y" => $wym_row['ligh']));
            $i++;
        }
        echo "l=$i";
        unset($wym);
        mysqli_close($con);
    }
?>
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

	<script>
window.onload = function () {

var chartT = new CanvasJS.Chart("chartContainerT", {
    backgroundColor: "#101010",
	animationEnabled: true,
	title:{
        fontColor: "#aaaaaa",
		text: "Temperaturay"
	},
	axisX: {
        valueType: "dateTime",
        titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
        valueFormatString:"DD-MM-YY HH:mm",
        labelAngle: -30
	},
	axisY: {
		title: "Temperatura",
		titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
		valueFormatString: "00.0#",
		suffix: "°C",
		interval: 5,
		gridColor: "#888888",
		gridDashType: "shortDot",
		minimum: -30,
		maximum: 50
	},
	data: [{
        title: "dateTime",
        lineColor: "#ee5e32",
        markerColor: "#ee5e32",
		type: "spline",
		markerSize: 5,
		yValueFormatString: "0.0#°C",
		xValueFormatString:"DD-MM-YY HH:mm",
		xValueType: "dateTime",
		dataPoints: <?php echo json_encode($dataPointsT, JSON_NUMERIC_CHECK); ?>
	}]
});



var chartP = new CanvasJS.Chart("chartContainerP", {
    backgroundColor: "#101010",
	animationEnabled: true,
	title:{
        fontColor: "#aaaaaa",
		text: "Ciśnienie atmosferyczne"
	},
	axisX: {
        valueType: "dateTime",
        titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
        valueFormatString:"DD-MM-YY HH:mm",
        labelAngle: -30
	},
	axisY: {
		title: "cisnienie",
		titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
		valueFormatString: "0.0#",
		suffix: "hPa",
		interval: 5,
		gridColor: "#888888",
		gridDashType: "shortDot",
		minimum: 970,
		maximum: 1025
	},
	data: [{
        title: "dateTime",
        lineColor: "#FF00FF",
        markerColor: "#FF00FF",
		type: "spline",
		markerSize: 5,
		yValueFormatString: "0.0# hPa",
		xValueFormatString:"DD-MM-YY HH:mm",
		xValueType: "dateTime",
		dataPoints: <?php echo json_encode($dataPointsP, JSON_NUMERIC_CHECK); ?>
	}]
});

var chartH = new CanvasJS.Chart("chartContainerH", {
    backgroundColor: "#101010",
	animationEnabled: true,
	title:{
        fontColor: "#aaaaaa",
		text: "Wilgotność powietrza"
	},
	axisX: {
        valueType: "dateTime",
        titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
        valueFormatString:"DD-MM-YY HH:mm",
        labelAngle: -30
	},
	axisY: {
		title: "Wilgotność",
		titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
		valueFormatString: "0.0#",
		suffix: "%",
		interval: 5,
		gridColor: "#888888",
		gridDashType: "shortDot",
		minimum: 5,
		maximum: 100
	},
	data: [{
        title: "dateTime",
		type: "spline",
		lineColor: "#3095d3",
		markerColor: "#3095d3",
		markerSize: 5,
		yValueFormatString: "0.0",
		xValueFormatString:"DD-MM-YY HH:mm",
		xValueType: "dateTime",
		dataPoints: <?php echo json_encode($dataPointsH, JSON_NUMERIC_CHECK); ?>
	}]
});

var chartL = new CanvasJS.Chart("chartContainerL", {
    backgroundColor: "#101010",
	animationEnabled: true,
	title:{
        fontColor: "#aaaaaa",
		text: "Usłonecznienie "
	},
	axisX: {
        titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
        valueType: "dateTime",
        valueFormatString:"DD-MM-YY HH:mm",
        labelAngle: -30
	},
	axisY: {
        titleFontColor: "#aaaaaa",
        labelFontColor: "#aaaaaa",
		title: "Usłonecznienie",
		valueFormatString: "0.0# lux",
		suffix: "lux",
		interval: 100,
		gridColor: "#888888",
		gridDashType: "shortDot",
		minimum: 0,
		maximum: 2200
	},
	data: [{
        title: "dateTime",
		type: "spline",
		markerColor: "#FFFF00",
		lineColor: "#FFFF00",
		markerSize: 5,
		yValueFormatString: "0.0 lux",
		xValueFormatString:"DD-MM-YY HH:mm",
		xValueType: "dateTime",
		dataPoints: <?php echo json_encode($dataPointsL, JSON_NUMERIC_CHECK); ?>
	}]
});

chartT.render();
chartP.render();
chartH.render();
chartL.render();

}
</script>
</head>

<body>
<div id="main">
		<div id="toolbar">
			<a href="index.php"><div class="tyt"><i class="demo-icon icon-tencent-weibo"></i>IDR</div></a>
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

					echo '<div class="dpList">';
					echo '<h2>Historia pogody</h2>';

                    echo "Data: $today Czas: $today_tim</br>";
                    echo '<form action="" method="POST">';
					echo '	<table id="tabList">';
					echo '		<tr>';
					echo '			<td class="tdNg" width="300px">Logi dla okresu od:</td>';
					echo '          <td class="tdNg" width="250">';
					echo '             <input type="date" name="dat_od" value="' . $dat_od . '">';
					echo '          </td>';
					echo '			<td class="tdNg" width="50px">do:</td>';
					echo '          <td class="tdNg" width="250">';
					echo '             <input type="date" name="dat_do" value="' . $dat_do . '">';
					echo '          </td>';
					echo '          <td class="tdNg" width="250">';
					echo '				<input type="submit" value="Wyświetl">';
					echo '          </td>';
					echo '		</tr>';
					echo '	</table>';
					echo '</form>';
					echo '</div>';
?>
                <div class="dpList">
					<div id="chartContainerT" style="height: 370px; width: 100%;"></div>
                </div>
                <div class="dpList">
					<div id="chartContainerP" style="height: 370px; width: 100%;"></div>
                </div>
                <div class="dpList">
					<div id="chartContainerH" style="height: 370px; width: 100%;"></div>
                </div>
                <div class="dpList">
					<div id="chartContainerL" style="height: 370px; width: 100%;"></div>
                </div>

					<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		</div>
		<div class="footer">
			<?php
				echo '<div class="stPlay"><a href="idr_pomiar.php?rfs=0">STOP <i class="demo-icon icon-cancel"></i> </a> </div> <div class="stStop">Copyright Piotr Michna</div>';
			?>
			<div style="clear:both"></div>
		</div>
	</div>
</body>
</html>
