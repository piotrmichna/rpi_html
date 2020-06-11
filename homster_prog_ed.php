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
								$str="Usunięcie w programie[" . $wyn_row['nazwa'] . "] - startu[" . $wynt_row['nazwa'] . "]";
								$today_tim = date("H:i:s"); 
								$today = date("Y-m-d");
								mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
							}	
						}
					}
					if( isset($_GET['rvi']) ){
							mysqli_query($con, 'DELETE FROM prog_item WHERE id=' . $_GET['rvi']);
							if($hist==1){
								$str="Usunięcie w programie[" . $_GET['programn'] . "] - urządzenia[" . $G_GET['itemn'] . "]";
								$today_tim = date("H:i:s"); 
								$today = date("Y-m-d");
								mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
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
					
// ----------------- TREŚĆ STRONY --------------------------------------------------------------------------------------					
					$wym=mysqli_query($con, 'SELECT * FROM prog WHERE id=' . $_GET['id'] . ';');	
					$wym_ro=mysqli_fetch_assoc($wym);
					echo' <h3>Program: ' . $wym_ro['nazwa'] . '</h3>' . "\n";
					echo' <h5>' . $wym_ro['opis'] . '</h5>';
					$progid=$wym_ro['id'];

						echo '<div class="dpList">' . "\n";
						echo '<h2>Starty porogramu</h2>' . "\n";	
												
						echo '	<table id="tabList">' . "\n";
						echo '		<tr>' . "\n";
						echo '			<td class="tdNg" width="50px">ID</td><td class="tdNg" width="250px">Nazwa</td><td class="tdNg" width="200px">Czas startu</td><td class="tdNg" width="490px">Dostępny/Usuń</td>' . "\n";
						echo '		<tr>' . "\n";
						$wynT=mysqli_query($con, 'SELECT * FROM start_time WHERE progid=' . $progid . ' ORDER BY tim;');	
						$i=0;
						while ( $wynT_row=mysqli_fetch_assoc($wynT) ) {
							if($i%2==0) $styl="tdLib"; else $styl="tdLia"; 
							echo '		<tr>' . "\n";
							echo '			<td class="' . $styl . '">'. $wynT_row['id']. '</td>' . "\n";
							echo '			<td class="' . $styl . '">'. $wynT_row['nazwa']. '</td>' . "\n";
							echo '			<td class="' . $styl . '">'. $wynT_row['tim']. '</td>' . "\n";
							if($wynT_row['en']==0) {
								echo '			<td class="' . $styl . '">' . "\n";
								echo '				<form action="?id=' . $progid .'" method="POST">' . "\n";
								echo '					<input type="hidden" name="timid" value="' . $wynT_row['id'] , '">' . "\n";
								echo '					Dostępny<input type="checkbox" name="en" value="0"> / Usuń<input type="checkbox" name="rv" value="0">' . "\n";
								echo '					<input type="submit" value="OK">' . "\n";
								echo '				</form>' . "\n";
								echo '			</td>' . "\n";
							}else{
								echo '			<td class="' . $styl . '">' . "\n";
								echo '				<form action="id=' . $progid .'" method="POST">' . "\n";
								echo '					<input type="hidden" name="timid" value="' . $wynT_row['id'] , '">' . "\n";
								echo '					Dostępny<input type="checkbox" name="en" value="1" checked> / Usuń<input type="checkbox" name="rv" value="0">' . "\n";
								echo '					<input type="submit" value="OK">' . "\n";
								echo '				</form>' . "\n";
								echo '			</td>' . "\n";
							}
							echo '		</tr>' . "\n";
							$i++;
						}
						echo '	</table>' . "\n";
					
					
						echo '	<form action="?id=' . $progid .'" method="POST">' . "\n";
						echo '	<table id="tabList">' . "\n";
						echo '		<tr>' . "\n";
						echo '			<td class="tdNg" width="250px">Nazwa</td><td class="tdNg" width="100px">Godziny</td><td class="tdNg" width="100px">Minuty</td><td class="tdNg" width="100px">Sekundy</td><td class="tdNg" width="440px">Działanie</td>';
						echo '		</tr>' . "\n";
						echo '		<tr>' . "\n";
						echo '			<td class="tdLib">' . "\n";
						echo '			<input type="hidden" name="progid" value="'. $progid . '">' . "\n";
						echo '			<input type="hidden" name="prognazwa" value="'. $$wym_ro['nazwa'] . '">' . "\n";
						echo '			<input type="text" name="nazwa"></td>' . "\n";
						echo '			<td class="tdLib"><input type="text" name="hh"></td>' . "\n";
						echo '			<td class="tdLib"><input type="text" name="mm"></td>' . "\n";
						echo '			<td class="tdLib"><input type="text" name="ss"></td>' . "\n";
						echo '			<td class="tdLib"><input type="submit" value="Dodaj"></td>' . "\n";
						echo '		</tr>' . "\n";
						echo '	</table>' . "\n";	
						echo '	</form>' . "\n";
					
						echo '</div>' . "\n";
						echo '<br />' . "\n";
						
// ----------------- tabela urzadzen --------------------------------------------------------------------------------------										
					echo '<div class="dpList">' . "\n";
					echo '<h2>Lista urządzeń</h2>' . "\n";
					
					echo '	<table id="tabList">' . "\n";
					echo '		<tr>' . "\n";
					echo '			<td class="tdNg" width="50px">LP</td>' . "\n";
					echo '			<td class="tdNg" width="290px">NAZWA</td>' . "\n";
					echo '			<td class="tdNg" width="250px">TYP</td>' . "\n";
					echo '			<td class="tdNg" width="50px">[s]</td>' . "\n";
					echo '			<td class="tdNg" width="50px">||</td>' . "\n";
					echo '			<td colspan="2" class="tdNg" width="250px">Działanie</td>' . "\n";
					echo '		</tr>' . "\n";
					$pr=mysqli_query($con, 'SELECT * FROM prog_item WHERE progid=' . $progid . ' ORDER BY lp;');		
					if( mysqli_num_rows($pr)>0){
						$i=0;
						while ( $pr_ro=mysqli_fetch_assoc($pr) ){
							$it=mysqli_query($con, 'SELECT * FROM item WHERE id=' . $pr_ro['itemid'] . ';');		
							$it_ro=mysqli_fetch_assoc($it);
							if($i%2==0) $styl="tdLib"; else $styl="tdLia"; 
							echo '		<tr>' . "\n";
							echo '			<td class="' . $styl . '" width="50px">' . $pr_ro['lp'] . '</td>' . "\n";
							echo '			<td class="' . $styl . '" width="290px">' . $it_ro['nazwa'] . '</td>' . "\n";
							$ty=mysqli_query($con, 'SELECT * FROM item_typ WHERE id=' . $it_ro['typid'] . ';');		
							$ty_ro=mysqli_fetch_assoc($ty);
							echo '			<td class="' . $styl . '" width="250px">' . $ty_ro['nazwa'] . '</td>' . "\n";
							echo '			<td class="' . $styl . '" width="50px">' . $pr_ro['delay_s'] . '</td>' . "\n";
							echo '			<td class="' . $styl . '" width="50px">';
							if($pr_ro['parale']==1) echo '||';
							echo '			</td>' . "\n";
							echo '			<td class="' . $styl . '" width="125px">' . "\n";
							echo '				<form action="homster_prog_item.php?id=' . $pr_ro['id'] .'&pid=' . $progid .'" method="POST">' . "\n";
							echo '					<input type="submit" value="Edytuj">' . "\n";
							echo '				</form>' . "\n";
							echo '			</td>' . "\n";
							echo '			<td class="' . $styl . '" width="125px">' . "\n";
							echo '				<form action="?id=' . $progid . '&rvi=' . $pr_ro['id'] .'&programn=' . $wym_ro['nazwa']  .'&itemn=' . $it_ro['nazwa'] . '" method="POST">' . "\n";
							echo '					<input type="submit" value="Usuń">' . "\n";
							echo '				</form>' . "\n";
							echo '			</td>' . "\n";
							echo '		</tr>' . "\n";
							$i++;
						}
					}else{
						echo '		<tr>' . "\n";
						echo '			<td colspan="5" class="tdLib">Brak urządzń...' . "\n";
						echo '			<td colspan="2" class="tdLib"></td>' . "\n";
						echo '		</tr>' . "\n";
					}				
					
					
					echo '		<tr>' . "\n";
					echo '			<td colspan="5" class="tdLib">' . "\n";
					echo '			<td colspan="2" class="tdLib">' . "\n";
					echo '				<form action="homster_prog_item.php?pid=' . $progid .'" method="POST">' . "\n";
					echo '					<input type="submit" value="Dodaj">' . "\n";
					echo '				</form>' . "\n";
					echo '			</td>' . "\n";
					echo '		</tr>' . "\n";
					echo '	</table>' . "\n";
					
					echo '</div>' . "\n";
					echo '<br />' . "\n";
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