# TASK

## Objetivo

Fes una aplicació en Code Igniter 4 que permeti treballar amb equips i jugadors de la base de dades DDaw que s’inclou juntament amb aquest enunciat. (archivo init.sql)

És obligatori treballar com a mínim amb 1 controlador, tots els mètodes han d’estar mapejats a una ruta, tots els formularis s’han de fer amb validació de dades.

És obligatori crear un Model per a cada taula de la base de dades, i executar totes les operacions amb la base de dades a través del Model.

## Implementación

Per a implementar-ho segueix les següents indicacions:
Fes una plana (vista) inicial que ofereixi les següents opcions:

1. Inserir Equip —> a través d’un formulari (amb validació) demana les dades d’un equip i utilitzant el model, el guarda a la base de dades
2. Mostrar Equips —> Mostra tots els equips de la base de dades
3. Eliminar Equip —> Mostra tots els equips de la base de dades i a partir de botons de tipus radio permet eliminar-ne un. (Recorda que per a mantenir la integritat referencial, quan s’elimina un equip, també cal eliminar tots els
jugadors d’aquell equip)
4. Inserir jugador —> a través d’un formulari (amb validació) demana les dades d’un jugador i utilitzant el model, el guarda a la base de dades. (L’atribut equip ha de ser un SELECT d’HTML i només ha de permetre triar equips que hi hagi a la base de dades)
5. Mostrar Jugadors —> Mostra tots els jugadors de la base de dades
6. Eliminar Jugador —> Mostra tots els jugadors de la base de dades i a partir de botons de tipus radio, permet eliminar-ne un.
7. Sense model —> Fes una consulta a la base de dades sense utilitzar el model, a partir de les funcions “Raw Query”
