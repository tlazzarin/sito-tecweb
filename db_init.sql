CREATE USER IF NOT EXISTS 'tlazzari'@'%' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON *.* TO 'tlazzari'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Creato il: Dic 07, 2024 alle 11:32
-- Versione del server: 10.6.7-MariaDB-1:10.6.7+maria~focal
-- Versione PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tlazzari`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `CARATTERISTICA`
--

CREATE TABLE `CARATTERISTICA` (
  `nome` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `descrizione` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `CARATTERISTICA_PERCORSO`
--

CREATE TABLE `CARATTERISTICA_PERCORSO` (
  `caratteristica` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `percorso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `IMMAGINI`
--

CREATE TABLE `IMMAGINI` (
  `id_immagine` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alt` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PERCORSO`
--

CREATE TABLE `PERCORSO` (
  `id` int(11) NOT NULL,
  `titolo` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `sottotitolo` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `indicazioni` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_gpx` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dislivello_salita` smallint(6) NOT NULL DEFAULT 0,
  `dislivello_discesa` smallint(6) NOT NULL DEFAULT 0,
  `lunghezza` float UNSIGNED NOT NULL DEFAULT 0,
  `tag_title` text COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tag_description` text COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tag_keywords` text COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dump dei dati per la tabella `PERCORSO`
--

INSERT INTO `PERCORSO` (`id`, `titolo`, `sottotitolo`, `descrizione`, `indicazioni`, `file_gpx`, `dislivello_salita`, `dislivello_discesa`, `lunghezza`, `tag_title`, `tag_description`, `tag_keywords`) VALUES
(1, 'Tra malghe e boschi della Lessinia', 'Immergiti nei boschi e nei prati della Lessinia in questa incantevole passeggiata autunnale', 'Questo <em>percorso ad anello</em>abbastanza semplice, attraversa i paesaggi suggestivi della Lessinia. Passa per l''incantevole <em>Valle delle Sfingi</em>, chiamata così per le particolari formazioni rocciose chiamate appunto \"sfingi\". Lungo il percorso si attraversano malghe ed alpeggi che hanno ancora più fascino in autunno, durante il <span lang=\"fr\">foliage</span>. \r\nIl sentiero presenta alcuni tratti in salita facilmente affrontabili anche da persone non allenate.', 'Si parte dal <em>Parcheggio di Camposilvano</em> e si prosegue in direzione nord attraversando il paese. Dopo aver oltrepassato il <em>Campeggio Composilvano</em>, prendere il <em>sentiero</em> sterrato sulla destra. Attraversare la Valle delle Sfingi e poi seguire le indicazioni per il \"Rifugio Lausen\". Una volta raggiunta la fine della strada, girare a sinistra e raggiungere l''alpeggio. Proseguire il sentiero andando verso Est fino ad arrivare alla Malga Sergio Rosso Alta. Da qui seguire le indicazioni per \"<em>Croce del Gal</em>\" e scendere verso Sud. Riprendere la strada sterrata e proseguire fino al Museo Geopantologico.', '1_ValleSfingiLessinia.gpx', 290, 290, 7.1, 'Valle delle Sfingi', 'Percorso ad anello semplice in Lessinia che attraversa la Valle delle Sfingi, le malghe e gli alpeggi, ideale da visitare durante il foliage.', 'Valle delle Sfingi,Lessinia,foliage,sentiero,Camposilvano,malghe,percorso'),
(2, 'Passeggiata nei boschi da Corvara a La Villa (Alta Badia)', 'Immergiti nel bosco in una passeggiata semplice e adatta a tutti', 'Questo <em>percorso pianeggiante</em> si immerge nei boschi della Val Badia e segue principalmente una strada sterrata, ben battuta e larga. Lungo la passeggiata avrai modo di poter riposare in numerose panchine tipiche del luogo e di rilassarti sentendo il rumore del <em>torrente</em> che affianca la strada. Alla fine, anche i più piccoli potranno svagarsi al <em>parco giochi</em> e i più grandi potranno ammirare il punto d''arrivo della pista \"<em>Gran Risa</em>\" che ospita la Coppa del Mondo di sci alpino.', 'Si parte dalla fermata dell''<em>autobus</em> (\"Strada Col Alt\";) di <em>Corvara</em> in Badia, si prosegue verso nord seguendo il marciapiede. Dopo circa 700m si attraversa la strada tramite un sottopassaggio e si prosegue mantenendo la strada sterrata fino al punto d''arrivo.', '2_CorvaraLaVilla.gpx', 0, 105, 3.5, 'Da Corvara a La Villa', 'Percorso pianeggiante e adatto a tutti nel bosco da Corvara a La Villa, in Val Badia', 'Corvara,La Villa,Alta Badia,Gran Risa,semplice,bambini,parco giochi,autobus'),
(3, 'Escursione tra le Cascate di Fanes vicino a Cortina d''Ampezzo', 'Un canyon incantevole circondato da cascate maestose', 'Questo <em>percorso impegnativo</em>, <em>in parte ad anello</em>, si immerge nella Val di Fanes situata a nord di Cortina d''Ampezzo. La valle è caratterizzata da un profondo <em lang=\"en\">canyon</em> scavato dal torrente Boite e dal Rio di Fanes ammirabile nel <em>punto panoramico</em> \"Ponte sulla Cascata\" raggiungibile tramite un sentiero sterrato. Le numerose e impetuose <em>cascate</em> sono ammirabili da vicino tramite un sentiero circolare abbastanza difficile con alcuni <em>tratti esposti</em>. ', 'Si parte dal <em>parcheggio a pagamento Sant''Uberto</em> e si prosegue lungo il sentiero sterrato verso Sud-Ovest seguendo il sentiero 10 fino a raggiungere il Ponte della Cascata del torrente Boite. Da qui si prosegue prendendo il sentiero delle cascate che si snoda inizialmente immerso nel bosco e poi seguendo il fianco della montagna. Una volta raggiunta l''ultima cascata \"Cascata Sbarco di Fanes\" si è conclusa la prima parte dell''anello e si ritorna al punto di partenza proseguendo nuovamente per la strada sterrata.', '3_CascateDiFanes.gpx', 670, 670, 9.1, 'Cascate di Fanes', 'Escursione panoramica tra il canyon e le scascate della Val di Fanes, vicino a Cortina', 'Cascate di Fanes,Val di Fanes,Cortina,cascate,panorama,canyon,sentiero'),
(4, 'Il Parco dei Cervi e il Lago Sompunt', 'Ammira da vicino gli animali in questa passeggiata per i più piccoli', 'Questa <em>breve passeggiata</em> adatta ai bambini affianca il <em>Parco Cervi Sompunt</em> dove si possono vedere, anche da vicino, molti esemplari di cervi e di daini. Il percorso fino al <em>Lago Sompunt</em> è accessibile con il <em>passeggino</em> da <span lang=\"en\">trekking</span>, ma per fare il giro è necessario proseguire a piedi. Dal lago sarà possibile avere un bellissimo scorcio sul massiccio di Sas dla Crusc.', 'Si parte dal parcheggio libero “Sponata” a <em>Badia</em> (BZ), si prosegue verso ovest seguendo il sentiero in direzione “Parco dei Cervi”. Si affianca la staccionata fino ad arrivare alla strada, proseguire per un tornante fino ad arrivare al Lago. Al ritorno segui la strada in asfalto per 700m e poi prendi il sentiero sulla sinistra fino a raggiungere il parcheggio.', '4_LechDeSompunt.gpx', 95, 95, 2.1, 'Parco dei Cervi e Lago Sompunt', 'Percorso panoramico adatto ai bambini tra il Parco dei Cervi e il Lago Sompunt a Badia (BZ)', 'Badia,Parco Cervi Sompunt, Lago Sompunt,lago,passeggiata,passeggino,bambini'),
(5, 'Passeggiata alle Cascate del Pisciadù da Colfosco in Val Badia', 'Un percorso semplice in una valle circondata da montagne', 'Questo <em>percorso ad anello</em> si sviluppa nella valle di <em>Colfosco</em>, sotto il <em>Passo Gardena</em>. La passeggiata è affrontabile con passeggini o sedie a rotelle (preferibilmente motorizzate) in quanto si sviluppa su asfalto o strada sterrata ben battuta. Vicino alle cascate è presente un’<em>area attrezzata</em> con tavoli per <em lang=\"en\">picnic</em>, servizi igienici e acqua potabile. ', 'Si parte dalla fermata dell''autobus ("Strada Col Pradat") a <em>Colfosco</em>. Si prosegue seguendo il marciapiede per 900m fino al Parcheggio della funivia Sodlisia. Da qui si segue il percorso su strada sterrata verso sud-ovest seguendo le indicazioni per “Cascate del Pisciadù”. Per ritornare al paese si prosegue sempre su strada forestale, costeggiando il torrente seguendo le indicazioni per “Colfosco” del percorso “Tru dles Cascades” fino al Bistro La Scola dove è presente anche un parco giochi e un parco avventura. Poi si prosegue verso nord seguendo la strada asfaltata. ', '5_CascateDelPisciadu.gpx', 130, 130, 4.7, 'Le cascate del Pisciadù a Colfosco', 'Percorso per tutti alle Cascate del Pisciadù a Colfosco', 'Colfosco,Cascate del Pisciadù,cascate,Passo Gardena,semplice,picnic'),
(6, 'A strapiombo sul Lago di Garda dal Rifugio Altissimo “Damiano Chiesa”', 'Un percorso spettacolare con vista a 360° sul Lago di Garda e le montagne trentine', 'Questo <em>percorso</em> è abbastanza impegnativo per il dislivello medio ma il sentiero è semplice e affrontabile da tutti con un minimo di allenamento. Durante tutta la camminata si potrà ammirare da varie prospettive il <em>Lago di Garda</em>, i monti della Lessinia e una parte delle Dolomiti.', 'Si parte dal <em>Rifugio Graziani a Brentonico</em> (TN) e si prosegue per la strada sterrata in direzione nord-ovest seguendo le indicazioni per il <em>Rifugio Altissimo “Damiano Chiesa”</em>. Una volta arrivati è possibile proseguire per qualche metro per raggiungere altri punti panoramici. Il ritorno è previsto per la stessa strada.', '6_RifugioMonteAltissimo.gpx', 460, 460, 5.3, 'Rifugio “Damiano Chiesa” del Monte Altissimo', 'Percorso impegnativo dal Rifugio Graziani al Rifugio “Damiano Chiesa” con vista sul Lago di Garda', 'Rifugio Altissimo,Rifugio Damiano Chiesa,Monte Altissimo,Lago di Garda'),
(7, 'L''iconica vetta del Monte Seceda', 'Uno dei luoghi più caratteristici e panoramici delle Dolomiti', 'Questo <em>percorso</em> permette di visitare la famosa e molto fotografata vetta del <em>Seceda</em>. Questa è l''alternativa per non utilizzare la seggiovia. La salita e il sole accompagnano tutto il sentiero quindi è necessario essere allenati e preparati per proteggersi. La fatica verrà ripagata dall''incantevole <em>paesaggio</em> diventato molto famoso nei <span lang=\"en\">social</span>.', 'Si parte dal <em>parcheggio</em> \"Cristauta\" a Santa Cristina Valgardena (BZ). Si prosegue seguendo il "<em>sentiero degli scoiattoli</em>" fino al Rifugio Gamsblut. Si prosegue a nord fino alla Malga Nëidia. Da qui si continua seguendo il sentiero a destra che segue la cresta della montagna fino a raggiungere la vetta. Da qui si ritorna alle malghe seguendo la strada sterrata e poi si torna al parcheggio con lo stesso sentiero dell''andata.', '7_seceda.gpx', 770, 770, 12.8, 'Il monte Seceda', 'Uno dei trekking più iconici nelle dolomiti', 'Monte Seceda,percorso,parcheggio,sentiero,scoiattoli,Dolomiti'),
(8, 'La malga Geisleralm con vista sul massiccio delle Odle', 'Un percorso impegnativo per ammirare uno dei paesaggi più belli delle Dolomiti', 'Questo <em>percorso ad anello</em> parte dal Paese di <em>Santa Maddalena</em>, famoso per la Chiesetta di San Giovanni in Ranui <em>fotografata</em> molte volte e presente in molti <span lang=\"en\">puzzle</en>. La passeggiata è da considerare medio-difficile in quanto il dislivello è impegnativo anche se le strade percorse sono ben segnate e facili. Se si ha fortuna, sarà possibile ammirare da vicino gli animali selvatici del bosco come scoiattoli e cervi. Una volta arrivati alla <em>Malga Geisleralm</em> ci si può rilassare sul prato ammirando il meraviglioso panorama sul Massiccio delle <em>Odle</em>.', 'Si parte dal parcheggio \"Parkplatz\" a <em>Santa Maddalena</em> (BZ). Si prosegue verso Sud seguendo la strada forestale a destra del bivio per 1,5km. Una volta arrivati al ponte si prosegue a destra per proseguire nel <em>sentiero</em> in mezzo al bosco per 1km. Una volta terminato proseguire verso Est e seguire le indicazioni per \"Geisleralm\". Per tornare al punto di partenza continuare sulla strada forestale che affianca il torrente e seguire le indicazioni per il parcheggio: si prosegue per 2,8km prima verso Est e poi verso Sud. Al bivio si prosegue verso sinistra per tornare al parcheggio.', '8_Geisleralm.gpx', 630, 630, 10.3, 'La malga Geisleralm', 'Un bellissimo trekking per ammirare le Odle da vicino', 'Malga Geisleralm,Santa Maddalena,Odle,sentiero,panorama,Dolomiti');

-- --------------------------------------------------------

--
-- Struttura della tabella `RECENSIONE`
--

CREATE TABLE `RECENSIONE` (
  `utente` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `percorso` int(6) NOT NULL,
  `voto` int(1) NOT NULL CHECK (`voto` between 0 and 5),
  `testo` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `UTENTE`
--

CREATE TABLE `UTENTE` (
  `username` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` char(128) COLLATE utf8mb3_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `CARATTERISTICA`
--
ALTER TABLE `CARATTERISTICA`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `CARATTERISTICA_PERCORSO`
--
ALTER TABLE `CARATTERISTICA_PERCORSO`
  ADD PRIMARY KEY (`caratteristica`,`percorso`),
  ADD KEY `percorso` (`percorso`);

--
-- Indici per le tabelle `IMMAGINI`
--
ALTER TABLE `IMMAGINI`
  ADD PRIMARY KEY (`id_immagine`);

--
-- Indici per le tabelle `PERCORSO`
--
ALTER TABLE `PERCORSO`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titolo` (`titolo`) USING HASH;

--
-- Indici per le tabelle `RECENSIONE`
--
ALTER TABLE `RECENSIONE`
  ADD PRIMARY KEY (`utente`,`percorso`),
  ADD KEY `percorso` (`percorso`);

--
-- Indici per le tabelle `UTENTE`
--
ALTER TABLE `UTENTE`
  ADD PRIMARY KEY (`username`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `CARATTERISTICA_PERCORSO`
--
ALTER TABLE `CARATTERISTICA_PERCORSO`
  ADD CONSTRAINT `CARATTERISTICA_PERCORSO_ibfk_1` FOREIGN KEY (`caratteristica`) REFERENCES `CARATTERISTICA` (`nome`),
  ADD CONSTRAINT `CARATTERISTICA_PERCORSO_ibfk_2` FOREIGN KEY (`percorso`) REFERENCES `PERCORSO` (`id`);

--
-- Limiti per la tabella `RECENSIONE`
--
ALTER TABLE `RECENSIONE`
  ADD CONSTRAINT `RECENSIONE_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `UTENTE` (`username`),
  ADD CONSTRAINT `RECENSIONE_ibfk_2` FOREIGN KEY (`percorso`) REFERENCES `PERCORSO` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
