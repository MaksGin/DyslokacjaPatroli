<a name="readme-top"></a>

<details>
  <summary>Spis treści</summary>
  <ol>
    <li>
      <a href="#o-projekcie">O projekcie</a>
      <ul>
        <li><a href="#funkcje">Funkcje</a></li>
      </ul>
        <ul>
        <li><a href="#Technologie">Technologie</a></li>
      </ul>
    </li>
    <li><a href="#Ustawienia">Ustawienia</a></li>
    <li><a href="#Instrukcja-instalacji">Instrukcja instalacji</a></li>
    <li><a href="#Wnioski">Wnioski</a></li> <!-- I corrected the spelling here -->
  </ol>
</details>


## O projekcie 

Na praktykach miałem okazję pracować nad projektem - aplikacją Dyslokacji Patroli. To projekt, który stanowi rozwinięcie i ulepszenie wcześniejszej wersji aplikacji, która została mi przedstawiona na początku mojego stażu. Moim głównym zadaniem było stworzenie nowej, bardziej zaawansowanej wersji tej aplikacji, skupiając się zwłaszcza na wzmacnianiu jej zabezpieczeń. W tym celu zdecydowałem się wykorzystać paczkę Spatie Laravel Permission. 

### Proces tworzenia
Podczas tworzenia aplikacji miałem cały czas kontakt z osoba która pracowała na starej wersji aplikacji, konsultowałem z nią jakie rzeczy warto dodać i czy interfejs który stworzyłem jest intuicyjny. Dążyłem do stworzenia aplikacji, która będzie nie tylko technicznie zaawansowana, ale przede wszystkim praktyczna i użyteczna. W tym celu aktywnie konsultowałem się z pracownikami, którzy mieli być ostatecznymi użytkownikami aplikacji. Dzięki ich wskazówkom i feedbackowi byłem w stanie dostosować funkcjonalności i interfejs użytkownika do ich potrzeb i przyzwyczajeń.

Pracując blisko z przyszłymi użytkownikami aplikacji, zdobyłem wgląd w ich codzienne zwyczaje pracy oraz to, jakie rozwiązania są dla nich najbardziej intuicyjne. To pomogło mi stworzyć interfejs użytkownika, który jest zgodny z ich przyzwyczajeniami, co z kolei przekłada się na wygodę obsługi aplikacji.



### Funkcje



### Technologie

Projekt stworzony jest za pomocą:
* Bootstrap v5.3.0
* PHP 8.2.4
* Laravel Framework 8.83.27
* spatie/laravel-permission v3.17


<p align="right">(<a href="#readme-top">wróć na góre</a>)</p>

## Ustawienia
- PHP (wersja >= 8.2.4)
- composer


### Instrukcja instalacji: 
1. Sklonuj repozytorium w swoim środowisku lokalnym
   
   Zacznij od sklonowania tego repozytorium na komputer lokalny za pomocą następującego polecenia:
   
```
$ git clone https://github.com/MaksGin/DyslokacjaPatroli.git
$ cd folder-name
```

2. Zainstaluj zależności (użyj composera, aby zainstalować zależności php)
   
```
composer install
```

3. Utwórz plik .env i skopiuj do niego całą zawartość pliku env.example

Zaktualizuj plik w odpowiednie ustawienia, takie jak dane do bazy danych, klucze API itp. Link do dokumentacji:  https://laravel.com/docs/10.x/configuration#introduction

4 .Wygeneruj klucz aplikacji:

```
php artisan key:generate
```

5. Uruchom migracje i dane początkowe: wykonaj migracje baz danych i zainicjuj przykładowe dane.

```
php artisan migrate
php artisan db:seed --class=PermissionTableSeeder 
php artisan db:seed
```

6. Wystartuj serwer.
   
```
php artisan serve
```

7. Otwórz przeglądarke i pod adresem:
   http://localhost:8000 będziesz mógł korzystać z aplikacji.

  

### Wnioski

Kluczowym celem tego projektu było stworzenie narzędzia, które pozwala na efektywne zarządzanie dyslokacjami patroli. W ramach tego projektu podjąłem się zadania zaprojektowania i zaimplementowania nowych funkcji, które nie tylko poprawią efektywność pracy pracowników którzy obsługują aplikacje, ale także zwiększą bezpieczeństwo aplikacji.



