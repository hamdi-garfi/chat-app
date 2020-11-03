#!/usr/bin/env bash
psql "postgres://$POSTGRES_USER:$POSTGRES_PASSWORD@$POSTGRES_HOST/$POSTGRES_DB?sslmode=disable" <<-EOSQL


CREATE TABLE IF NOT EXISTS connexion (
    id integer NOT NULL DEFAULT nextval('connexion_id_seq'::regclass),
    user_id integer NOT NULL DEFAULT nextval('connexion_user_id_seq'::regclass),
    datetime timestamp without time zone NOT NULL,
    CONSTRAINT connexion_pkey PRIMARY KEY (id)
);
 


CREATE TABLE IF NOT EXISTS message (
    id integer NOT NULL DEFAULT nextval('message_id_seq'::regclass),
    content text COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp without time zone NOT NULL,
    user_id integer NOT NULL DEFAULT nextval('message_user_id_seq'::regclass),
    CONSTRAINT message_pkey PRIMARY KEY (id)
);
 
CREATE TABLE IF NOT EXISTS "user"  (
   created_at timestamp without time zone,
    password text COLLATE pg_catalog."default",
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name text COLLATE pg_catalog."default",
    username text COLLATE pg_catalog."default"
);


TRUNCATE connexion, message,"user" RESTART IDENTITY;

EOSQL
