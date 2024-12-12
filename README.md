# Sito tecweb
## Impostazione e uso dell'ambiente su Docker
### Impostazione
1. Installare Docker desktop (non è necessario effettuare il login per utilizzarlo)
2. Installare su VS Code l'estensione di Docker
### Avvio
Questo comando crea l'ambiente in docker: crea un volume virtuale, inizializza un web server e un database (utilizza il file db_init.sql per la creazione e la popolazione delle tabelle)
1. Effettuare il clone della repo
2. Fare tasto destro sul file "compose.yaml" e premere "docker compose up" (è necessario aver aperto l'applicazione Docker)
### Chiusura / cancellazione in locale dell'ambiente 
- Per chiudere l'ambiente (e quindi il web server locale) fare tasto destro sul file "compose.yaml" e premere "docker compose down" 
- Per cancellare tutti i dati locali (eventualmente per fare una nuova inizializzazione dopo aver modificato il file di configurazione db_init.sql) aprire l'applicazione Docker, nel menu a sinistra premere su Volumes e cancellare quello nominato sito-tecweb
 
## Sviluppo software
### Visualizzare PHPMYADMIN
1. Visitare localhost:8080
2. Inserire username `tlazzari` e la password `pass`
### Visualizzare il sito
1. Visitare localhost
2. Viene aperta la pagina index.html contenuta nella cartella src
