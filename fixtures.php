<?php

include_once('config.php');
$link = mysqlConnect();

$create_users_query = "
    CREATE TABLE IF NOT EXISTS clf.uzytkownicy (
        id INT NOT NULL AUTO_INCREMENT,
        imie VARCHAR(64) NOT NULL,
        nazwisko VARCHAR(128) NOT NULL,
        koordynator INT NOT NULL DEFAULT 0,
        aktywny VARCHAR(64) NOT NULL DEFAULT 'aktywny',
        PRIMARY KEY (id)
    );
";

$insert_users_query = "
    INSERT INTO clf.uzytkownicy (
        imie,
        nazwisko,
        koordynator
    ) VALUES 
        ('jan', 'nowak', 0),
        ('krzysztof', 'jarzyna', 1)
    ;
";

$create_customers_query = "
    CREATE TABLE IF NOT EXISTS clf.klienci (
        id INT NOT NULL AUTO_INCREMENT,
        imie VARCHAR(64) NOT NULL,
        nazwisko VARCHAR(128) NOT NULL,
        email VARCHAR(255) NOT NULL,
        telefon VARCHAR(32) NOT NULL,
        level VARCHAR(32) NOT NULL,
        status VARCHAR(16) NOT NULL DEFAULT 'nieaktywny',
        PRIMARY KEY (id)
    );
";

$insert_customers_query = "
    INSERT INTO clf.klienci (
        imie,
        nazwisko,
        email,
        telefon,
        level,
        status
    ) VALUES 
        ('adam', 'kaczmarek', 'adam@kaczmarek.pl', '123 456 789', 'uczestnik', 'aktywny'),
        ('anna', 'kowalska', 'anna@kowalska.pl', '131 353 686', 'uczestnik', 'aktywny'),
        ('anna', 'kowalska', 'anna@kowalska.pl', '131 353 686', 'uczestnik', 'aktywny'),
        ('jacek', 'michalski', 'jacek@michalski.pl', '244 453 123', 'uczestnik', 'aktywny'),
        ('tomasz', 'batorowski', 'tomasz@batorowski.pl', '531 457 786', 'uczestnik', 'aktywny'),
        ('katarzyna', 'kamińska', 'katarzyna@kaminska.pl', '342 909 788', 'uczestnik', 'aktywny'),
        ('maria', 'paczkowska', 'maria@paczkowska.pl', '454 899 087', 'uczestnik', 'aktywny'),
        ('krystyna', 'radko', 'krystyna@radko.pl', '854 878 445', 'uczestnik', 'aktywny'),
        ('michał', 'jankowski', 'michal@jankowski.pl', '565 677 677', 'uczestnik', 'aktywny'),
        ('marian', 'bykowski', 'marian@bykowski.pl', '998 897 557', 'uczestnik', 'aktywny'),
        ('bronisław', 'maj', 'bronislaw@maj.pl', '346 788 899', 'uczestnik', 'aktywny'),
        ('antoni', 'czerwiński', 'antoni@czerwinski.pl', '776 224 899', 'uczestnik', 'aktywny'),
        ('mieczysław', 'albiński', 'mieczyslaw@albinski.pl', '868 866 444', 'uczestnik', 'aktywny'),
        ('natalia', 'kleczewska', 'natalia@kleczewska.pl', '765 788 999', 'uczestnik', 'aktywny'),
        ('magdalena', 'mirowska', 'magdalena@mirowska.pl', '223 885 565', 'uczestnik', 'aktywny'),
        ('stefan', 'lubański', 'stefan@lubanski.pl', '788 900 777', 'uczestnik', 'aktywny'),
        ('jarosław', 'polak', 'jaroslaw@polak.pl', '885 787 656', 'uczestnik', 'aktywny'),
        ('albert', 'mirkowski', 'albert@mirkowski.pl', '588 007 788', 'uczestnik', 'aktywny'),
        ('robert', 'matkowski', 'robert@matkowski.pl', '677 799 996', 'uczestnik', 'aktywny'),
        ('robert', 'matkowski', 'robert@matkowski.pl', '677 799 996', 'uczestnik', 'aktywny'),
        ('alojzy', 'rajewski', 'alojzy@rajewski.pl', '452 774 477', 'uczestnik', 'aktywny'),
        ('radosław', 'kierzkowski', 'radoslaw@kierzkowski.pl', '343 888 455', 'uczestnik', 'aktywny'),
        ('adam', 'nowacki', 'adam@nowacki.pl', '664 688 655', 'uczestnik', 'aktywny'),
        ('marek', 'biernacki', 'marek@biernacki.pl', '969 546 773', 'uczestnik', 'aktywny')
    ;
";

