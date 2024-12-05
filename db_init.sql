CREATE USER IF NOT EXISTS 'tlazzari'@'%' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON *.* TO 'tlazzari'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Creato il: Dic 05, 2024 alle 17:37
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

USE tlazzari

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
  `titolo` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `sottotitolo` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `descrizione` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `indicazioni` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_gpx` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dislivello_salita` smallint(6) NOT NULL DEFAULT 0,
  `dislivello_discesa` smallint(6) NOT NULL DEFAULT 0,
  `lunghezza` float UNSIGNED NOT NULL DEFAULT 0,
  `tag_title` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tag_description` varchar(70) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tag_keywords` varchar(120) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  ADD UNIQUE KEY `titolo` (`titolo`);

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

