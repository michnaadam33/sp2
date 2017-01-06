# System do zarządzania wydatkami
## Studio projektowe 2
Adam Michna  
Aplikacja REST API do systemu zarządzania wydatkami.  


* System pozwalający zapisywać wydatki grupy osób. 
* Wydatki możliwe w różnych walutach.
* Każdy wprowadzony wydatek może być podzielony na osobę z grupy po równo lub w odpowiednich proporcjach. 
* W wyniku dostajemy ilość nadpłaty oraz niedopłaty na jedną osobę. 
* Do wydatków dopisywany jest ich czas.
* Wydatki można edytować usuwać. 
* Do wydatków dodana jest lokalizacja.
* Poprzez dodanie odpowiedniego argumentu w funkcji API dostajemy czas wykonywania skryptu.  
* Front end responsywny. Wersja dla urządzeń mobilnych pozwala na tworzenie jednego rekordu jednocześnie. Wersja desktopowa pozwala na tworzenie wielu rekordów na jednym widoku. 
* Każda grupa posiada 8 znakowy klucz identyfikujący

[Dokumentacja](documentation.md)

## Serwer produkcyjny
Proszę dodać wpis do pliku /etc/hosts
```
91.134.134.121   michna.sp2.dev
```
Serwer dostępny pod adresem: http://michna.sp2.dev

## Instalacja

* `git clone git clone git@bitbucket.org:adam_michna33/sp2.git`
* `cd sp2/`
* Zainstaluj composer
* `php composer.phar install`
* `php bin/console server:run`
* Aplikacja jest dostępna pod adresem "http://127.0.0.1:8000/"

W razie problemów aplikacja jest dostępna na serwerze autora. 
