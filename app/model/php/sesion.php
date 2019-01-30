<?php
    session_start();
    $ses = json_encode($_SESSION);
    echo $ses;
?>
