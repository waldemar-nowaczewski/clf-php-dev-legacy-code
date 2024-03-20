# PHP_Developer_Legacy_Code


## Kontekst biznesowy
Proces sprzedażowy produktu 'IRP' rozpoczyna się od wyłonienia z bazy klientów, potencjalnie zainteresowanych (leadów). Muszą oni spełniać warunki dostarczone przez Dział Sprzedaży, z uwzględnieniem listy wykluczeń.

Lista leadów ( irpLeadsListA.php ) wyświetla dwie tabele, w której znajdują się leady podzielone na dwa segmenty:
- klienci, którzy są obecnie na 3 lekcji PR
- klienci, którzy są obecnie na lekcji dalszej niż 3

Pojedyncza tabela wyświetla imię i nazwisko, telefon, email oraz level klienta.

Dane do tabel pobierane są z pliku irpLeadsListAAjax.php, w którym znajduje się zapytanie SQL budowane według zlecenia Działu Sprzedaży

Na Liście leadów, można zaznaczyć konkretnego klienta (checkbox), a następnie przydzielić mu `zadanie` przypisane do konkretnego Sprzedawcy, poprzez kliknięcie przycisku "zaznaczonych". Przycisk ten powoduje wyświetlenie formularza `Przydziel zadanie`.


## Twoje zadania
- Dział Sprzedaży utworzył nowy proces sprzedażowy `MagMark` i powiązaną z nim `szansę sprzedaży` (id_procesu = 62 ). Ten proces należy uwzględnić w wykluczeniach Listy leadów. Dokładniej: Klient nie może mieć `otwartej` `szansy sprzedazy` na proces `MagMark`. Nie może mieć również `przegranej` `szansy sprzedazy` na proces `MagMark` w przeciągu ostatniego miesiąca.

- Dział Sprzedaży potrzebuje dodatkowej informacji, na której Lekcji PR znajduje się obecnie klient. Dodaj kolumnę z nazwą produktu.

- Dział Sprzedaży zauważył, że w zależności od skuteczności Sprzedawcy, zazwyczaj przydzielają jednemu sprzedawcy albo 5, albo 10 leadów. Dodaj możliwość szybkiego zaznaczenia 5 lub 10 pierwszych leadów w tabeli i wyświetlenia dla nich formularza `Przydziel zadanie`. Uwzględnij też możliwość szybkiego odznaczenia wszystkich leadów. Uzupełnij kod w irpLeadsListA.php, od wiersza 150 lub zaproponuj swoje rozwiązanie.
