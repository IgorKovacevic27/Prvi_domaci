<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timovi</title>

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
        <div class='row mt-2'>
            <div class='col-8'>
                <div class='container' id='timovi'>


                </div>
            </div>
            <div class='col-4'>
                <h2>Kreiraj tim</h2>
                <form>
                    <label>Naziv</label>
                    <input class="form-control" type="text" id='naziv'>
                    <label>Skraceni naziv</label>
                    <input class="form-control" type="text" id='skraceno'>
                    <button class="btn btn-primary form-control mt-2" id='dugmeKreiraj'>Kreiraj</button>
                </form>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        let timovi = [];

        function setTimovi(val) {
            timovi = val;
            $('#timovi').html('');
            for (let tim of timovi) {
                $('#timovi').append(`
                    <div class='row mt-2 border'>
                        <div class='col-8 mt-3 '>
                            ${tim.naziv} - ${tim.skraceno}
                        </div>
                        <div class='col-2'>
                            <a href='tim.php?id=${tim.id}'>
                                <button class='btn btn-success mt-2 mb-2'>Izmeni</button>
                            </a>
                            
                        </div>
                        <div class='col-2'>
                            <button class='btn btn-danger mt-2 mb-2' onClick="obrisiTim(${tim.id})">Obrisi</button>
                            </div>
                    <div>
                `)
            }
        }

        $(document).ready(function () {
            ucitajTimove();
            $('#dugmeKreiraj').click(e => {
                e.preventDefault();
                const naziv = $('#naziv').val();
                const skraceno = $('#skraceno').val();
                $.post('server/kreirajTim.php', {
                    naziv, skraceno
                }).then(res => {
                    console.log(res);
                    ucitajTimove();
                })
            })

        })
        function ucitajTimove() {
            $.getJSON('server/vratiTimove.php').then(function (res) {
                if (!res.status) {
                    $('#timovi').html(`
                        <h1>${res.greska}</h1>
                    `);
                    return;
                }
                setTimovi(res.podaci);
            })
        }
        function obrisiTim(id) {
            if (!id || isNaN(Number(id))) {
                return;
            }
            $.post('server/obrisiTim.php', { id }).then(res => {
                res = JSON.parse(res);
                console.log(res);
                if (res.status) {
                    setTimovi(timovi.filter(element => element.id != id));
                }

            })
        }
    </script>
</body>

</html>