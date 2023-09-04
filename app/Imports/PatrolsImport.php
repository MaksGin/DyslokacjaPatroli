<?php

namespace App\Imports;

use App\Models\Patrol;
use Maatwebsite\Excel\Concerns\ToModel;

class PatrolsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Patrol([
            'krypt' => $row['Kryptonim'],
            'rodzaj_patrolu' => $row['Rodzaj patrolu'],
            'forma_pelni_slużby' => $row['Forma pełnienia służby'],
            'dysponujacy_system_dowodzenia' => $row['Dysponujący System Dowodzenia'],
            'odpowiedzialnosc_dysponujaca' => $row['Odpowiedzialność dysponująca'],
            'jednostka_wystawiajaca' => $row['Jednostka wystawiająca'],
            'wystawiajacy_system_dowodzenia' => $row['Wystawiający System Dowodzenia'],
            'planowany_czas_poczatku_sluzby' => $row['Planowany czas początku służby'],
            'planowany_czas_konca_sluzby' => $row['Planowany czas końca służby'],
            'sklad' => $row['Skład'],
            'flota' => $row['Flota'],
            'sektory' => $row['Sektory'],
            'rejon' => $row['Rejony'],
            'trasy' => $row['Trasy'],
            'rejony_patrolowe' => $row['Rejony patrolowe'],
            'id_sledzonego_urzadzenia_mobilnego' => $row['Id śledzonego urządzenia mobilnego'],
            'status' => $row['Status'],
            'czas_w_statusie' => $row['Czas w statusie'],
            'uruchomiony' => $row['Uruchomiony'],
            'zwolniony' => $row['Zwolniony'],
            'odprawa' => $row['Odprawa'],
            'zakonczony' => $row['Zakończony'],
            'ilosc_funkcjonariuszy' => $row['Ilość funkcjonariuszy'],
            'wyposazenie' => $row['Wyposażenie'],
            'id_kadrowy_odprawiajacego_patrol' => $row['Id kadrowy odprawiającego patrol'],
            'id_urzadzen_mobilnych_nr_tel_terminala' => $row['Id urządzeń mobilnych / nr tel. terminala'],
            'id_kadrowe_funkcjonariuszy_pionu_kryminalnego' => $row['Id kadrowe funkcjonariuszy pionu kryminalnego'],
            'id_kamer_nasobnych' => $row['Id kamer nasobnych'],
            'liczba_kamer' => $row['Liczba kamer'],
            'charakterystyka_obszaru' => $row['Charakterystyka obszaru'],
            'zapoznanie_z_zadanimi' => $row['Zapoznanie z zadanimi'],
        ]);
    }
}
