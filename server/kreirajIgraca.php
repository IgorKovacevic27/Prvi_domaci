<?php
include 'broker.php';

$broker=Broker::getBroker();

    $res=$broker->izvrsiIzmenu("insert into igrac (ime,prezime,broj,tim_id,pozicija_id) values ('".$_POST['ime']."','".$_POST['prezime']."',".$_POST['broj'].",".$_POST['tim'].",".$_POST['pozicija'].")");
    echo json_encode($res);
    


?>