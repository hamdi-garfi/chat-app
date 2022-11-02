#!/usr/bin/env bash
psql "postgres://$POSTGRES_USER:$POSTGRES_PASSWORD@$POSTGRES_HOST/$POSTGRES_DB?sslmode=disable" <<-EOSQL


CREATE TABLE IF NOT EXISTS connexion (
  id serial primary key,
  user_id serial NOT NULL,
  datetime timestamp NOT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS message (
  id serial primary key,
  content text NOT NULL,
  created_at timestamp NOT NULL,
  user_id serial NOT NULL
);


CREATE TABLE IF NOT EXISTS "user"  (
  id serial primary key,
  name varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  created_at timestamp NOT NULL
);

TRUNCATE connexion, message,"user" RESTART IDENTITY;

EOSQL