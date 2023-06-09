-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema
CREATE DATABASE IF NOT EXISTS `cinema` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema`;

-- Listage de la structure de table cinema. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  KEY `id_personne` (`id_personne`) USING BTREE,
  CONSTRAINT `FK_acteur_personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.acteur : ~7 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(1, 2),
	(2, 6),
	(3, 8),
	(4, 9),
	(5, 11),
	(6, 12),
	(7, 13);

-- Listage de la structure de table cinema. appartenir
CREATE TABLE IF NOT EXISTS `appartenir` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_film` (`id_film`),
  KEY `FK_appartenir_genre` (`id_genre`),
  CONSTRAINT `FK_appartenir_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_appartenir_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.appartenir : ~9 rows (environ)
INSERT INTO `appartenir` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 2),
	(7, 3),
	(8, 4),
	(9, 5),
	(10, 5);

-- Listage de la structure de table cinema. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_acteur`,`id_role`),
  KEY `id_film` (`id_film`),
  KEY `FK_casting_acteur` (`id_acteur`),
  KEY `FK_casting_role` (`id_role`),
  CONSTRAINT `FK_casting_acteur` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `FK_casting_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_casting_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.casting : ~9 rows (environ)
INSERT INTO `casting` (`id_film`, `id_acteur`, `id_role`) VALUES
	(1, 1, 1),
	(2, 1, 1),
	(3, 1, 1),
	(4, 1, 1),
	(5, 2, 1),
	(6, 3, 2),
	(7, 4, 3),
	(8, 5, 4),
	(9, 7, 5),
	(10, 6, 6),
	(10, 7, 7);

-- Listage de la structure de vue cinema. dureefilmheure
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `dureefilmheure` (
	`id_film` INT(10) NOT NULL,
	`titre` VARCHAR(100) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`tempsHeure` TIME NULL
) ENGINE=MyISAM;

