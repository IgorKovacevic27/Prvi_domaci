<?php
include 'broker.php';

$broker=Broker::getBroker();
if(!isset($_POST['id'])){
    $res=[];
    $res['status']=false;
    $res['greska']="Id nije prosledjen";
    echo json_encode($res);
}else{
    $res=$broker->izvrsiIzmenu("update igrac set ime='".$_POST['ime']."', prezime='".$_POST['prezime']."', broj=".$_POST['broj'].", pozicija_id=".$_POST['pozicija'].", tim_id=".$_POST['tim']." where id=".$_POST['id']);
    echo json_encode($res);
    
}

?>