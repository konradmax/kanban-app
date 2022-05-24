Appka dziala na nastepujacym stacku:
* OS Ubuntu 22LTS
* PHP 8.1.5, PHP build-in server.
* Sqlite
* Composer
* Local development server address is [**http://localhost:8800**](http://localhost:8800).


## DB 
Aby zainstalowac wsparcie SQLITE wydaj 
* `apt-get install -y sqlite`
* `sudo apt-get install -y php8.1-sqlite`
* `phpenmod sqlite3`

## Migracja i dane
Dzieje sie poprzez wydanie komendy `php ./vendor/robmorgan/phinx/bin/phinx migrate && php ./vendor/robmorgan/phinx/bin/phinx seed:run` lub `composer run-script migrate && composer run-script seed`

## Web Server
Start servera:
`php -S localhost:8800 -t ./public/` lub poprzez `composer run-script start`.


### Zwykly user:
* user: `username1`
* haslo: `lubiemaslo`
### Admin user:
* user: `admin`
* haslo: `swiezemlekotez`

### Autentifykacja
Sprawdzenie czy uzytkownik jest zalogowany jest sprawdzane w middleware 