-- Listage de la structure de table cinema. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_sortie_france` date DEFAULT NULL,
  `duree` int DEFAULT NULL,
  `synopsis` text NOT NULL,
  `note` float DEFAULT NULL,
  `affiche_film` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'indisponible.jpg',
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.film : ~10 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `date_sortie_france`, `duree`, `synopsis`, `note`, `affiche_film`, `id_realisateur`) VALUES
	(1, 'Skyfall', '2012-10-24', 143, 'Les agents britanniques James Bond, nom de code 007, et Eve sont à Istanbul à la suite du meurtre d\'une section du MI6 et du vol d\'un disque dur d\'ordinateur contenant les identités de tous les agents de l\'OTAN infiltrés dans des organisations terroristes. Bond et Eve, à bord d\'une voiture, prennent le meurtrier en chasse dans le but de récupérer le disque dur.', 4.2, '<img class="posterMovie" src="public/image/skyfall.jpg">', 1),
	(2, 'Casino Royale', '2006-11-22', 144, 'Dans la séquence pré-générique en noir et blanc, James Bond va être nommé agent 00 par le MI6, et sera donc autorisé à tuer selon son propre jugement. Pour obtenir cette promotion, il rend visite dans la nuit à un chef de section corrompu à Prague, dont il retire quelques minutes avant son arrivée au bureau le chargeur de son arme à feu. Le jeune agent lui annonce qu\'il a tué avec difficulté l\'agent double que le chef supervisait dans des toilettes (c\'était son premier meurtre), puis l\'abat facilement d\'une balle dans la tête. Une fois la mission accomplie, James Bond se voit assigner le matricule 007 pendant le générique.', 4, '<img class="posterMovie" src="public/image/casino_royale.jpg">', 2),
	(3, 'Quantum of Solace', '2008-10-31', 106, 'Après avoir arrêté M. White dans sa villa (à la fin de Casino Royale), James Bond le met dans le coffre de sa DBS mais il est poursuivi par les hommes de ce dernier sur les rives du lac de Garde. Il arrive tout de même à tous les éliminer après une course-poursuite dangereuse, qui a lourdement endommagé sa voiture, et à rejoindre une antenne secrète du MI6 dans le vieux centre de Sienne.', 3.1, '<img class="posterMovie" src="public/image/quantum_of_solace.jpg">', 3),
	(4, '007 Spectre', '2021-11-11', 148, 'Lors d’une mission à Mexico, pendant la fête des morts, James Bond exécute les dernières volontés de l\'ancienne M tuée à Skyfall en faisant exploser un appartement où se sont réunis plusieurs terroristes qui projettent de faire sauter un stade sportif. Bond prend en chasse le seul qui a survécu à l\'explosion, Marco Sciarra, qui tente de s\'échapper par hélicoptère. Bond s\'agrippe à l\'hélicoptère et, après un violent combat, jette par-dessus bord Sciarra après s\'être emparé de l\'anneau à motif de pieuvre qu\'il portait au doigt.', 3.6, '<img class="posterMovie" src="public/image/spectre.jpg">', 1),
	(5, 'Meurs un autre jour', '2002-11-20', 132, 'Alors qu\'il débarque (en surf) sur les côtes de Corée du Nord pour une mission, Bond et deux agents étrangers détournent un hélicoptère et prennent la place et les identités des occupants qui sont des trafiquants de diamants de conflit. Ils arrivent dans une base militaire située dans la zone démilitarisée et entrent en contact avec le colonel nord-coréen Moon où Bond se fait passer pour le trafiquant de diamants de conflit avec qui le colonel avait rendez-vous pour acheter la marchandise. Mais au cours de la transaction, le colonel est informé du statut d\'agent des services secrets britanniques de James Bond et, en réaction, il détruit l\'hélicoptère prévu pour leur départ et s\'apprête à faire exécuter l\'agent secret.', 3, '<img class="posterMovie" src="public/image/meurs_un_autre_jour.jpg">', 4),
	(6, 'Star Wars, épisode IV : Un nouvel espoir', '1977-10-19', 121, 'Le vaisseau spatial de Leia est arraisonné par l\'énorme croiseur interstellaire dans lequel se trouve Dark Vador alors qu\'elle s\'apprête à faire escale sur la planète désertique Tatooine. Les Impériaux pénètrent à bord et font prisonniers ses occupants, considérés comme des espions. Se sentant perdue, la princesse prend la décision de confier les plans dérobés au petit droïde R2-D23. Ce dernier s\'échappe avec un autre robot du nom de C-3PO grâce à une capsule de sauvetage. Ils parviennent à atterrir sur Tatooine sans trop d\'encombres mais se font rapidement capturer par des Jawas, petites créatures autochtones spécialisées dans la vente de ferraille et de composants électroniques. Ils vendent les deux droïdes à un couple de fermiers4', 4.4, '<img class="posterMovie" src="public/image/star_wars4.jpg">', 5),
	(7, 'L\'Inspecteur Harry', '1972-02-16', 98, 'Alors qu\'une jeune femme se baigne dans une piscine située sur un toit de San Francisco, un homme l\'assassine à l\'aide d\'un fusil de calibre .30-06 Springfield. Chargé de l\'enquête, l\'inspecteur de la police de San Francisco Harry Callahan retrouve une douille usagée sur un toit situé non loin du lieu du crime et un message d\'un dénommé « Scorpion ». Le message réclame une rançon, faute de laquelle le tueur en série tuera une personne par jour en commençant par « un prêtre catholique ou un nègre ».', 3.8, '<img class="posterMovie" src="public/image/inspecteur_harry.webp">', 6),
	(8, 'L\'Échange', '2008-05-20', 141, 'Los Angeles, 1928. Christine Collins (Angelina Jolie), mère célibataire et opératrice téléphonique, laisse à la maison son fils de neuf ans, Walter (Gattlin Griffith) pour aller travailler. Alors que son supérieur lui propose une promotion, Christine manque le tramway qui devait la ramener chez elle. Le soir, quand elle rentre, elle retrouve la maison vide. Quelques mois plus tard, le Los Angeles Police Department (LAPD) informe Christine que Walter a été retrouvé vivant et en bonne santé. Désireuse de redorer son blason après de récentes critiques, la police décide de convier la presse aux retrouvailles de la mère et de l\'enfant. Mais, contre toute attente, et malgré le fait que « Walter » (Devon Conti) assure être le fils de Christine, cette dernière ne le reconnaît pas. Le capitaine J. J. Jones (Jeffrey Donovan), chef de la brigade des mineurs de Los Angeles insiste et fait pression sur Christine qui accepte de recueillir le garçon chez elle.', 4.2, '<img class="posterMovie" src="public/image/échange.webp">', 7),
	(9, 'L\'Américain', '2004-06-18', 94, 'Un avocat, Édouard Barnier (Thierry Lhermitte), va tenter de convaincre l\'ambassade américaine d\'accorder la nationalité américaine à un jeune Français, Francis Farge (Lorànt Deutsch), qui se considère plus Américain que Français. Aidé par Me Bernier, il va tenter de convaincre les Américains en transformant son lotissement de Sarcelles en 51e État des États-Unis. Leur associé, Monsieur Sammarone (Patrick Timsit) invente alors un test urinaire permettant de savoir si l\'on est congénitalement américain ou non. Le mouvement prend de l\'ampleur et l\'ambassade des États-Unis cherche à le tuer dans l\'œuf en provoquant un match de football américain.', 0.9, '<img class="posterMovie" src="public/image/americain.jpg">', 8),
	(10, 'Un Indien dans la ville', '1994-12-14', 86, 'Parti en Amazonie retrouver son ex-femme Patricia afin de lui faire signer l\'acte de divorce dans le but de pouvoir se remarier, Stéphane Marchadot, fringant opérateur sur le marché des matières premières, découvre avec stupeur qu\'il est le père de Mimi-Siku, un enfant âgé de 13 ans. Convaincu par son fils qui rêve de découvrir la tour Eiffel, Stéphane décide de l\'emmener avec lui, même s\'il sait que le moment est mal venu. Il ne vit que pour son travail et n\'a donc pas de temps à consacrer à son fils. Arrivé à Paris, il apprend par Richard Montignac, son associé, qu\'ils ont encore une option d\'achat de 4500 tonnes de soja dont le cours baisse dangereusement.', 2.9, '<img class="posterMovie"  src="public/image/indien_ville.jpg">', 9),
	(11, 'Mourrir peut attendre', '2021-09-28', 163, 'James Bond n\'est plus en service et profite d\'une vie tranquille en Italie. Mais son répit est de courte durée car l\'agent de la CIA Felix Leiter fait son retour pour lui demander son aide. Sa mission, qui est de secourir un scientifique kidnappé, va se révéler plus traîtresse que prévu et mener Bond sur la piste de Safin, un ennemi particulièrement dangereux', 3.7, 'mourrir_peut_attendre.webp', 1),
	(14, 'Mourrir peut attendre', '2021-09-28', 163, 'James Bond n\'est plus en service et profite d\'une vie tranquille en Italie. Mais son répit est de courte durée car l\'agent de la CIA Felix Leiter fait son retour pour lui demander son aide. Sa mission, qui est de secourir un scientifique kidnappé, va se révéler plus traîtresse que prévu et mener Bond sur la piste de Safin, un ennemi particulièrement dangereux', 3.7, 'mourrir_peut_attendre.webp', 1);

-- Listage de la structure de table cinema. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.genre : ~5 rows (environ)
INSERT INTO `genre` (`id_genre`, `libelle`) VALUES
	(1, 'Espionnage'),
	(2, '	Science-fiction'),
	(3, 'Policier'),
	(4, 'Thriller'),
	(5, 'Comédie');

-- Listage de la structure de vue cinema. listfilmrequest
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `listfilmrequest` (
	`id_film` INT(10) NOT NULL,
	`titre` VARCHAR(100) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`affiche_film` VARCHAR(255) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`sortieSalleFrance` VARCHAR(72) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`tempsHeure` TIME NULL,
	`note` FLOAT NULL,
	`synopsis` TEXT NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Listage de la structure de table cinema. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sexe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_naissance` date NOT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.personne : ~14 rows (environ)
