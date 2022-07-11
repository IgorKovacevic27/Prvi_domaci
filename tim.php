<?php
    
    if(!isset($_GET['id'])){
        header('Location index.php');
    }
    include 'server/broker.php';
    $broker=Broker::getBroker();
    $res=$broker->izvrsiCitanje('select * from tim where id='.$_GET['id']);
    if(!$res['status'] || count($res['podaci'])==0){
        header('Location index.php');
    }else{
        $tim=$res['podaci'][0];
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim</title>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class='container'>
        <h1>Izmeni tim</h1>
        <div class="row mt-2">
            <div class="col-6 ">
                <form>
                    <label>ID</label>
                    <input type="text" class='form-control' id='idTima' disabled value='<?php echo $tim->id;?>'>
                    <label for="naziv">Naziv</label>
                    <input type="text" class='form-control' id='naziv' value='<?php echo $tim->naziv;?>'>
                    <label for="skraceno">Skraceni naziv</label>
                    <input type="text" class='form-control' id='skraceno' value='<?php echo $tim->skraceno;?>'>
                    <button class="btn btn-success form-control mt-2" id='izmeniDugme'>Izmeni</button>
                </form>
            </div>
        </div>
        <div class="row mt-2" id='igraciDiv'>
            <div class="col-12">
                <h1>Igraci</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Broj</th>
                            <th>Pozicija</th>
                        </tr>
                    </thead>
                    <tbody id='igraci'>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        let igraci = [];

        function setIgraci(val) {
            igraci = val;
            $('#igraci').html('');
            for (let igrac of igraci) {
                $('#igraci').append(`
                <tr>
                    <td>${igrac.id}</td>
                        <td>${igrac.ime}</td>
                        <td>${igrac.prezime}</td>
                        <td>${igrac.broj}</td>
                        <td>${igrac.pozicija_naziv}</td>
                </tr>
        `)
            }
        }

        $(document).ready(function () {
            $.getJSON('server/vratiIgrace.php').then(function (res) {
                if (!res.status) {
                    $('#igraciDiv').html(`
                <h1>${res.greska}</h1>
            `);
                    return;
                }
                console.log(res.podaci);
                const id = $('#idTima').val();
                console.log(id);
                setIgraci(res.podaci.filter(element => element.tim_id == id));
            })
            $('#izmeniDugme').click(e => {
                e.preventDefault();
                const id = $('#idTima').val();
                const naziv = $('#naziv').val();
                const skraceno = $('#skraceno').val();
                const telo = {
                    id, naziv, skraceno
                }
                console.log(telo);
                $.post('server/izmeniTim.php', telo).then(res => {
                   res=JSON.parse(res);
                    if (res.status) {
                        alert('uspeh');
                    }else{
                        alert(res.greska);
                    }
                })
            })
        })
    </script>
</body>

</html>