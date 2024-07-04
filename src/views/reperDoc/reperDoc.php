<link rel="stylesheet" href="reperDoc.css">
<?php

require_once ("../../required/head.php");
if($_SESSION["usuario"]== "Asier"){
    $link ="https://docs.google.com/document/d/17vJDg8iyZM9suMwrY9tZgjweHnJ3GrNjRFt99_EhoUI/edit?usp=sharing";
}else if($_SESSION["usuario"]== "Benat"){
    $link ="https://docs.google.com/document/d/17vJDg8iyZM9suMwrY9tZgjweHnJ3GrNjRFt99_EhoUI/edit?usp=sharing";
}
?>
<br>
<center>
    <a class="aH1" href="<?=$link?>"><h1>Repertorio Documento</h1></a>
<br><br>
<?php
if($_SESSION["usuario"]== "Asier"){
    ?>
    <iframe class="repertorioDoc" src="<?=$link?>"></iframe>
    <?php
}else if($_SESSION["usuario"]== "Benat"){
    ?>
    <iframe class="repertorioDoc" src="<?=$link?>"></iframe>
    <?php
}
?>
</center>
<br><br>
<?php

require_once ("../../required/footer.php");
?>