INSERT INTO `personne` (`id_personne`, `photo`, `prenom`, `nom`, `sexe`, `date_naissance`) VALUES
	(1, '<img class="photoPerson" src="public/image/Sam_Mendes_2012.jpg">', 'Sam', 'Mendes', 'Homme', '1965-08-01'),
	(2, '<img class="photoPerson" src="public/image/daniel_craig.jpg">', 'Daniel', 'Craig', 'Homme', '1968-03-02'),
	(3, '<img class="photoPerson" src="public/image/Martin_Campbell.jpg">', 'Martin', 'Campbell', 'Homme', '1943-10-24'),
	(4, '<img class="photoPerson" src="public/image/MarcForsterColorNov08.jpg">', 'Marc', 'Forster', 'Homme', '1969-11-30'),
	(5, '<img class="photoPerson" src="public/image/Lee_Tamahori.webp">', 'Lee', 'Tamahori', 'Homme', '1950-06-17'),
	(6, '<img class="photoPerson" src="public/image/Pierce_Brosnan_2017.jpg">', 'Pierce', 'Brosnan', 'Homme', '1953-05-16'),
	(7, '<img class="photoPerson" src="public/image/George_Lucas_cropped_2009.jpg">', 'George', 'Lucas', 'Homme', '1944-05-14'),
	(8, '<img class="photoPerson" src="public/image/Harrison_Ford_by_Gage_Skidmore_2.jpg">', 'Harrison', 'Ford', 'Homme', '1942-07-13'),
	(9, '<img class="photoPerson" src="public/image/136406.webp">', 'Clint', 'Eastwood', 'Homme', '1930-05-31'),
	(10, '<img class="photoPerson" src="public/image/donsiegel.jpg">', 'Don', 'Siegel', 'Homme', '1912-10-26'),
	(11, '<img class="photoPerson" src="public/image/Angelina_Jolie.jpg">', 'Angelina', 'Jolie', 'Femme', '1973-06-04'),
	(12, '<img class="photoPerson" src="public/image/Patrick_Timsit_printemps_du_cinéma_2013.jpg">', 'Patrick', 'Timsit', 'Homme', '1959-07-15'),
	(13, '<img class="photoPerson" src="public/image/Thierry_Lhermitte.jpg">', 'Thierry', 'Lhermitte', 'Homme', '1952-11-24'),
	(14, '<img class="photoPerson" src="public/image/herve-palud.png">', 'Hervé', 'Palud', 'Homme', '1953-04-14');

