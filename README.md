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

Na praktykach miałem okazję pracować nad projektem aplikacji Dyslokacji Patroli. To projekt, który stanowi rozwinięcie i ulepszenie wcześniejszej wersji aplikacji, która została mi przedstawiona na początku moich praktyk. Moim głównym zadaniem było stworzenie nowej, bardziej zaawansowanej wersji tej aplikacji, skupiając się zwłaszcza na wzmacnianiu jej zabezpieczeń. W tym celu zdecydowałem się wykorzystać paczkę Spatie Laravel Permission. 

### Proces tworzenia

Podczas tworzenia aplikacji miałem cały czas kontakt z osoba która pracowała na starej wersji aplikacji, konsultowałem z nią jakie rzeczy warto dodać i czy interfejs który stworzyłem jest intuicyjny. Dążyłem do stworzenia aplikacji, która będzie nie tylko technicznie zaawansowana, ale przede wszystkim praktyczna i użyteczna. W tym celu aktywnie konsultowałem się z pracownikami, którzy mieli być ostatecznymi użytkownikami aplikacji. Dzięki ich wskazówkom i feedbackowi byłem w stanie dostosować funkcjonalności i interfejs użytkownika do ich potrzeb i przyzwyczajeń.

Pracując blisko z przyszłymi użytkownikami aplikacji, zdobyłem wgląd w ich codzienne zwyczaje pracy oraz to, jakie rozwiązania są dla nich najbardziej intuicyjne. To pomogło mi stworzyć interfejs użytkownika, który jest zgodny z ich przyzwyczajeniami, co z kolei przekłada się na wygodę obsługi aplikacji.



### Funkcje

Aplikacja oferuje różne funkcjonalności dla trzech rodzajów użytkowników: administratora, komendanta i koordynatora. Poniżej główne funkcje dostępne w aplikacji:

#### Dla administratora

Pełna Kontrola -  Administrator ma dostęp do wszystkich funkcji i danych w systemie:
   -  Może wyświetlać patrole wszystkich wydziałów na dany dzień
   -  Listę patroli określoną liczbę w przód
   -  Dostęp do kryptonimów osób w patrolu
   -  Listę wszystkich rejonów i wydziałów
   -  Zarządza użytkownikami (Tworzy, usuwa, edytuje)
   -  Tworzy role i przypisuje do nich permisje

![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/f04984ea-04f1-454c-9162-634d1ae9fd3b)
     

#### Dla Komendanta

Po zalogowaniu się do aplikacji, komendant ma możliwość przeglądania listy wszystkich wydziałów, listy rejonów oraz ma również możliwość przegladania patroli w wybranych dniu i określoną liczbę dni w przyszłość:

##### Widok po zalogowaniu

![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/4d423cd1-0d4e-4f03-927e-5aaccc5a4760)


Wpisuje liczbę dni do przodu i wyświetlają się patrole ze wszystkich działów:

![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/5917a9a2-fb9f-454f-9f18-4a93f92dda8d)



#### Dla Koordynatora

Koordynator danego wydziału może tworzyć patrole tylko dla swojego wydziału, ma możliwość importu patroli z pliku CSV oraz pobrania istniejacych patroli do formatu PDF.

![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/faa3ede2-997c-4e0c-897a-604f90cf616d)


Na stronie patroli wyświetla się tyle wydziałów do ilu jest przypisany użytkownik, również w formularzu dodawania patroli ma wybór wsród swoich wydziałów.

Formularz dodawnia posiada funkcje autocomplete dla rejonów i kryptonimów, użytkownik może dodać nową opcję lub wybrać istniejącą z podpowiedzi:

![DodawaniePatrolu](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/37cea2b0-384b-4d1d-bccd-d682ae57ded3)


![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/067e6d38-16dc-48a2-9300-a36abdc891d2)


Oczywiście dzięki paczce spatie laravel permission można łatwo dostosować permisje użytkownika i zmienić jego zakres działań w zależności od potrzeb.

Panel użytkowników:

![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/2116d293-91c7-482f-817e-df8cab4d32fa)


Panel Ról i permisji:
![image](https://github.com/MaksGin/DyslokacjaPatroli/assets/26302413/e119d34d-b66d-46a3-ac02-5421eb517e3c)

Po dodaniu roli do użytkownika odrazu zostaje od przypisany do wydziału który odpowiada danej roli.

Paczka Spatie Laravel Permission cechuje się prostotą konfiguracji, można w łatwy sposób definiować role i permisje dla użytkownika, bazuje na modelu RBAC który jest powszechnie stosowany
w projektach związanych z bezpieczeństwem. 

Posiada wsparcie dla middleware czyli kontrole dostępu do różnych części aplikacji na podstawie uprawnień. Paczka posiada dobra dokumentację co jeszcze bardziej zwiększa łatwość 
wprowadzenia do aplikacji. 

### Technologie

Projekt stworzony jest za pomocą:
* Bootstrap v5.3.0
* PHP 8.2.4
* Laravel Framework 8.83.27
* RBAC - spatie/laravel-permission v3.17


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



