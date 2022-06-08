-- Création de la table Inscrits

CREATE TABLE Inscrits (
     login varchar(16) NOT NULL,
     nom varchar(64) NOT NULL,
     prénom varchar(64),
     mdp varchar(64),
     courriel varchar(128),
     validation varchar(64),
     rôle varchar(32), -- ROLE_UTILISATEUR, ROLE_REDACTEUR, ROLE_ADMIN
     PRIMARY KEY (login)
) CHARSET='utf8' COMMENT='Liste des inscrits';

-- 
-- Contenu de la table `Inscrits`
-- 
INSERT INTO Inscrits (login, nom, prénom, mdp, courriel, validation, rôle) 
VALUES ('adm', 'gallion', 'ugo', '123', 'gallion.ugo.pro@gmail.com', '', 'ROLE_ADMIN'),
       ('red', 'gallion', 'ugo', '1234', 'gallion.ugo.pro@gmail.com', '', 'ROLE_REDACTEUR'),
       ('uti', 'nom', 'prenom', '12345', 'gallion.ugo.pro@gmail.com', '', 'ROLE_UTILISATEUR');

