# Activitat 3.1

## Exercici 1:

Implementa en PHP la classe Vehicle i les seves classes derivades, en concret:

[x] a. Crea la classe Vehicle amb les propietats (marca, model, potencia, cilindrada, consum) i les funcions de set() i get() per cada un dels atributs. A més ha de disposar de la funció calculaImpostCirculacio(...) i la funció mostraDades(...).

[x] b. Crea la classe Cotxe que hereti de Vehicle, i alhora afegeix les propietats (numPortes, numPlaces, tipusCarburant). Has de saber que l’impost de circulació d’un cotxe es calcula aplicant-li un coeficient de 0,04 a la cilindrada.

[x] c. Crea la classe Camio que hereti de Vehicle, i alhora afegeix les propietats (pesTara, pesCarrega). Has de saber que el coeficient d’un camió és de 0,08.

[x] d. Crea la classe Moto que hereti de Vehicle, i alhora afegeix les propietats (tipusMoto, numPlaces). Has de saber que el coeficient d’una moto és de 0,03.

[X] e. Totes les classes filles de Vehicle, han de redefinir el mètode mostraDades(...) que cridi al mostraDades(...) de la classe pare i posteriorment mostri els atributs particulars de la pròpia classe.

[x] f. Crea un script en PHP que a partir d’un formulari permeti guardar cotxes, camions i motos en un array de vehicles (que pots guardar a la variable de Sessió). L’usuari ha d’omplir el formulari del nou cotxe, del nou camió o de la nova moto, i automàticament aquest objecte s’ha de guardar en l’array de vehicles.

[x] g. Quan l’usuari vulgui, pot prémer el botó Veure Vehicles, i ha de mostrar les dades de tots els vehicles que hi ha a l’array identificant si es tracta d’un Cotxe, un Camió o una Moto. També s’han de mostrar alhora les dades de l’impost de circulació de cada vehicle.

---

## Exercici 2:

Afegeix a l’exercici anterior l’ús d’interfícies, en concret has de fer:

[X] a. Crear la interfície quatreXquatre, que incorpora un mètode anomenat activa4x4(), que mostra el consum del vehicle quan s’activa el 4x4.

→ En un cotxe, el coeficient és de 1.8x el consum normal i en un camió és de 2x cops el consum normal. La classe moto no pot implementar aquesta interfície.

[x] b. Mostra les dades dels vehicles de l’array amb el consum normal i amb el 4x4 activat.

---

## Exercici 3

Afegeix a les classes Vehicle, Cotxe, Camió i Moto de l’exercici anterior les següents funcionalitats:

[] a. La classe vehicle ha de tenir un mètode abstracte anomenat insertVehicle() que al ser implementat en les seves classes filles, permeti inserir aquell vehicle a la base de dades.

→ Per a provar el funcionament, caldrà afegir un botó en la plana principal, que al ser clickat, recorri tot l’array de vehicles i els pugi un a un, a la taula corresponent de la base de dades

[] b. La classe vehicle ha de tenir un mètode anomenat selectVehicles($tipus) (que segurament hauràs de ser static) que retorni un array amb tots els vehicles trobats a la base de dades d’aquell tipus de vehicle.

→ Per a provar el funcionament, caldrà afegir un botó en la plana principal que permeti seleccionar un tipus de vehicle i mostri el resultat per pantalla.

[ ] c. La classe vehicle ha de tenir un mètode anomenat deleteVehicles($tipus) (que segurament haurà de ser static) que elimini tots els vehicles d’aquell tipus de la base de dades.

→ Per a provar el funcionament, caldrà afegir un botó en la plana principal que permeti triar un tipus de vehicle i els elimini.

---

## Observacions:

- Totes les connexions, querys a executar i resultats a mostrar amb la base de dades, s’han de fer utilitzant POO.
- Cal fer servir la base de dades proporcionada pel professor (creada a classe)
- Recorda que existeix l’operador instanceof que permet saber si un objecte és o no d’una classe concreta.
