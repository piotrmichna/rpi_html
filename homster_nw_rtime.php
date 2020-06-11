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
				$con = mysqli_connect("localhost", "pituEl", "hi24biscus", "homster");
				
				if (mysqli_connect_errno())
				{
					echo "Error: ".mysqli_connect_errno();

				}
				else
				{

					if(isset($_POST['stime'])){
						if( is_numeric($_POST['stime']) ){
							mysqli_query($con, 'UPDATE item SET stime=' . $_POST['stime'] .' WHERE id=' . $_POST['id']);
						}
					}
					if(isset($_POST['gpio'])){
						//echo $_POST['id'] > /sys/class/gpio/export;
						system("gpio mode ". $_POST['gpio'] . " out");
						
						if($_POST['stan']==0) {
							system("gpio write ". $_POST['gpio'] . " 1");
							mysqli_query($con, 'UPDATE item SET stan=1 WHERE id=' . $_POST['id']);
						}else{
							system("gpio write ". $_POST['gpio'] . " 0");
							mysqli_query($con, 'UPDATE item SET stan=0 WHERE id=' . $_POST['id']);
						}
						$stan=0;
						$wym=mysqli_query($con, 'SELECT * FROM item WHERE typid=2 AND stan=0;');
						
						if( mysqli_num_rows($wym)>0 ){
							system("gpio write 1 0");
							mysqli_query($con, 'UPDATE item SET stan=0 WHERE gpio=1');
						}else{
							system("gpio write 1 1");
							mysqli_query($con, 'UPDATE item SET stan=1 WHERE gpio=1');
						}
					}
					$wym=mysqli_query($con, 'SELECT * FROM item ORDER BY id;');			

						echo '<div class="dpList">';
						echo '<h2>Lista urządzeń</h2>';	
						echo '	<table id="tabList">';
						echo '		<tr>';
						echo '			<td class="tdNg">ID</td><td class="tdNg">Nazwa</td><td class="tdNg">Opis</td><td class="tdNg">Stan</td><td class="tdNg">Sekund</td>';
						echo '		</tr>';
						$i=0;
						while ( $wym_row=mysqli_fetch_assoc($wym) ){

							echo '		<tr>';
							echo '			<td class="tdLia">.</td><td class="tdLia"></td><td class="tdLia"></td><td class="tdLia"></td><td class="tdLia"></td>';
							echo '		</tr>';
							echo '		<tr>';
							$styl="tdLib";
							echo '			<td class="' . $styl . '">'. $wym_row['id']. '</td>';
							echo '			<td class="' . $styl . '">'. $wym_row['nazwa']. '</td>';
							echo '			<td class="' . $styl . '">'. $wym_row['opis']. '</td>';							
		
							if($wym_row['stan']==1) {
								echo '			<td class="' . $styl . '">-</td>';
							}else{
								echo '			<td class="' . $styl . '">TAK</td>';
							}
							
							echo '			<td class="' . $styl . '">';
							if($wym_row['typid']>=2){
								echo '				<form action="?ed=0" method="POST">';
								echo '					<input type="hidden" name="id" value="' . $wym_row['id'] , '">';
								echo '					<input type="text" name="stime" value="' . $wym_row['stime'] , '">---->';
								echo '					<input type="submit" value="Ustaw">';
								echo '				</form>';
							}
							echo '			</td>';
							
							echo '		</tr>';
							$i++;
						}

						echo '	</table>';	
						echo ' </br>';
						echo ' </br>';
						echo '</div>';
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