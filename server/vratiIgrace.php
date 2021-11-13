<?php
include 'broker.php';

$broker=Broker::getBroker();

$res=$broker->izvrsiCitanje("select i.*, p.naziv as 'pozicija_naziv', t.naziv as 'tim_naziv' from igrac i inner join pozicija p on (p.id=i.pozicija_id) left join tim t on (t.id=i.tim_id)");
echo json_encode($res);

?>