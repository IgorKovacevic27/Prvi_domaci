<?php
include 'broker.php';

$broker=Broker::getBroker();

    $res=$broker->izvrsiIzmenu("insert into tim (naziv,skraceno) values ('".$_POST['naziv']."' ,'".$_POST['skraceno']."')");
    echo json_encode($res);
    


?>