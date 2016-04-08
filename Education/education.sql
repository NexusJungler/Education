-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 08 Avril 2016 à 15:00
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `education`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(100) NOT NULL,
  `acronyme` varchar(3) NOT NULL,
  `FKdiscipline` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKdiscipline` (`FKdiscipline`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `intitule`, `acronyme`, `FKdiscipline`) VALUES
(1, 'Dire', 'D', 1),
(2, 'Lire', 'L', 1),
(3, 'Ecrire', 'E', 1),
(4, 'Etude de la langue-Vocabulaire', 'V', 1),
(5, 'Etude de la langue-Grammaire', 'G', 1),
(6, 'Etude de la langue-Orthographe', 'O', 1),
(7, 'Réagir et dialoguer', 'RD', 2),
(8, 'Ecouter et comprendre à l''oral', 'EC', 2),
(9, 'Parler en continu', 'P', 2),
(10, 'Lire', 'L', 2),
(11, 'Ecrire', 'E', 2),
(12, 'Problèmes', 'PB', 3),
(13, 'Nombres et calcul', 'NC', 3),
(14, 'Géométrie', 'GT', 3),
(15, 'Grandeurs et mesures', 'GM', 3),
(16, 'Organisation et gestion de données', 'OG', 3),
(17, 'Culture scientifique et technologique', 'CST', 3),
(18, 'Environnement et développement durable', 'EDD', 3),
(19, 'S’approprier un environnement informatique de travail', 'EIT', 4),
(20, 'Adopter une attitude responsable', 'AR', 4),
(21, 'Créer, produire, traiter, exploiter des données', 'CED', 4),
(22, 'S’informer, se documenter', 'ID', 4),
(23, 'Communiquer, échanger', 'CE', 4),
(24, 'Avoir des repères relevant du temps et de l''espace', 'RTE', 5),
(25, 'Avoir des repères littéraires', 'ARL', 5),
(26, 'Avoir des connaissances et des repères', 'ACR', 5),
(27, 'Situer dans le temps, l''espace et les civilisation', 'TEC', 5),
(28, 'Lire et pratiquer différents langages', 'LPL', 5),
(29, 'Pratiquer les arts et avoir des repères en histoire de l''art', 'AH', 5),
(30, 'Faire preuve de sensibilité, d''esprit critique, de curiosité', 'ECC', 5),
(31, 'Connaître les principes et fondements de la vie civique et sociale', 'FSC', 6),
(32, 'Avoir un comportement responsable', 'ACR', 6),
(33, 'S’appuyer sur des méthodes de travail pour être autonome', 'MTA', 7),
(34, 'Être acteur de son parcours de formation et d’orientation', 'APO', 7),
(35, 'Avoir une bonne maîtrise de son corps et une pratique physique (sportive ou artistique)', 'MCP', 7),
(36, 'Etre capable de mobiliser ses ressources physiques dans diverses situations', 'MRS', 7),
(37, 'Faire preuve d''initiative', 'PI', 7);

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE IF NOT EXISTS `classe` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(4) NOT NULL,
  `annee` tinyint(2) unsigned NOT NULL,
  `FKuser` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKuser_id` (`FKuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`id`, `nom`, `annee`, `FKuser`) VALUES
(1, '53', 16, 1),
(12, 'toto', 10, 1),
(13, 'n21', 14, 1),
(14, 'vip', 12, 1),
(15, 'kalp', 36, 1);

-- --------------------------------------------------------

--
-- Structure de la table `compensation`
--

CREATE TABLE IF NOT EXISTS `compensation` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(50) NOT NULL,
  `acronyme` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `compensation`
--

INSERT INTO `compensation` (`id`, `intitule`, `acronyme`) VALUES
(1, 'aucune', '<br>'),
(2, 'matérielle', 'MAT'),
(3, 'écrite', 'ECR'),
(4, 'orale', 'ORA'),
(5, 'temporelle', 'TEM'),
(6, 'humaine', 'HUM'),
(7, 'automatique', 'AUTO');

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE IF NOT EXISTS `competence` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(250) NOT NULL,
  `acronyme` varchar(3) NOT NULL,
  `FKcategorie` tinyint(2) unsigned NOT NULL,
  `FKpallier` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKcategorie` (`FKcategorie`),
  KEY `FKpallier` (`FKpallier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=235 ;

--
-- Contenu de la table `competence`
--

INSERT INTO `competence` (`id`, `intitule`, `acronyme`, `FKcategorie`, `FKpallier`) VALUES
(1, 'S’exprimer clairement à l’oral en utilisant un vocabulaire approprié\r\n', 'AAC', 1, 1),
(2, 'Participer en classe à un échange verbal en respectant les règles de la communication\r\n', '', 1, 1),
(3, 'Dire de mémoire quelques textes en prose ou poèmes courts\r\n', '', 1, 1),
(4, 'S’exprimer à l’oral comme à l’écrit dans un vocabulaire approprié et précis\r\n', '', 1, 2),
(5, 'Prendre la parole en respectant le niveau de langue adapté\r\n', '', 1, 2),
(6, 'Répondre à une question par une phrase complète à l’oral\r\n', '', 1, 2),
(7, 'Prendre part à un dialogue : prendre la parole devant les autres, écouter autrui, formuler et justifier un point de vue\r\n', '', 1, 2),
(8, ' Dire de mémoire, de façon expressive, une dizaine de poèmes et de textes en prose\r\n', '', 1, 2),
(9, 'Formuler clairement un propos simple\r\n', '', 1, 3),
(10, 'Développer de façon suivie un propos en public sur un sujet déterminé\r\n', '', 1, 3),
(11, 'Adapter sa prise de parole à la situation de communication\r\n', '', 1, 3),
(12, 'Participer à un débat, à un échange verbal\r\n', '', 1, 3),
(13, 'Lire seul, à haute voix, un texte comprenant des mots connus et inconnus\r\n', '', 2, 1),
(14, 'Lire seul et écouter lire des textes du patrimoine et des oeuvres intégrales de la littérature de jeunesse adaptés à son âge\r\n', '', 2, 1),
(15, 'Lire seul et comprendre un énoncé, une consigne simple\r\n', '', 2, 1),
(16, 'Dégager le thème d’un paragraphe ou d’un texte court\r\n', '', 2, 1),
(17, 'Lire silencieusement un texte en déchiffrant les mots inconnus et manifester sa compréhension dans un résumé, une reformulation, des réponses à des questions\r\n', '', 2, 1),
(18, 'Lire avec aisance (à haute voix, silencieusement) un texte\r\n', '', 2, 2),
(19, 'Lire seul des textes du patrimoine et des oeuvres intégrales de la littérature de jeunesse, adaptés à son âge\r\n', '', 2, 2),
(20, 'Lire seul et comprendre un énoncé, une consigne\r\n', '', 2, 2),
(21, 'Dégager le thème d’un texte\r\n', '', 2, 2),
(22, 'Repérer dans un texte des informations explicites\r\n', '', 2, 2),
(23, 'Inférer des informations nouvelles (implicites)\r\n', '', 2, 2),
(24, 'Repérer les effets de choix formels (emploi de certains mots, utilisation d’un niveau de langue)\r\n', '', 2, 2),
(25, 'Utiliser ses connaissances pour réfléchir sur un texte, mieux le comprendre\r\n', '', 2, 2),
(26, 'Effectuer, seul, des recherches dans des ouvrages documentaires (livres, produits multimédia)\r\n', '', 2, 2),
(27, 'Se repérer dans une bibliothèque, une médiathèque\r\n', '', 2, 2),
(28, 'Adapter son mode de lecture à la nature du texte proposé et à l’objectif poursuivi\r\n', '', 2, 3),
(29, 'Repérer les informations dans un texte à partir des éléments explicites et des éléments implicites nécessaires\r\n', '', 2, 3),
(30, 'Utiliser ses capacités de raisonnement, ses connaissances sur la langue, savoir faire appel à des outils appropriés pour lire\r\n', '', 2, 3),
(31, 'Dégager, par écrit ou oralement, l’essentiel d’un texte lu\r\n', '', 2, 3),
(32, 'Manifester, par des moyens divers, sa compréhension de textes variés\r\n', '', 2, 3),
(33, 'Copier un texte court sans erreur dans une écriture cursive lisible et avec une présentation soignée\r\n', '', 3, 1),
(34, 'Utiliser ses connaissances pour mieux écrire un texte court\r\n', '', 3, 1),
(35, 'Écrire de manière autonome un texte de cinq à dix lignes\r\n', '', 3, 1),
(36, 'Copier sans erreur un texte d’au moins quinze lignes en lui donnant une présentation adaptée\r\n', '', 3, 2),
(37, 'Utiliser ses connaissances pour réfléchir sur un texte, mieux l’écrire\r\n', '', 3, 2),
(38, 'Répondre à une question par une phrase complète à l’écrit\r\n', '', 3, 2),
(39, 'Rédiger un texte d’une quinzaine de lignes (récit, description, dialogue, texte poétique, compte rendu) en utilisant ses connaissances en vocabulaire et en grammaire\r\n', '', 3, 2),
(40, 'Reproduire un document sans erreur et avec une présentation adaptée\r\n', '', 3, 3),
(41, 'Écrire lisiblement un texte, spontanément ou sous la dictée, en respectant l’orthographe et la grammaire\r\n', '', 3, 3),
(42, 'Rédiger un texte bref, cohérent et ponctué, en réponse à une question ou à partir de consignes données\r\n', '', 3, 3),
(43, 'Utiliser ses capacités de raisonnement, ses connaissances sur la langue, savoir faire appel à des outils variés pour améliorer son texte\r\n', '', 3, 3),
(44, 'Utiliser des mots précis pour s’exprimer\r\n', '', 4, 1),
(45, 'Donner des synonymes\r\n', '', 4, 1),
(46, ' Trouver un mot de sens opposé\r\n', '', 4, 1),
(47, 'Regrouper des mots par familles\r\n', '', 4, 1),
(48, 'Commencer à utiliser l’ordre alphabétique\r\n', '', 4, 1),
(49, 'Comprendre des mots nouveaux et les utiliser à bon escient\r\n', '', 4, 2),
(50, 'Maîtriser quelques relations de sens entre les mots\r\n', '', 4, 2),
(51, 'Maîtriser quelques relations concernant la forme et le sens des mots\r\n', '', 4, 2),
(52, 'Savoir utiliser un dictionnaire papier ou numérique\r\n', '', 4, 2),
(53, 'Identifier la phrase, le verbe, le nom, l’article, l’adjectif qualificatif, le pronom personnel (sujet)\r\n', '', 5, 1),
(54, 'Repérer le verbe d’une phrase et son sujet\r\n', '', 5, 1),
(55, 'Conjuguer les verbes du 1er groupe, être et avoir, au présent, au futur, au passé composé de l’indicatif ; conjuguer les verbes faire, aller, dire, venir, au présent de l’indicatif\r\n', '', 5, 1),
(56, 'Distinguer le présent du futur et du passé\r\n', '', 5, 1),
(57, 'Distinguer les mots selon leur nature\r\n', '', 5, 2),
(58, 'Identifier les fonctions des mots dans la phrase\r\n', '', 5, 2),
(59, 'Conjuguer les verbes, utiliser les temps à bon escient\r\n', '', 5, 2),
(60, 'Écrire en respectant les correspondances entre lettres et sons et les règles relatives à la valeur des lettres\r\n', '', 6, 1),
(61, 'Écrire sans erreur des mots mémorisés\r\n', '', 6, 1),
(62, 'Orthographier correctement des formes conjuguées, respecter l’accord entre le sujet et le verbe, ainsi que les accords en genre et en nombre dans le groupe nominal\r\n', '', 6, 1),
(63, 'Maîtriser l’orthographe grammaticale\r\n', '', 6, 2),
(64, 'Maîtriser l’orthographe lexicale\r\n', '', 6, 2),
(65, 'Orthographier correctement un texte simple de dix lignes - lors de sa rédaction ou de sa dictée - en se référant aux  règles connues d’orthographe et de grammaire ainsi qu’à la connaissance du vocabulaire\r\n', '', 6, 2),
(66, 'Communiquer, au besoin avec des pauses pour chercher ses mots', '', 7, 2),
(67, 'Se présenter, présenter quelqu’un, demander à quelqu’un de ses nouvelles en utilisant les formes de politesse les plus élémentaires, accueil et prise de congé\r\n', '', 7, 2),
(68, 'Répondre à des questions et en poser (sujets familiers ou besoins immédiats)\r\n', '', 7, 2),
(69, 'Épeler des mots familiers\r\n', '', 7, 2),
(70, 'Établir un contact social', '', 7, 3),
(71, 'Dialoguer sur des sujets familiers', '', 7, 3),
(72, 'Demander et donner des informations\r\n', '', 7, 3),
(73, 'Réagir à des propositions\r\n', '', 7, 3),
(74, 'Comprendre les consignes de classe\r\n', '', 8, 2),
(75, 'Comprendre des mots familiers et des expressions courantes', '', 8, 2),
(76, 'Suivre des instructions courtes et simples\r\n', '', 8, 2),
(77, 'Comprendre un message oral pour réaliser une tâche\r\n', '', 8, 3),
(78, 'Comprendre les points essentiels d’un message oral (conversation, information, récit, exposé)\r\n', '', 8, 3),
(81, 'Reproduire un modèle oral\r\n', '', 9, 2),
(82, 'Utiliser des expressions et des phrases proches des modèles rencontrés lors des apprentissages\r\n', '', 9, 2),
(83, 'Lire à haute voix et de manière expressive un texte bref après répétition\r\n', '', 9, 2),
(84, 'Reproduire un modèle oral\r\n', '', 9, 3),
(85, 'Décrire, raconter, expliquer\r\n', '', 9, 3),
(86, 'Présenter un projet et lire à haute voix\r\n', '', 9, 3),
(87, 'Comprendre des textes courts et simples en s’appuyant sur des éléments connus (indications, informations)\r\n', '', 10, 2),
(88, 'Se faire une idée du contenu d’un texte informatif simple, accompagné éventuellement d’un document visuel\r\n', '', 10, 2),
(89, 'Comprendre le sens général de documents écrits\r\n', '', 10, 3),
(90, 'Savoir repérer des informations dans un texte\r\n', '', 10, 3),
(91, 'Copier des mots isolés et des textes courts\r\n', '', 11, 2),
(92, 'Écrire un message électronique simple ou une courte carte postale en référence à des modèles\r\n', '', 11, 2),
(93, 'Renseigner un questionnaire\r\n', '', 11, 2),
(94, 'Produire de manière autonome quelques phrases\r\n', '', 11, 2),
(95, 'Écrire sous la dictée des expressions connues\r\n', '', 11, 2),
(96, 'Copier, écrire sous la dictée\r\n', '', 11, 3),
(97, 'Renseigner un questionnaire\r\n', '', 11, 3),
(98, 'Écrire un message simple\r\n', '', 11, 3),
(99, 'Rendre compte de faits\r\n', '', 11, 3),
(100, 'Écrire un court récit, une description\r\n', '', 11, 3),
(101, 'Pratiquer une démarche d’investigation : savoir observer, questionner\r\n', '', 12, 2),
(102, 'Manipuler et expérimenter, formuler une hypothèse et la tester, argumenter, mettre à l’essai plusieurs pistes de solutions\r\n', '', 12, 2),
(103, 'Exprimer et exploiter les résultats d’une mesure et d’une recherche en utilisant un vocabulaire scientifique à l’écrit ou à l’oral\r\n', '', 12, 2),
(104, 'Rechercher, extraire et organiser l’information utile\r\n', '', 12, 3),
(105, 'Réaliser, manipuler, mesurer, calculer, appliquer des consignes\r\n', '', 12, 3),
(106, 'Raisonner, argumenter, pratiquer une démarche expérimentale ou technologique, démontrer\r\n', '', 12, 3),
(107, 'Présenter la démarche suivie, les résultats obtenus, communiquer à l’aide d’un langage adapté\r\n', '', 12, 3),
(108, 'Écrire, nommer, comparer, ranger les nombres entiers naturels inférieurs à 1000\r\n', '', 13, 1),
(109, 'Résoudre des problèmes de dénombrement\r\n', '', 13, 1),
(110, 'Calculer : addition, soustraction, multiplication\r\n', '', 13, 1),
(111, 'Diviser par 2 et par 5 dans le cas où le quotient exact est entier\r\n', '', 13, 1),
(112, 'Restituer et utiliser les tables d’addition et de multiplication par 2, 3, 4 et 5\r\n', '', 13, 1),
(113, 'Calculer mentalement en utilisant des additions, des soustractions et des multiplications simples\r\n', '', 13, 1),
(114, 'Résoudre des problèmes relevant de l’addition, de la soustraction et de la multiplication\r\n', '', 13, 1),
(115, 'Utiliser les fonctions de base de la calculatrice\r\n', '', 13, 1),
(116, 'Écrire, nommer, comparer et utiliser les nombres entiers, les nombres décimaux (jusqu’au centième) et quelques fractions simples\r\n', '', 13, 2),
(117, 'Restituer les tables d’addition et de multiplication de 2 à 9\r\n', '', 13, 2),
(118, 'Utiliser les techniques opératoires des quatre opérations sur les nombres entiers et décimaux (pour la division, le diviseur est un nombre entier)\r\n', '', 13, 2),
(119, 'Ajouter deux fractions décimales ou deux fractions simples de même dénominateur\r\n', '', 13, 2),
(120, 'Calculer mentalement en utilisant les quatre opérations\r\n', '', 13, 2),
(121, 'Estimer l’ordre de grandeur d’un résultat\r\n', '', 13, 2),
(122, 'Résoudre des problèmes relevant des quatre opérations\r\n', '', 13, 2),
(123, 'Utiliser une calculatrice\r\n', '', 13, 2),
(124, 'Connaître et utiliser les nombres entiers, décimaux et fractionnaires.\r\n', '', 13, 3),
(125, 'Mener à bien un calcul : mental, à la main, à la calculatrice, avec un ordinateur\r\n', '', 13, 3),
(126, ' Situer un objet par rapport à soi ou à un autre objet, donner sa position et décrire son déplacement\r\n', '', 14, 1),
(127, 'Reconnaître, nommer et décrire les figures planes et les solides usuels\r\n', '', 14, 1),
(128, 'Utiliser la règle et l’équerre pour tracer avec soin et précision un carré, un rectangle, un triangle rectangle\r\n', '', 14, 1),
(129, 'Percevoir et reconnaître quelques relations et propriétés géométriques : alignement, angle droit, axe de symétrie, égalité de longueurs\r\n', '', 14, 1),
(130, 'Repérer des cases, des noeuds d’un quadrillage\r\n', '', 14, 1),
(131, 'Résoudre un problème géométrique\r\n', '', 14, 1),
(132, 'Reconnaître, décrire et nommer les figures et solides usuels\r\n', '', 14, 2),
(133, 'Utiliser la règle, l’équerre et le compas pour vérifier la nature de figures planes usuelles et les construire avec soin et précision\r\n', '', 14, 2),
(134, 'Percevoir et reconnaître parallèles et perpendiculaires\r\n', '', 14, 2),
(135, 'Résoudre des problèmes de reproduction, de construction\r\n', '', 14, 2),
(136, 'Connaître et représenter des figures géométriques et des objets de l’espace.\r\n', '', 14, 3),
(137, 'Utiliser leurs propriétés\r\n', '', 14, 3),
(138, 'Utiliser les unités usuelles de mesure, estimer une mesure\r\n', '', 15, 1),
(139, 'Être précis et soigneux dans les mesures et les calculs\r\n', '', 15, 1),
(140, 'Résoudre des problèmes de longueur et de masse\r\n', '', 15, 1),
(141, 'Utiliser des instruments de mesure\r\n', '', 15, 2),
(142, 'Connaître et utiliser les formules du périmètre et de l’aire d’un carré, d’un rectangle et d’un triangle\r\n', '', 15, 2),
(143, 'Utiliser les unités de mesures usuelles\r\n', '', 15, 2),
(144, ' Résoudre des problèmes dont la résolution implique des conversions\r\n', '', 15, 2),
(145, 'Réaliser des mesures (longueurs, durées, …), calculer des valeurs (volumes, vitesses, …) en utilisant différentes unités\r\n', '', 15, 3),
(146, 'Utiliser un tableau, un graphique\r\n', '', 16, 1),
(147, 'Organiser les données d’un énoncé\r\n', '', 16, 1),
(148, 'Lire, interpréter et construire quelques représentations simples : tableaux, graphiques\r\n', '', 16, 2),
(149, 'Savoir organiser des informations numériques ou géométriques, justifier et apprécier la vraisemblance d’un résultat\r\n', '', 16, 2),
(150, 'Résoudre un problème mettant en jeu une situation de proportionnalité\r\n', '', 16, 2),
(151, 'Reconnaître des situations de proportionnalité, utiliser des pourcentages, des tableaux, des graphiques\r\n', '', 16, 3),
(152, 'Exploiter des données statistiques et aborder des situations simples de probabilité\r\n', '', 16, 3),
(153, 'Maîtriser des connaissances dans divers domaines scientifiques et les mobiliser dans des contextes scientifiques différents et dans des activités de la vie courante\r\n', '', 17, 2),
(154, 'Le ciel et la Terre\r\n', '', 17, 2),
(155, 'La matière\r\n', '', 17, 2),
(156, 'L’énergie\r\n', '', 17, 2),
(157, 'L’unité et la diversité du vivant\r\n', '', 17, 2),
(168, 'Le fonctionnement du vivant\r\n', '', 17, 2),
(169, 'Le fonctionnement du corps humain et la santé\r\n', '', 17, 2),
(170, 'Les êtres vivants dans leur environnement\r\n', '', 17, 2),
(171, 'Les objets techniques\r\n', '', 17, 2),
(172, 'Savoir utiliser des connaissances dans divers domaines scientifiques \r\n', '', 17, 3),
(173, 'L’univers et la Terre : organisation de l’univers, structure et évolution au cours des temps géologiques de la Terre, phénomènes physiques\r\n', '', 17, 3),
(174, 'La matière : principales caractéristiques, états et transformations, propriétés physiques et chimiques de la matière et des matériaux, comportement électrique, interactions avec la lumière\r\n', '', 17, 3),
(175, 'Le vivant : unité d’organisation et diversité, fonctionnement des organismes vivants, évolution des espèces, organisation et fonctionnement du corps humain\r\n', '', 17, 3),
(176, 'L’énergie : différentes formes d’énergie, notamment l’énergie électrique, et transformations d’une forme à une autre\r\nLes objets techniques : analyse, conception et réalisation, fonctionnement et conditions d’utilisation\r\n', '', 17, 3),
(177, 'Mobiliser ses connaissances pour comprendre une question liée à l’environnement et au développement durable et agir en conséquence\r\n\r\n', '', 18, 2),
(178, 'Mobiliser ses connaissances pour comprendre des questions liées à l’environnement et au développement durable\r\n', '', 18, 2),
(179, 'Connaître et maîtriser les fonctions de base d’un ordinateur et de ses périphériques\r\n', '', 19, 2),
(180, 'Utiliser, gérer des espaces de stockage à disposition\r\n', '', 19, 3),
(181, 'Utiliser les périphériques à disposition\r\n', '', 19, 3),
(182, 'Utiliser les logiciels et les services à disposition\r\n', '', 19, 3),
(183, 'Prendre conscience des enjeux citoyens de l’usage de l’informatique et de l’internet et adopter une attitude critique face aux résultats obtenus\r\n', '', 20, 2),
(184, 'Connaître et respecter les règles élémentaires du droit relatif à sa pratique\r\n', '', 20, 3),
(185, 'Protéger sa personne et ses données\r\n', '', 20, 3),
(186, 'Faire preuve d’esprit critique face à l’information et à son traitement\r\n', '', 20, 3),
(187, 'Participer à des travaux collaboratifs en connaissant les enjeux et en respectant les règles\r\n', '', 20, 3),
(188, 'Produire un document numérique : texte, image, son\r\n', '', 21, 2),
(189, 'Utiliser l’outil informatique pour présenter un travail\r\n', '', 21, 2),
(190, 'Saisir et mettre en page un texte\r\n', '', 21, 3),
(191, 'Traiter une image, un son ou une vidéo\r\n', '', 21, 3),
(192, 'Organiser la composition du document, prévoir sa présentation en fonction de sa destination\r\n', '', 21, 3),
(193, 'Différencier une situation simulée ou modélisée d’une situation réelle\r\n', '', 21, 3),
(194, 'Lire un document numérique\r\n', '', 22, 2),
(195, 'Chercher des informations par voie électronique\r\n', '', 22, 2),
(196, 'Découvrir les richesses et les limites des ressources de l’internet\r\n', '', 22, 2),
(197, 'Consulter des bases de données documentaires en mode simple (plein texte)\r\n', '', 22, 3),
(198, 'Identifier, trier et évaluer des ressources\r\n', '', 22, 3),
(199, 'Chercher et sélectionner l’information demandée\r\n', '', 22, 3),
(200, 'Échanger avec les technologies de l’information et de la communication\r\n', '', 23, 2),
(201, 'Écrire, envoyer, diffuser, publier\r\n', '', 23, 3),
(202, 'Recevoir un commentaire, un message y compris avec pièces jointes\r\n', '', 23, 3),
(203, 'Exploiter les spécificités des différentes situations de communication en temps réel ou différé\r\n', '', 23, 3),
(204, 'Identifier les périodes de l’histoire au programme\r\n', '', 24, 2),
(205, 'Connaître et mémoriser les principaux repères chronologiques (événements et personnages)\r\n', '', 24, 2),
(206, ' Connaître les principaux caractères géographiques physiques et humains de la région où vit l’élève, de la France et de l’Union européenne, les repérer sur des cartes à différentes échelles\r\n', '', 24, 2),
(207, ' Comprendre une ou deux questions liées au développement durable et agir en conséquence, (l’eau dans la  commune, la réduction et le recyclage des déchets)\r\n', '', 24, 2),
(208, 'Lire des oeuvres majeures du patrimoine et de la littérature pour la jeunesse\r\n', '', 25, 2),
(209, 'Établir des liens entre les textes lus\r\n', '', 25, 2),
(210, 'Relevant de l’espace : les grands ensembles physiques et humains et les grands types d’aménagements dans le monde, les principales caractéristiques géographiques de la France et de l’Europe\r\n', '', 26, 3),
(211, 'Relevant du temps : les différentes périodes de l’histoire de l’humanité - Les grands traits de l’histoire (politique, sociale, économique, littéraire, artistique, culturelle) de la France et de l’Europe\r\n', '', 26, 3),
(212, 'Relevant de la culture littéraire : oeuvres littéraires du patrimoine\r\n', '', 26, 3),
(213, ' Relevant de la culture artistique : oeuvres picturales, musicales, scéniques, architecturales ou cinématographiques du patrimoine\r\n', '', 26, 3),
(214, 'Relevant de la culture civique : Droits de l’Homme – Formes d’organisation politique, économique et sociale dans l’Union européenne – Place et rôle de l’État en France – Mondialisation –Développement durable\r\n', '', 26, 3),
(215, 'Situer des événements, des oeuvres littéraires ou artistiques, des découvertes scientifiques ou techniques, des ensembles géographiques\r\n', '', 27, 3),
(216, 'Identifier la diversité des civilisations, des langues, des sociétés, des religions\r\n', '', 27, 3),
(217, 'Etablir des liens entre les oeuvres (littéraires, artistiques) pour mieux les comprendre\r\n', '', 27, 3),
(218, 'Mobiliser ses connaissances pour donner du sens à l’actualité\r\n', '', 27, 3),
(219, 'Lire et utiliser textes, cartes, croquis, graphiques\r\n', '', 28, 2),
(220, 'Pratiquer le dessin et diverses formes d’expressions visuelles et plastiques\r\n', '', 28, 2),
(221, 'Interpréter de mémoire une chanson, participer à un jeu rythmique ; repérer des éléments musicaux caractéristiques simples\r\n', '', 28, 2),
(222, 'Inventer et réaliser des textes, des oeuvres plastiques, des chorégraphies ou des enchaînements, à visée artistique ou expressive\r\n', '', 28, 2),
(223, 'Lire et employer différents langages : textes – graphiques – cartes – images – musique\r\n', '', 28, 3),
(224, 'Connaître et pratiquer diverses formes d’expression à visée littéraire\r\n', '', 28, 3),
(225, 'Connaître et pratiquer diverses formes d’expression à visée artistique\r\n', '', 28, 3),
(226, 'Distinguer les grandes catégories de la création artistique (littérature, musique, danse, théâtre, cinéma, dessin,  peinture, sculpture, architecture)\r\n', '', 29, 2),
(227, 'Reconnaître et décrire des oeuvres préalablement étudiées\r\n', '', 29, 2),
(228, 'Pratiquer le dessin et diverses formes d’expressions visuelles et plastiques\r\n', '', 29, 2),
(229, ' Interpréter de mémoire une chanson, participer à un jeu rythmique ; repérer des éléments musicaux caractéristiques simples\r\n', '', 29, 2),
(230, 'Inventer et réaliser des textes, des oeuvres plastiques, des chorégraphies ou des enchaînements, à visée artistique ou expressive\r\n', '', 29, 2),
(231, 'Être sensible aux enjeux esthétiques et humains d’un texte littéraire\r\n', '', 30, 3),
(232, 'Être sensible aux enjeux esthétiques et humains d’une oeuvre artistique\r\n', '', 30, 3),
(233, 'Être capable de porter un regard critique sur un fait, un document, une oeuvre\r\n', '', 30, 3),
(234, 'Manifester sa curiosité pour l’actualité et pour les activités culturelles ou artistiques\r\n', '', 30, 3);

-- --------------------------------------------------------

--
-- Structure de la table `discipline`
--

CREATE TABLE IF NOT EXISTS `discipline` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(80) NOT NULL,
  `acronyme` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `discipline`
--

INSERT INTO `discipline` (`id`, `intitule`, `acronyme`) VALUES
(1, 'Maîtrise de la langue française', 'LF'),
(2, 'Pratique d''une langue vivante étrangère', 'LVE'),
(3, 'Principaux éléments de mathématiques et la culture scientifique et technologique', 'MST'),
(4, 'Maîtrise des techniques usuelles de l''information et de la communication', 'TIC'),
(5, 'Culture humaniste', 'CH'),
(6, 'Compétences sociales et civiques', 'CSS'),
(7, 'Autonomie et initiative', 'AI');

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE IF NOT EXISTS `eleve` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `age` date NOT NULL,
  `voie` varchar(10) NOT NULL,
  `num` smallint(3) unsigned NOT NULL,
  `complement` varchar(50) NOT NULL,
  `cpost` mediumint(5) unsigned NOT NULL,
  `ville` varchar(25) NOT NULL,
  `FKclasse` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `eleve`
--

INSERT INTO `eleve` (`id`, `nom`, `prenom`, `photo`, `age`, `voie`, `num`, `complement`, `cpost`, `ville`, `FKclasse`) VALUES
(1, 'Traversière', 'François', '63e503ae6e42cefe770b7ea635906d5n.jpg', '2004-03-04', 'rue', 5, 'des tulipes', 75020, 'Paris', 53),
(2, 'Mougier', 'Jean-Luc', '63e503ae6e42cefe770b7ea635906d5a.jpg', '2000-01-18', 'boulevard', 71, 'des Maraichers', 75011, 'Paris', 53),
(3, 'Dupuit', 'Emilie', '63e503ae6e42cefe770b7ea635906d5z.jpg', '2004-08-20', 'route', 66, 'du chemin vert', 78450, 'Marne-La-Vallée', 53),
(9, 'Parvis', 'Virginie', '63e503ae6e42cefe770b7ea635906d5e.jpg', '1998-04-12', 'rue', 45, 'des champs', 45212, 'Nantes', 53),
(10, 'Pinkday', 'Arnaud', 'dc11f5177984dcc674a2eb5f963ec9fb.gif', '1982-05-12', 'rue', 5, 'des peupliers', 21540, 'Busette', 53);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(25) NOT NULL,
  `color` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`id`, `intitule`, `color`) VALUES
(1, 'nul', 'rouge'),
(2, 'essentiel', 'orange'),
(3, 'aisance', 'jaune'),
(4, 'expert', 'vert');

-- --------------------------------------------------------

--
-- Structure de la table `pallier`
--

CREATE TABLE IF NOT EXISTS `pallier` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `pallier`
--

INSERT INTO `pallier` (`id`, `intitule`) VALUES
(1, '1er pallier'),
(2, '2em pallier'),
(3, '3em pallier');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) NOT NULL,
  `password` char(60) NOT NULL,
  `statut` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `password`, `statut`) VALUES
(1, 'Olive', '$2y$10$Rr9BiRwjEenmAxUyMl.IBe6Pf4S1tF2xPiczRQXc6N1xJGfgGXIMK', 1),
(2, 'Arnaud', '$2y$10$VICuuyXJwZw9s9LGQORpe.c/.p.bL31l1mcltlwXC15q9CTVKE06y', 0),
(3, 'toto', '$2y$10$K/GPQfb7ulUI9KzTbw8PC.f7MR0xJibO4SHBdEH0dVWGZ2ruEu3BC', 0);

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

CREATE TABLE IF NOT EXISTS `validation` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `FKeleve` tinyint(2) unsigned NOT NULL,
  `FKcompetence` smallint(3) unsigned NOT NULL,
  `first` date NOT NULL,
  `FKcompensationA` tinyint(1) unsigned NOT NULL,
  `second` date NOT NULL,
  `FKcompensationB` tinyint(1) unsigned NOT NULL,
  `last` date NOT NULL,
  `FKcompensationC` tinyint(1) unsigned NOT NULL,
  `FKetat` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKeleve_id` (`FKeleve`),
  KEY `FKcompetence_id` (`FKcompetence`),
  KEY `FKetat_id` (`FKetat`),
  KEY `FKcompensationA_id` (`FKcompensationA`),
  KEY `FKcompensationB_id` (`FKcompensationB`),
  KEY `FKcompensationC_id` (`FKcompensationC`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `validation`
--

INSERT INTO `validation` (`id`, `FKeleve`, `FKcompetence`, `first`, `FKcompensationA`, `second`, `FKcompensationB`, `last`, `FKcompensationC`, `FKetat`) VALUES
(2, 3, 1, '2015-01-12', 1, '2015-05-04', 1, '0000-00-00', 1, 3),
(3, 3, 2, '2015-08-07', 1, '0000-00-00', 1, '0000-00-00', 1, 2),
(4, 3, 3, '2015-02-09', 1, '2015-11-14', 1, '2016-03-01', 1, 4),
(6, 2, 47, '2016-01-29', 1, '1954-05-24', 1, '2001-06-12', 1, 4),
(8, 2, 15, '2016-01-29', 1, '2002-01-03', 1, '2008-06-12', 1, 4),
(9, 2, 33, '2016-01-29', 1, '2001-06-12', 1, '2016-03-30', 1, 4),
(10, 3, 47, '2016-01-29', 1, '2001-06-12', 1, '2016-04-06', 7, 4),
(11, 1, 6, '2008-09-16', 1, '2011-06-08', 1, '2014-01-25', 1, 4),
(12, 1, 3, '1999-07-18', 1, '2001-02-09', 1, '0000-00-00', 1, 3),
(13, 1, 83, '2016-02-20', 1, '2016-03-21', 4, '0000-00-00', 1, 3),
(14, 1, 113, '2016-03-20', 1, '0000-00-00', 1, '0000-00-00', 1, 2),
(15, 1, 179, '2016-03-20', 1, '2016-03-30', 1, '0000-00-00', 1, 3),
(16, 1, 66, '2016-03-20', 2, '0000-00-00', 1, '0000-00-00', 1, 2),
(17, 1, 205, '2016-03-20', 1, '0000-00-00', 1, '0000-00-00', 1, 2),
(18, 3, 5, '2016-04-04', 7, '2016-04-04', 7, '2016-04-04', 7, 4),
(19, 2, 5, '2016-04-06', 7, '2016-04-06', 7, '2016-04-06', 7, 4);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`FKdiscipline`) REFERENCES `discipline` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`FKuser`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `competence`
--
ALTER TABLE `competence`
  ADD CONSTRAINT `competence_ibfk_1` FOREIGN KEY (`FKcategorie`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `competence_ibfk_2` FOREIGN KEY (`FKpallier`) REFERENCES `pallier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `validation`
--
ALTER TABLE `validation`
  ADD CONSTRAINT `validation_ibfk_1` FOREIGN KEY (`FKeleve`) REFERENCES `eleve` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validation_ibfk_2` FOREIGN KEY (`FKcompetence`) REFERENCES `competence` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validation_ibfk_3` FOREIGN KEY (`FKetat`) REFERENCES `etat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validation_ibfk_4` FOREIGN KEY (`FKcompensationC`) REFERENCES `compensation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validation_ibfk_5` FOREIGN KEY (`FKcompensationA`) REFERENCES `compensation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `validation_ibfk_6` FOREIGN KEY (`FKcompensationB`) REFERENCES `compensation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
