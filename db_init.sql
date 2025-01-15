CREATE USER IF NOT EXISTS 'tlazzari'@'%' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON *.* TO 'tlazzari'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Creato il: Dic 17, 2024 alle 15:06
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

--
-- Dump dei dati per la tabella `CARATTERISTICA`
--

INSERT INTO `CARATTERISTICA` (`nome`, `descrizione`) VALUES
('bambini', 'Il percorso è facilmente percorribile da bambini.'),
('escursionisti', 'Il percorso è adatto esclusivamente ad escursionisti esperti.'),
('ipovedente_cieco', 'Il percorso è percorribile da persone ipovedenti o cieche.'),
('mobilita_ridotta', 'Il percorso è accessibile da persone con mobilità ridotta.'),
('passeggini', 'Il percorso è percorribile con un passeggino.'),
('sedia_a_rotelle', 'Il percorso è accessibile da persone in sedia a rotelle.');

-- --------------------------------------------------------

--
-- Struttura della tabella `CARATTERISTICA_PERCORSO`
--

CREATE TABLE `CARATTERISTICA_PERCORSO` (
  `caratteristica` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `percorso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dump dei dati per la tabella `CARATTERISTICA_PERCORSO`
--

INSERT INTO `CARATTERISTICA_PERCORSO` (`caratteristica`, `percorso`) VALUES
('bambini', 1),
('bambini', 2),
('bambini', 4),
('bambini', 5),
('escursionisti', 3),
('escursionisti', 6),
('escursionisti', 7),
('escursionisti', 8),
('ipovedente_cieco', 2),
('ipovedente_cieco', 5),
('mobilita_ridotta', 2),
('mobilita_ridotta', 5),
('passeggini', 2),
('passeggini', 4),
('passeggini', 5),
('sedia_a_rotelle', 2),
('sedia_a_rotelle', 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `IMMAGINI`
--

CREATE TABLE `IMMAGINI` (
  `id_immagine` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alt` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dump dei dati per la tabella `IMMAGINI`
--

INSERT INTO `IMMAGINI` (`id_immagine`, `alt`) VALUES
('1_valledellesfingi/1.jpg', 'La Valle delle Sfingi, sullo sfondo le caratteristiche formazioni rocciose'),
('1_valledellesfingi/2.jpg', 'Il foliage lungo il sentiero'),
('1_valledellesfingi/3.jpg', 'Paesaggio collinare con una vecchia malga in pietra e montagne sullo sfondo'),
('1_valledellesfingi/4.jpg', 'Paesaggio con la Croce del Gal e il bosco di latifoglie autunnale'),
('2_corvaralavilla/1.jpg', 'La strada sterrata e sullo sfondo le montagne di Sas dla Crusc'),
('2_corvaralavilla/2.jpg', 'Panchina in legno con cuore intagliato e tavolino d''appoggio centrale'),
('2_corvaralavilla/3.jpg', 'Recinto con alpaca al pascolo '),
('2_corvaralavilla/4.jpg', 'Partenza dell''impianto di risalita della pista Gran Risa'),
('3_cascatefanes/1.jpg', 'Cascata su tre livelli circondata dal bosco'),
('3_cascatefanes/2.jpg', 'Cascata Sbarco di Fanes circondata da rocce marroni e vegetazione'),
('3_cascatefanes/3.jpg', 'Canyon scavato dal torrente visto dal punto panoramico'),
('3_cascatefanes/4.jpg', 'Cascata su più livelli e ponte che l''attraversa'),
('4_lagosompunt/1.jpg', 'Il Lago Sompunt con un piccolo albergo di montagna e le montagne di sfondo'),
('4_lagosompunt/2.jpg', 'Cornice con scritto \"Carpe diem\" che mostra il lago, l''hotel e le montagne'),
('4_lagosompunt/3.jpg', 'Due cervi nel prato: uno seduto e uno sdraiato'),
('4_lagosompunt/4.jpg', 'Due asini che mangiano l''erba'),
('4_lagosompunt/5.jpg', 'Il panorama collinare e roccioso sul massiccio di Sas dla Crusc'),
('5_cascatepisciadu/1.jpg', 'Le montagne del gruppo Sella e la Cascata del Pisciadù'),
('5_cascatepisciadu/2.jpg', 'La vallata di Colfosco con l''impianto di risalita e le montagne di sfondo'),
('5_cascatepisciadu/3.jpg', 'Ponte che attraversa il torrente e nello sfondo il massiccio del Sassongher'),
('5_cascatepisciadu/4.jpg', 'La cascata vista da vicino'),
('5_cascatepisciadu/5.jpg', 'Torrente che scende circondato da boschi e roccia'),
('6_rifugioaltissimo/1.jpg', 'Il Rifugio Damiano Chiesa caratterizzato dagli scuri azzurri'),
('6_rifugioaltissimo/2.jpg', 'Il paesaggio che mostra quasi interamente il Lago di Garda visto dall''alto'),
('6_rifugioaltissimo/3.jpg', 'Il sentiero con vista verso Sud del lago di Garda e delle montagne'),
('6_rifugioaltissimo/4.jpg', 'La strada da percorrere vista dall''alto, caratterizzata da molti tornanti'),
('6_rifugioaltissimo/5.jpg', 'Il sentiero con vista sulle montagne e sullo sfondo il cielo nuvoloso'),
('7_seceda/1.jpg', 'La vetta del Monte Seceda caratterizzata dalla sua inclinazione di 45°'),
('7_seceda/2.jpg', 'Un dettaglio sulla vetta del monte a strapiombo sulla vallata'),
('7_seceda/3.jpg', 'Una vetta secondaria nella quale termina il sentiero con dietro le montagne'),
('7_seceda/4.jpg', 'In primo piano una fontana, poi una malga e dietro una chiesetta in pietra'),
('7_seceda/5.jpg', 'Un tratto del sentiero degli Scoiattoli nel bosco'),
('8_geislerarm/1.jpg', 'La Malga Geisleralm con dietro il massiccio delle Odle'),
('8_geislerarm/2.jpg', 'La Malga Geisleralm con davanti la statua di un''aquila in legno'),
('8_geislerarm/3.jpg', 'Il prato con pochi pini, sullo sfondo il massiccio delle Odle'),
('8_geislerarm/4.jpg', 'La Chiesetta di San Giovanni circondata da prato e da bosco, dietro le Odle');

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
  `tag_keywords` text COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `map_embed` text COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dump dei dati per la tabella `PERCORSO`
--

INSERT INTO `PERCORSO` (`id`, `titolo`, `sottotitolo`, `descrizione`, `indicazioni`, `file_gpx`, `dislivello_salita`, `dislivello_discesa`, `lunghezza`, `tag_title`, `tag_description`, `tag_keywords`, `map_embed`) VALUES
(1, 'Tra malghe e boschi della Lessinia', 'Immergiti nei boschi e nei prati della Lessinia in questa incantevole passeggiata autunnale', 'Questo <strong>percorso ad anello</strong> abbastanza semplice, attraversa i paesaggi suggestivi della Lessinia. Passa per l''incantevole <strong>Valle delle Sfingi</strong>, chiamata così per le particolari formazioni rocciose chiamate appunto \"<em>sfingi</em>\". Lungo il percorso si attraversano malghe ed alpeggi che hanno ancora più fascino in autunno, durante il <span lang=\"en\">foliage</span>. <br>Il sentiero presenta alcuni tratti in salita facilmente affrontabili anche da persone non allenate.', 'Si parte dal <strong>Parcheggio di Camposilvano</strong> e si prosegue in direzione nord attraversando il paese. Dopo aver oltrepassato il <strong>Campeggio Camposilvano</strong>, prendere il <strong>sentiero</strong> sterrato sulla destra. Attraversare la Valle delle Sfingi e poi seguire le indicazioni per il \"<em>Rifugio Lausen</em>\". Una volta raggiunta la fine della strada, girare a sinistra e raggiungere l''alpeggio. Proseguire il sentiero andando verso Est fino ad arrivare alla <em>Malga Sergio Rosso Alta</em>. Da qui seguire le indicazioni per \"<strong><em>Croce del Gal</em></strong>\" e scendere verso Sud. Riprendere la strada sterrata e proseguire fino al Museo Geopantologico.', '1_valle_delle_sfingi.gpx', 290, 290, 7.1, 'Valle delle Sfingi', 'Percorso ad anello semplice in Lessinia che attraversa la Valle delle Sfingi, le malghe e gli alpeggi, ideale da visitare durante il foliage.', 'Valle delle Sfingi,Lessinia,foliage,sentiero,Camposilvano,malghe,percorso', '<iframe src=\"//umap.openstreetmap.fr/en/map/cascate-di-fanes_1162816?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#14/46.5968/12.0855\"></iframe>'),
(2, 'Passeggiata nei boschi da Corvara a La Villa (Alta Badia)', 'Immergiti nel bosco in una passeggiata semplice e adatta a tutti', 'Questo <strong>percorso pianeggiante</strong> si immerge nei boschi della Val Badia e segue principalmente una strada sterrata, ben battuta e larga. Lungo la passeggiata avrai modo di poter riposare in numerose panchine tipiche del luogo e di rilassarti sentendo il rumore del <strong>torrente</strong> che affianca la strada. Alla fine, anche i più piccoli potranno svagarsi al <strong>parco giochi</strong> e i più grandi potranno ammirare il punto d''arrivo della pista \"<strong><em>Gran Risa</em></strong>\" che ospita la Coppa del Mondo di sci alpino.', 'Si parte dalla fermata dell''<strong>autobus</strong> (\"<em>Strada Col Alt</em>\") di <strong>Corvara</strong> in Badia, si prosegue verso nord seguendo il marciapiede. Dopo circa 700<abbr title="metri">m</abbr> si attraversa la strada tramite un sottopassaggio e si prosegue mantenendo la strada sterrata fino al punto d''arrivo.', '2_corvara_la_villa.gpx', 0, 105, 3.5, 'Da Corvara a La Villa', 'Percorso pianeggiante e adatto a tutti nel bosco da Corvara a La Villa, in Val Badia', 'Corvara,La Villa,Alta Badia,Gran Risa,semplice,bambini,parco giochi,autobus', '<iframe src=\"//umap.openstreetmap.fr/en/map/corvara-la-villa_1162815?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#13/46.5633/11.8805\"></iframe>'),
(3, 'Escursione tra le Cascate di Fanes vicino a Cortina d''Ampezzo', 'Un <span lang=\"en\">canyon</span> incantevole circondato da cascate maestose', 'Questo <strong>percorso impegnativo</strong>, <strong>in parte ad anello</strong>, si immerge nella Val di Fanes situata a nord di Cortina d''Ampezzo. La valle è caratterizzata da un profondo <span lang=\"en\">canyon</span> scavato dal torrente Boite e dal Rio di Fanes ammirabile nel <strong>punto panoramico</strong> \"<em>Ponte sulla Cascata</em>\" raggiungibile tramite un sentiero sterrato. Le numerose e impetuose <strong>cascate</strong> sono ammirabili da vicino tramite un sentiero circolare abbastanza difficile con alcuni <strong>tratti esposti</strong>. ', 'Si parte dal <strong>parcheggio a pagamento Sant''Uberto</strong> e si prosegue lungo il sentiero sterrato verso Sud-Ovest seguendo il sentiero 10 fino a raggiungere il Ponte della Cascata del torrente Boite. Da qui si prosegue prendendo il sentiero delle cascate che si snoda inizialmente immerso nel bosco e poi seguendo il fianco della montagna. Una volta raggiunta l''ultima cascata \"<em>Cascata Sbarco di Fanes</em>\" si è conclusa la prima parte dell''anello e si ritorna al punto di partenza proseguendo nuovamente per la strada sterrata.', '3_cascate_di_fanes.gpx', 670, 670, 9.1, 'Cascate di Fanes', 'Escursione panoramica tra il canyon e le scascate della Val di Fanes, vicino a Cortina', 'Cascate di Fanes,Val di Fanes,Cortina,cascate,panorama,canyon,sentiero', '<iframe src=\"//umap.openstreetmap.fr/en/map/valle-delle-sfingi_1162809?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#14/45.6321/11.0993\"></iframe>'),
(4, 'Il Parco dei Cervi e il Lago Sompunt', 'Ammira da vicino gli animali in questa passeggiata per i più piccoli', 'Questa <strong>breve passeggiata</strong> adatta ai bambini affianca il <strong>Parco Cervi Sompunt</strong> dove si possono vedere, anche da vicino, molti esemplari di cervi e di daini. Il percorso fino al <strong>Lago Sompunt</strong> è accessibile con il <strong>passeggino</strong> da <span lang=\"en\">trekking</span>, ma per fare il giro è necessario proseguire a piedi. Dal lago sarà possibile avere un bellissimo scorcio sul massiccio di <span lang=\"de\">Sas dla Crusc</span>.', 'Si parte dal parcheggio libero \"<em>Sponata</em>\" a <strong>Badia</strong> (<abbr title="Bolzano">BZ</abbr>), si prosegue verso ovest seguendo il sentiero in direzione \"<em>Parco dei Cervi</em>\". Si affianca la staccionata fino ad arrivare alla strada, proseguire per un tornante fino ad arrivare al Lago. Al ritorno segui la strada in asfalto per 700<abbr title="metri">m</abbr> e poi prendi il sentiero sulla sinistra fino a raggiungere il parcheggio.', '4_lago_sompunt.gpx', 95, 95, 2.1, 'Parco dei Cervi e Lago Sompunt', 'Percorso panoramico adatto ai bambini tra il Parco dei Cervi e il Lago Sompunt a Badia (BZ)', 'Badia,Parco Cervi Sompunt, Lago Sompunt,lago,passeggiata,passeggino,bambini', '<iframe src=\"//umap.openstreetmap.fr/en/map/lago-sompunt_1162827?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#15/46.5975/11.8959\"></iframe>'),
(5, 'Passeggiata alle Cascate del Pisciadù da Colfosco in Val Badia', 'Un percorso semplice in una valle circondata da montagne', 'Questo <strong>percorso ad anello</strong> si sviluppa nella valle di <strong>Colfosco</strong>, sotto il <strong>Passo Gardena</strong>. La passeggiata è affrontabile con passeggini o sedie a rotelle (preferibilmente motorizzate) in quanto si sviluppa su asfalto o strada sterrata ben battuta. Vicino alle cascate è presente un''<strong>area attrezzata</strong> con tavoli per <span lang=\"en\"><strong>picnic</strong></span>, servizi igienici e acqua potabile. ', 'Si parte dalla fermata dell''autobus ("<em>Strada Col Pradat</em>") a <strong>Colfosco</strong>. Si prosegue seguendo il marciapiede per 900<abbr title="metri">m</abbr> fino al Parcheggio della funivia Sodlisia. Da qui si segue il percorso su strada sterrata verso sud-ovest seguendo le indicazioni per \"<em>Cascate del Pisciadù</em>\". Per ritornare al paese si prosegue sempre su strada forestale, costeggiando il torrente seguendo le indicazioni per Colfosco del percorso \"<em lang=\"de\">Tru dles Cascades</em>\" fino al <span lang=\"fr\">Bistrò</span> La Scola dove è presente anche un parco giochi e un parco avventura. Poi si prosegue verso nord seguendo la strada asfaltata. ', '5_cascate_del_pisciadu.gpx', 130, 130, 4.7, 'Le cascate del Pisciadù a Colfosco', 'Percorso per tutti alle Cascate del Pisciadù a Colfosco', 'Colfosco,Cascate del Pisciadù,cascate,Passo Gardena,semplice,picnic', '<iframe src=\"//umap.openstreetmap.fr/en/map/cascate-del-pisciadu_1162829?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#14/46.5494/11.8477\"></iframe>'),
(6, 'A strapiombo sul Lago di Garda dal Rifugio Altissimo \"<em>Damiano Chiesa</em>\"', 'Un percorso spettacolare con vista a 360<abbr title="gradi">°</abbr> sul Lago di Garda e le montagne trentine', 'Questo <strong>percorso</strong> è abbastanza impegnativo per il dislivello medio ma il sentiero è semplice e affrontabile da tutti con un minimo di allenamento. Durante tutta la camminata si potrà ammirare da varie prospettive il <strong>Lago di Garda</strong>, i monti della Lessinia e una parte delle Dolomiti.', 'Si parte dal <strong>Rifugio Graziani a Brentonico</strong> (<abbr title="Trentino">TN</abbr>) e si prosegue per la strada sterrata in direzione nord-ovest seguendo le indicazioni per il <strong>Rifugio Altissimo \"<em>Damiano Chiesa</em>\"</strong>. Una volta arrivati è possibile proseguire per qualche metro per raggiungere altri punti panoramici. Il ritorno è previsto per la stessa strada.', '6_rifugio_altissimo.gpx', 460, 460, 5.3, 'Rifugio \"Damiano Chiesa\" del Monte Altissimo', 'Percorso impegnativo dal Rifugio Graziani al Rifugio \"Damiano Chiesa\" con vista sul Lago di Garda', 'Rifugio Altissimo,Rifugio Damiano Chiesa,Monte Altissimo,Lago di Garda', '<iframe src=\"//umap.openstreetmap.fr/en/map/rifugio-altissimo_1162830?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#14/45.8059/10.8929\"></iframe>'),
(7, 'L''iconica vetta del Monte Seceda', 'Uno dei luoghi più caratteristici e panoramici delle Dolomiti', 'Questo <strong>percorso</strong> permette di visitare la famosa e molto fotografata vetta del <strong>Seceda</strong>. Questa è l''alternativa per non utilizzare la seggiovia. La salita e il sole accompagnano tutto il sentiero quindi è necessario essere allenati e preparati per proteggersi. La fatica verrà ripagata dall''incantevole <strong>paesaggio</strong> diventato molto famoso nei <span lang=\"en\">social</span>.', 'Si parte dal <strong>parcheggio</strong> \"Cristauta\" a Santa Cristina Valgardena (<abbr title="Bolzano">BZ</abbr>). Si prosegue seguendo il "<strong>sentiero degli scoiattoli</strong>" fino al Rifugio Gamsblut. Si prosegue a nord fino alla Malga Nëidia. Da qui si continua seguendo il sentiero a destra che segue la cresta della montagna fino a raggiungere la vetta. Da qui si ritorna alle malghe seguendo la strada sterrata e poi si torna al parcheggio con lo stesso sentiero dell''andata.', '7_seceda.gpx', 770, 770, 12.8, 'Il monte Seceda', 'Uno dei trekking più iconici nelle dolomiti', 'Monte Seceda,percorso,parcheggio,sentiero,scoiattoli,Dolomiti', '<iframe src=\"//umap.openstreetmap.fr/en/map/seceda_1162831?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#12/46.5863/11.7337\"></iframe>'),
(8, 'La malga Geisleralm con vista sul massiccio delle Odle', 'Un percorso impegnativo per ammirare uno dei paesaggi più belli delle Dolomiti', 'Questo <strong>percorso ad anello</strong> parte dal Paese di <strong>Santa Maddalena</strong>, famoso per la Chiesetta di San Giovanni in Ranui <strong>fotografata</strong> molte volte e presente in molti <span lang=\"en\">puzzle</span>. La passeggiata è da considerare medio-difficile in quanto il dislivello è impegnativo anche se le strade percorse sono ben segnate e facili. Se si ha fortuna, sarà possibile ammirare da vicino gli animali selvatici del bosco come scoiattoli e cervi. Una volta arrivati alla <strong>Malga Geisleralm</strong> ci si può rilassare sul prato ammirando il meraviglioso panorama sul Massiccio delle <strong>Odle</strong>.', 'Si parte dal parcheggio \"<em>Parkplatz</em>\" a <strong>Santa Maddalena</strong> (<abbr title="Bolzano">BZ</abbr>). Si prosegue verso Sud seguendo la strada forestale a destra del bivio per 1,5<abbr title="chilometri">km</abbr>. Una volta arrivati al ponte si prosegue a destra per proseguire nel <strong>sentiero</strong> in mezzo al bosco per 1<abbr title="chilometri">km</abbr>. Una volta terminato proseguire verso Est e seguire le indicazioni per \"<em>Geisleralm</em>\". Per tornare al punto di partenza continuare sulla strada forestale che affianca il torrente e seguire le indicazioni per il parcheggio: si prosegue per 2,8<abbr title="chilometri">km</abbr> prima verso Est e poi verso Sud. Al bivio si prosegue verso sinistra per tornare al parcheggio.', '8_geisleralm.gpx', 630, 630, 10.3, 'La malga Geisleralm', 'Un bellissimo trekking per ammirare le Odle da vicino', 'Malga Geisleralm,Santa Maddalena,Odle,sentiero,panorama,Dolomiti', '<iframe src=\"//umap.openstreetmap.fr/en/map/geisleram_1162832?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=null&onLoadPanel=none&captionBar=false&captionMenus=false&fullscreenControl=null&captionControl=null#13/46.6295/11.7446\"></iframe>');

-- --------------------------------------------------------

--
-- Struttura della tabella `RECENSIONE`
--

CREATE TABLE `RECENSIONE` (
  `utente` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `percorso` int(6) NOT NULL,
  `voto` int(1) NOT NULL CHECK (`voto` between 0 and 5),
  `testo` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dump dei dati per la tabella `RECENSIONE`
--

INSERT INTO `RECENSIONE` (`utente`, `percorso`, `voto`, `testo`, `ultima_modifica`) VALUES
('user', 1, 5, 'Bellissimo percorso!!!', '2024-12-17 14:17:22'),
('user', 3, 5, 'Partiamo col dire che l’Escursione tra le Cascate di Fanes è perfetta per chi ama il brivido... e non parlo solo della natura. Prima sfida: trovare parcheggio.\r\nE poi arrivano loro, le cascate. Splendide, eh, nulla da dire, ma per arrivarci devi attraversare un ponticello traballante. Ma tranquilli, una volta arrivato vicino alle cascate sei ricompensato con una doccia gelata a tradimento. Rinfrescante? Sicuramente. Voluta? Non proprio.\r\nE il bello è che mentre ero lì, a contemplare il perché avessi deciso di torturarmi in questo modo, arriva la notizia: la Ferrari ha vinto a Monza! No, dico, LA FERRARI! Non succedeva da così tanto tempo che, per un attimo, ho pensato di aver perso la testa per la stanchezza. Un evento talmente raro che avrebbe meritato un brindisi.\r\nLa prossima volta mi porto una bandiera della Ferrari, così se non ce la faccio posso almeno sventolarla come segno di resa.', '2024-09-01 19:46:49'),
('user', 4, 3, 'Percorso stupendo peccato per i cervi che mi hanno morso una mano', '2024-12-13 15:15:30'),
('user', 5, 1, 'Devo argomentare?? No mi dispiace non c’è tempo da perdere qui arrivederci', '2024-12-17 14:58:28'),
('user', 7, 5, 'Non so esattamente cosa sia successo sul Monte Seceda, ma so che non sono tornato la stessa persona. Sarà stato il panorama mozzafiato, con quelle vette che sembrano dipinte a mano, o il silenzio quasi mistico che ti avvolge a 2.500 metri, ma qualcosa dentro di me è cambiato.', '2024-09-03 16:02:37'),
('user', 8, 4, 'Bello ma in malga mi hanno fatto pagare la polenta 25 euro.', '2024-12-12 16:24:05'),
('user2', 1, 3, 'Percorso carino, peccato per la spazzatura lasciata in giro da alcuni incivili. Non penso ci tornerò.', '2024-12-17 14:35:10'),
('user2', 3, 5, 'Questo percorso mi ha cambiato la vita', '2024-12-09 10:24:12'),
('user2', 4, 5, 'Un parco veramente bello dove puoi trovarti con cervi con un mindset importante.\r\nNon pensavo esistessero luoghi di tale bellezza, ma come al solito la metropoli de La Villa non delude mai.\r\nConsigliatissimo.', '2024-12-05 15:51:16'),
('user2', 6, 3, 'Meh, mediocre.', '2024-12-17 15:02:29');

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
-- Dump dei dati per la tabella `UTENTE`
--

INSERT INTO `UTENTE` (`username`, `password`, `isAdmin`) VALUES
('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 1),
('user', 'b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2', 0),
('user2', '291116775902b38dd09587ad6235cec503fc14dbf9c09cad761f2e5a5755102eaceb54b95ffd179c22652c3910dbc6ed85ddde7e09eef1ecf3ad219225f509f5', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `CARATTERISTICA`
--
ALTER TABLE `CARATTERISTICA`
  ADD PRIMARY KEY (`nome`),
  ADD UNIQUE KEY `nome` (`nome`);

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
