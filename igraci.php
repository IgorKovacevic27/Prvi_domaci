<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Igraci</title>

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
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Tim</th>
                            <th>Broj</th>
                            <th>Pozicija</th>
                        </tr>
                    </thead>
                    <tbody id='igraci'></tbody>
                </table>
            </div>
            <div class='col-4'>
                <form>
                    <label>Ime</label>
                    <input class="form-control" type="text" id='ime'>
                    <label>Prezime</label>
                    <input class="form-control" type="text" id='prezime'>
                    <label>Broj</label>
                    <input class="form-control" type="number" id='broj'>
                    <label>Tim</label>
                    <select class="form-control" id="tim">

                    </select>
                    <label>Pozicija</label>
                    <select class="form-control" id="pozicija">

                    </select>
                    <button class="btn btn-primary mt-2 form-control" id='kreirajDugme'>Kreiraj</button>
                    <button hidden class="btn btn-success mt-2 form-control" id='izmeniDugme'>Izmeni</button>
                    <button hidden class="btn btn-danger mt-2 form-control" id='obrisiDugme'>Obrisi</button>
                </form>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        let timovi = [];
        let pozicije = [];
        let igraci = [];
        let selIndex = -1;

        $(document).ready(function () {
            $.getJSON('server/vratiTimove.php').then(function (res) {
                if (!res.status) {
                    $('#timovi').html(`
                        <option value='0'>${res.greska}</option>
                    `);
                    return;
                }
                setTimovi(res.podaci);

            })
            $.getJSON('server/vratiPozicije.php').then(function (res) {
                if (!res.status) {
                    $('#pozicija').html(`
                        <option value='0'>${res.greska}</option>
                    `);
                    return;
                }
                setPozicije(res.podaci);

            })
            ucitajIgrace();

            $('#obrisiDugme').click((e) => {
                e.preventDefault();
                console.log('click');
                console.log(selIndex);
                if (selIndex === -1) {
                    return;
                }
                $.post('server/obrisiIgraca.php', { id: igraci[selIndex].id }).then(res => {

                    res = JSON.parse(res);
                    if (!res.status) {
                        return;
                    }

                    const igrac = igraci[selIndex];
                    setSelIndex(-1);
                    setIgraci(igraci.filter(element => element !== igrac));
                })
            })
            $('#izmeniDugme').click(e => {
                e.preventDefault();
                console.log('izmeni')
                const id = igraci[selIndex].id;
                const ime = $('#ime').val();
                const prezime = $('#prezime').val();
                const broj = $('#broj').val();
                const tim = $('#tim').val();
                const pozicija = $('#pozicija').val();
                const igrac = {
                    id,
                    ime,
                    prezime,
                    tim,
                    broj,
                    pozicija
                }
                $.post('server/izmeniIgraca.php', igrac).then(res => {
                    res = JSON.parse(res);
                    console.log(res)
                    if (!res.status) {
                        return;
                    }
                    igrac.tim_naziv = timovi.find(t => t.id === tim);
                    if (!igrac.tim_naziv) {
                        igrac.tim_naziv = 'nema';
                    } else {
                        igrac.tim_naziv = igrac.tim_naziv.naziv;
                    }

                    igrac.pozicija_naziv = pozicije.find(p => p.id === pozicija).naziv;
                    setIgraci(igraci.map(element => {
                        if (element.id === id) {
                            return igrac;
                        }
                        return element;
                    }))
                    setSelIndex(-1);
                })
            })
            $('#kreirajDugme').click(e => {
                e.preventDefault();
                const ime = $('#ime').val();
                const prezime = $('#prezime').val();
                const broj = $('#broj').val();
                const tim = $('#tim').val();
                const pozicija = $('#pozicija').val();
                const telo = {

                    ime,
                    prezime,
                    tim,
                    broj,
                    pozicija
                }
                $.post('server/kreirajIgraca.php', telo).then((res) => {

                    ucitajIgrace();
                });
            })
        })

        function ucitajIgrace() {
            $.getJSON('server/vratiIgrace.php').then(function (res) {

                if (!res.status) {
                    $('#igraci').html(`
                       
                    `);
                    return;
                }
                setIgraci(res.podaci);

            })
        }
        function setTimovi(val) {
            timovi = val;
            $('#timovi').html('');
            for (let tim of timovi) {
                $('#tim').append(`
                   <option value='${tim.id}'>${tim.naziv}</option>
                `)
            }
        }


        function setPozicije(val) {
            pozicije = val;
            $('#pozicije').html('');
            for (let pozicija of pozicije) {
                $('#pozicija').append(`
           <option value='${pozicija.id}'>${pozicija.naziv}</option>
        `)
            }
        }

        function setIgraci(val) {
            igraci = val;
            $('#igraci').html('');
            let index = 0;
            for (let igrac of igraci) {
                $('#igraci').append(`
                <tr onClick="selRed(${index})" >
                    <td>${igrac.id}</td>
                        <td>${igrac.ime}</td>
                        <td>${igrac.prezime}</td>
                        <td>${igrac.tim_naziv ? igrac.tim_naziv : 'nema'}</td>
                        
                        <td>${igrac.broj}</td>
                        <td>${igrac.pozicija_naziv}</td>
                </tr>

                `)
                index++;
            }
        }
        function selRed(index) {
            index = Number(index);

            for (let i = 0; i < $('#igraci').children().length; i++) {

                const row = $('#igraci').children()[i];
                if (i === index && row.className === 'table-secondary') {
                    row.className = '';
                    setSelIndex(-1);
                    break;
                }
                if (i !== index || row.className === 'table-secondary') {
                    row.className = '';
                    continue;
                }
                row.className = 'table-secondary'
                setSelIndex(index)

            }

        }

        function setSelIndex(val) {
            selIndex = val;
            const igrac = (selIndex === -1) ? undefined : igraci[selIndex];
            $('#kreirajDugme').attr('hidden', val !== -1);
            $('#izmeniDugme').attr('hidden', val === -1);
            $('#obrisiDugme').attr('hidden', val === -1);
            $('#ime').val(igrac ? igrac.ime : '');
            $('#prezime').val(igrac ? igrac.prezime : '');
            $('#broj').val(igrac ? igrac.broj : 0);
            $('#tim').val(igrac ? igrac.tim_id : 0);
            $('#pozicija').val(igrac ? igrac.pozicija_id : 0);
        }
    </script>
</body>

</html>