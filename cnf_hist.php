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
				$con = mysqli_connect("localhost", "/**/user", "password", "homhist");

				if (mysqli_connect_errno())
				{
					echo "Error: ".mysqli_connect_errno();

				}
				else
				{
					echo '<div class="dpList">';
					echo '<h2>Historia systemu</h2>';
					$today_tim = date("H:i:s");
                    $today = date("Y-m-d");
                    if ( isset($_POST['dat_od']) ) {
                        $dat_od=$_POST['dat_od'];
                    }else{
                        $dat_od= date("Y-m-d", strtotime( $doday ." -1 day"));
                    }

                    if ( isset($_POST['dat_do']) ) {
                        $dat_do=$_POST['dat_do'];
                    }else{
                        $dat_do= date("Y-m-d");
                    }
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

					$datt=$dat_do;
					while ($datt>=$dat_od){
                        $wym=mysqli_query($con, 'SELECT * FROM syst WHERE dat="' . $datt . '" ORDER BY dat, tim;');
                        if (mysqli_num_rows($wym)>0) {
                            echo '<div class="dpList">';
                            echo '<h2>' . $datt . '</h2>';
                            echo '	<table id="tabList">';
                            echo '		<tr>';
                            echo '			<td class="tdNg" width="80">ID</td><td class="tdNg" width="120">Czas</td><td class="tdNg" width="800">Opis</td>';
                            echo '		</tr>';
                            $i=0;
                            while ( $wym_row=mysqli_fetch_assoc($wym) ){
                                if($i%2==0) $styl="tdLia"; else $styl="tdLib";
                                echo '		<tr>';
                                echo '			<td class="' . $styl . '">'. $wym_row['id']. '</td>';
                                echo '			<td class="' . $styl . '">'. $wym_row['tim']. '</td>';
                                echo '			<td class="' . $styl . '">'. $wym_row['opis']. '</td>';
                                echo '		<tr>';
                                $i++;
                            }
                            echo '	</table>';
                            echo '</div>';
                        }else{
                            echo '<div class="dpList">';
                            echo '<h2>' . $datt . '</h2>';
                            echo '</div>';
                        }
                        $datt=date("Y-m-d", strtotime( $datt ." -1 day"));
					}

					unset($wym);
					mysqli_close($con);
				}
			?>
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
