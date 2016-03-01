BEGIN;

DROP TABLE IF EXISTS COMITE CASCADE;
CREATE TABLE COMITE (
  nom TEXT PRIMARY KEY
);


DROP TABLE IF EXISTS ORGANISME_PROJET CASCADE; --OK
CREATE TABLE ORGANISME_PROJET (
	nom TEXT PRIMARY KEY,
	date_creation DATE NOT NULL,
	duree INTEGER
);

DROP TABLE IF EXISTS APPEL_A_PROJET CASCADE; --OK
CREATE TABLE APPEL_A_PROJET (
	nom TEXT,
	organisme TEXT,
	publication DATE,
	duree INTEGER NOT NULL,
	theme TEXT NOT NULL,
	description TEXT NOT NULL,
	comite TEXT NOT NULL,
	PRIMARY KEY (nom, organisme, publication),
	FOREIGN KEY (organisme) REFERENCES ORGANISME_PROJET ON DELETE CASCADE,
	FOREIGN KEY (comite) REFERENCES COMITE ON DELETE CASCADE
);

DROP TABLE IF EXISTS PROPOSITION_DE_PROJET CASCADE;  --OK
CREATE TABLE PROPOSITION_DE_PROJET (
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	date_reponse DATE,
	date_emission DATE NOT NULL,
	statut BOOLEAN,
	CHECK (date_reponse >= date_emission),
	PRIMARY KEY (numero, appel, organisme, publication_appel),
	FOREIGN KEY (appel,organisme,publication_appel) REFERENCES APPEL_A_PROJET(nom,organisme,publication) ON DELETE CASCADE
);

DROP TABLE IF EXISTS PROJET CASCADE; --OK
CREATE TABLE PROJET (
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	date_debut DATE NOT NULL,
	date_fin DATE,
	CHECK (date_debut <= date_fin),
	PRIMARY KEY (numero, appel, organisme, publication_appel),
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES PROPOSITION_DE_PROJET(numero, appel, organisme, publication_appel) ON DELETE CASCADE
);

DROP TABLE IF EXISTS BUDGET CASCADE;  --OK
CREATE TABLE BUDGET (
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	budget_total FLOAT NOT NULL,
	PRIMARY KEY (numero, appel, organisme, publication_appel),
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES PROJET(numero, appel, organisme, publication_appel) ON DELETE CASCADE
);

DROP TYPE IF EXISTS TYPE_DEPENSE CASCADE;
CREATE TYPE TYPE_DEPENSE AS ENUM ('materiel', 'fonctionnement');

DROP TABLE IF EXISTS LIGNES_BUDGETAIRE CASCADE; --OK
CREATE TABLE LIGNES_BUDGETAIRE (
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	objet TEXT,
	montant FLOAT NOT NULL,
	type TYPE_DEPENSE NOT NULL,
	PRIMARY KEY (numero, appel, organisme, publication_appel, objet),
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES BUDGET(numero, appel, organisme, publication_appel) ON DELETE CASCADE
);

DROP TABLE IF EXISTS MEMBRE_COMITE CASCADE;
CREATE TABLE MEMBRE_COMITE (
	id INTEGER,
	comite TEXT,
	nom TEXT NOT NULL,
  password TEXT NOT NULL,
	mail TEXT UNIQUE,
	telephone VARCHAR(22),
	PRIMARY KEY(id,comite),
	FOREIGN KEY(comite) REFERENCES COMITE ON DELETE CASCADE
);

DROP TABLE IF EXISTS ENTITE_JURIDIQUE CASCADE;
CREATE TABLE ENTITE_JURIDIQUE (
	id SERIAL PRIMARY KEY, --INTEGER
	nom TEXT NOT NULL,
	type TEXT NOT NULL
);

DROP TABLE IF EXISTS FINANCEUR CASCADE;
CREATE TABLE FINANCEUR (
	id INTEGER PRIMARY KEY,
	date_debut DATE NOT NULL,
	date_fin DATE,
	FOREIGN KEY(id) REFERENCES ENTITE_JURIDIQUE ON DELETE CASCADE
);

