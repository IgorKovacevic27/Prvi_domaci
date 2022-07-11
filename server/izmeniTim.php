<?php
include 'broker.php';

$broker=Broker::getBroker();
if(!isset($_POST['id'])){
    $res=[];
    $res['status']=false;
    $res['greska']="Id nije prosledjen";
    echo json_encode($res);
}else{
    $res=$broker->izvrsiIzmenu("update tim set naziv='".$_POST['naziv']."', skraceno='".$_POST['skraceno']."' where id=".$_POST['id']);
    echo json_encode($res);
    
}

?>