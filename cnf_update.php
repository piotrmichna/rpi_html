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
					
					if ( isset($_POST['restart']) ){
						if($hist==1){
							$str="AKTUALIZACJA SYSTEMU-www";
							$today_tim = date("H:i:s"); 
							$today = date("Y-m-d");
							mysqli_query($conx, 'INSERT INTO syst (dat, tim, opis) VALUES ("'. $today . '", "' . $today_tim .'", "'. $str . '");');										
						}	
						mysqli_query($con, 'UPDATE cnf SET valu=1 WHERE comm="update";');
						echo '<div class="dpList">';
						echo '<h2>Odczekaj chwilę na aktualizacje i ponowny start systemu.</h2>';	
						echo '</div>';
						echo '<br />';
					}else{
						echo '<div class="dpList">';
						echo '<h2>Czy na pewno chcesz wykonać aktualizacje systemu?</h2>';	
	
						echo '				<form action="" method="POST">';
						echo '					<input type="hidden" name="restart" value="1">';
						echo '					<input type="submit" value="Wykonaj Aktualizację">';
						echo '				</form>';
						
						echo '</div>';
						echo '<br />';
					}

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
