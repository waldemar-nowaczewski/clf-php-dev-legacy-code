<?php
include_once('config.php');
$link = mysqlConnect();

// user hardcoded (parametrized query used below because of assumption that it might come from $_POST variable)
$post_user = 'krzysztof_jarzyna';

// active user query
$user_query = mysqli_prepare($link, "
    SELECT CONCAT(imie, '_', nazwisko), koordynator 
    FROM clf.uzytkownicy WHERE CONCAT(imie, '_', nazwisko) = ?;
");
mysqli_stmt_bind_param($user_query, "s", $post_user);
mysqli_stmt_execute($user_query);
$user_query_result = mysqli_fetch_array(mysqli_stmt_get_result($user_query));


// all users query
$employees_query = mysqli_query($link, "
    SELECT CONCAT(imie, '_', nazwisko) AS imie_nazwisko, aktywny FROM clf.uzytkownicy;
");
while ($record = mysqli_fetch_assoc($employees_query)) {
    $pracownicy[] = [
        'imie_nazwisko' => $record['imie_nazwisko'],
        'aktywny' => $record['aktywny']
    ];
}

$user_mod = $user_query_result[0];
$dostep_koordynator = $user_query_result[1];

// Zabezpieczenia 
if(!$dostep_koordynator){$alert = 'notAllowed';}


function breadcrumb(){ ?>
    <ol class="breadcrumb">
        <li><a href="/index.php">Panel</a></li>
        <li class="active">IRP 1P</li>
    </ol>
<?php }

function alert($alert){ ?>
    <script>alert('<?= $alert ?>')</script>
<?php }

function header_section(){ ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Leads List</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<?php }



//Pracownicy-opiekunowie
$wypisz_pracownikow = '';
foreach ($pracownicy as $key => $value) {
    if($value['aktywny']){
        $wypisz_pracownikow .= '<option value="'.$key.'">'.$value['imie_nazwisko'].'</option>';
    }
}

// Podpowiedzi kolejnych tygodni 
$wypisz_tygodnie = "";
$ten_tydzien_poniedzialek = strtotime('last Monday',strtotime('tomorrow'));
$ten_tydzien_niedziela = strtotime('next Sunday',$ten_tydzien_poniedzialek);

$ttp = date('d-m',$ten_tydzien_poniedzialek);
$ttn = date('d-m',$ten_tydzien_niedziela);
$wypisz_tygodnie .= '<option value="'.$ten_tydzien_poniedzialek.'">od '.$ttp.' do '.$ttn.'</option>';

$poprzedni_poniedzialek = $ten_tydzien_poniedzialek;

for ($i = 0; $i < 9; $i++) {

    $kolejny_poniedzialek = strtotime('next Monday',$poprzedni_poniedzialek);
    $kolejna_niedziela    = strtotime('next Sunday',$kolejny_poniedzialek);
    $wypisz_tygodnie .= '<option value="'.$kolejny_poniedzialek.'">od '.date('d-m',$kolejny_poniedzialek).' do '.date('d-m',$kolejna_niedziela).'</option>';    
    $poprzedni_poniedzialek = $kolejny_poniedzialek;
}
    
 
// HTML
header_section();
//breadcrumb(); // not visible on print screens therefore I left comment there
alert('zalogowano jako ' . $user_mod); 
?>

<div class="container">
    <div class="page-header">
        <h1>IRP 1P</h1>
    </div>
    <div id="leady-0" class="grupa-leadow">
        <h2>SEGMENT I: Tylko lekcja 3 PR</h2>
        <div class="input-group" style="display: inline-block;">
            <span class="input-group-addon"><b>Przypisz zadanie 'Umówienie rozmowy' do </b></span>
            <span class="input-group-btn">
                <button class="btn btn-primary btn-add-task-to-many" data-ile="5">5 osób</button>
                <button class="btn btn-primary btn-add-task-to-many" data-ile="10">10 osób</button>
                <button class="btn btn-primary btn-add-task-to-checked">Tylko zaznaczone</button>
                <button class="btn btn-warning btn-add-task-to-many" data-ile="0">Odznacz</button>
            </span>
        </div>
        <div>
            <table class="table table-striped tabela-leadow" id="tabela-leadow-0">
                <thead>
                    <tr>
                        <th>Klient</th>
                        <th>Telefon</th>
                        <th>E-mail</th>
                        <th style="width: 60px;">Level</th>
                        <th>Nazwa produktu</th>
                        <th style="width: 50px;">zaznacz</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    
    
    <div id="leady-1" class="grupa-leadow">
        <h2>SEGMENT I: Od 4 lekcji PR + Klub</h2>
        <div class="input-group" style="display: inline-block;">
            <span class="input-group-addon"><b>Przypisz zadanie 'Umówienie rozmowy' do </b></span>
            <span class="input-group-btn">
                <button class="btn btn-primary btn-add-task-to-many" data-ile="5">5 osób</button>
                <button class="btn btn-primary btn-add-task-to-many" data-ile="10">10 osób</button>
                <button class="btn btn-primary btn-add-task-to-checked">Tylko zaznaczone</button>
                <button class="btn btn-warning btn-add-task-to-many" data-ile="0">Odznacz</button>
            </span>
        </div>
        <div>
            <table class="table table-striped tabela-leadow" id="tabela-leadow-1">
                <thead>
                    <tr>
                        <th>Klient</th>
                        <th>Telefon</th>
                        <th>E-mail</th>
                        <th style="width: 60px;">Level</th>
                        <th>Nazwa produktu</th>
                        <th style="width: 50px;">zaznacz</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Czarne tlo przetwarzam -->
<div id="czarne-tlo-przetwarzam" class="light-box" style="display: none;"><span class="glyphicon glyphicon-refresh"></span></div>

<!-- Formularz przydzielania zadania-->
<div id="czarne-tlo-przydziel-zadanie-form" class="light-box" style="display: none;">
    <div class="panel panel-info" style="width:300px;">
        <div class="panel-heading">
            <span class="panel-title">Przydziel zadanie</span>
            <div class="pull-right">
                <button class="btn btn-warning btn-xs btn-zamknij-light-box">
                    <span class="glyphicon glyphicon-remove">&times;</span>
                </button>
            </div>
        </div>
        <div class="panel-body max-500-height" >
            <form id="przydziel-zadanie-form">
                <input type="hidden" name="grupa_leadow">
                <div class="form-group">
                    <label for="edytuj-pracownika-input">Opiekun*</label>
                    <select class="form-control" id="edytuj-pracownika-input" name="opiekun">
                        <?=$wypisz_pracownikow?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edytuj-termin-input">Wybierz termin*</label>
                    <select id="edytuj-termin-input" class="form-control" name="tydzien">
                        <?=$wypisz_tygodnie?>
                    </select>                    
                </div>
                <div><!-- PRZYCISKI ZAPISZ/ANULUJ -->
                    <button type="button" class="btn btn-md btn-warning btn-zamknij-light-box">Anuluj <span class="glyphicon glyphicon-remove"></span></button>
                    <button type="submit" class="btn btn-md btn-success pull-right">Zapisz <span class="glyphicon glyphicon-ok"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

<script type="text/javascript">
window.onload = function()
{

    // ZAZNACZ WIELE LEADOW I WYŚWIETL FORMULARZ
    $(document).on('click','.btn-add-task-to-many',function(e)
    {
        var leadsGroup = $(this).parents('.grupa-leadow');
        var leadsQuantity = $(this).data().ile;
        $('input[type="checkbox"]', leadsGroup).slice(0, leadsQuantity).prop('checked', true);
        if (leadsQuantity == 0) {
            $('input[type="checkbox"]', leadsGroup).prop('checked', false);
        }
    });
    
    $(document).on('click','.btn-zamknij-light-box',function(e)
    {
        $('#czarne-tlo-przydziel-zadanie-form').hide();
    });

    //ładne formatowanie tabeli
    $('.tabela-leadow').DataTable({
        "retrieve": true,
        "order": [],
        "iDisplayLength": 25,
        "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Polish.json"},
        fnDrawCallback: function(){
            // fnGetNodes was throwing errors - commented - it is animation, not necessary for table to work
            /* $("[data-toggle='tooltip']",this.fnGetNodes()).tooltip({"delay": 0,"track": true,"fade": 250}); */
        }
    });
    
    // WYŚWIETL FORMULARZ TYLKO DLA ZAZNACZONYCH
    $(document).on('click','.btn-add-task-to-checked',function(e)
    {
        e.preventDefault();
        var grupa_leadow = $(this).parents('.grupa-leadow');
        var zaznaczone = $('input[data-klient-id]:checked',grupa_leadow);
        var len = zaznaczone.length;
        if(len){
            $('#czarne-tlo-przydziel-zadanie-form').show();
            $('#czarne-tlo-przydziel-zadanie-form input[name="grupa_leadow"]').val($(grupa_leadow).attr('id'));
        }
        else{
            bootbox.alert('Zaznacz przynajmniej jednego leada.');
            return false;
        }
    });


    $(document).on('submit','#przydziel-zadanie-form',function(e)
    {
        e.preventDefault();
       
        var czy_pusta = $('#edytuj-termin-input').val().trim()==='' || $('#edytuj-pracownika-input').val().trim()==='';
        if(czy_pusta){
            bootbox.alert("Uzupełnij wszystkie wymagane pola.");
            return false;
        }
        
        var tydzien= $('#edytuj-termin-input').val();
        var pracownik= $('#edytuj-pracownika-input').val();
        var grupa_leadow = $('#'+$('#czarne-tlo-przydziel-zadanie-form input[name="grupa_leadow"]').val());
        var zaznaczone  = $('input[data-klient-id]:checked',grupa_leadow);
        var len = zaznaczone.length;
        var ids = [];
        for ( var i = 0; i < len; i++ ) {
          ids.push( $(zaznaczone[i]).attr('data-klient-id'));
        }
        if(len){
            $.ajax({
                url: "zadania/zadania_PrzydzielTygodnioweAjax.php",
                method: "POST",
                data: {
                    user:'<?=$user_mod?>',
                    tydzien:tydzien,
                    pracownik:pracownik,
                    ids:ids,
                    typ_zadania:106
                },
                dataType: "json",
                beforeSend: function(){
                    /* pokazPrzetwarzam(); */ // function was undefined, it is commented to eliminate JS bugs
                }
            })
            .success(function(data){
                if(data.status === 'success'){
                    $('input[data-klient-id]:checked',grupa_leadow).prop('checked',false);
                    bootbox.alert("Przypisano nowe zadania sprzedawcom.");
                    for (var i = 0; i < ids.length; i++) {
                        $('#klient-'+ids[i]+'-row').addClass('danger').hide('slow');
                    }
                }
                else if(data.status === 'error'){
                    bootbox.alert('Błąd: '+data.message);
                }
                else{bootbox.alert("Nie udało się wykonać żądania. Błąd: "+data.message);}
            })
            .fail(function(){bootbox.alert("Nie udało się wysłać żądania.");})
            .complete(function(){$('#czarne-tlo-przydziel-zadanie-form,#czarne-tlo-przetwarzam').hide();});
        }
        else{
            bootbox.alert('Zaznacz przynajmniej jednego leada.');
            return false;
        }
    });
    

    $(document).ready(pokaz_leady());
    
};



function  pokaz_leady(){
    $.ajax({
        url: "irpLeadsListAAjax.php",
        method: "POST",
        data: {user:'<?=$user_mod?>'},
        dataType: "json",
        beforeSend: function(){
            /* pokazPrzetwarzam(); */ // function was undefined, it is commented to eliminate JS bugs
        }
    })
    .success(function(data){
        if(data.status === 'success')
        {
            for (var i = 0, max = 2; i < max; i++)
            {
                table = $('#tabela-leadow-'+i).DataTable();
                table.clear();
                $.each(data.dane[i], function(i,v)
                {
                    if(typeof v.telefon === 'undefined' || v.telefon === null){v.telefon='';}
                    var d1 = v.telefon.replace(/\D/mg, "");
                    var d2 = ((d1.length === 11 || d1.length === 12) && d1.indexOf("48")===0) ? d1.substr(2) : d1;
                    var d3 = ((d2.length === 10) && d2.indexOf("0")===0) ? d2.substr(1) : d2;
                    var d4 = (d3.length === 9 ) ? d3.replace(/^(\d{3})(\d{3})(\d{3})$/, '$1 $2 $3') : v.telefon;
                    var level = v.level === 'klient' ? '<span class="label label-primary">KLIENT</span>' : '<span class="label label-success">UCZESTNIK</span>';                
                    var rowNode = table.row.add( [
                        '<a href="/klientKarta&id='+v.klient_id+'" target="_blank" rel="noopener noreferer">'+v.klient+'&nbsp;<small><span class="glyphicon glyphicon-new-window"></span></small></a>', 
                        d4,
                        v.email,
                        level,
                        v.nazwa_produktu,
                        '<input data-klient-id="'+v.klient_id+'" type="checkbox">'
                    ] 
                    ).node();
                    $(rowNode).attr('id','klient-'+v.klient_id+'-row');
                    //$('td:eq(4),td:eq(5)',rowNode).addClass( 'text-center'); // was working only for first table - align moved to CSS
                });
                table.draw();
            }
        }
        else if(data.status === 'error')
        {bootbox.alert('Błąd: '+data.message);}
        else
        {bootbox.alert("Nie udało się wykonać żądania. Błąd: "+data.message);}
    })
    .fail(function(){bootbox.alert("Nie udało się wysłać żądania.");})
    .complete(function(){$('#czarne-tlo-przetwarzam').hide();});
};


<?php mysqli_close($link); ?>

</script>
</html>