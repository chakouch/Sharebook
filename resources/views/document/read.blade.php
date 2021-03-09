<?php

//Permet de garder les variables de la session
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sharebook - Ouvrage</title>
    @include('includes.navbar')
</head>

<body class="text-secondary">
    <div>
    <a href="/mydocument" class="text-dark"><i class="fa fa-undo"></i><span>Retour aux documents privés</span></a>
    </div>
    <embed src="/storage/<?php echo $file?>.pdf" style="height: 650px; width: 100%; position : relative;"/>
</body>

</html>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>