$create_customers_duplicates_query = "
    CREATE TABLE IF NOT EXISTS clf.klienci_duplikaty (
        id INT NOT NULL AUTO_INCREMENT,
        klient1_id INT NOT NULL,
        klient2_id INT NOT NULL,
        czy_duplikat INT NOT NULL,
        PRIMARY KEY (id)
    );
";

$insert_customers_duplicates_query = "
    INSERT INTO clf.klienci_duplikaty (
        klient1_id,
        klient2_id,
        czy_duplikat
        ) VALUES 
            (2, 3, 1),
            (19, 20, 1)
        ;
    ";

// To create table with uppercase letters add "lower_case_table_names=2" to mysql configuration
$create_sale_processess_query = "
    CREATE TABLE IF NOT EXISTS clf.`procesySprzedazy` (
        id_procesu INT NOT NULL, -- there might be auto_increment
        nazwa_procesu VARCHAR(128) NOT NULL,
        typ_procesu VARCHAR(16) NOT NULL, -- there should be dictionary table for process_type - that would make DB less normalized
        PRIMARY KEY (id_procesu)
    );
";

$insert_sale_processess_query = "
    INSERT INTO clf.`procesySprzedazy` (
        id_procesu,
        nazwa_procesu,
        typ_procesu
    ) VALUES
        (15, 'MPK', '3M'),
        (16, 'SU', '3M'),
        (18, 'ZM', '3M'),
        (21, 'NP', '3M'),
        (23, 'UF', '3M'),
        (38, 'NP (po kwalifikacji)', '3M'),
        (54, 'MPK (po skończonym PRCLF)', '3M'),
        (55, 'FPK', '3M'),
        (62, 'MagMark', '3M'),
        (9, 'IRP - SP', 'IRP'),
        (46, 'IRP', 'IRP'),
        (48, 'IRP - 1P', 'IRP'),
        (49, 'IRP - 2P', 'IRP'),
        (51, 'IRP 1P - PR', 'IRP'),
        (52, 'IRP 2P - PR', 'IRP'),
        (61, 'IRP - 3P', 'IRP')
    ;
";

$create_sale_chances_query = "
    CREATE TABLE IF NOT EXISTS clf.`szanseSprzedazy` (
        id INT NOT NULL AUTO_INCREMENT,
        klient_id INT NOT NULL,
        id_procesu INT NOT NULL,
        status VARCHAR(16) NOT NULL DEFAULT 'otwarta',
        data_dodania DATETIME NOT NULL, -- might be 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP' instead of DATETIME - I was not 100% sure If this will be compatible (PHP will do it)
        data_aktualizacji DATETIME NOT NULL,
        data_zakonczenia DATETIME NOT NULL, 
        PRIMARY KEY (id)
    );
";

$timestamp = date("Y-m-d H:i:s");
$insert_sale_chances_query = "
    INSERT INTO clf.`szanseSprzedazy` (
        klient_id,
        id_procesu,
        status,
        data_dodania,
        data_aktualizacji,
        data_zakonczenia
    ) VALUES 
        (1, 15, 'otwarta', '$timestamp', '$timestamp', '$timestamp'),
        (1, 62, 'otwarta', '$timestamp', '$timestamp', '$timestamp'),
        (2, 62, 'otwarta', '$timestamp', '$timestamp', '$timestamp'),
        (1, 61, 'wygrana', '$timestamp', '$timestamp', '$timestamp'),
        (2, 61, 'otwarta', '$timestamp', '$timestamp', '$timestamp'),
        (2, 23, 'otwarta', '$timestamp', '$timestamp', '$timestamp'),
        (2, 38, 'przegrana', '$timestamp', '$timestamp', '$timestamp'),
        (3, 62, 'otwarta', '$timestamp', '$timestamp', '$timestamp')
    ;
";

$create_products_query = "
    CREATE TABLE IF NOT EXISTS clf.produkty (
        id_produktu INT NOT NULL, -- there might be auto_increment
        nazwa_produktu VARCHAR(64) NOT NULL, -- If there is need to add additional chars to it - It is intentional longer varchar
        PRIMARY KEY (id_produktu)
    );
";

$insert_products_query = "
    INSERT INTO clf.produkty (
        id_produktu,
        nazwa_produktu
    ) VALUES 
        (116, 'Program Rozwoju - Lekcja 1'),
        (117, 'Program Rozwoju - Lekcja 2'),
        (118, 'Program Rozwoju - Lekcja 3'),
        (119, 'Program Rozwoju - Lekcja 4'),
        (120, 'Program Rozwoju - Lekcja 5'),
        (121, 'Program Rozwoju - Lekcja 6'),
        (122, 'Program Rozwoju - Lekcja 7'),
        (123, 'Program Rozwoju - Lekcja 8'),
        (124, 'Program Rozwoju - Lekcja 9'),
        (125, 'Program Rozwoju - Lekcja 10'),
        (126, 'Program Rozwoju - Lekcja 11'),
        (127, 'Program Rozwoju - Lekcja 12')
    ;
