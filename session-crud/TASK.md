# TASK

Per a practicar l’ús de sessions i l’upload de fitxers al servidor amb CodeIgniter, afegeix a l’activitat anterior, les següents funcionalitats:

## Objetivos

### Login d’usuari

- L’usuari s’ha de poder validar a l’aplicació amb una validació bàsica (usuari = viladoms i password = JVjv2026)
- No cal guardar-ho a la BBDD però si que ho farem mínimament segur, recorda primer calcular el hash i guardar-lo en una variable $hashCalculat. 
  - `echo password_hash("JVjv2026", PASSWORD_DEFAULT);`
- I després comprovar que el password que introdueix l’usuari sigui igual al hash que has calculat fent:
  - `if(…… password_verify($passIntroduit, $hashCalculat) …均衡.`
- Si les credencials que introdueix l’usuari són correctes, es crea la sessió per a aquest usuari i es deixa passar a l’aplicació.
- Si les credencials que introdueix l’usuari no són correctes, es redirecciona l’usuari a la plana de login.
- Cal afegir la opció de tancar sessió.

### Upload foto

- En el formulari d’inserir jugadors cal afegir un camp anomenat “foto” que permeti triar una foto per a pujar-la al servidor.
- La foto s’ha de guardar amb un nom aleatori, ha de conservar la seva extensió i s’ha de moure a la carpeta “uploads” dins de “writable” del servidor web.
  - Exemple: `$foto->move(WRITEPATH.’uploads’,$nomFoto)`
- Observació: WRITEPATH és una constant que té guardada la ruta a la carpeta writable dins de CodeIgniter.
- Sovint per mostrar la foto, s’acostuma a fer un mètode en el controlador que retorna la foto utilitzant el mètode download() de l’objecte response: `$this->response->download(WRITEPATH.’uploads/’.$nomFixer,null)->inline();`
- Pots trobar l’explicació en aquest enllaç: https://codeigniter.com/user_guide/outgoing/response.html#open-file-in-browser
