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
					
					if ( isset($_POST['sv']) ){
							if($hist==1){
								if( isset($_GET['id']) ){
									$str="Dodanie urządzenia[" . $_POST['itemn'] . "] do programu[" . $_POST['program'] . "]";
								}else{
									$str="Edycja urządzenia[" . $_POST['itemn'] . "] do programu[" . $_POST['program'] . "]";
								}
								
								$today_tim = date("H:i:s"); 
								$today = date("Y-m-d");
								mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
							}	
							if( !isset($_POST['parale']) ){
								$_POST['parale']=0;
							}else{
								$_POST['parale']=1;
							}
							if( isset($_GET['id']) ){
								mysqli_query($con, 'UPDATE prog_item SET itemid=' . $_POST['item'] .', lp=' . $_POST['lp'] .', delay_s=' . $_POST['delay_s'] .', parale=' . $_POST['parale'] .' WHERE id=' .$_GET['id'] .';');
							}else{
								mysqli_query($con, 'INSERT INTO prog_item (progid, itemid, lp, delay_s, parale) VALUES ('. $_GET['pid'] . ', ' . $_POST['item'] .', ' . $_POST['lp'] .', ' . $_POST['delay_s'] .', ' . $_POST['parale'] .');');
							}
							
							if( isset($_GET['pid']) ){					
								$wym=mysqli_query($con, 'SELECT * FROM prog WHERE id=' . $_GET['pid'] . ';');	
								$wym_ro=mysqli_fetch_assoc($wym);
								echo' <h3>Program: ' . $wym_ro['nazwa'] . '</h3>' . "\n";
								echo' <h5>' . $wym_ro['opis'] . '</h5>';
								echo' <a href="homster_prog_ed.php?id=' . $_GET['pid'] . '">Powrót do edycji programu</a>' . "\n";
							}		
					}else{
										
// ----------------- TREŚĆ STRONY --------------------------------------------------------------------------------------
					if( isset($_GET['pid']) ){					
					$wym=mysqli_query($con, 'SELECT * FROM prog WHERE id=' . $_GET['pid'] . ';');	
					$wym_ro=mysqli_fetch_assoc($wym);
					echo' <h3>Program: ' . $wym_ro['nazwa'] . '</h3>' . "\n";
					echo' <h5>' . $wym_ro['opis'] . '</h5>';
					echo' <a href="homster_prog_ed.php?id=' . $_GET['pid'] . '">Powrót do edycji programu</a>' . "\n";
					$progid=$wym_ro['id'];
						
// ----------------- edycja urzadzen --------------------------------------------------------------------------------------										
					echo '<div class="dpList">' . "\n";
					if( isset($_GET['id']) ){
						echo '<h2>Edytuj urządzeie</h2>' . "\n";
						echo '				<form action="homster_prog_item.php?id=' . $_GET['id'] .'&pid=' . $_GET['pid'] .'" method="POST">' . "\n";
						$pr=mysqli_query($con, 'SELECT * FROM prog_item WHERE id=' . $_GET['id'] . ' ORDER BY lp;');		
						if( mysqli_num_rows($pr)>0){
							$pr_ro=mysqli_fetch_assoc($pr);
							$program=$pr_ro['nazwa'];
							if( !isset($_POST['lp']) ) $_POST['lp']=$pr_ro['lp'];
							if( !isset($_POST['item']) ) $_POST['item']=$pr_ro['itemid'];
							if( !isset($_POST['delay_s']) ) $_POST['delay_s']=$pr_ro['delay_s'];
							if( !isset($_POST['parale']) ) $_POST['parale']=$pr_ro['parale'];
						}
					}else{
						echo '<h2>Dodaj urządzeie</h2>' . "\n";
						echo '				<form action="homster_prog_item.php?pid=' . $_GET['pid'] .'" method="POST">' . "\n";
						$numq=mysqli_query($con, 'SELECT * FROM prog_item WHERE progid=' . $_GET['pid'] . ' ORDER BY lp;');		
						$num=mysqli_num_rows($numq);
						$_POST['lp']=$num+1;
					}
					
					
					echo '	<table id="tabList">' . "\n";
					echo '		<tr>' . "\n";
					echo '			<td class="tdNg" width="400px">WŁASNPŚĆ</td>' . "\n";
					echo '			<td class="tdNg" width="490px">WARTOść</td>' . "\n";
					echo '		</tr>' . "\n";
					
					echo '		<tr>' . "\n";
					echo '			<td class="tdLia">LP</td>' . "\n";
					echo '			<td class="tdLia">' . "\n";
					if( isset($_POST['lp']) ) $val=' value="' . $_POST['lp'] .'"'; else $val="";
					echo '				<input type="text" name="lp"' . $val . '>' . "\n";
					echo '			</td>' . "\n";
					echo '		</tr>' . "\n";
					
					echo '		<tr>' . "\n";					
					echo '			<td class="tdLia">URZĄDZNIE</td>' . "\n";
					echo '			<td class="tdLia">' . "\n";
					echo '				<select name="item">' . "\n";
					$it=mysqli_query($con, 'SELECT * FROM item ORDER BY nazwa;');	
					while ( $it_ro=mysqli_fetch_assoc($it) ){
						$ty=mysqli_query($con, 'SELECT * FROM item_typ WHERE id='. $it_ro['typid'] .';');	
						$ty_ro=mysqli_fetch_assoc($ty);
						
						if( isset($_POST['item']) ){
							if( $_POST['item']==$it_ro['id'] ){
								$sel=" selected";
								if( !isset($_POST['delay_s']) ) $_POST['delay_s']=$it_ro['delay_s'];
								$dir=$it_ro['dir'];
								$item=$it_ro['nazwa'];
							}else{
								$sel="";
							}
						}
						
						echo '					<option value="' . $it_ro['id'] . '"' .$sel .'>'. $it_ro['nazwa'] .' ['. $ty_ro['nazwa'] .']</option>' . "\n";
					}
					echo '				</select>' . "\n";
					echo '			</td>' . "\n";
					echo '		</tr>' . "\n";
					
					if( isset($_POST['item']) ){
						echo '		<tr>' . "\n";
						if($dir==0){
							echo '			<td class="tdLia">TEST CO[s]</td>' . "\n";
						}else{
							echo '			<td class="tdLia">CZAS PRACY[s]</td>' . "\n";
						}
						echo '			<td class="tdLia">' . "\n";
						if( isset($_POST['delay_s']) ) {
							$val=' value="' . $_POST['delay_s'] .'"'; 
						}else{
							$val="";
						}
						echo '				<input type="text" name="delay_s"' . $val . '>' . "\n";
						echo '			</td>' . "\n";
						echo '		</tr>' . "\n";	
					
						echo '		<tr>' . "\n";
						if($dir==0){
							echo '			<td class="tdLia">TEST CIĄGŁY</td>' . "\n";
						}else{
							echo '			<td class="tdLia">PRACA RÓWNOLEGŁA</td>' . "\n";
						}
						echo '			<td class="tdLia">' . "\n";
						if( isset($_POST['parale']) ) {
							if( $_POST['parale']==0 ){
								echo '				<input type="checkbox" name="parale" value="0">' . "\n";
							}else{
								echo '				<input type="checkbox" name="parale" value="1" checked>' . "\n";
							}						
						}else{
							echo '				<input type="checkbox" name="parale" value="1">' . "\n";
						}					
						echo '			</td>' . "\n";
						echo '		</tr>' . "\n";	
					}
					
					echo '		<tr>' . "\n";
					echo '			<td class="tdLib"></td>' . "\n";
					echo '			<td class="tdLib">' . "\n";
					if( isset($_POST['item']) ){
						echo '					<input type="hidden" name="sv" value="1">' . "\n";
						echo '					<input type="hidden" name="itemn" value="' . $item . '">' . "\n";
						echo '					<input type="hidden" name="program" value="' . $program .'">' . "\n";
						echo '					<input type="submit" value="Zapisz">' . "\n";
					}else{
						echo '					<input type="submit" value="Wybierz">' . "\n";
					}
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
			}
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