DROP TABLE IF EXISTS FINANCEUR_CREE_ORGANISME_PROJET CASCADE;
CREATE TABLE FINANCEUR_CREE_ORGANISME_PROJET (
	financeur INTEGER,
	organisme_projet TEXT,
	PRIMARY KEY (financeur, organisme_projet),
	FOREIGN KEY (financeur) REFERENCES FINANCEUR ON DELETE CASCADE,
	FOREIGN KEY (organisme_projet) REFERENCES ORGANISME_PROJET ON DELETE CASCADE
);

DROP TABLE IF EXISTS LABORATOIRE CASCADE;
CREATE TABLE LABORATOIRE (
	id INTEGER PRIMARY KEY,
	FOREIGN KEY(id) REFERENCES ENTITE_JURIDIQUE ON DELETE CASCADE
);

DROP TABLE IF EXISTS EXTERNE CASCADE;
CREATE TABLE EXTERNE (
	id SERIAL PRIMARY KEY, --INTEGER
	nom TEXT NOT NULL,
  password TEXT NOT NULL,
	mail TEXT,
	telephone VARCHAR(22),
	validateur BOOLEAN,
	entite INTEGER NOT NULL,
	FOREIGN KEY(entite) REFERENCES ENTITE_JURIDIQUE ON DELETE CASCADE
);

DROP TABLE IF EXISTS MEMBRE_LABO CASCADE;
CREATE TABLE MEMBRE_LABO (
	id SERIAL PRIMARY KEY, --INTEGER
	nom TEXT NOT NULL,
  password TEXT NOT NULL,
	mail TEXT UNIQUE,
	telephone VARCHAR(22),
	date_debut DATE,
	date_fin DATE,
	quotite FLOAT,
	etablissement TEXT,
	specialite TEXT,
	validateur BOOLEAN NOT NULL,
	type char(1) NOT NULL,
	sujet TEXT,
	labo INTEGER NOT NULL,
	CHECK (date_debut <= date_fin),
	CHECK (
		(type = 'I' AND specialite IS NOT NULL AND date_debut IS NULL AND date_fin IS NULL AND sujet IS NULL AND quotite IS NULL AND etablissement IS NULL) OR
		(type = 'D' AND date_debut IS NOT NULL AND sujet IS NOT NULL AND specialite IS NULL AND quotite IS NULL AND etablissement IS NULL) OR
		(type = 'C' AND quotite IS NOT NULL AND etablissement IS NOT NULL AND date_debut IS NULL AND date_fin IS NULL AND sujet IS NULL AND specialite IS NULL)
	),
	FOREIGN KEY(labo) REFERENCES LABORATOIRE ON DELETE CASCADE
);

DROP TABLE IF EXISTS DEPENSE CASCADE;
CREATE TABLE DEPENSE (
	depense_id INTEGER,
	numero 	INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	date_depense DATE NOT NULL,
	montant FLOAT NOT NULL,
	type TYPE_DEPENSE NOT NULL,
	status INTEGER DEFAULT 0 NOT NULL,
	demandeurext INTEGER,
	demandeurlab INTEGER,
	validateurext INTEGER,
	validateurlab INTEGER,
	PRIMARY KEY (depense_id,numero,appel,organisme,publication_appel),
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES PROJET(numero, appel, organisme, publication_appel) ON DELETE CASCADE,
	FOREIGN KEY (demandeurext) REFERENCES EXTERNE(id) ON DELETE CASCADE,
	FOREIGN KEY (validateurext) REFERENCES EXTERNE(id) ON DELETE CASCADE,
	FOREIGN KEY (demandeurlab) REFERENCES MEMBRE_LABO(id) ON DELETE CASCADE,
	FOREIGN KEY (validateurlab) REFERENCES MEMBRE_LABO(id) ON DELETE CASCADE,
	CHECK (status BETWEEN 0 AND 2),
	CHECK ((demandeurext IS NOT NULL AND demandeurlab IS NULL) OR (demandeurlab IS NOT NULL AND demandeurext IS NULL)),
	CHECK ((validateurext IS NOT NULL AND validateurlab IS NULL) OR (validateurlab IS NOT NULL AND validateurext IS NULL)),
	CHECK (validateurext <> demandeurext OR validateurext IS NULL),
	CHECK (validateurlab <> demandeurlab OR validateurlab IS NULL)
);

