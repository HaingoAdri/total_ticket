create database ticketing;

\c ticketing

create table categorie(
    id serial primary key,
    nom varchar(500),
    description varchar(500),
    created_at timestamp,
    updated_at timestamp
);

create table priorite(
    id serial primary key,
    nom varchar(500),
    description varchar(500),
    created_at timestamp,
    updated_at timestamp
);

create table poste(
    id serial primary key,
    nom varchar(500),
    description varchar(500),
    created_at timestamp,
    updated_at timestamp
);

create table etat(
    id serial primary key,
    nom varchar(500),
    created_at timestamp,
    updated_at timestamp
);

create table utilisateur(
    id varchar(20) primary key,
    nom varchar(500),
    email varchar(50),
    mot_de_passe varchar(100),
    role int references poste(id),
    date_creation timestamp,
    created_at timestamp,
    updated_at timestamp
);

create table ticket(
    id varchar(20) primary key,
    titre varchar(500),
    description varchar(1500),
    etat int references etat(id),
    date_creation timestamp,
    date_deadline timestamp,
    date_debut_activite timestamp,
    date_resolution timestamp,
    categorie int references categorie(id),
    priorite int references priorite(id),
    utilisateur varchar(20) references utilisateur(id),
    technicien varchar(20) references utilisateur(id),
    created_at timestamp,
    updated_at timestamp
);

create table rapport_ticket(
    id serial primary key,
    ticket varchar(20) references ticket(id),
    rapport varchar(1500),
    date_rapport timestamp,
    created_at timestamp,
    updated_at timestamp
);

create table note_technicien(
    id serial primary key,
    ticket varchar(20) references ticket(id),
    note int,
    date_notation timestamp,
    created_at timestamp,
    updated_at timestamp
);


create table reouverture(
    id serial primary key,
    ticket varchar(20) references ticket(id),
    raison varchar(1500),
    date_reouverture timestamp,
    created_at timestamp,
    updated_at timestamp
);

create table historique_action(
    id serial primary key,
    ticket varchar(20) references ticket(id),
    date_ajout timestamp,
    created_at timestamp,
    updated_at timestamp
);

CREATE SEQUENCE seq_utilisateur_id START 1;
CREATE SEQUENCE seq_ticket_id START 1;

CREATE OR REPLACE FUNCTION generate_custom_id(sequence_name text, prefix text, zero_padding int)
RETURNS text AS $$
BEGIN
    RETURN prefix || lpad(nextval(sequence_name)::text, zero_padding, '0');
END;
$$ LANGUAGE plpgsql;

create view ticket_details AS
SELECT 
    ticket.id, 
    ticket.titre, 
    ticket.description, 
    etat.nom AS etat,
    ticket.date_creation, 
    ticket.date_deadline, 
    ticket.date_debut_activite, 
    ticket.date_resolution,
    categorie.nom AS categorie,
    priorite.nom AS priorite, 
    utilisateur.nom AS utilisateur, 
    poste.nom AS poste,
    utilisateur.id AS id_utilisateur,
    utilisateur1.nom AS technicien,
    utilisateur1.id as id_technicien
FROM 
    ticket
LEFT JOIN 
    categorie ON ticket.categorie = categorie.id
LEFT JOIN 
    etat ON ticket.etat = etat.id
LEFT JOIN 
    priorite ON ticket.priorite = priorite.id
LEFT JOIN 
    utilisateur ON ticket.utilisateur = utilisateur.id
LEFT JOIN 
    poste ON utilisateur.role = poste.id
LEFT JOIN  
    utilisateur AS utilisateur1 ON ticket.technicien = utilisateur1.id;


CREATE VIEW ticket_rapport_view AS
SELECT distinct
    t.id AS ticket_id,
    t.titre AS ticket_titre,
    t.categorie AS ticket_categorie,
    t.description AS ticket_description,
    t.priorite AS ticket_priorite,
    t.date_deadline AS ticket_deadline,
    t.date_resolution AS ticket_date_resolution,

    -- Informations sur l'utilisateur (créateur du ticket)
    u.id AS utilisateur_id,
    u.nom AS utilisateur_nom,
    u.role AS utilisateur_poste,

    -- Informations sur le technicien (qui traite le ticket)
    tec.id AS technicien_id,
    tec.nom AS technicien_nom,
    tec.role AS technicien_poste,

    -- Informations sur le rapport
    rt.id AS rapport_id,
    rt.rapport AS rapport_texte,
    rt.date_rapport AS rapport_date,
    rt.created_at AS rapport_created_at,
    rt.updated_at AS rapport_updated_at
FROM 
    rapport_ticket as r
LEFT JOIN
    ticket as t on r.ticket = t.id
LEFT JOIN 
    utilisateur u ON t.id = u.id  -- L'utilisateur qui a créé le ticket
LEFT JOIN 
    utilisateur tec ON t.id = tec.id  -- Le technicien qui traite le ticket
LEFT JOIN 
    rapport_ticket rt ON t.id = rt.ticket;
