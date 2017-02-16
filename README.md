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

## Dokumentacja
### Add group
* **URL** /group
* **Method** POST
* **URL Params** null
* **Data Params**
```
{"groupName" : "nazwa grupy","users": [{"login": "adam"},{"login":"Ewa"}, {"login":"Tomasz"}]}
```
* **Success Response:**
```
{"groupKey":90046431}
```

### Get group
* **URL** /group/{groupKey}
* **Method** GET
* **URL Params** null
* **Success Response:**
```
{"groupKey":"90046431","groupName":"nazwa grupy","users":[{"id":26,"login":"adam"},{"id":27,"login":"Ewa"},{"id":28,"login":"Tomasz"}],"creationDate":1482260913,"updateDate":1482260913}
```

### Add record
* **URL** /group/{groupKey}/record
* **Method** POST
* **URL Params** null
* **Data Params**
```
{"name" :"ciasyko i kawa ","recordedDate":{"timestamp":"timestamp"},"contentImage" : "base64","contentType": "image/jpg","coordinates":{"lat":19.115554,"lon" : 20.665998},"users":[{"id":26,"value": 2.0,"currency": "PLN","participation": 4},{"id":27,"value":12.0, "currency": "PLN","participation": 1},{"id":28,"value":12.0, "currency": "PLN","participation": 0}]} 
```
* **Success Response**
```
{"id":15,"name":"ciasyko i kawa ","coordinates":{"lat":19.115554,"lon":20.665998},"recordedDate":["timestamp"],"users":[{"id":26,"value":2,"currency":"PLN","participation":4},{"id":27,"value":12,"currency":"PLN","participation":1},{"id":28,"value":12,"currency":"PLN","participation":0}]}
```

### Delete record
* **URL** /group/{groupKey}/record/{recordId}
* **Method** DELETE
* **URL Params** null
* **Success Response**
```
{"id":"1"}
```

### Edit record
* **URL** /group/{groupKey}/record
* **Method** PUT
* **URL Params** null
* **Data Params**
```
{"id":16,"name" :"Woda ","recordedDate":{"timestamp":1428257841},"contentImage" : "base64","contentType": "image/jpg","coordinates":{"lat":19.115554,"lon" : 20.665998},"users":[{"id":26,"value": 2.0,"currency": "PLN","participation": 4},{"id":27,"value":12.0, "currency": "PLN","participation": 1},{"id":28,"value":12.0, "currency": "PLN","participation": 1}]}  
```
* **Success Response**
```
{"id":16,"name":"Woda","coordinates":{"lat":19.115554,"lon":20.665998},"recordedDate":{"timestamp":1428257841},"users":[{"id":26,"value":"2.00","currency":"PLN","participation":"4.00"},{"id":27,"value":"12.00","currency":"PLN","participation":"1.00"},{"id":28,"value":"12.00","currency":"PLN","participation":"1.00"},{"id":26,"value":2,"currency":"PLN","participation":4},{"id":27,"value":12,"currency":"PLN","participation":1},{"id":28,"value":12,"currency":"PLN","participation":1}]}
```

### Get records
* **URL** /group/{groupKey}/record
* **Method** GET
* **URL Params** 
`sort=[desc|asc]`
* **Success Response**
```
{"groupName":"nazwa grupy","records":[{"id":16,"created":{"date":"2015-04-05 20:17:21.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"updated":{"date":"2016-12-20 20:25:02.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"name":"Piwo ","lon":"20.665998","lat":"19.115554","contentImage":"base64","contentType":"image\/jpg"},{"id":15,"created":{"date":"2016-12-20 20:13:32.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"updated":{"date":"2016-12-20 20:13:32.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"name":"ciasyko i kawa ","lon":"20.665998","lat":"19.115554","contentImage":"base64","contentType":"image\/jpg"},{"id":17,"created":{"date":"2016-12-20 20:17:52.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"updated":{"date":"2016-12-20 20:17:52.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"name":"Woda ","lon":"20.665998","lat":"19.115554","contentImage":"base64","contentType":"image\/jpg"}]}
```

### Get summary
* **URL** /group/{groupKey}/summary
* **Method** GET
* **URL Params** null
* **Success Response**
```
{"groupId":14,"summaryCost":147.8,"users":{"26":{"toPay":94.82,"overpayment":0},"27":{"toPay":0,"overpayment":66.1},"28":{"toPay":0,"overpayment":28.72}}}
```

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
