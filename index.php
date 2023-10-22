
<?php 
	session_start();
	
	if(empty($_SESSION["login"])){
		header("Location: login.php");
	}
	
	$hash = "";
	$endDate = "";
	
	$con = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($con, "heduis");
	$rs = mysqli_query($con, "SELECT * FROM activation_links");
	
	$start = $expire = 0;
	
	$today = strtotime("now");
	
	if(!$con || !$db || !$rs){
		die('Error: '.mysqli_error());
	}
	else{
		
		while($row = mysqli_fetch_array($rs)){
			
			$expire = strtotime($row["endDate"]);
			
			if($today > $expire){
				$endDate = date("Y-m-d", $expire);
				$rs1 = mysqli_query($con, "DELETE FROM activation_links WHERE endDate=\"$endDate\" ") or die('Error: '.mysqli_error());
			}
			
		}
		
	}
	
	mysqli_close($con);
	
?> 
 <!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>HEDU IMS | Home</title>
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link rel="shortcut icon" href="dist/img/logo.gif" />
    
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
   
   
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
   
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
	<?php 
		echo header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		echo header("Cache-Control: no-cache");
		echo header("Pragma: no-cache");
	?>	
	<script>
		function showResult(str) {
		  if (str.length==0) { 
			document.getElementById("livesearch").innerHTML="";
			document.getElementById("livesearch").style.border="0px";
			return;
		  }
		  if (window.XMLHttpRequest) {
			i
			xmlhttp=new XMLHttpRequest();
		  } 
		  else {  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
			  document.getElementById("livesearch").style.border="1px solid #A5ACB2";
			}
		  }
		  
		  xmlhttp.open("GET","livesearch.php?q="+str,true);
		  xmlhttp.send();
		}
	</script>
    	
  </head>
  <body class="skin-blue"  >
    <div class="wrapper">
      
      <header class="main-header">
			<?php include "header.php"; ?>
      </header> 
	  
     
      <aside class="main-sidebar" style="min-height: 100% !important;" >
       
        <section class="sidebar">

		
          <form action="search.php" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="key" autocomplete="off" required onkeyup="showResult(this.value)" class="form-control" placeholder="Search Serial#, Service Tag, Type"/>
              <span class="input-group-btn">
                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
			<div id="livesearch"></div>
          </form>
          
          <?php 
				if($_SESSION["user"] == "admin"){
					include "adminmenu.php";
				}
				else{
					include "menu.php";
				}
			?>
        </section>
        
      </aside>

      
      <div class="content-wrapper">
       
        <section class="content-header">
          <h1>
            Dashboard <img src="dist/img/dashboard.png" width="50" height="45"/>
          </h1>
          
        </section>
		
		       
		<section class="content" style="min-height: 800px">
			
			<?php
			$con = mysqli_connect("localhost", "root", "");
			$db = mysqli_select_db($con, "heduis");
			$num = 0;
			$a = 1;
			$j = 0;
			$br = "";
			
			$rs1 = mysqli_query($con, "SELECT * FROM new_stationery GROUP BY type ");
			$rs2 = mysqli_query($con, "SELECT * FROM new_equipment GROUP BY type");
			$rs3 = mysqli_query($con, "SELECT * FROM new_office_equipment GROUP BY type");
			$type = "";			
						
			if(!$con || !$db || !$rs1|| !$rs2 ||!$rs3){
				die('Error: '.mysqli_error());
			}
			else{		
			
				if($_SESSION["user"] == "admin"){
										
				
				$i = 'a';
				
				echo '<div id="row">';
				
				echo '<h3>Stationery</h3>';
				
				while($row = mysqli_fetch_array($rs1)){
					if($i > 'd'){
						$i = 'a';
					}
					$type = $row["type"];	
					$rs = mysqli_query($con, "SELECT * FROM stock WHERE type='$type'");
					$num = mysqli_num_rows($rs);
					
					echo '
					<div id="col" class="'.$i.'" onclick="window.location.href=\'search.php?key='.$type.'\'" ">
						<img src="dist/img/'.$type.'.png" width="50" height="50" /> '.$type.'s <span>'.$num.'</span>
					</div>
					
					';
					$i++;
				}
				
				
				echo '</div>';
						
				
									//COMPUTER EQUIPMENT
									
				$i = 'a';
				
				
				echo '<div id="row" style="margin-bottom: 20px">';
				echo '<br/>';
				echo '<h3>Computer Equipment</h3>';
				
				while($row = mysqli_fetch_array($rs2)){
					if($i > 'd'){
						$i = 'a';
					}
								
					$type = $row["type"];	
					$rs = mysqli_query($con, "SELECT * FROM stock WHERE type='$type'");
					$num = mysqli_num_rows($rs);
					
					echo '
					<div id="col" class="'.$i.'" onclick="window.location.href=\'search.php?key='.$type.'\'" ">
						<img src="dist/img/'.$type.'.png" width="50" height="50" /> '.$type.'s <span>'.$num.'</span>
					</div>
					
					';
					$i++;
					
				}
				
				
				echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				</div>
				<br/>';

				
										//OFFICE EQUIPMENT
				
				$i = 'a';
				
				echo '<div id="row">';
				echo '<br/>';
				echo '<h3>Office Equipment</h3>';
				
				while($row = mysqli_fetch_array($rs3)){
					
					if($i > 'd'){
						$i = 'a';
					}					
					$type = $row["type"];	
					$rs = mysqli_query($con, "SELECT * FROM stock WHERE type='$type'");
					$num = mysqli_num_rows($rs);
					
					echo '
					<div id="col" class="'.$i.'" onclick="window.location.href=\'search.php?key='.$type.'\'" ">
						<img src="dist/img/'.$type.'.png" width="50" height="50" /> '.$type.'s <span>'.$num.'</span>
					</div>
					';
					$i++;
					$a++;
					if($a % 3 == 0){ 
						$br .= "<br/><br/><br/><br/><br/><br/><br/><br/>";
					}	
				}
				
				
				
				echo $br;
				
				
				echo '</div>
				<br/>';
				
				}
				
				else{
									//USER DASHBOARD
										
					$i = 'a';
					
					
					echo '<div id="row">';
					echo '<br/>';
					echo '<h3>Computer Equipment</h3>';
					
					$rs = mysqli_query($con, "SELECT * FROM stock WHERE type='Laptop'") or die("Error: ".mysqli_error());
					$rs1 = mysqli_query($con, "SELECT * FROM stock WHERE type='Desktop'") or die("Error: ".mysqli_error());
					$rs2 = mysqli_query($con, "SELECT * FROM stock WHERE type='Tablet'") or die("Error: ".mysqli_error());
					
					$row = mysqli_fetch_array($rs);
						if($i > 'd'){
							$i = 'a';
						}
									
						$type = $row["type"];	
						
					
						$num = mysqli_num_rows($rs);
						
						echo '
						<div id="col" class="'.$i.'" onclick="window.location.href=\'search.php?key='.$type.'\'" ">
							<img src="dist/img/'.$type.'.png" width="50" height="50" /> '.$type.'s <span>'.$num.'</span>
						</div>
						';
					$i++;
						
					
					$row = mysqli_fetch_array($rs1);
					if($i > 'd'){
						$i = 'a';
					}
								
					$type = $row["type"];	
					
				
					$num = mysqli_num_rows($rs1);
					
					echo '
					<div id="col" class="'.$i.'" onclick="window.location.href=\'search.php?key='.$type.'\'" ">
						<img src="dist/img/'.$type.'.png" width="50" height="50" /> '.$type.'s <span>'.$num.'</span>
					</div>
					';
					$i++;
					
					
					$row = mysqli_fetch_array($rs2);
					if($i > 'd'){
						$i = 'a';
					}
								
					$type = $row["type"];	
					
				
					$num = mysqli_num_rows($rs2);
					
					echo '
					<div id="col" class="'.$i.'" onclick="window.location.href=\'search.php?key='.$type.'\'" ">
						<img src="dist/img/'.$type.'.png" width="50" height="50" /> '.$type.'s <span>'.$num.'</span>
					</div>
					';
					$i++;
					
					
					
					echo '</div>
					<br/>';
				}
				
			}
		?>
		<br/>
		<br/>
		<br/>	
		<br/>	
		</section>
      </div>
	  
      <footer class="main-footer">
		<?php include "footer.php";?>
	  </footer>
    </div>

 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
	
	<script src="dist/js/app.min.js" type="text/javascript"></script>
	
	<script src="dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>