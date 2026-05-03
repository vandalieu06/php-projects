# ACTIVIDAD 7 

## Exercici 1
Implementeu una plana en php que tingui un comptador de visites, és a dir,
cada vegada que es carrega la plana s’incrementa el número. El número s’ha
de guardar en un fitxer de text (comptador.txt)

## Exercici 2
Mitjançant un formulari implementeu una plana de comentaris (a mode de
llibre de visites), que permeti introduir dades a qualsevol visitant i veure les
dades anteriorment introduïdes pels altres visitants.
En el formulari s’han de demanar les següents dades:
- Nom (caixa de text)
- Cognoms (caixa de text)
- Correu (caixa de text)
- Foto (tipus file)
- Opinió (textarea de 5 files)
Quan un visitant entri a la plana, li apareixeran els comentaris que han entrat
els usuaris anteriors (juntament amb la seva imatge), i al final li apareixerà el
formulari per poder posar els seus comentaris

### Observació:
- Només pot existir un fitxer .php, i un fitxer .txt (dades.txt) on es guarden les 
dades de cada visitant.
- El format del fitxer dades.txt ha de ser:Nom;Cognoms; Correu;Foto;Opinio\n
- Les fotos s’han de guardar en una subcarpeta anomenada imatges i per a què no hi hagi 
solapament de nom, s’han d’anomenar com el correu de l’usuari.
- A l’hora de mostrar les dades cal implementar 2 funcions que llegeixin les dades 
de fitxer, una utilitzant fopen(...) i l’altre utilitzant file(...)

## Exercici 3
Afegiu a l’exercici 2, el comptador de visites que heu creat en l’exercici 1.
→ Només cal entregar 1 fitxer que inclogui els exercicis 2 i 3