DROP VIEW IF EXISTS VINGENIEUR;
CREATE VIEW VINGENIEUR AS
SELECT id,nom,mail,telephone,validateur,labo,specialite
FROM MEMBRE_LABO
WHERE type = 'I';

DROP VIEW IF EXISTS VDOCTORANT;
CREATE VIEW VDOCTORANT AS
SELECT id,nom,mail,telephone,validateur,labo,specialite
FROM MEMBRE_LABO
WHERE type = 'D';

DROP VIEW IF EXISTS VCHERCHEUR;
CREATE VIEW VCHERCHEUR AS
SELECT id,nom,mail,telephone,validateur,labo,specialite
FROM MEMBRE_LABO
WHERE type = 'C';

DROP TABLE IF EXISTS EMPLOYE_CONTACT CASCADE;
CREATE TABLE EMPLOYE_CONTACT (
	id INTEGER,
	financeur INTEGER,
	nom TEXT NOT NULL,
  password TEXT NOT NULL,
	mail TEXT NOT NULL,
	telephone VARCHAR(22),
	titre TEXT,
	PRIMARY KEY(id,financeur),
	FOREIGN KEY(financeur) REFERENCES FINANCEUR(id) ON DELETE CASCADE
);

DROP VIEW IF EXISTS VFINANCEUR;
CREATE VIEW VFINANCEUR AS
SELECT f.id, e.nom, e.type, f.date_debut, f.date_fin
FROM ENTITE_JURIDIQUE e, FINANCEUR f
WHERE e.id = f.id;

DROP VIEW IF EXISTS VLABORATOIRE;
CREATE VIEW VLABORATOIRE AS
SELECT e.id, e.nom, e.type
FROM ENTITE_JURIDIQUE e,LABORATOIRE l
WHERE e.id = l.id;

