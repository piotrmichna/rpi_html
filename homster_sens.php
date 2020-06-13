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

					if(isset($_POST['delay_s'])){
						if( is_numeric($_POST['delay_s']) ){
							mysqli_query($con, 'UPDATE item SET delay_s=' . $_POST['delay_s'] .' WHERE id=' . $_POST['id']);
						}
					}
					if(isset($_POST['act'])){
						if( is_numeric($_POST['act']) ){
							mysqli_query($con, 'UPDATE item SET stan_act=' . $_POST['act'] .' WHERE id=' . $_POST['id']);
						}
					}
					if(isset($_POST['enf'])){
						if( isset($_POST['en']) ){
							mysqli_query($con, 'UPDATE item SET en=1 WHERE id=' . $_POST['enf']);
						}else{
							mysqli_query($con, 'UPDATE item SET en=0 WHERE id=' . $_POST['enf']);
						}
					}
					$wym=mysqli_query($con, 'SELECT * FROM item WHERE dir=0 ORDER BY nazwa;');			

						echo '<div class="dpList">';
						echo '<h2>Lista czujnikow</h2>';	
						echo '	<table id="tabList">';
						echo '		<tr>';
						echo '			<td class="tdNg">ID</td><td class="tdNg">Nazwa</td><td class="tdNg">Stan</td><td class="tdNg">Stan ACT</td><td class="tdNg">Test[s]</td><td class="tdNg">EN</td>';
						echo '		</tr>';
						$i=0;
						while ( $wym_row=mysqli_fetch_assoc($wym) ){

							echo '		<tr>';
							echo '			<td class="tdLia">.</td><td class="tdLia"></td><td class="tdLia"></td><td class="tdLia"></td><td class="tdLia"></td><td class="tdLia"></td>';
							echo '		</tr>';
							echo '		<tr>';
							$styl="tdLib";
							echo '			<td class="' . $styl . '">'. $wym_row['id']. '</td>';
							echo '			<td class="' . $styl . '">'. $wym_row['nazwa']. '</td>';
		
							if($wym_row['stan']==$wym_row['stan_act']) {
								echo '			<td class="' . $styl . '">Aktywny</td>';
							}else{
								echo '			<td class="' . $styl . '">-</td>';
							}
							
							echo '			<td class="' . $styl . '">';							
							echo '				<form action="?ed=0" method="POST">';
							echo '					<input type="hidden" name="id" value="' . $wym_row['id'] , '">';
								
							echo '					<input type="text" name="act" value="' . $wym_row['stan_act'] , '">---->';
							echo '					<input type="submit" value="Ustaw">';
							echo '				</form>';					
							echo '			</td>';
							
							echo '			<td class="' . $styl . '">';							
							echo '				<form action="?ed=0" method="POST">';
							echo '					<input type="hidden" name="id" value="' . $wym_row['id'] , '">';
								
							echo '					<input type="text" name="delay_s" value="' . $wym_row['delay_s'] , '">---->';
							echo '					<input type="submit" value="Ustaw">';
							echo '				</form>';					
							echo '			</td>';
							
							echo '			<td class="' . $styl . '">';							
							echo '				<form action="?ed=0" method="POST">';
							echo '					<input type="hidden" name="enf" value="' . $wym_row['id'] , '">';		
							if ( $wym_row['en']==1){
								echo '					<input type="checkbox" name="en" value="1" checked>';
							}else{
								echo '					<input type="checkbox" name="en" value="0">';
							}

							echo '					<input type="submit" value="Ustaw">';
							echo '				</form>';					
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
