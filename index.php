<?php

include_once('config.php');
$link = mysqlConnect();

$message = '
    Brak tabeli użytkownicy: kliknij, aby utworzyć 
    <a href="/fixtures.php" rel="noopener noreferer" target="_blank">Załaduj dane do DB</a>
' ;

$query = mysqli_query($link, "DESC uzytkownicy;") or die($message);
$record = mysqli_fetch_assoc($query);

if ($query) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/irpLeadsListA.php');
}
