<?php
include 'broker.php';

$broker=Broker::getBroker();
if(!isset($_POST['id'])){
    $res=[];
    $res['status']=false;
    $res['greska']="Id nije prosledjen";
    echo json_encode($res);
}else{
    $res=$broker->izvrsiIzmenu('delete from igrac where id='.$_POST['id']);
    echo json_encode($res);
    
}

?>