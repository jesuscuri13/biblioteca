<?php

@set_time_limit(0);

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


include_once ("libraries/Amazonia/autoload.php");

include_once ("core/Exceptions.php"); // Para llamar a los métodos Exceptions::response
include_once ("core/cfg.php"); // Configuración de la base de datos y otras configuraciones más
include_once ("core/plconexion/plconexion.php"); // Clase que maneja la conexión con la base de datos
include_once ("core/Help.php"); // Clase que maneja la conexión con la base de datos
include_once ("core/restFunctions.php");
include("cfg.php");
include_once ("config/FbReceive.php");
include_once ("models/Enlaces.php");
include_once ("models/Programados.php");
include_once ("models/Albumes.php");
include_once ("models/VideosProgramados.php");

include_once ("OpenGraph.php");

include_once ("controllers/SessionController.php");



header('Content-Type: text/html; charset=UTF-8');

if (!empty($_POST['dopassword'])) {
    
    
    setcookie("mypassword", $_POST['dopassword'], time() + (3600 * 24 * 60));
    
    redir("?");
    
}



if (!empty($_GET['goto'])) {
    switch ($_GET['goto']) {
        default:
            $lang = "";
            break;
        case "en":
            $lang = "";
            break;
            
    }
    
    setcookie("lang", $lang, time() + 3600 * 24 * 365);
    
    redir("?");
    
}



switch ($_COOKIE['lang']) {
    
    default:
        $lang = "";
        break;
    
    case "en":
        $lang = "";
        break;
        
}



include("lang_" . $lang . ".php");

//Obtenemos Los datos del usuario

$input = new stdClass();
$input->res = "session";
$method = "GET";
//run ($input, $method);
logued();
/*$inp = ["res" => "user", "action" => "changeMembership", "id" => $usuario["id"], "type" => "5"];
$result = run (Help::objectize($inp), "PUT");
var_dump ($result);   
*/
if ( $usuario["membresia"] != "4" && $usuario["membresia"] != "5" ) {
	unset (Menu::$_es["usuarios"]);	
}
if (strstr($_POST['changemail'], "@") AND !empty($_POST['changemail']) AND empty($usuario['email'])) {
    
    $emailnew = trim(addslashes($_POST['changemail']));
    
    $mysqli->query("UPDATE fb_usuarios SET email='" . $emailnew . "' WHERE uid='" . $usuario['uid'] . "' limit 1");
    
    redir("?changed", "Gracias por completar tu registro!");
    
}



if (!isUTF8($usuario['uname'])) {
    $usuario['uname'] = utf8_encode($usuario['uname']);
}

/*if ($usuario['membresia'] == 0 AND !empty($usuario['id'])) {
    redir("./ayuda/", $txt_banned);
}*/

