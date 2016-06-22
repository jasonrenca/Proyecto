<?php
include('../php/conexion.php');
if(isset($_SESSION['id_usu'])==false or isset($_SESSION['id_area'])==false){
	header('Location: login.php');
}else{
	if($_SESSION['id_area'] == 'administrador'){
		header('Location: administrador.php');
	}else{
		$nombre = mysql_query("SELECT * FROM usuarios WHERE id_usu = '".$_SESSION['id_usu']."'");
		$nombre2 = mysql_fetch_array($nombre);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guarda Parques</title>

<link href="../css/estilo.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../js/myjava.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-3.0.0.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAO4ElIfJkm2QV28_DIOWT9cv4FIs7qypQ&sensor=false"></script>
    
    <script type="text/javascript">
        var myCenter=new google.maps.LatLng(-33.4639445,-70.755042);
        var marker;
        var map;
        var mapProp;

        function initialize()
        {
            mapProp = {
              center:myCenter,
              zoom:15,
              mapTypeId:google.maps.MapTypeId.ROADMAP
              };
            setInterval('mark()',5000);
        }

        function mark()
        {
            map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
            var file = "gps.txt";
            $.get(file, function(txt) { 
                var lines = txt.split("\n");
                for (var i=0;i<lines.length;i++){
                    console.log(lines[i]);
                    var words=lines[i].split(",");
                    if ((words[0]!="")&&(words[1]!=""))
                    {
                        marker=new google.maps.Marker({
                              position:new google.maps.LatLng(words[0],words[1]),
                              });
                        marker.setMap(map);
                        map.setCenter(new google.maps.LatLng(words[0],words[1]));
                        document.getElementById('sat').innerHTML=words[3];
                        document.getElementById('speed').innerHTML=words[4];
                        document.getElementById('course').innerHTML=words[5];
                    }
                }
                marker.setAnimation(google.maps.Animation.BOUNCE);
            });

        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>

<body>
<img id="fondoLogin" src="../recursos/FondoLogin.jpg" />
<header>
	<table align="left" border="0" height="100%" width="100%">
    	<tr>
        	<td><b>AREA DE GUARDAPARQUES</b></td>
            <td width="300" align="left"><label>Bienvenido/a: <?php echo $nombre2['nomb_usu']; ?></label></td>
            <td width="50"><a href="../php/logout.php">Salir</a></td>
        </tr>
    </table>
    
</header>

<div>
            <center><br />
                <b> GPS Posición Turistas</b><br /><br />
                <div id="superior" style="width:800px;border:1px solid">
                    <table style="width:100%">
                        <tr>
                            <td>Time</td>
                            <td>Satellites</td>
                            <td>Speed OTG</td>
                            <td>Course</td>
                        </tr>
                        <tr>
                            <td id="time">'. date("Y M d - H:m") .'</td>
                            <td id="sat"></td>
                            <td id="speed"></td>
                            <td id="course"></td>
                        </tr>
                </table>
                </div>
                <br /><br />
                <div id="googleMap" style="width:800px;height:350px;"></div>
            </center>
        </div>';

</body>
</html>