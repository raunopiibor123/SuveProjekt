# Roheline Energia
# SuveProjekt Praktika

## Eesmärk  
Põhieesmärk: Klientidele luua veebileht, kus peal saab ta arvutada haridusasutuse elektritarbimist aasta/kuu/nädala/päeva lõikes.

## Kirjeldus  
Klient saab ennast registreerida veebilehel ja sisse logida. Sisestada CSV(failis tuleb ära kustutada esimesed 5 rida, et faili esimene rida oleksid andmed) faili ning veebileht töötleb sisestatud faili ära. Kasutajale kuvatakse diagrammid, kust ta saab vaadata elektritarbimist ning olenevalt diagrammist saab ta ka muuta vahemikke. 

## Liikmed
* Krister Riska
* Rauno Piibor
* Rasmus Kello
* Elinor Roosalu
* Hendrik Heinsar

## Kasutatud Tehnoloogiad
* Jquery
* Highcharts
* Bootstrap

## Ekraanitõmmis  
![Kuvatõmmis_Raportitest.PNG](/Kuvatõmmis_Raportitest.PNG)

## Mysql Tabel
![mysql_tabel.PNG](/mysql_tabel.PNG)

CREATE TABLE IF NOT EXISTS 'schools'(
	'id' int(11) NOT NULL,
	'school_name' varchar(100) NOT NULL
	)ENGINE=InnoDB AUTO_INVREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS 'users' (
	'id' int(7) NOT NULL
	'email' varchar(100) NOT NULL,
	'password' varchar(128= NOT NULL,
	'school' int(11) NOT NULL,
	'created' timestamp NOT NULL DEFAULT current_timestamp()
	)ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

## Info
Webpage is about usage of electricity and how to be more environmentally friendly.

Log in page and sign up page are seperated

Sign up page:
1. Company name
2. E-mail
3. Password

Log in page:
1. E-mail
2. Password

First page is log in page. From log in page you can go to sign up page where is possible to register an account.
After logging in you can watch your previous raports or create a new one. If client wants to create new raport then he must upload CSV file which consists of electricity usage data. After uploading you can watch diagramms of the electricity usage.

## Deadlines

23.03.18 log in and sign up pages

30.03.18 questions template

 * @license  [https://opensource.org/licenses/MIT] [MIT]
