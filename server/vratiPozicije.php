<?php
include 'broker.php';

$broker=Broker::getBroker();

$res=$broker->izvrsiCitanje('select * from pozicija');
echo json_encode($res);

?>