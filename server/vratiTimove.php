<?php
include 'broker.php';

$broker=Broker::getBroker();

$res=$broker->izvrsiCitanje('select * from tim');
echo json_encode($res);

?>