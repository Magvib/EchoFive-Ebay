# EchoFive-Ebay
## Laravel app med (mysql database)
### Her har vi dashboardet hvor man kan se product-databasen i tabel form.
![Pic1](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/1.PNG)
### Her kan man se at når man clicker på "buy" knappen så står der sold.
![Pic2](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/2.PNG)
### Og det du har købt kan du se inde på din profil.
![Pic3](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/3.PNG)
### Her har vi admin panelet, hvor man kan slette brugere, slætte produkter, uploade produkter til databasen (mysql), Slætte beskeder og Sende beskeder
![Pic4](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/4.PNG)
![Pic5](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/5.PNG)
![Pic6](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/6.PNG)
### Her kan man slette beskeder og Sende beskeder globale beskeder som alle bruger kan se.
![Pic7](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/7.PNG)
![Pic8](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/8.PNG)
### På denne bruger er man ikke admin så man kan ikke komme ind på admin panelet, og man kan også se den globale besked som jeg sendte.
![Pic9](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/9.PNG)
### Her har vi brugerens profil og han kan også slætte sin profil som sender ham ud til forsiden.
![Pic10](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/10.PNG)
![Pic11](https://github.com/Magvib/EchoFive-Ebay/blob/master/pic/11.PNG)

### Instalation
```
git clone https://github.com/Magvib/EchoFive
```
Så skal du have composer.
[Composer](https://getcomposer.org/).
Derefter skal du have en mysql database og apache. Jeg bruger Laragon til det.
[Laragon](https://laragon.org/). Nu skal du kopier .env.example til .env og i den fil skal du skrive din database informationer.
```
DB_CONNECTION=mysql
DB_HOST= "ip"
DB_PORT= "port"
DB_DATABASE= "database navn"
DB_USERNAME= "brugernavn"
DB_PASSWORD= "adgangskode"
```
```
php artisan migrate
```
Jeg bruger et plugin som hedder [Voyager](https://github.com/the-control-group/voyager). Så derfor skal man også lige skrive dette ind i terminalen.
```
composer require tcg/voyager
```
```
php artisan voyager:install
```
Så skal du ind på hjemmesiden og lave en konto, derefter kan du skrive komandoen her og give dig selv admin.
```
php artisan voyager:admin "your@email.com"
```
