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
					if(isset($_POST['rv'])) {
							mysqli_query($con, 'DELETE FROM start_time WHERE id=' . $_POST['rv']);
					}
					if(isset($_POST['ad'])) {
							mysqli_query($con, 'INSERT INTO start_time (nazwa, tim) VALUES ("'. $_POST['nazwa'] . '", "'. $_POST['hr'] . ':' . $_POST['min'] .':00");');
					}
					echo '<div class="dpList">';
					echo '<h2>Lista godznn startu nawadniania</h2>';	
					echo '	<table id="tabList">';
					echo '		<tr>';
					echo '			<td class="tdNg" width="40px">ID</td><td class="tdNg" width="550">Nazwa</td><td class="tdNg" width="150px">Czas startu</td><td class="tdNg" width="150px">Stan</td><td class="tdNg" width="100px">Działanie</td>';
					echo '		</tr>';
					$wym=mysqli_query($con, 'SELECT * FROM start_time ORDER BY tim;');	
					$i=0;
					while ( $wym_row=mysqli_fetch_assoc($wym) ){
						echo '		<tr>';
						if($i%2==0) $styl="tdLib"; else $styl="tdLia"; 
						echo '			<td class="' . $styl . '">'. $wym_row['id']. '</td>';
						echo '			<td class="' . $styl . '">'. $wym_row['nazwa']. '</td>';
						echo '			<td class="' . $styl . '">'. $wym_row['tim']. '</td>';
						if($wym_row['stan']==0) {
							echo '			<td class="' . $styl . '">NIE</td>';
						}else{
							echo '			<td class="' . $styl . '">TAK</td>';
						}
						echo '			<td class="' . $styl . '">';
	
						echo '				<form action="?ed=0" method="POST">';
						echo '					<input type="hidden" name="rv" value="' . $wym_row['id'] , '">';
						echo '					<input type="submit" value="Usuń">';
						echo '				</form>';
						echo '			</td>';
						echo '		</tr>';
						$i++;
					}
					
					echo '	</table>';	
					
					echo '<form action="?ad=0" method="POST">';
					echo '	<table id="tabList">';
					echo '		<tr>';
					echo '			<td class="tdNg">ID</td><td class="tdNg">Nazwa</td><td class="tdNg">Godzina startu</td><td class="tdNg">Minuta startu</td><td class="tdNg">Działanie</td>';
					echo '		</tr>';
					echo '		<tr>';
					if($i%2==0) $styl="tdLib"; else $styl="tdLia"; 
					echo '			<td class="' . $styl . '">-</td>';
					echo '			<td class="' . $styl . '"><input type="hidden" name="ad" value="1"><input type="text" name="nazwa" value="Start"></td>';
					echo '			<td class="' . $styl . '"><input type="text" name="hr"></td>';
					echo '			<td class="' . $styl . '"><input type="text" name="min"></td>';
					echo '			<td class="' . $styl . '"><input type="submit" value="Dodaj"></td>';
					echo '		</tr>';
					echo '	</table>';	
					echo '</form>';
					
					echo '</div>';
					
					unset($wym);
					unset($wymwym_row);
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