DROP TABLE IF EXISTS REDACTION CASCADE;
CREATE TABLE REDACTION (
	id INTEGER, -- id du membre labo
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	numero INTEGER, -- numero de la proposition
	PRIMARY KEY(id,appel,organisme,publication_appel,numero),
	FOREIGN KEY(appel,organisme,publication_appel,numero) REFERENCES PROPOSITION_DE_PROJET(appel,organisme,publication_appel,numero) ON DELETE CASCADE,
	FOREIGN KEY(id) REFERENCES MEMBRE_LABO(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS PARTICIPANT_DU_LABO CASCADE;
CREATE TABLE PARTICIPANT_DU_LABO (
	id INTEGER, -- id du membre du projet
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	PRIMARY KEY(id,numero,appel,organisme,publication_appel),
	FOREIGN KEY(id) REFERENCES MEMBRE_LABO(id) ON DELETE CASCADE,
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES PROJET(numero, appel, organisme, publication_appel) ON DELETE CASCADE
);

DROP TABLE IF EXISTS PARTICIPANT_EXTERNE CASCADE;
CREATE TABLE PARTICIPANT_EXTERNE (
	id INTEGER, -- id du membre du projet
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	PRIMARY KEY(id,numero,appel,organisme,publication_appel),
	FOREIGN KEY(id) REFERENCES EXTERNE(id) ON DELETE CASCADE,
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES PROJET(numero, appel, organisme, publication_appel) ON DELETE CASCADE
);

DROP TABLE IF EXISTS LABEL CASCADE;
CREATE TABLE LABEL (
	nom_du_label TEXT PRIMARY KEY
);

DROP TABLE IF EXISTS LABELLISE CASCADE;
CREATE TABLE LABELLISE (
	nom_du_label TEXT,
	numero INTEGER,
	appel TEXT,
	organisme TEXT,
	publication_appel DATE,
	PRIMARY KEY(nom_du_label,numero,appel,organisme,publication_appel),
	FOREIGN KEY(nom_du_label) REFERENCES LABEL(nom_du_label) ON DELETE CASCADE,
	FOREIGN KEY (numero, appel, organisme, publication_appel) REFERENCES PROPOSITION_DE_PROJET(numero, appel, organisme, publication_appel) ON DELETE CASCADE
);

DROP TABLE IF EXISTS DONNE_LABEL CASCADE;
CREATE TABLE DONNE_LABEL (
	nom_du_label TEXT,
	entite INTEGER,
	PRIMARY KEY(nom_du_label,entite),
	FOREIGN KEY(nom_du_label) REFERENCES LABEL(nom_du_label) ON DELETE CASCADE,
	FOREIGN KEY(entite) REFERENCES ENTITE_JURIDIQUE(id) ON DELETE CASCADE
);




-- METS A JOUR UNE PROPOSITION DE PROJET APRES AVOIR CREE LE PROJET CORRESPONDANT
DROP TRIGGER IF EXISTS TRIGGER_PROPOSITION_PROJET_UPDATE_AFTER_PROJET ON PROJET CASCADE;
DROP FUNCTION IF EXISTS SET_PROPOSITION_PROJET_UPDATE_AFTER_PROJET() CASCADE;

CREATE FUNCTION SET_PROPOSITION_PROJET_UPDATE_AFTER_PROJET() RETURNS trigger AS $ret$
  BEGIN
  	IF (TG_OP = 'INSERT') THEN
    	UPDATE PROPOSITION_DE_PROJET P SET STATUT = True, date_reponse = now() WHERE P.numero = NEW.numero AND P.appel = NEW.appel AND P.organisme = NEW.organisme AND P.publication_appel = NEW.publication_appel;
    ELSEIF (TG_OP = 'DELETE') THEN
    	UPDATE PROPOSITION_DE_PROJET P SET STATUT = False, date_reponse = NULL WHERE P.numero = OLD.numero AND P.appel = OLD.appel AND P.organisme = OLD.organisme AND P.publication_appel = OLD.publication_appel;
    END IF;
    RETURN NULL;
  END;
$ret$ LANGUAGE 'plpgsql';

CREATE TRIGGER TRIGGER_PROPOSITION_PROJET_UPDATE_AFTER_PROJET
  AFTER INSERT OR DELETE ON PROJET
  FOR EACH ROW EXECUTE PROCEDURE SET_PROPOSITION_PROJET_UPDATE_AFTER_PROJET();
----------------------------------------------------------------------------------------------------------------





-- VERIFIE QUE LA DATE D'EMISSION D'UNE PROPOSITION EST :
--   <= DATE DE PUBLICATION DE L'APPEL + SA DUREE DE VALIDITE ET
--   >= DATE DE PUBLICATION DE L'APPEL
DROP TRIGGER IF EXISTS TRIGGER_CHECK_DATE_PROPOSITION_PROJET_CREATE ON PROPOSITION_DE_PROJET CASCADE;
DROP FUNCTION IF EXISTS CHECK_DATE_PROPOSITION_PROJET_CREATE() CASCADE;

CREATE FUNCTION CHECK_DATE_PROPOSITION_PROJET_CREATE() RETURNS trigger AS $ret$
  DECLARE
  	publi date;
  	dur integer;
  BEGIN
  	SELECT INTO publi,dur publication,duree FROM APPEL_A_PROJET WHERE nom = NEW.appel AND organisme = NEW.organisme AND publication = NEW.publication_appel;
  	IF((NEW.date_emission <= (publi+dur)) AND (NEW.date_emission >= publi)) THEN
  		RETURN NEW;
  	ELSE
  		RAISE EXCEPTION 'Date d''émission de proposition incorrecte : doit être dans la durée de validité d''un appel !';
	END IF;
	RETURN NULL;
  END;
$ret$ LANGUAGE 'plpgsql';

CREATE TRIGGER TRIGGER_CHECK_DATE_PROPOSITION_PROJET_CREATE
  BEFORE INSERT ON PROPOSITION_DE_PROJET
  FOR EACH ROW EXECUTE PROCEDURE CHECK_DATE_PROPOSITION_PROJET_CREATE();
----------------------------------------------------------------------------------------------------------------



-- VERIFIE QUE LA DATE DE DEBUT D'UN PROJET est >= DATE EMISSION PROPOSITION
DROP TRIGGER IF EXISTS TRIGGER_CHECK_DATE_PROJET_CREATE ON PROJET CASCADE;
DROP FUNCTION IF EXISTS CHECK_DATE_PROJET_CREATE() CASCADE;

CREATE FUNCTION CHECK_DATE_PROJET_CREATE() RETURNS trigger AS $ret$
  DECLARE
  	proposition date;
  BEGIN
  	SELECT INTO proposition date_emission FROM PROPOSITION_DE_PROJET prop WHERE prop.appel = NEW.appel AND prop.organisme = NEW.organisme AND prop.publication_appel = NEW.publication_appel;
  	IF(NEW.date_debut >= proposition) THEN
  		RETURN NEW;
  	ELSE
  		RAISE EXCEPTION 'Date de début antérieure à la proposition de projet !';
	END IF;
	RETURN NULL;
  END;
$ret$ LANGUAGE 'plpgsql';

CREATE TRIGGER TRIGGER_CHECK_DATE_PROJET_CREATE
  BEFORE INSERT ON PROJET
  FOR EACH ROW EXECUTE PROCEDURE CHECK_DATE_PROJET_CREATE();



END; -- FIN TRANSACTION BEGIN LIGNE 1




/******************** REMPLISSAGE ********************/



INSERT INTO ENTITE_JURIDIQUE VALUES (101,'MoleculeX','Laboratoire');
INSERT INTO ENTITE_JURIDIQUE VALUES (102,'Pills4All','Laboratoire');
INSERT INTO FINANCEUR VALUES (101, '2013-03-03', '2017-09-14');
INSERT INTO FINANCEUR VALUES (102, '2015-03-14', '2042-06-03');
INSERT INTO EMPLOYE_CONTACT VALUES (1, 101, 'Dumont','password', 'd@dumont.fr', 0987542562, 'Employé contact');
INSERT INTO EMPLOYE_CONTACT VALUES (2, 101, 'Francis','strongpass', 'francis@labo.fr', 0783244517, 'Chaman');
INSERT INTO EMPLOYE_CONTACT VALUES (1, 102, 'Roland','password', 'roland@pills.fr', 0912548796, 'Grand sage');



INSERT INTO ORGANISME_PROJET VALUES ('les createurs de projet','2015-05-30',90);
INSERT INTO ORGANISME_PROJET VALUES ('organisme qui ne sera pas affiché','2015-05-30',2); -- car durée courte
INSERT INTO ORGANISME_PROJET VALUES ('Escroc inc','2014-12-20',500);
INSERT INTO ORGANISME_PROJET VALUES ('Orga2000','2015-03-14',420);
INSERT INTO FINANCEUR_CREE_ORGANISME_PROJET VALUES (101,'les createurs de projet'),
(101,'organisme qui ne sera pas affiché'),
(102, 'Escroc inc'),
(101, 'Orga2000');



INSERT INTO COMITE VALUES ('comite UTC');
INSERT INTO COMITE VALUES ('Jury projet');
INSERT INTO COMITE VALUES ('High committee');

INSERT INTO MEMBRE_COMITE
VALUES
(55,'comite UTC','Jean','password' ,'jean@jr.t',0156548026),
(43,'comite UTC','Dupuis','password' ,'dupuis@du.puis',0964257897),
(42,'Jury projet','Franck','password' ,'franck@comite.fr',0985647521);



INSERT INTO LABORATOIRE VALUES (101);
INSERT INTO LABORATOIRE VALUES (102);
INSERT INTO MEMBRE_LABO
VALUES
(67,'Antoine','password', 'antoine@domaine.com','0456765346','2000-11-23','2006-04-15',NULL,NULL,NULL,true,'D','Le TC',101),
(90,'Membre42','password' ,'reponse@universe.bit','0586765346','2001-10-07','2006-04-15',NULL,NULL,NULL,true,'D','LA reponse',101),
(51,'AnotherMember','password' ,'another@member.net','0652371561','2004-08-15','2010-01-16',NULL,NULL,NULL,true,'D','le sujet',102);
INSERT INTO EXTERNE
VALUES
(78, 'Externe1','password' ,'1@externe.fr',0787432796, 'true',101),
(14, 'Externe2','password' ,'2@externe.fr', 0782014620, 'true',101);



INSERT INTO APPEL_A_PROJET VALUES ('Premier projet','les createurs de projet','2015-04-17',30,'test de bases de données','rien','comite UTC');
INSERT INTO APPEL_A_PROJET VALUES ('Pills','Escroc inc','2015-06-14',42,'Faire des pillule','Nothing','Jury projet');
INSERT INTO PROPOSITION_DE_PROJET VALUES (1,'Premier projet','les createurs de projet','2015-04-17','2015-05-10','2015-05-03','true');
INSERT INTO PROPOSITION_DE_PROJET VALUES (2,'Pills','Escroc inc','2015-06-14','2015-06-17','2015-06-15','true');

INSERT INTO PROJET VALUES (1,'Premier projet','les createurs de projet','2015-04-17','2016-06-17','2016-07-17');
INSERT INTO PROJET VALUES (2,'Pills','Escroc inc','2015-06-14','2016-06-17','2016-07-17');

INSERT INTO BUDGET VALUES (1,'Premier projet','les createurs de projet','2015-04-17',200000);
INSERT INTO BUDGET VALUES (2,'Pills','Escroc inc','2015-06-14',42000);
INSERT INTO LIGNES_BUDGETAIRE VALUES (1,'Premier projet','les createurs de projet','2015-04-17','objet du projet',567.45,'materiel');
INSERT INTO LIGNES_BUDGETAIRE VALUES (2,'Pills','Escroc inc','2015-06-14','Pizza',42,'materiel');
INSERT INTO DEPENSE VALUES (1,1,'Premier projet','les createurs de projet','2015-04-17','2015-09-16',567.45,'materiel',1,NULL,67,NULL,90);
INSERT INTO DEPENSE VALUES (2,1,'Premier projet','les createurs de projet','2015-04-17','2015-09-13',200,'materiel',1,NULL,90,78,NULL);
INSERT INTO DEPENSE VALUES (1,2,'Pills','Escroc inc','2015-06-14','2015-06-18',31,'materiel',1,NULL,90,78,NULL);




INSERT INTO REDACTION VALUES (67, 'Premier projet', 'les createurs de projet', '2015-04-17', 1);
INSERT INTO REDACTION VALUES (90, 'Pills', 'Escroc inc', '2015-06-14', 2);

INSERT INTO PARTICIPANT_DU_LABO VALUES (90, 1, 'Premier projet', 'les createurs de projet', '2015-04-17');
INSERT INTO PARTICIPANT_DU_LABO VALUES (90, 2, 'Pills', 'Escroc inc', '2015-06-14');
INSERT INTO PARTICIPANT_EXTERNE VALUES (78, 1, 'Premier projet', 'les createurs de projet', '2015-04-17');



INSERT INTO LABEL VALUES ('LabelNF17');
INSERT INTO LABELLISE VALUES ('LabelNF17',1,'Premier projet', 'les createurs de projet','2015-04-17');
INSERT INTO DONNE_LABEL VALUES ('LabelNF17',101);