if ($usuario) {
    
    if ($_POST['cambiarzona'] == 1 AND $_POST['zh'] <= 25) {
        
        $mysqli->query("UPDATE fb_usuarios SET zona='" . addslashes($_POST['zh']) . "' WHERE uid='" . $usuario['uid'] . "'");
        
        $mysqli->query("UPDATE fb_pages SET zona='" . addslashes($_POST['zh']) . "' WHERE uid='" . $usuario['uid'] . "'");
        
        redir("?", $txt_zona);
        
    }
    
    if ($usuario['zona'] > 0 AND $usuario['zona'] <= 25) {
        
        $zonahora = $zonahoraria[$usuario['zona']];
        
        //$zonahora = str_replace("-","-",$zonahora);
        
        date_default_timezone_set($zonahora);
        // var_dump($zonahora);
    }
    
    
    
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html dir="ltr" lang="<?= $xml_lang ?>" xml:lang="<?= $xml_lang ?>">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"<?php
    if (!empty($_GET['pic'])) {
        echo "article: http://ogp.me/ns/article#";
    }
?>>

<meta http-equiv="Content-Type" content="text/html;"/>
<meta charset="UTF-8">

    <title><?php
        $sitename;
    ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="style.css" type="text/css" />

    <link rel="stylesheet" href="media/css/alertify-1.11.4/alertify.min.css" type="text/css" />
    <link rel="stylesheet" href="media/css/alertify-1.11.4/themes/default.min.css" type="text/css" />
    <link rel="stylesheet" href="shadowbox/shadowbox.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="media/css/manage.css" type="text/css" media="screen"/>
    <style type="text/css">@import url(/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
    <link rel="stylesheet" href="media/css/bootstrap.min.css" type="text/css" />

    <script type="text/javascript" src="media/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="media/js/alertify-1.11.4/alertify.min.js"></script>
<!--<script type="text/javascript" src="jq.js"></script>-->

<!-- <script type="text/javascript" src="inview.js"></script>  -->



<script src="shadowbox/shadowbox.js" type="text/javascript"></script>

<script src="media/js/ajax.js"></script>
<script src="media/js/components/Component.js"></script>
<script src="media/js/messages.js"></script>
<script src="media/js/factory.js"></script>
<script src="media/js/handleUsers.js"></script>
<script src="media/js/handleAlbums.js"></script>
<script src="media/js/components/FanpageComponent.js"></script>
<script src="media/js/components/ProgrammedComponent.js"></script>
<script src="media/js/components/AlbumListComponent.js"></script>
<script src="media/js/components/InstagramListComponent.js"></script>
<script src="media/js/albumComponent.js"></script>
<script src="media/js/handleSend.js"></script>
<script >
    var resourceGetted = <?= array_key_exists ("s", $_GET) ? json_encode ($_GET["s"]) : json_encode(""); ?>;
    var actualUser = <?= json_encode($usuario) ?>
</script>
<script src="media/js/main.js"></script>

</head>

<body>

<?
    
    print "<div id=\"fb-root\"></div>

<script>

  window.fbAsyncInit = function() {

    // init the FB JS SDK

    FB.init({

      appId      : '" . $app_id . "', // App ID from the App Dashboard

      channelUrl : 'super-repunto.es/channel.html', // Channel File for x-domain communication

      status     : true, // check the login status upon init?

      cookie     : true, // set sessions cookies to allow your server to access the session?

      xfbml      : true  // parse XFBML tags on this page?

    });

  };



  // Load the SDK's source Asynchronously

  // Note that the debug version is being actively developed and might

  // contain some type checks that are overly strict.

  // Please report such bugs using the bugs tool.

  (function(d, debug){

     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];

     if (d.getElementById(id)) {return;}

     js = d.createElement('script'); js.id = id; js.async = true;

     js.src = \"//connect.facebook.net/es_ES/all\" + (debug ? \"/debug\" : \"\") + \".js\";

     ref.parentNode.insertBefore(js, ref);

   }(document, /*debug*/ false));

</script>\n";
    
    
    
?>

<div id="wrapper">

<div id="contenido">



<table width="100%" border="0" cellspace="0" cellpadding="0">

<tr>

<td width="300"><a href="?" title="Repunto Manager"><img src="https://super.repunto.es/super-admin.png" width="268" height="119" alt="Repunto Manager" border=0></a></td>

<td width="230" valign="top">

<div class="listado">

<?
    if ($usuario['nivel'] < 3 AND !strstr($_SERVER['HTTP_USER_AGENT'], "iPad")) {
?><div class="fb-like-box" data-href="https://www.facebook.com/repunto" data-width="230" data-show-faces="false" data-stream="false" data-header="false"></div><?
    }
?>

<div align="center" style="height: 24px;"></div>

</div>

</td>

<td valign="top">

<div class="listado">

   <form action="?" method="post"><b>Fecha y Hora:</b> <?= date("d/m/Y H:i"); ?>

   <br /><br><b>Elegir Zona Horaria:</b><br>

<input name="cambiarzona" type="hidden" value="1">

<select size="1" name="zh" onchange="this.form.submit()">

 <?
    
    $cttt = 0;
    
    foreach ($zonahoraria AS $zhid => $zhtxt) {
        
        print '<option value="' . $zhid . '"';
        
        if ($usuario['zona'] == $zhid) {
            print " SELECTED";
        }
        
        print '>' . $zonaname[$cttt] . '</option>';
        
        $cttt++;
        
    }
    
?>

</select>

<?
    if ($usuario['nivel'] < 3 AND !strstr($_SERVER['HTTP_USER_AGENT'], "iPad")) {
?><br><div style="" class="g-plusone" data-href="https://super.repunto.es" data-size="medium"></div><?
    }
?> &nbsp;&nbsp;&nbsp;&nbsp;  <?= $txt_version ?></form>

<b>Tu Email:</b> <small><?= $usuario['email'] ?></small>


</div>
</td>
</tr>
</table>




</div>



<div id="menu">

<?php

foreach (Menu::$_es as $k => $v) {
    echo '<a href ="' . $v["href"] . '" class="' . $v["class"] . " " . ($_GET["s"] == $v["url"] ? "selected" : "") . '" style="'. $v["style"] .'">'.
        $v["name"] . "</a>";
}

?>

</div>

<div id="contenido-body">

<?
    if ($lang == "en") {
        $dias[0] = "Sunday";
        
        $dias[1] = "Monday";
        
        $dias[2] = "Tuesday";
        
        $dias[3] = "Wednesday";
        
        $dias[4] = "Thursday";
        
        $dias[5] = "Friday";
        
        $dias[6] = "Saturday";
    }
    
    checkpassword();
    
    switch ($_GET['s']) {
        default:
            
            /*$queryusuarios = $mysqli->query("SELECT * FROM fb_usuarios WHERE membresia = '2'");
            
            while ($uussuuaarriioo = $queryusuarios->fetch_array()) {
                
                $result              = $mysqli->query("SELECT uid,id,email FROM fb_usuarios WHERE email='" . $uussuuaarriioo['email'] . "' AND uid!='" . $uussuuaarriioo['uid'] . "'");
                $uussuuaarriioonuevo = $result->fetch_array();
                
                if ($uussuuaarriioonuevo['uid']) {
                    
                    $mysqli->query("UPDATE fb_usuarios SET uid='" . $uussuuaarriioonuevo['uid'] . "' WHERE id='" . $uussuuaarriioo['id'] . "';");
                    
                    $mysqli->query("DELETE FROM fb_usuarios WHERE id='" . $uussuuaarriioonuevo['id'] . "';");
                    
                    $mysqli->query("UPDATE fb_albums SET uid='" . $uussuuaarriioonuevo['uid'] . "' WHERE uid='" . $uussuuaarriioo['uid'] . "';");
                    
                }
            
            }*/
            
            include("sec" . $lang . ".php");
            
            break;
        
        case "facebook":
            
?>

    <div align="center"><h1>Actualizaciones Facebook</h1>

        <div style="width:100%;border:0;height:800px;" class="fb-like-box" data-href="https://www.facebook.com/?sk=h_chr" data-width="900" data-height="800" data-show-faces="false" data-stream="true" data-header="false">
        </div>
    </div>

     <?
            
            break;
        
        
        
        case "pp":
            
            
            
            include("modulo/pp" . $lang . ".php");
            
            break;
        
        case "fp":
            // echo "Hola";
            // exit;
            include("modulo/fp" . $lang . ".php");
            
            break;
        
        case "edd":
            
            include("modulo/edd" . $lang . ".php");
            
            break;
        
        case "fpa":
            
            include("modulo/fpa" . $lang . ".php");
            
            break;
        
        case "al":
            
            include("modulo/al" . $lang . ".php");
            
            break;
        
        case "eddal":
            
            include("modulo/eddal" . $lang . ".php");
            
            break;
        
        case "ahora":
            
            include("modulo/now.php");
            
            break;

        case "twitter":
            
            include("modulo/twitter.php");
            
            break;
        
        case "instagram":
            include("modulo/instagram.php");
            break;
        case "usuarios":
            
            include("modulo/usuarios.php");
            
            break;
        
        
        
        case "temporal":
            
?>

     <div align="center">Estamos trabajando en la actualizacion a la nueva version de la api Facebook 2.1, estaremos denuevo disponibles a la brevedad, se enviará un email a todos los miembros.</div>



     <?
            
            break;
            
    }
    
?>

</div>



</div>

<script type="text/javascript" src="sc.js"></script>



<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<!-- Place this tag after the last +1 button tag. -->

<!-- <script type="text/javascript">

  window.___gcfg = {lang: 'es'};



  (function() {

    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;

    po.src = 'https://apis.google.com/js/plusone.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);

  })();

</script> -->

</body>

</html>

<?
    
}