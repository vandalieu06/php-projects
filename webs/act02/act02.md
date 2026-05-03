# 3. Funcions en PHP

## Exercici 1

Creeu una funció que dibuixi una taula en HTML.  
Aquesta funció ha de rebre 2 paràmetres que siguin la quantitat de files i columnes de la taula.  
Cal posar text en cada una de les cel·les.

## Exercici 2

Busqueu per què serveix la funció `str_word_count(...)` i poseu un exemple on es vegi el seu funcionament.  

👉 Podeu trobar ajuda a [php.net](http://php.net/manual/en/function.str-word-count.php)

## Exercici 3

Busqueu per què serveix la funció `levenshtein(...)` i poseu un exemple on es vegi el seu funcionament.

## Exercici 4

Busqueu què és l’**operador ternari** de PHP i poseu un exemple on es vegi el seu ús.

## Exercici 5

Utilitzeu la funció `strcmp(...)` per comparar 2 paraules i demostreu el seu funcionament.

## Exercici 6

Demostreu el funcionament del **pas de variables per referència**.

## Exercici 7

Tot i que encara no sabem treballar amb arrays en PHP, expliqueu què creieu que fa aquest bloc de codi:

```php
function funcioMultiplesReturns($v1,$v2,$v3){
    $v1="variable1";
    $v2="variable2";
    $v3="variable3";
    return array($v1,$v2,$v3);
}
```

## Exercici 8

Creeu la funció comprova_email(...) que rep una cadena de caràcters que conté una adreça de correu electrònic, i li fa les següents comprovacions:

- La converteix a minúscules
- Li elimina tots els espais en blanc
- Comprova si té el caràcter @
- Compta el número de caràcters

Finalment, si la mida és menor de 75 caràcters i conté l’@, l’adreça és vàlida i per tant ha de retornar un TRUE, sinó ha de retornar un FALSE.

## Exercici 9

A l’exercici anterior afegiu-li un nou control sobre l’adreça de correu mitjançant la funció checkdnsrr(...), que donat el domini d’una adreça de correu, permet veure si aquest domini existeix o no.

```php
if (checkdnsrr("nom_de_domini","MX")){
    echo "Aquest domini existeix";
}else{
    echo "Aquest domini inventat No existeix";
}

```

## Exercici 10

Poseu la funció anterior en un fitxer anomenat funcions.php i proveu el funcionament de la funció include(..).

## Excercici 11

Exercici 11

Existeixen moltes funcions per treballar amb dates, proveu:

- Què fa la funció time(...)?
- Proveu el funcionament de la funció date(...) sabent que li podeu passar el format.

Les opcions més interessants de format són:

- Y = any
- F = Mes en format text
- m = mes en format numèric
- M = Mes en text abreviat
- l = dia de la setmana en text
- d = dia numèric del mes
- G = hora del dia format 24h
- i = minut de l’hora