-- Listage de la structure de table cinema. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  KEY `id_personne` (`id_personne`) USING BTREE,
  CONSTRAINT `FK_realisateur_personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.realisateur : ~8 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 1),
	(2, 3),
	(3, 4),
	(4, 5),
	(5, 7),
	(7, 9),
	(6, 10),
	(8, 12),
	(9, 14);

-- Listage de la structure de table cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema.role : ~7 rows (environ)
INSERT INTO `role` (`id_role`, `nom_role`) VALUES
	(1, 'James Bond'),
	(2, 'Han Solo'),
	(3, 'Inspecteur Harry Callahan'),
	(4, 'Christine Collins'),
	(5, 'Édouard Barnier (surnommé "Eddy")'),
	(6, 'Richard Montignac'),
	(7, 'Stéphane Marchadot');

-- Listage de la structure de vue cinema. dureefilmheure
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `dureefilmheure`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `dureefilmheure` AS select `f`.`id_film` AS `id_film`,`f`.`titre` AS `titre`,sec_to_time((`f`.`duree` * 60)) AS `tempsHeure` from `film` `f`;

-- Listage de la structure de vue cinema. listfilmrequest
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `listfilmrequest`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `listfilmrequest` AS select `f`.`id_film` AS `id_film`,`f`.`titre` AS `titre`,`f`.`affiche_film` AS `affiche_film`,date_format(`f`.`date_sortie_france`,'%e %M %Y') AS `sortieSalleFrance`,sec_to_time((`f`.`duree` * 60)) AS `tempsHeure`,`f`.`note` AS `note`,`f`.`synopsis` AS `synopsis` from `film` `f` group by `f`.`id_film`,`f`.`titre`,`f`.`affiche_film`,`sortieSalleFrance`,`f`.`note`,`f`.`synopsis` order by `tempsHeure`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