";

$create_atendees_query = "
    CREATE TABLE IF NOT EXISTS clf.`uczestnicyProgramu` (
        uczestnik_id INT NOT NULL,
        klient_id INT NOT NULL,
        PRIMARY KEY (uczestnik_id)
    );
";

$insert_atendees_query = "
    INSERT INTO clf.`uczestnicyProgramu` (
        uczestnik_id,
        klient_id
    ) VALUES 
        (1, 1),
        (2, 2),
        (3, 4),
        (4, 5),
        (5, 6),
        (6, 7),
        (7, 8),
        (8, 9),
        (9, 10),
        (10, 11),
        (11, 12),
        (12, 13),
        (13, 14),
        (14, 15),
        (15, 16),
        (16, 17),
        (17, 18),
        (18, 19),
        (19, 21),
        (20, 22),
        (21, 23),
        (22, 24)
    ;
";

$create_atendees_products_query = "
    CREATE TABLE IF NOT EXISTS clf.`uczestnicyProgramuProdukty` (
        id INT NOT NULL AUTO_INCREMENT,
        produkt_id INT NOT NULL,
        uczestnik_id INT NOT NULL,
        status VARCHAR(16) NOT NULL DEFAULT 'niewyslane',
        PRIMARY KEY (id)
    );
";

$insert_atendees_products_query = "
    INSERT INTO clf.`uczestnicyProgramuProdukty` (
        produkt_id,
        uczestnik_id,
        status
    ) VALUES 
        (116, 1, 'wyslane'),
        (117, 1, 'wyslane'),
        (118, 6, 'wyslane'),
        (118, 1, 'wyslane'),
        (118, 10, 'wyslane'),
        (118, 11, 'wyslane'),
        (118, 12, 'wyslane'),
        (118, 13, 'wyslane'),
        (118, 14, 'wyslane'),
        (118, 22, 'wyslane'),
        (118, 9, 'wyslane'),
        (118, 7, 'wyslane'),
        (118, 8, 'wyslane'),
        (119, 18, 'wyslane'),
        (120, 15, 'wyslane'),
        (121, 2, 'wyslane'),
        (122, 16, 'wyslane'),
        (123, 3, 'wyslane'),
        (124, 17, 'wyslane'),
        (125, 19, 'wyslane'),
        (126, 4, 'wyslane'),
        (127, 5, 'wyslane'),
        (127, 20, 'wyslane'),
        (127, 21, 'wyslane')
    ;
";

// some empty tables for UNION queries to work
$create_tasks_query = "
    CREATE TABLE IF NOT EXISTS clf.zadania (
        id INT NOT NULL,
        klient_id INT NOT NULL,
        typ INT NOT NULL,
        status VARCHAR(16) NOT NULL DEFAULT 'nieaktywne',
        PRIMARY KEY (id)
    );
";

$create_tags_query = "
    CREATE TABLE IF NOT EXISTS clf.tagi (
        id INT NOT NULL,
        klient_id INT NOT NULL,
        `tagId` INT NOT NULL,
        PRIMARY KEY (id)
    );
";

$create_orders_query = "
    CREATE TABLE IF NOT EXISTS clf.zamowienia (
        id INT NOT NULL,
        klient_id INT NOT NULL,
        zaplacone VARCHAR(8) NOT NULL DEFAULT 'nie',
        status VARCHAR(32) NOT NULL DEFAULT 'do opłacenia',
        PRIMARY KEY (id)
    );
";

$create_invoices_query = "
    CREATE TABLE IF NOT EXISTS clf.faktury (
        id INT NOT NULL,
        id_zamowienia INT NOT NULL,
        rodzaj_faktury VARCHAR(8) NOT NULL DEFAULT 'VAT',
        data_wystawienia DATETIME NOT NULL,
        termin DATETIME NOT NULL,
        PRIMARY KEY (id)
    );
";

$queries_array = [
    'DROP DATABASE clf;',
    'CREATE DATABASE clf;',
    $create_users_query, 
    $insert_users_query, 
    $create_customers_query, 
    $insert_customers_query,
    $create_customers_duplicates_query,
    $insert_customers_duplicates_query,
    $create_sale_processess_query,
    $insert_sale_processess_query,
    $create_sale_chances_query,
    $insert_sale_chances_query,
    $create_products_query,
    $insert_products_query,
    $create_atendees_query,
    $insert_atendees_query,
    $create_atendees_products_query,
    $insert_atendees_products_query,
    $create_tasks_query,
    $create_tags_query,
    $create_orders_query,
    $create_invoices_query
];

foreach ($queries_array as $query) {
    mysqli_query($link, $query);
}

if ($query) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/irpLeadsListA.php');
}