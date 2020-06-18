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
				$con = mysqli_connect("localhost", "pituEl", "hi24biscus", "homster");

				if (mysqli_connect_errno())
				{
					echo "Error: ".mysqli_connect_errno();

				}
				else
				{
					$conw = mysqli_connect("localhost", "pituEl", "hi24biscus", "homsweather");
					echo '<div class="dpList">';

					$wym=mysqli_query($conw, 'SELECT * FROM bme ORDER BY id;');
					$i=0;
					while ( $wym_row=mysqli_fetch_assoc($wym) ){
							if($wym_row['para']=="temp"){
								$temper=$wym_row['valu'];
							}else{
								if($wym_row['para']=="press"){
									$press=$wym_row['valu'];
								}else{
									$humi=$wym_row['valu'];
								}
							}
					}
#lewa
					echo '	<div class="mCol">';
					echo '		<div class="cafelT">Tęperatura: '. $temper . '&deg;C</div>';
					echo '		<div class="cafelH">Wilgotność:  '. $humi . '%</div>';
					echo '		<div class="cafelP">Ciśnienie: '. $press . 'hPa</div>';
					echo '	</div>';
#prawa
					echo '	<div class="mCol">';
					echo ' 	</div>';
					echo ' 	<div style="clear:both"></div>';
					echo '</div>';
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
