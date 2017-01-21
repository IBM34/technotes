-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2016 at 09:48 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `technotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_note` int(11) NOT NULL,
  `id_reponse` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `commentaire` text NOT NULL,
  `date_commentaire` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `commentaires`
--

INSERT INTO `commentaires` (`id`, `id_note`, `id_reponse`, `pseudo`, `commentaire`, `date_commentaire`) VALUES
(1, 0, 1, 'ivan', 'Merci ! je marque la question comme résolue !', '2016-04-29 21:18:33'),
(2, 3, 0, 'ivan', 'Très bon article ! ', '2016-04-29 21:21:06'),
(3, 4, 0, 'user', 'J''adore le javascript ! Cela me donne envie de faire une technote sur le php', '2016-04-29 21:24:12'),
(6, 4, 0, 'ivan', 'génial ! j''ai hâte de voir ça !', '2016-04-29 21:26:38'),
(7, 2, 0, 'ivan', 'Merci, je ne connaissais pas cette fonctionnalité', '2016-04-29 21:27:46'),
(8, 1, 0, 'ivan', 'Merci pour cette technote, cela donne envie de s''y mettre !', '2016-04-29 21:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `actions` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` (`id`, `titre`, `actions`) VALUES
(1, 'administrateur', 127),
(2, 'membre', 31);

-- --------------------------------------------------------

--
-- Table structure for table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_groupe` int(1) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `membres`
--

INSERT INTO `membres` (`id`, `id_groupe`, `pseudo`, `email`, `password`, `statut`) VALUES
(1, 1, 'admin', 'admin@hotmail.fr', 'e4e99f400ebfee197ed6f4e2b0238cd0f9fca6ed', 'Active'),
(2, 2, 'user', 'user@hotmail.fr', 'e4e99f400ebfee197ed6f4e2b0238cd0f9fca6ed', 'Active'),
(3, 2, 'ivan', 'ivan.brunet@hotmail.fr', 'ed3b1efc8c5aa7a026a8302a627ad5f754ed115c', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `mots_cles`
--

CREATE TABLE IF NOT EXISTS `mots_cles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_note` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `mot` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mots_cles`
--

INSERT INTO `mots_cles` (`id`, `id_note`, `id_question`, `mot`) VALUES
(1, 1, 0, 'C'),
(2, 1, 0, 'expressions régulières'),
(3, 1, 0, 'regexp'),
(4, 2, 0, 'localStorage'),
(5, 2, 0, 'mémoire'),
(6, 2, 0, 'navigateur'),
(7, 0, 1, 'md5'),
(8, 0, 1, 'sha1'),
(9, 0, 1, 'hash'),
(10, 0, 2, 'mail'),
(11, 0, 2, ' php'),
(12, 0, 2, ' site'),
(13, 0, 2, 'internet'),
(14, 0, 3, ''),
(15, 0, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `pseudo`, `titre`, `contenu`, `date_creation`) VALUES
(1, 'user', 'Expressions régulières en C', 'Les expressions régulières sont des chaînes de caractères qui se contentent de décrire un motif. Elles ont la réputation d''avoir une syntaxe difficile à apprendre et à relire, ce qui, j''espère vous en convaincre, est faux.\r\nCe tutoriel utilise la bibliothèque regex qui fait partie du projet GNU. Cette bibliothèque nécessite un système compatible POSIX.2 (la compilation s''est déroulée sans problème avec cygwin sous Windows XP). \r\n\r\n- regcomp\r\n[code]\r\nint regcomp (regex_t *preg, const char *regex, int cflags);\r\n[/code]\r\n\r\n Cette fonction a pour but de compiler l''expression régulière regex fournie sous forme de chaîne de caractères pour la transformer en structure de type dont l''adresse est passée en premier argument. Il est possible de modifier le comportement de cette fonction par l''intermédiaire de cflags qui peut être un OU binaire de l''une des constantes suivantes :\r\n\r\n-REG_EXTENDED : permet d''utiliser le modèle d''expression régulière étendu plutôt que le mode basique qui est l''option par défaut\r\n-REG_ICASE : permet d''ignorer la casse (minuscules/majuscules)\r\n-REG_NOSUB : compile pour vérifier uniquement la concordance (vrai ou faux)\r\n-REG_NEWLINE : Par défaut, le caractère de fin de ligne est un caractère normal. Avec cette option, les expressions ''[^'', ''.'' et ''$'' (nous reviendrons plus tard sur la signification de ces expressions) incluent le caractère de fin de ligne implicitement. L''ancre ''^'' reconnaît une chaîne vide après un caractère de fin de ligne.\r\n\r\nEn cas de succès, la fonction retourne 0. En cas d''échec de la compilation, retourne un code d''erreur non nul. \r\n\r\n-regexec\r\n\r\n[code]\r\nint regexec (const regex_t *preg, const char *string, size_t nmatch, regmatch_t pmatch[], int eflags);\r\n[/code]\r\n\r\nUne fois notre expression compilée, on va pouvoir la comparer à la chaîne de caractères string à l''aide de cette fonction. Le résultat de la comparaison sera stocké dans le tableau pmatch alloué à nmatch éléments par nos soins. Il est possible de modifier le comportement de grâce à eflags :\r\n\r\nREG_NOTBOL : le premier caractère de la chaîne échoue toujours. Ceci n''a pas d''effet s''il s''agit du caractère de fin de ligne et que l''option REG_NEWLINE a été utilisée pour compiler l''expression régulière\r\nREG_NOTEOL : idem sauf qu''il s''agit du dernier caractère. La remarque à propos de REG_NEWLINE est également valable\r\n\r\nretourne 0 en cas de succès ou REG_NOMATCH en cas d''échec.\r\n', '2016-04-29 18:10:55'),
(2, 'admin', 'LocalStorage dans un navigateur', 'C''est sans doute l''une des prorpiétés les plus intéressantes du HTML5: Le local storage, ou le stockage local.\r\n\r\nEn effet, grâce à cette propriété, il sera désormais possible de stocker des données localement dans votre navigateur (supportant la propriété bien sûr).\r\n\r\nLes données sont stockées pour un domaine précis et peuvent récupérées dans n''importe quelle page du domaine en question.\r\n\r\nLa propriété s''annonce comme le remplacement des cookies à la différence qu''il est possible de stocker bien plus d''informations (Environ 5 Mb) et que seul le client peut accéder à ces données.\r\n\r\nPassons maintenant à la pratique en utilisant les fonctions dédiées:\r\n\r\n \r\nStocker une valeur locale (HTML5)\r\n\r\nIl y''a deux façons de procéder pour stocker localement:\r\n\r\n[code]\r\nlocalStorage[''maCle''] = "Ma valeur";\r\n[/code]\r\n\r\nou\r\n\r\n[code]\r\nlocalStorage.setitem("maCle", "Ma valeur");\r\n[/code]\r\n \r\nRécupérer une valeur locale (HTML5)\r\n\r\nAprès avoir stocké une donnée, vous avez là aussi deux possibilités de la récupérer:\r\n\r\n[code]\r\nlocalStorage[''maCle'']\r\n[/code]\r\n\r\nou\r\n\r\n[code]\r\nlocalStorage.getitem[''maCle'']\r\n[/code]\r\n\r\nFacile non ?', '2016-04-29 18:18:16'),
(3, 'user', 'Qu''est ce que PHP?', ' PHP (officiellement, ce sigle est un acronyme récursif pour PHP Hypertext Preprocessor) est un langage de scripts généraliste et Open Source, spécialement conçu pour le développement d''applications web. Il peut être intégré facilement au HTML.\r\n\r\nBien... mais qu''est ce que cela veut dire ? Un exemple :\r\n\r\nExemple #1 Exemple d''introduction\r\n\r\n[code]\r\n<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"\r\n"http://www.w3.org/TR/html4/loose.dtd">\r\n<html>\r\n<head>\r\n<title>Exemple</title>\r\n</head>\r\n<body>\r\n\r\n<?php\r\necho "Bonjour, je suis un script PHP !";\r\n?>\r\n\r\n</body>\r\n</html>\r\n[/code]\r\n\r\nAu lieu d''utiliser des tonnes de commandes afin d''afficher du HTML (comme en C ou en Perl), les pages PHP contiennent des fragments HTML dont du code qui fait "quelque chose" (dans ce cas, il va afficher "Bonjour, je suis un script PHP !"). Le code PHP est inclus entre une balise de début <?php et une balise de fin ?> qui permettent au serveur web de passer en mode PHP.\r\n\r\nCe qui distingue PHP des langages de script comme le Javascript, est que le code est exécuté sur le serveur, générant ainsi le HTML, qui sera ensuite envoyé au client. Le client ne reçoit que le résultat du script, sans aucun moyen d''avoir accès au code qui a produit ce résultat. Vous pouvez configurer votre serveur web afin qu''il analyse tous vos fichiers HTML comme des fichiers PHP. Ainsi, il n''y a aucun moyen de distinguer les pages qui sont produites dynamiquement des pages statiques.\r\n\r\nLe grand avantage de PHP est qu''il est extrêmement simple pour les néophytes, mais offre des fonctionnalités avancées pour les experts. Ne craignez pas de lire la longue liste de fonctionnalités PHP. Vous pouvez vous plonger dans le code, et en quelques instants, écrire des scripts simples. ', '2016-04-27 00:00:00'),
(4, 'ivan', 'Qu’est-ce que Javascript et à quoi ça sert ?', 'La question parait bête, mais je me la suis posé il y a des années. Et personne n’avait écrit un article pour expliquer ça. Personne. C’était tellement évident.\r\n\r\nCet article est pour toi, étudiant en info, commercial dans une boîte IT ou juste curieux qui trouve que l’article Wikipedia ne veut rien dire.\r\nCe que c’est\r\n\r\nJavascript est un langage de programmation, c’est une forme de code qui permet, quand on sait l’écrire, de dicter à l’ordinateur quoi faire.\r\n\r\nLe code Javascript ressemble à ça :\r\n\r\n[code]\r\nsetTimeout(function(){\r\n    if (truc == machin) {\r\n        alert(''Bidule !'')\r\n    }\r\n}, 100)\r\n[/code]\r\n\r\nC’est du texte. Juste du texte. Comme une autre langue.\r\n\r\nOn trouve la majorité du code Javascript dans des pages Web, même si vous ne le voyez pas s’afficher. En effet, c’est le seul langage qui permette de dicter à un navigateur Web (Internet Explorer, Firefox, Chrome…) ce qu’il doit faire sans rien installer. La grande majorité des navigateurs Web “parlent” le Javascript.\r\nCe qu’on peut faire avec\r\n\r\nLa plupart du code Javascript se trouve dans des pages Web, et sert donc à dire comme la page Web doit réagir. Cela marche ainsi :\r\n\r\n    L’utilisateur clique sur un lien ou entre une adresse.\r\n    Son navigateur charge la page Web. Il voit le texte, les couleurs, les images.\r\n    Si la page Web contient du code Javascript, le navigateur lit le code Javascript et suit les instructions du code.\r\n\r\nGénéralement le code Javascript dans une page Web sert à :\r\n\r\n    Faire bouger, apparaitre ou disparaitre des éléments de la page (un titre, un menu, un paragraphe, une image…).\r\n    Mettre à jour des éléments de la page sans recharger la page (changer le texte, recalculer un nombre, etc).\r\n    Demander au serveur un nouveau bout de page et l’insérer dans la page en cours, sans la recharger.\r\n    Attendre que l’utilisateur face quelque chose (cliquer, taper au clavier, bouger la souris…) et réagir (faire une des opérations ci-dessus suite à cette action).\r\n\r\nLe code Javascript sert donc à donner du dynamisme à la page. Sans lui, la page ressemble à une page de livre, un peu animée (grâce à un autre langage appelé le CSS), mais qui ne change pas beaucoup.', '2016-04-24 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `titre` text NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `pseudo`, `titre`, `contenu`, `date_creation`, `statut`) VALUES
(1, 'ivan', 'md5 ou sha1 ?', 'Bonjour, quel Hash choisir entre md5 et sha1 ?', '2016-04-22 05:18:28', 'resolue'),
(2, 'user', 'Envoyer un mail', 'Bonjour, je voudrais savoir comment envoyer un mail depuis un site internet.', '2016-04-29 21:35:57', 'irresolue');

-- --------------------------------------------------------

--
-- Table structure for table `reponses`
--

CREATE TABLE IF NOT EXISTS `reponses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `reponse` text NOT NULL,
  `date_reponse` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `reponses`
--

INSERT INTO `reponses` (`id`, `id_question`, `pseudo`, `reponse`, `date_reponse`) VALUES
(1, 1, 'user', 'Plus la chaine générée est grande, plus celle-ci est sécurisée et il y a moins de chance d’avoir des juxtapositions de valeur pour un mot de passe. voici 2 exemples: md5:fbade9e36a3f36d3d676c1b808451dd7 VARCHAR(32) sha1:395df8f7c51f007019cb30201c49e884b46b92fa VARCHAR(40)  Je te conseille donc plutot sha1.', '2016-04-29 21:17:03'),
(2, 2, 'ivan', 'Il faut utiliser la fonction mail() de php ;)', '2016-04-29 21:36:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
