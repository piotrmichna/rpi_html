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
			<br />
			<h3>Programy</h3>
		<?php 
			
				//require_once "connect.php";
				$con = mysqli_connect("localhost", "pituEl", "hi24biscus", "homster");
				
				if (mysqli_connect_errno()){
					echo "Error: ".mysqli_connect_errno();
				}else{
					$conx = mysqli_connect("localhost", "pituEl", "hi24biscus", "homhist");
					if (mysqli_connect_errno()){
						echo "Error: ".mysqli_connect_errno();
						$hist=0;
					}else{
						$hist=1;
					}
					
					if ( isset($_POST['progad']) ){
							if($hist==1){
								$str="Dodanie programu[" . $_POST['nazwa'] . "]";
								$today_tim = date("H:i:s"); 
								$today = date("Y-m-d");
								mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
							}	
							mysqli_query($con, 'INSERT INTO prog (nazwa, opis) VALUES ("'. $_POST['nazwa'] . '", "' . $_POST['opis'] .'");');		
					}
					
					if ( isset( $_POST['progrv']) ) {
						if( is_numeric($_POST['progrv']) ) {							
							$wyn=mysqli_query($con, 'SELECT * FROM prog WHERE id='. $_POST['progrv'] . ';');	
							while( $wyn_row=mysqli_fetch_assoc($wyn) ){
								$wynt=mysqli_query($con, 'SELECT * FROM start_time WHERE progid='. $wyn_row['id'] . ';');	
								while( $wynt_row=mysqli_fetch_assoc($wynt) ){
									if($hist==1){
										$str="Usunięcie w programie[" . $wyn_row['nazwa'] . "] - startu[" . $wynt_row['nazwa'] . "]";
										$today_tim = date("H:i:s"); 
										$today = date("Y-m-d");
										mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
									}	
									mysqli_query($con, 'DELETE FROM start_time WHERE id=' . $_POST['timid']);						
								}
								if($hist==1){
									$str="Usunięcie programu[" . $wyn_row['nazwa'] . "]";
									$today_tim = date("H:i:s"); 
									$today = date("Y-m-d");
									mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
								}	
								mysqli_query($con, 'DELETE FROM prog WHERE id=' . $wyn_row['id']);
							}							
						}
					}
					
					if(isset($_POST['timid'])) {
						if( isset($_POST['en']) ){
								mysqli_query($con, 'UPDATE start_time SET en=1 WHERE id=' . $_POST['timid'] .';');
						}else{
							mysqli_query($con, 'UPDATE start_time SET en=0 WHERE id=' . $_POST['timid'] .';');
						}
						
						if( isset($_POST['rv']) ){
							mysqli_query($con, 'DELETE FROM start_time WHERE id=' . $_POST['timid']);
							if($hist==1){
								$str="Usunięcie w programie[" . $_POST['pnazwa'] . "] - startu[" . $_POST['snazwa'] . "]";
								$today_tim = date("H:i:s"); 
								$today = date("Y-m-d");
								mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
							}	
						}
					}
					if( isset($_POST['progid']) ) {
						$stan=1;
						// nazwa

						$timst="";
						// godziny
						if(isset($_POST['hh']) && $stan==1){
							if( is_numeric($_POST['hh']) ) {
								if($_POST['hh']<10) $timst="0".$_POST['hh'] . ":"; else $timst=$_POST['hh'] . ":";
							}else{
								$stan=0;
							}						
						}else{
							$stan=0;						
						}
					
						
						// minuty
						if(isset($_POST['mm']) && $stan==1){
							if( is_numeric($_POST['mm']) ) {
								if($_POST['mm']<10) $timst.="0".$_POST['mm'] . ":"; else $timst.=$_POST['mm'] . ":";
							}else{
								$stan=0;
							}						
						}else{
							$stan=0;						
						}
						
						// minuty
						if(isset($_POST['ss']) && $stan==1){
							if( is_numeric($_POST['ss']) ) {
								if($_POST['ss']<10) $timst.="0".$_POST['ss']; else $timst.=$_POST['ss'];
							}else{
								$timst.="00";		
							}						
						}else{
							$timst.="00";				
						}
						
						if($stan==1) {
							if( $_POST['nazwa']=="") $_POST['nazwa']="Start";
							mysqli_query($con, 'INSERT INTO start_time (nazwa, progid, tim) VALUES ("'. $_POST['nazwa'] . '", ' . $_POST['progid'] .', "'. $timst . '");');
							if($hist==1){
								$str="Dodanie w programie[" . $_POST['prognazwa'] . "] - startu[" . $_POST['nazwa'] . "]";
								$today_tim = date("H:i:s"); 
								$today = date("Y-m-d");
								mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
							}	
						}
					}

					
					$wym=mysqli_query($con, 'SELECT * FROM prog ORDER BY id;');	
					
					while ( $wym_row=mysqli_fetch_assoc($wym) ){
						echo '<div class="dpList">';
						echo '<h2>'. $wym_row['nazwa']. '</h2>';	
						echo '	<table id="tabList">';
						echo '		<tr>';
						echo '			<td colspan="2" class="tdLib" width="990px">'. $wym_row['opis'];
						echo '			</td>';
						echo '		</tr>';
						echo '		<tr>';
						echo '			<td class="tdLia" width="445px">';
						echo '				<form action="homster_prog_ed.php?id=' . $wym_row['id'] , '" method="POST">';
						echo '					<input type="hidden" name="proged" value="' . $wym_row['id'] , '">';
						echo '					<input type="submit" value="Edytuj program">';
						echo '				</form>';
						echo '			</td>';	
						echo '			<td class="tdLia" width="445px">';
						echo '				<form action="?ed=0" method="POST">';
						echo '					<input type="hidden" name="progrv" value="' . $wym_row['id'] , '">';
						echo '					<input type="submit" value="Usuń program">';
						echo '				</form>';
						echo '			</td>';					
						echo '		</tr>';
						echo '	</table>';
						
						echo '	<table id="tabList">';
						echo '		<tr>';
						echo '			<td class="tdNg" width="50px">ID</td><td class="tdNg" width="250px">Nazwa</td><td class="tdNg" width="200px">Czas startu</td><td class="tdNg" width="490px">Dostępny/Usuń</td>';
						echo '		<tr>';
						$wynT=mysqli_query($con, 'SELECT * FROM start_time WHERE progid=' . $wym_row['id'] . ' ORDER BY tim;');	
						$i=0;
						while ( $wynT_row=mysqli_fetch_assoc($wynT) ) {
							if($i%2==0) $styl="tdLib"; else $styl="tdLia"; 
							echo '		<tr>';
							echo '			<td class="' . $styl . '">'. $wynT_row['id']. '</td>';
							echo '			<td class="' . $styl . '">'. $wynT_row['nazwa']. '</td>';
							echo '			<td class="' . $styl . '">'. $wynT_row['tim']. '</td>';
							
							echo '			<td class="' . $styl . '">';
							echo '				<form action="?ed=0" method="POST">';
							echo '					<input type="hidden" name="timid" value="' . $wynT_row['id'] , '">';
							echo '					<input type="hidden" name="snazwa" value="' . $wynT_row['nazwa'] , '">';
							echo '					<input type="hidden" name="pnazwa" value="' . $wym_row['nazwa'] , '">';
							if($wynT_row['en']==0) {	
								echo '					Dostępny<input type="checkbox" name="en" value="0"> / Usuń<input type="checkbox" name="rv" value="0">';
							}else{	
								echo '					Dostępny<input type="checkbox" name="en" value="1" checked> / Usuń<input type="checkbox" name="rv" value="0">';
							}
							echo '					<input type="submit" value="OK">';
							echo '				</form>';
							echo '			</td>';
							echo '		</tr>';
							$i++;
						}
						echo '	</table>';
					
					
						echo '	<form action="?ad=0" method="POST">';
						echo '	<table id="tabList">';
						echo '		<tr>';
						echo '			<td class="tdNg" width="250px">Nazwa</td><td class="tdNg" width="100px">Godziny</td><td class="tdNg" width="100px">Minuty</td><td class="tdNg" width="100px">Sekundy</td><td class="tdNg" width="440px">Działanie</td>';
						echo '		</tr>';
						echo '		<tr>';
						echo '			<td class="tdLib">';
						echo '			<input type="hidden" name="progid" value="'. $wym_row['id'] . '">';
						echo '			<input type="hidden" name="prognazwa" value="'. $wym_row['nazwa'] . '">';
						echo '			<input type="text" name="nazwa"></td>';
						echo '			<td class="tdLib"><input type="text" name="hh"></td>';
						echo '			<td class="tdLib"><input type="text" name="mm"></td>';
						echo '			<td class="tdLib"><input type="text" name="ss"></td>';
						echo '			<td class="tdLib"><input type="submit" value="Dodaj"></td>';
						echo '		</tr>';
						echo '	</table>';	
						echo '	</form>';
					
						echo '</div>';
						echo '<br />';
						
					}
					echo '<div class="dpList">';
					echo '<h2>Dodaj program</h2>';	
					echo '	<form action="?ad=0" method="POST">';
					echo '	<table id="tabList">';
					echo '		<tr>';
					echo '			<td class="tdNg" width="350px">Nazwa</td><td class="tdNg" width="350px">Opis</td><td class="tdNg" width="290px">Działanie</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td class="tdLib"><input type="hidden" name="progad" value="1"><input type="text" name="nazwa"></td>';
					echo '			<td class="tdLib"><input type="text" name="opis"></td>';
					echo '			<td class="tdLib"><input type="submit" value="Dodaj"></td>';
					echo '		</tr>';
					echo '	</table>';	
					echo '	</form>';
					echo '</div>';
					echo '<br />';
					unset($wym);
					unset($wym_row);
					unset($wymT);
					unset($wymT_row);
					mysqli_close($con);
				}
			?>
		</div>
		<br />
		<div class="footer">
			<?php
				
				echo '<div class="stPlay"><a href="idr_pomiar.php?rfs=0">STOP <i class="demo-icon icon-cancel"></i> </a> </div> <div class="stStop">Copyright Piotr Michna</div>';
				
				
			?>		
			<div style="clear:both"></div>	
		</div>
	</div>
</body>
</html>