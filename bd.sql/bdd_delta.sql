PGDMP     .    ,                y            delta    10.0    10.0     ?           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            ?           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            ?           1262    1249417    delta    DATABASE     ?   CREATE DATABASE delta WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'French_France.1252' LC_CTYPE = 'French_France.1252';
    DROP DATABASE delta;
             postgres    false            ?           1262    1249417    delta    COMMENT     @   COMMENT ON DATABASE delta IS 'Gestion de debours et Documents';
                  postgres    false    3206                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            ?           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    3                        3079    12924    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            ?           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    1            ?            1259    1274050    billet_avion    TABLE     f  CREATE TABLE billet_avion (
    id integer NOT NULL,
    num_bc character varying(20),
    date_bc date,
    id_pers integer NOT NULL,
    date_depart date,
    date_retour date,
    monnaie integer,
    lieu_depart character varying(50) NOT NULL,
    lieu_destination character varying(50),
    montant_ttc numeric(14,2),
    id_mission integer NOT NULL
);
     DROP TABLE public.billet_avion;
       public         postgres    false    3            ?            1259    1274048    billet_avion_id_seq    SEQUENCE     ?   CREATE SEQUENCE billet_avion_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.billet_avion_id_seq;
       public       postgres    false    3    229            ?           0    0    billet_avion_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE billet_avion_id_seq OWNED BY billet_avion.id;
            public       postgres    false    228            ?            1259    1249450    client    TABLE       CREATE TABLE client (
    id integer NOT NULL,
    code character varying(20) NOT NULL,
    nom_client character varying(150) NOT NULL,
    adresse character varying(100),
    telephone character varying(25),
    fax character varying(25),
    email character varying(60),
    nif character varying(25),
    stat character varying(30),
    cif character varying(30),
    reg_comm character varying(30),
    groupe_app character varying(10),
    groupe smallint,
    capital numeric(14,2),
    effectif integer
);
    DROP TABLE public.client;
       public         postgres    false    3            ?            1259    1249448    client_id_seq    SEQUENCE     ~   CREATE SEQUENCE client_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.client_id_seq;
       public       postgres    false    199    3            ?           0    0    client_id_seq    SEQUENCE OWNED BY     1   ALTER SEQUENCE client_id_seq OWNED BY client.id;
            public       postgres    false    198            ?            1259    1274098    contact_client    TABLE     ?   CREATE TABLE contact_client (
    id integer NOT NULL,
    nom character varying(100) NOT NULL,
    fonction character varying(60),
    tel character varying(30),
    email character varying(200),
    id_client integer
);
 "   DROP TABLE public.contact_client;
       public         postgres    false    3            ?            1259    1274096    contacte_client_id_seq    SEQUENCE     ?   CREATE SEQUENCE contacte_client_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.contacte_client_id_seq;
       public       postgres    false    3    235            ?           0    0    contacte_client_id_seq    SEQUENCE OWNED BY     B   ALTER SEQUENCE contacte_client_id_seq OWNED BY contact_client.id;
            public       postgres    false    234            ?            1259    1257611    contrat    TABLE       CREATE TABLE contrat (
    id integer NOT NULL,
    num_contrat character varying(40) NOT NULL,
    date_contrat date NOT NULL,
    id_client integer NOT NULL,
    montant_ht numeric(14,2),
    taux_tva numeric(2,0),
    monnaie integer,
    date_debut date,
    date_fin date
);
    DROP TABLE public.contrat;
       public         postgres    false    3            ?            1259    1257609    contrat_id_seq    SEQUENCE        CREATE SEQUENCE contrat_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.contrat_id_seq;
       public       postgres    false    201    3            ?           0    0    contrat_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE contrat_id_seq OWNED BY contrat.id;
            public       postgres    false    200            ?            1259    1274112    cv_personnel    TABLE     ?   CREATE TABLE cv_personnel (
    id integer NOT NULL,
    libelle character varying(150) NOT NULL,
    repertoire character varying(500) NOT NULL,
    id_pers integer NOT NULL
);
     DROP TABLE public.cv_personnel;
       public         postgres    false    3            ?            1259    1274110    cv_personnel_id_seq    SEQUENCE     ?   CREATE SEQUENCE cv_personnel_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.cv_personnel_id_seq;
       public       postgres    false    237    3            ?           0    0    cv_personnel_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE cv_personnel_id_seq OWNED BY cv_personnel.id;
            public       postgres    false    236            ?            1259    1265832    debours    TABLE     ?   CREATE TABLE debours (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(100),
    type_deb smallint,
    nature character varying(20),
    unitaire smallint
);
    DROP TABLE public.debours;
       public         postgres    false    3            ?            1259    1265830    debours_id_seq    SEQUENCE        CREATE SEQUENCE debours_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.debours_id_seq;
       public       postgres    false    215    3            ?           0    0    debours_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE debours_id_seq OWNED BY debours.id;
            public       postgres    false    214            ?            1259    1265840    demande_debours    TABLE     ?  CREATE TABLE demande_debours (
    id integer NOT NULL,
    num_demande character varying(10) NOT NULL,
    date_demande date NOT NULL,
    id_mission integer NOT NULL,
    id_demandeur integer NOT NULL,
    nombre integer,
    visa smallint,
    date_visa date,
    id_user integer,
    date_paiement date,
    personne_visa integer,
    date_autorisation date,
    personne_permis integer,
    annuler smallint,
    personne_paiement integer
);
 #   DROP TABLE public.demande_debours;
       public         postgres    false    3            ?            1259    1265838    demande_debours_id_seq    SEQUENCE     ?   CREATE SEQUENCE demande_debours_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.demande_debours_id_seq;
       public       postgres    false    217    3            ?           0    0    demande_debours_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE demande_debours_id_seq OWNED BY demande_debours.id;
            public       postgres    false    216            ?            1259    1265850    det_demande_debours    TABLE     ?  CREATE TABLE det_demande_debours (
    id integer NOT NULL,
    id_debours integer NOT NULL,
    id_pers integer NOT NULL,
    id_demande integer NOT NULL,
    nbre_jours integer,
    nbre_heure integer,
    pu numeric,
    date_debut date,
    date_fin date,
    id_region integer,
    localite character varying(50),
    montant numeric,
    id_grade integer,
    montant_retourne numeric,
    explication character varying(150)
);
 '   DROP TABLE public.det_demande_debours;
       public         postgres    false    3            ?            1259    1265848    det_demande_debours_id_seq    SEQUENCE     ?   CREATE SEQUENCE det_demande_debours_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.det_demande_debours_id_seq;
       public       postgres    false    3    219            ?           0    0    det_demande_debours_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE det_demande_debours_id_seq OWNED BY det_demande_debours.id;
            public       postgres    false    218            ?            1259    1274137    detail_feuille_temps    TABLE     ?   CREATE TABLE detail_feuille_temps (
    id integer NOT NULL,
    id_mission integer NOT NULL,
    libelle character varying(500) NOT NULL,
    id_entete integer NOT NULL,
    sous_tache integer,
    pourcentage numeric(3,0),
    duree integer
);
 (   DROP TABLE public.detail_feuille_temps;
       public         postgres    false    3            ?            1259    1274135    detail_feuille_temps_id_seq    SEQUENCE     ?   CREATE SEQUENCE detail_feuille_temps_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.detail_feuille_temps_id_seq;
       public       postgres    false    3    241            ?           0    0    detail_feuille_temps_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE detail_feuille_temps_id_seq OWNED BY detail_feuille_temps.id;
            public       postgres    false    240            ?            1259    1265813 	   documents    TABLE       CREATE TABLE documents (
    id integer NOT NULL,
    libelle character varying(150) NOT NULL,
    prepare_par integer NOT NULL,
    id_utilisateur integer,
    date_preparation date,
    date_insertion date,
    id_mission integer,
    repertoire character varying(400)
);
    DROP TABLE public.documents;
       public         postgres    false    3            ?            1259    1265811    documents_id_seq    SEQUENCE     ?   CREATE SEQUENCE documents_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.documents_id_seq;
       public       postgres    false    3    211            ?           0    0    documents_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE documents_id_seq OWNED BY documents.id;
            public       postgres    false    210            ?            1259    1274070    echeance_paiement    TABLE     '  CREATE TABLE echeance_paiement (
    id integer NOT NULL,
    libelle character varying(100),
    pourcentage numeric(5,2),
    date_facture date,
    id_mission integer,
    date_em_facture date,
    num_facture character varying(30),
    montant_facture numeric(14,2),
    date_saisie date
);
 %   DROP TABLE public.echeance_paiement;
       public         postgres    false    3            ?            1259    1274068    echeance_paiement_id_seq    SEQUENCE     ?   CREATE SEQUENCE echeance_paiement_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.echeance_paiement_id_seq;
       public       postgres    false    3    231            ?           0    0    echeance_paiement_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE echeance_paiement_id_seq OWNED BY echeance_paiement.id;
            public       postgres    false    230            ?            1259    1274129    entete_feuille_temps    TABLE     }   CREATE TABLE entete_feuille_temps (
    id integer NOT NULL,
    date_feuille date NOT NULL,
    id_pers integer NOT NULL
);
 (   DROP TABLE public.entete_feuille_temps;
       public         postgres    false    3            ?            1259    1274127    entete_feuille_temps_id_seq    SEQUENCE     ?   CREATE SEQUENCE entete_feuille_temps_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.entete_feuille_temps_id_seq;
       public       postgres    false    3    239            ?           0    0    entete_feuille_temps_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE entete_feuille_temps_id_seq OWNED BY entete_feuille_temps.id;
            public       postgres    false    238            ?            1259    1257637    grade    TABLE     ?   CREATE TABLE grade (
    id integer NOT NULL,
    code character varying(15) NOT NULL,
    libelle character varying(100) NOT NULL,
    rang smallint
);
    DROP TABLE public.grade;
       public         postgres    false    3            ?            1259    1257635    grade_id_seq    SEQUENCE     }   CREATE SEQUENCE grade_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.grade_id_seq;
       public       postgres    false    3    205            ?           0    0    grade_id_seq    SEQUENCE OWNED BY     /   ALTER SEQUENCE grade_id_seq OWNED BY grade.id;
            public       postgres    false    204            ?            1259    1265824    historique_doc    TABLE     ?   CREATE TABLE historique_doc (
    id integer NOT NULL,
    type_histoire character varying(100) NOT NULL,
    observation character varying(200),
    id_document integer,
    date_histoire date,
    id_utilisateur integer
);
 "   DROP TABLE public.historique_doc;
       public         postgres    false    3            ?            1259    1265822    historique_doc_id_seq    SEQUENCE     ?   CREATE SEQUENCE historique_doc_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.historique_doc_id_seq;
       public       postgres    false    3    213            ?           0    0    historique_doc_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE historique_doc_id_seq OWNED BY historique_doc.id;
            public       postgres    false    212            ?            1259    1257645    mission    TABLE     ?  CREATE TABLE mission (
    id integer NOT NULL,
    code character varying(40) NOT NULL,
    libelle character varying(200) NOT NULL,
    associe_resp integer,
    senior_manager integer,
    chef_mission integer,
    montant_ht numeric(14,2),
    tva numeric,
    monnaie integer,
    produit integer,
    date_deb_prevue date,
    date_fin_prevue date,
    cloturer smallint,
    id_contrat integer NOT NULL,
    associate_director integer,
    director integer
);
    DROP TABLE public.mission;
       public         postgres    false    3            ?            1259    1257643    mission_id_seq    SEQUENCE        CREATE SEQUENCE mission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.mission_id_seq;
       public       postgres    false    207    3            ?           0    0    mission_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE mission_id_seq OWNED BY mission.id;
            public       postgres    false    206            ?            1259    1265933    monnaie    TABLE     ?   CREATE TABLE monnaie (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(50) NOT NULL
);
    DROP TABLE public.monnaie;
       public         postgres    false    3            ?            1259    1265931    monnaie_id_seq    SEQUENCE        CREATE SEQUENCE monnaie_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.monnaie_id_seq;
       public       postgres    false    3    223            ?           0    0    monnaie_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE monnaie_id_seq OWNED BY monnaie.id;
            public       postgres    false    222            ?            1259    1274084    paiement_facture    TABLE     ?   CREATE TABLE paiement_facture (
    id integer NOT NULL,
    montant_payer numeric(14,2),
    date_paiement date,
    id_echeance integer,
    reference_paiement character varying(30),
    mode_paiement character varying(30)
);
 $   DROP TABLE public.paiement_facture;
       public         postgres    false    3            ?            1259    1274082    paiement_facture_id_seq    SEQUENCE     ?   CREATE SEQUENCE paiement_facture_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.paiement_facture_id_seq;
       public       postgres    false    233    3            ?           0    0    paiement_facture_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE paiement_facture_id_seq OWNED BY paiement_facture.id;
            public       postgres    false    232            ?            1259    1257627 	   personnel    TABLE     `  CREATE TABLE personnel (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    nom character varying(150) NOT NULL,
    grade integer NOT NULL,
    telephone character varying(30),
    adresse character varying(150),
    matricule character varying(20),
    rang smallint,
    appelation character varying(100),
    date_depart date
);
    DROP TABLE public.personnel;
       public         postgres    false    3            ?            1259    1257625    personnel_id_seq    SEQUENCE     ?   CREATE SEQUENCE personnel_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.personnel_id_seq;
       public       postgres    false    203    3            ?           0    0    personnel_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE personnel_id_seq OWNED BY personnel.id;
            public       postgres    false    202            ?            1259    1265947    prev_debours    TABLE     ?   CREATE TABLE prev_debours (
    id integer NOT NULL,
    nbre_jours integer NOT NULL,
    id_debours integer NOT NULL,
    id_mission integer NOT NULL,
    pu numeric(14,2),
    unite character varying(15)
);
     DROP TABLE public.prev_debours;
       public         postgres    false    3            ?            1259    1265945    prev_debours_id_seq    SEQUENCE     ?   CREATE SEQUENCE prev_debours_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.prev_debours_id_seq;
       public       postgres    false    225    3            ?           0    0    prev_debours_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE prev_debours_id_seq OWNED BY prev_debours.id;
            public       postgres    false    224            ?            1259    1274024    prev_honoraire    TABLE       CREATE TABLE prev_honoraire (
    id integer NOT NULL,
    nbre_jour numeric(10,2),
    nbre_heure integer,
    nbre_homme integer,
    pu numeric(14,2),
    grade integer,
    id_mission integer NOT NULL,
    monnaie integer,
    type_unite character varying(20)
);
 "   DROP TABLE public.prev_honoraire;
       public         postgres    false    3            ?            1259    1274022    prev_honoraire_id_seq    SEQUENCE     ?   CREATE SEQUENCE prev_honoraire_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.prev_honoraire_id_seq;
       public       postgres    false    3    227            ?           0    0    prev_honoraire_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE prev_honoraire_id_seq OWNED BY prev_honoraire.id;
            public       postgres    false    226            ?            1259    1274188 
   prev_tache    TABLE     ?   CREATE TABLE prev_tache (
    id integer NOT NULL,
    grand_tache integer NOT NULL,
    nbre_heure integer NOT NULL,
    id_mission integer NOT NULL
);
    DROP TABLE public.prev_tache;
       public         postgres    false    3            ?            1259    1274186    prev_tache_id_seq    SEQUENCE     ?   CREATE SEQUENCE prev_tache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.prev_tache_id_seq;
       public       postgres    false    247    3            ?           0    0    prev_tache_id_seq    SEQUENCE OWNED BY     9   ALTER SEQUENCE prev_tache_id_seq OWNED BY prev_tache.id;
            public       postgres    false    246            ?            1259    1265803    produit    TABLE     ?   CREATE TABLE produit (
    id integer NOT NULL,
    code character varying NOT NULL,
    libelle character varying NOT NULL,
    type_prd integer NOT NULL
);
    DROP TABLE public.produit;
       public         postgres    false    3            ?            1259    1265801    produit_id_seq    SEQUENCE        CREATE SEQUENCE produit_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.produit_id_seq;
       public       postgres    false    209    3            ?           0    0    produit_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE produit_id_seq OWNED BY produit.id;
            public       postgres    false    208            ?            1259    1265901    region    TABLE     Y   CREATE TABLE region (
    id integer NOT NULL,
    libelle character varying NOT NULL
);
    DROP TABLE public.region;
       public         postgres    false    3            ?            1259    1265899    region_id_seq    SEQUENCE     ~   CREATE SEQUENCE region_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.region_id_seq;
       public       postgres    false    3    221            ?           0    0    region_id_seq    SEQUENCE OWNED BY     1   ALTER SEQUENCE region_id_seq OWNED BY region.id;
            public       postgres    false    220            ?            1259    1290575    section    TABLE     ?   CREATE TABLE section (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(150) NOT NULL
);
    DROP TABLE public.section;
       public         postgres    false    3            ?            1259    1290573    section_id_seq    SEQUENCE        CREATE SEQUENCE section_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.section_id_seq;
       public       postgres    false    3    251            ?           0    0    section_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE section_id_seq OWNED BY section.id;
            public       postgres    false    250            ?            1259    1290583    sous_section    TABLE     ?   CREATE TABLE sous_section (
    id integer NOT NULL,
    code character varying(15) NOT NULL,
    libelle character varying(150) NOT NULL,
    id_section integer NOT NULL,
    ponderation integer
);
     DROP TABLE public.sous_section;
       public         postgres    false    3            ?            1259    1290581    sous_section_id_seq    SEQUENCE     ?   CREATE SEQUENCE sous_section_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.sous_section_id_seq;
       public       postgres    false    3    253            ?           0    0    sous_section_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE sous_section_id_seq OWNED BY sous_section.id;
            public       postgres    false    252            ?            1259    1274174 
   sous_tache    TABLE     ?   CREATE TABLE sous_tache (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(150) NOT NULL,
    grand_tache integer NOT NULL,
    ponderation integer
);
    DROP TABLE public.sous_tache;
       public         postgres    false    3            ?            1259    1274172    sous_tache_id_seq    SEQUENCE     ?   CREATE SEQUENCE sous_tache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.sous_tache_id_seq;
       public       postgres    false    245    3            ?           0    0    sous_tache_id_seq    SEQUENCE OWNED BY     9   ALTER SEQUENCE sous_tache_id_seq OWNED BY sous_tache.id;
            public       postgres    false    244            ?            1259    1274166    tache    TABLE     ?   CREATE TABLE tache (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(150) NOT NULL
);
    DROP TABLE public.tache;
       public         postgres    false    3            ?            1259    1274164    tache_id_seq    SEQUENCE     }   CREATE SEQUENCE tache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.tache_id_seq;
       public       postgres    false    3    243            ?           0    0    tache_id_seq    SEQUENCE OWNED BY     /   ALTER SEQUENCE tache_id_seq OWNED BY tache.id;
            public       postgres    false    242            ?            1259    1282358    type_produit    TABLE     ?   CREATE TABLE type_produit (
    id integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(100)
);
     DROP TABLE public.type_produit;
       public         postgres    false    3            ?            1259    1282356    type_produit_id_seq    SEQUENCE     ?   CREATE SEQUENCE type_produit_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.type_produit_id_seq;
       public       postgres    false    3    249            ?           0    0    type_produit_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE type_produit_id_seq OWNED BY type_produit.id;
            public       postgres    false    248            ?            1259    1249427    utilisateur_id_seq    SEQUENCE     t   CREATE SEQUENCE utilisateur_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.utilisateur_id_seq;
       public       postgres    false    3            ?            1259    1249429    utilisateur    TABLE     ?  CREATE TABLE utilisateur (
    nom character varying(255) DEFAULT NULL::character varying,
    prenom character varying(255) DEFAULT NULL::character varying,
    email character varying(255) DEFAULT NULL::character varying,
    password character varying(255) DEFAULT NULL::character varying,
    date_creation timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    date_modification timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    enabled smallint,
    token text,
    roles text,
    id integer DEFAULT nextval('utilisateur_id_seq'::regclass) NOT NULL,
    sigle character varying(5),
    envoi_donnees smallint DEFAULT 0 NOT NULL,
    id_pers integer
);
    DROP TABLE public.utilisateur;
       public         postgres    false    196    3            6           2604    1274053    billet_avion id    DEFAULT     d   ALTER TABLE ONLY billet_avion ALTER COLUMN id SET DEFAULT nextval('billet_avion_id_seq'::regclass);
 >   ALTER TABLE public.billet_avion ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    228    229    229            '           2604    1249453 	   client id    DEFAULT     X   ALTER TABLE ONLY client ALTER COLUMN id SET DEFAULT nextval('client_id_seq'::regclass);
 8   ALTER TABLE public.client ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    198    199    199            9           2604    1274101    contact_client id    DEFAULT     i   ALTER TABLE ONLY contact_client ALTER COLUMN id SET DEFAULT nextval('contacte_client_id_seq'::regclass);
 @   ALTER TABLE public.contact_client ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    235    234    235            (           2604    1257614 
   contrat id    DEFAULT     Z   ALTER TABLE ONLY contrat ALTER COLUMN id SET DEFAULT nextval('contrat_id_seq'::regclass);
 9   ALTER TABLE public.contrat ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    201    200    201            :           2604    1274115    cv_personnel id    DEFAULT     d   ALTER TABLE ONLY cv_personnel ALTER COLUMN id SET DEFAULT nextval('cv_personnel_id_seq'::regclass);
 >   ALTER TABLE public.cv_personnel ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    236    237    237            /           2604    1265835 
   debours id    DEFAULT     Z   ALTER TABLE ONLY debours ALTER COLUMN id SET DEFAULT nextval('debours_id_seq'::regclass);
 9   ALTER TABLE public.debours ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    214    215    215            0           2604    1265843    demande_debours id    DEFAULT     j   ALTER TABLE ONLY demande_debours ALTER COLUMN id SET DEFAULT nextval('demande_debours_id_seq'::regclass);
 A   ALTER TABLE public.demande_debours ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    217    216    217            1           2604    1265910    det_demande_debours id    DEFAULT     r   ALTER TABLE ONLY det_demande_debours ALTER COLUMN id SET DEFAULT nextval('det_demande_debours_id_seq'::regclass);
 E   ALTER TABLE public.det_demande_debours ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    219    218    219            <           2604    1274140    detail_feuille_temps id    DEFAULT     t   ALTER TABLE ONLY detail_feuille_temps ALTER COLUMN id SET DEFAULT nextval('detail_feuille_temps_id_seq'::regclass);
 F   ALTER TABLE public.detail_feuille_temps ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    241    240    241            -           2604    1265816    documents id    DEFAULT     ^   ALTER TABLE ONLY documents ALTER COLUMN id SET DEFAULT nextval('documents_id_seq'::regclass);
 ;   ALTER TABLE public.documents ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    210    211    211            7           2604    1274073    echeance_paiement id    DEFAULT     n   ALTER TABLE ONLY echeance_paiement ALTER COLUMN id SET DEFAULT nextval('echeance_paiement_id_seq'::regclass);
 C   ALTER TABLE public.echeance_paiement ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    230    231    231            ;           2604    1274132    entete_feuille_temps id    DEFAULT     t   ALTER TABLE ONLY entete_feuille_temps ALTER COLUMN id SET DEFAULT nextval('entete_feuille_temps_id_seq'::regclass);
 F   ALTER TABLE public.entete_feuille_temps ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    239    238    239            *           2604    1257640    grade id    DEFAULT     V   ALTER TABLE ONLY grade ALTER COLUMN id SET DEFAULT nextval('grade_id_seq'::regclass);
 7   ALTER TABLE public.grade ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    204    205    205            .           2604    1265827    historique_doc id    DEFAULT     h   ALTER TABLE ONLY historique_doc ALTER COLUMN id SET DEFAULT nextval('historique_doc_id_seq'::regclass);
 @   ALTER TABLE public.historique_doc ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    213    212    213            +           2604    1257648 
   mission id    DEFAULT     Z   ALTER TABLE ONLY mission ALTER COLUMN id SET DEFAULT nextval('mission_id_seq'::regclass);
 9   ALTER TABLE public.mission ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    207    206    207            3           2604    1265936 
   monnaie id    DEFAULT     Z   ALTER TABLE ONLY monnaie ALTER COLUMN id SET DEFAULT nextval('monnaie_id_seq'::regclass);
 9   ALTER TABLE public.monnaie ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    223    222    223            8           2604    1274087    paiement_facture id    DEFAULT     l   ALTER TABLE ONLY paiement_facture ALTER COLUMN id SET DEFAULT nextval('paiement_facture_id_seq'::regclass);
 B   ALTER TABLE public.paiement_facture ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    232    233    233            )           2604    1257630    personnel id    DEFAULT     ^   ALTER TABLE ONLY personnel ALTER COLUMN id SET DEFAULT nextval('personnel_id_seq'::regclass);
 ;   ALTER TABLE public.personnel ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    203    202    203            4           2604    1265950    prev_debours id    DEFAULT     d   ALTER TABLE ONLY prev_debours ALTER COLUMN id SET DEFAULT nextval('prev_debours_id_seq'::regclass);
 >   ALTER TABLE public.prev_debours ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    224    225    225            5           2604    1274027    prev_honoraire id    DEFAULT     h   ALTER TABLE ONLY prev_honoraire ALTER COLUMN id SET DEFAULT nextval('prev_honoraire_id_seq'::regclass);
 @   ALTER TABLE public.prev_honoraire ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    227    226    227            ?           2604    1274191    prev_tache id    DEFAULT     `   ALTER TABLE ONLY prev_tache ALTER COLUMN id SET DEFAULT nextval('prev_tache_id_seq'::regclass);
 <   ALTER TABLE public.prev_tache ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    246    247    247            ,           2604    1265806 
   produit id    DEFAULT     Z   ALTER TABLE ONLY produit ALTER COLUMN id SET DEFAULT nextval('produit_id_seq'::regclass);
 9   ALTER TABLE public.produit ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    208    209    209            2           2604    1265904 	   region id    DEFAULT     X   ALTER TABLE ONLY region ALTER COLUMN id SET DEFAULT nextval('region_id_seq'::regclass);
 8   ALTER TABLE public.region ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    220    221    221            A           2604    1290578 
   section id    DEFAULT     Z   ALTER TABLE ONLY section ALTER COLUMN id SET DEFAULT nextval('section_id_seq'::regclass);
 9   ALTER TABLE public.section ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    250    251    251            B           2604    1290586    sous_section id    DEFAULT     d   ALTER TABLE ONLY sous_section ALTER COLUMN id SET DEFAULT nextval('sous_section_id_seq'::regclass);
 >   ALTER TABLE public.sous_section ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    253    252    253            >           2604    1274177    sous_tache id    DEFAULT     `   ALTER TABLE ONLY sous_tache ALTER COLUMN id SET DEFAULT nextval('sous_tache_id_seq'::regclass);
 <   ALTER TABLE public.sous_tache ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    244    245    245            =           2604    1274169    tache id    DEFAULT     V   ALTER TABLE ONLY tache ALTER COLUMN id SET DEFAULT nextval('tache_id_seq'::regclass);
 7   ALTER TABLE public.tache ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    242    243    243            @           2604    1282361    type_produit id    DEFAULT     d   ALTER TABLE ONLY type_produit ALTER COLUMN id SET DEFAULT nextval('type_produit_id_seq'::regclass);
 >   ALTER TABLE public.type_produit ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    249    248    249            i          0    1274050    billet_avion 
   TABLE DATA               ?   COPY billet_avion (id, num_bc, date_bc, id_pers, date_depart, date_retour, monnaie, lieu_depart, lieu_destination, montant_ttc, id_mission) FROM stdin;
    public       postgres    false    229   lK      K          0    1249450    client 
   TABLE DATA               ?   COPY client (id, code, nom_client, adresse, telephone, fax, email, nif, stat, cif, reg_comm, groupe_app, groupe, capital, effectif) FROM stdin;
    public       postgres    false    199   ?K      o          0    1274098    contact_client 
   TABLE DATA               K   COPY contact_client (id, nom, fonction, tel, email, id_client) FROM stdin;
    public       postgres    false    235   ?K      M          0    1257611    contrat 
   TABLE DATA               y   COPY contrat (id, num_contrat, date_contrat, id_client, montant_ht, taux_tva, monnaie, date_debut, date_fin) FROM stdin;
    public       postgres    false    201   L      q          0    1274112    cv_personnel 
   TABLE DATA               A   COPY cv_personnel (id, libelle, repertoire, id_pers) FROM stdin;
    public       postgres    false    237   rL      [          0    1265832    debours 
   TABLE DATA               I   COPY debours (id, code, libelle, type_deb, nature, unitaire) FROM stdin;
    public       postgres    false    215   ?L      ]          0    1265840    demande_debours 
   TABLE DATA               ?   COPY demande_debours (id, num_demande, date_demande, id_mission, id_demandeur, nombre, visa, date_visa, id_user, date_paiement, personne_visa, date_autorisation, personne_permis, annuler, personne_paiement) FROM stdin;
    public       postgres    false    217   ?L      _          0    1265850    det_demande_debours 
   TABLE DATA               ?   COPY det_demande_debours (id, id_debours, id_pers, id_demande, nbre_jours, nbre_heure, pu, date_debut, date_fin, id_region, localite, montant, id_grade, montant_retourne, explication) FROM stdin;
    public       postgres    false    219   ?L      u          0    1274137    detail_feuille_temps 
   TABLE DATA               k   COPY detail_feuille_temps (id, id_mission, libelle, id_entete, sous_tache, pourcentage, duree) FROM stdin;
    public       postgres    false    241   M      W          0    1265813 	   documents 
   TABLE DATA               ?   COPY documents (id, libelle, prepare_par, id_utilisateur, date_preparation, date_insertion, id_mission, repertoire) FROM stdin;
    public       postgres    false    211   #M      k          0    1274070    echeance_paiement 
   TABLE DATA               ?   COPY echeance_paiement (id, libelle, pourcentage, date_facture, id_mission, date_em_facture, num_facture, montant_facture, date_saisie) FROM stdin;
    public       postgres    false    231   @M      s          0    1274129    entete_feuille_temps 
   TABLE DATA               B   COPY entete_feuille_temps (id, date_feuille, id_pers) FROM stdin;
    public       postgres    false    239   ]M      Q          0    1257637    grade 
   TABLE DATA               1   COPY grade (id, code, libelle, rang) FROM stdin;
    public       postgres    false    205   zM      Y          0    1265824    historique_doc 
   TABLE DATA               m   COPY historique_doc (id, type_histoire, observation, id_document, date_histoire, id_utilisateur) FROM stdin;
    public       postgres    false    213   ?M      S          0    1257645    mission 
   TABLE DATA               ?   COPY mission (id, code, libelle, associe_resp, senior_manager, chef_mission, montant_ht, tva, monnaie, produit, date_deb_prevue, date_fin_prevue, cloturer, id_contrat, associate_director, director) FROM stdin;
    public       postgres    false    207   ?M      c          0    1265933    monnaie 
   TABLE DATA               -   COPY monnaie (id, code, libelle) FROM stdin;
    public       postgres    false    223   CN      m          0    1274084    paiement_facture 
   TABLE DATA               u   COPY paiement_facture (id, montant_payer, date_paiement, id_echeance, reference_paiement, mode_paiement) FROM stdin;
    public       postgres    false    233   ?N      O          0    1257627 	   personnel 
   TABLE DATA               p   COPY personnel (id, code, nom, grade, telephone, adresse, matricule, rang, appelation, date_depart) FROM stdin;
    public       postgres    false    203   ?N      e          0    1265947    prev_debours 
   TABLE DATA               R   COPY prev_debours (id, nbre_jours, id_debours, id_mission, pu, unite) FROM stdin;
    public       postgres    false    225   O      g          0    1274024    prev_honoraire 
   TABLE DATA               t   COPY prev_honoraire (id, nbre_jour, nbre_heure, nbre_homme, pu, grade, id_mission, monnaie, type_unite) FROM stdin;
    public       postgres    false    227   /O      {          0    1274188 
   prev_tache 
   TABLE DATA               F   COPY prev_tache (id, grand_tache, nbre_heure, id_mission) FROM stdin;
    public       postgres    false    247   LO      U          0    1265803    produit 
   TABLE DATA               7   COPY produit (id, code, libelle, type_prd) FROM stdin;
    public       postgres    false    209   iO      a          0    1265901    region 
   TABLE DATA               &   COPY region (id, libelle) FROM stdin;
    public       postgres    false    221   ?O                0    1290575    section 
   TABLE DATA               -   COPY section (id, code, libelle) FROM stdin;
    public       postgres    false    251   ?O      ?          0    1290583    sous_section 
   TABLE DATA               K   COPY sous_section (id, code, libelle, id_section, ponderation) FROM stdin;
    public       postgres    false    253   :P      y          0    1274174 
   sous_tache 
   TABLE DATA               J   COPY sous_tache (id, code, libelle, grand_tache, ponderation) FROM stdin;
    public       postgres    false    245   ?P      w          0    1274166    tache 
   TABLE DATA               +   COPY tache (id, code, libelle) FROM stdin;
    public       postgres    false    243   YQ      }          0    1282358    type_produit 
   TABLE DATA               2   COPY type_produit (id, code, libelle) FROM stdin;
    public       postgres    false    249   ?Q      I          0    1249429    utilisateur 
   TABLE DATA               ?   COPY utilisateur (nom, prenom, email, password, date_creation, date_modification, enabled, token, roles, id, sigle, envoi_donnees, id_pers) FROM stdin;
    public       postgres    false    197   /R      ?           0    0    billet_avion_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('billet_avion_id_seq', 1, false);
            public       postgres    false    228            ?           0    0    client_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('client_id_seq', 24, true);
            public       postgres    false    198            ?           0    0    contacte_client_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('contacte_client_id_seq', 1, false);
            public       postgres    false    234            ?           0    0    contrat_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('contrat_id_seq', 3, true);
            public       postgres    false    200            ?           0    0    cv_personnel_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('cv_personnel_id_seq', 1, false);
            public       postgres    false    236            ?           0    0    debours_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('debours_id_seq', 9, true);
            public       postgres    false    214            ?           0    0    demande_debours_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('demande_debours_id_seq', 1, false);
            public       postgres    false    216            ?           0    0    det_demande_debours_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('det_demande_debours_id_seq', 1, false);
            public       postgres    false    218            ?           0    0    detail_feuille_temps_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('detail_feuille_temps_id_seq', 1, false);
            public       postgres    false    240            ?           0    0    documents_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('documents_id_seq', 1, false);
            public       postgres    false    210            ?           0    0    echeance_paiement_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('echeance_paiement_id_seq', 1, false);
            public       postgres    false    230            ?           0    0    entete_feuille_temps_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('entete_feuille_temps_id_seq', 1, false);
            public       postgres    false    238            ?           0    0    grade_id_seq    SEQUENCE SET     3   SELECT pg_catalog.setval('grade_id_seq', 2, true);
            public       postgres    false    204            ?           0    0    historique_doc_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('historique_doc_id_seq', 1, false);
            public       postgres    false    212            ?           0    0    mission_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('mission_id_seq', 3, true);
            public       postgres    false    206            ?           0    0    monnaie_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('monnaie_id_seq', 3, true);
            public       postgres    false    222            ?           0    0    paiement_facture_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('paiement_facture_id_seq', 1, false);
            public       postgres    false    232            ?           0    0    personnel_id_seq    SEQUENCE SET     7   SELECT pg_catalog.setval('personnel_id_seq', 4, true);
            public       postgres    false    202            ?           0    0    prev_debours_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('prev_debours_id_seq', 1, false);
            public       postgres    false    224            ?           0    0    prev_honoraire_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('prev_honoraire_id_seq', 1, false);
            public       postgres    false    226            ?           0    0    prev_tache_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('prev_tache_id_seq', 1, false);
            public       postgres    false    246            ?           0    0    produit_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('produit_id_seq', 6, true);
            public       postgres    false    208            ?           0    0    region_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('region_id_seq', 1, false);
            public       postgres    false    220            ?           0    0    section_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('section_id_seq', 1, true);
            public       postgres    false    250            ?           0    0    sous_section_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('sous_section_id_seq', 3, true);
            public       postgres    false    252            ?           0    0    sous_tache_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('sous_tache_id_seq', 5, true);
            public       postgres    false    244            ?           0    0    tache_id_seq    SEQUENCE SET     3   SELECT pg_catalog.setval('tache_id_seq', 2, true);
            public       postgres    false    242            ?           0    0    type_produit_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('type_produit_id_seq', 6, true);
            public       postgres    false    248            ?           0    0    utilisateur_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('utilisateur_id_seq', 1, true);
            public       postgres    false    196            ?           2606    1274055    billet_avion billet_avion_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY billet_avion
    ADD CONSTRAINT billet_avion_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.billet_avion DROP CONSTRAINT billet_avion_pkey;
       public         postgres    false    229            G           2606    1249458    client client_pkey 
   CONSTRAINT     I   ALTER TABLE ONLY client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.client DROP CONSTRAINT client_pkey;
       public         postgres    false    199            I           2606    1249460    client code_cl 
   CONSTRAINT     B   ALTER TABLE ONLY client
    ADD CONSTRAINT code_cl UNIQUE (code);
 8   ALTER TABLE ONLY public.client DROP CONSTRAINT code_cl;
       public         postgres    false    199            `           2606    1282365    produit code_prd 
   CONSTRAINT     D   ALTER TABLE ONLY produit
    ADD CONSTRAINT code_prd UNIQUE (code);
 :   ALTER TABLE ONLY public.produit DROP CONSTRAINT code_prd;
       public         postgres    false    209            P           2606    1257634    personnel codepers 
   CONSTRAINT     F   ALTER TABLE ONLY personnel
    ADD CONSTRAINT codepers UNIQUE (code);
 <   ALTER TABLE ONLY public.personnel DROP CONSTRAINT codepers;
       public         postgres    false    203            ?           2606    1274103 #   contact_client contacte_client_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY contact_client
    ADD CONSTRAINT contacte_client_pkey PRIMARY KEY (id);
 M   ALTER TABLE ONLY public.contact_client DROP CONSTRAINT contacte_client_pkey;
       public         postgres    false    235            K           2606    1257616    contrat contrat_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY contrat
    ADD CONSTRAINT contrat_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.contrat DROP CONSTRAINT contrat_pkey;
       public         postgres    false    201            M           2606    1257618    contrat contrat_unique 
   CONSTRAINT     Q   ALTER TABLE ONLY contrat
    ADD CONSTRAINT contrat_unique UNIQUE (num_contrat);
 @   ALTER TABLE ONLY public.contrat DROP CONSTRAINT contrat_unique;
       public         postgres    false    201            ?           2606    1274120    cv_personnel cv_personnel_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY cv_personnel
    ADD CONSTRAINT cv_personnel_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.cv_personnel DROP CONSTRAINT cv_personnel_pkey;
       public         postgres    false    237            i           2606    1265837    debours debours_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY debours
    ADD CONSTRAINT debours_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.debours DROP CONSTRAINT debours_pkey;
       public         postgres    false    215            k           2606    1265845 $   demande_debours demande_debours_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT demande_debours_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT demande_debours_pkey;
       public         postgres    false    217            s           2606    1265912 ,   det_demande_debours det_demande_debours_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY det_demande_debours
    ADD CONSTRAINT det_demande_debours_pkey PRIMARY KEY (id);
 V   ALTER TABLE ONLY public.det_demande_debours DROP CONSTRAINT det_demande_debours_pkey;
       public         postgres    false    219            ?           2606    1274145 .   detail_feuille_temps detail_feuille_temps_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY detail_feuille_temps
    ADD CONSTRAINT detail_feuille_temps_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.detail_feuille_temps DROP CONSTRAINT detail_feuille_temps_pkey;
       public         postgres    false    241            e           2606    1265821    documents documents_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY documents
    ADD CONSTRAINT documents_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.documents DROP CONSTRAINT documents_pkey;
       public         postgres    false    211            ?           2606    1274075 (   echeance_paiement echeance_paiement_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY echeance_paiement
    ADD CONSTRAINT echeance_paiement_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.echeance_paiement DROP CONSTRAINT echeance_paiement_pkey;
       public         postgres    false    231            ?           2606    1274134 .   entete_feuille_temps entete_feuille_temps_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY entete_feuille_temps
    ADD CONSTRAINT entete_feuille_temps_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.entete_feuille_temps DROP CONSTRAINT entete_feuille_temps_pkey;
       public         postgres    false    239            T           2606    1257642    grade grade_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY grade
    ADD CONSTRAINT grade_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.grade DROP CONSTRAINT grade_pkey;
       public         postgres    false    205            g           2606    1265829 "   historique_doc historique_doc_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY historique_doc
    ADD CONSTRAINT historique_doc_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.historique_doc DROP CONSTRAINT historique_doc_pkey;
       public         postgres    false    213            ^           2606    1257653    mission mission_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY mission
    ADD CONSTRAINT mission_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.mission DROP CONSTRAINT mission_pkey;
       public         postgres    false    207            z           2606    1265938    monnaie monnaie_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY monnaie
    ADD CONSTRAINT monnaie_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.monnaie DROP CONSTRAINT monnaie_pkey;
       public         postgres    false    223            ?           2606    1274089 &   paiement_facture paiement_facture_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY paiement_facture
    ADD CONSTRAINT paiement_facture_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.paiement_facture DROP CONSTRAINT paiement_facture_pkey;
       public         postgres    false    233            R           2606    1257632    personnel personnel_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY personnel
    ADD CONSTRAINT personnel_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.personnel DROP CONSTRAINT personnel_pkey;
       public         postgres    false    203            }           2606    1265952    prev_debours prev_debours_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY prev_debours
    ADD CONSTRAINT prev_debours_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.prev_debours DROP CONSTRAINT prev_debours_pkey;
       public         postgres    false    225            ?           2606    1274029 "   prev_honoraire prev_honoraire_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY prev_honoraire
    ADD CONSTRAINT prev_honoraire_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.prev_honoraire DROP CONSTRAINT prev_honoraire_pkey;
       public         postgres    false    227            c           2606    1265808    produit produit_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY produit
    ADD CONSTRAINT produit_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.produit DROP CONSTRAINT produit_pkey;
       public         postgres    false    209            x           2606    1265909    region region_pkey 
   CONSTRAINT     I   ALTER TABLE ONLY region
    ADD CONSTRAINT region_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.region DROP CONSTRAINT region_pkey;
       public         postgres    false    221            ?           2606    1290580    section section_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY section
    ADD CONSTRAINT section_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.section DROP CONSTRAINT section_pkey;
       public         postgres    false    251            ?           2606    1290588    sous_section sous_section_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY sous_section
    ADD CONSTRAINT sous_section_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.sous_section DROP CONSTRAINT sous_section_pkey;
       public         postgres    false    253            ?           2606    1274179    sous_tache sous_tache_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY sous_tache
    ADD CONSTRAINT sous_tache_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.sous_tache DROP CONSTRAINT sous_tache_pkey;
       public         postgres    false    245            ?           2606    1274171    tache tache_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY tache
    ADD CONSTRAINT tache_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.tache DROP CONSTRAINT tache_pkey;
       public         postgres    false    243            ?           2606    1282363    type_produit type_produit_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY type_produit
    ADD CONSTRAINT type_produit_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.type_produit DROP CONSTRAINT type_produit_pkey;
       public         postgres    false    249            E           2606    1249444    utilisateur utilisateur_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.utilisateur DROP CONSTRAINT utilisateur_pkey;
       public         postgres    false    197            U           1259    1290660    fki_fk_associate_dir    INDEX     O   CREATE INDEX fki_fk_associate_dir ON mission USING btree (associate_director);
 (   DROP INDEX public.fki_fk_associate_dir;
       public         postgres    false    207            V           1259    1290611    fki_fk_associe    INDEX     C   CREATE INDEX fki_fk_associe ON mission USING btree (associe_resp);
 "   DROP INDEX public.fki_fk_associe;
       public         postgres    false    207            ?           1259    1274061    fki_fk_avion_miss    INDEX     I   CREATE INDEX fki_fk_avion_miss ON billet_avion USING btree (id_mission);
 %   DROP INDEX public.fki_fk_avion_miss;
       public         postgres    false    229            ?           1259    1274067    fki_fk_avion_pers    INDEX     F   CREATE INDEX fki_fk_avion_pers ON billet_avion USING btree (id_pers);
 %   DROP INDEX public.fki_fk_avion_pers;
       public         postgres    false    229            W           1259    1290623    fki_fk_chef    INDEX     @   CREATE INDEX fki_fk_chef ON mission USING btree (chef_mission);
    DROP INDEX public.fki_fk_chef;
       public         postgres    false    207            N           1259    1257624    fki_fk_clcontrat    INDEX     B   CREATE INDEX fki_fk_clcontrat ON contrat USING btree (id_client);
 $   DROP INDEX public.fki_fk_clcontrat;
       public         postgres    false    201            ?           1259    1274109    fki_fk_client_contact    INDEX     N   CREATE INDEX fki_fk_client_contact ON contact_client USING btree (id_client);
 )   DROP INDEX public.fki_fk_client_contact;
       public         postgres    false    235            X           1259    1290572    fki_fk_contrat_mission    INDEX     I   CREATE INDEX fki_fk_contrat_mission ON mission USING btree (id_contrat);
 *   DROP INDEX public.fki_fk_contrat_mission;
       public         postgres    false    207            ?           1259    1274126 	   fki_fk_cv    INDEX     >   CREATE INDEX fki_fk_cv ON cv_personnel USING btree (id_pers);
    DROP INDEX public.fki_fk_cv;
       public         postgres    false    237            t           1259    1265918    fki_fk_debours    INDEX     M   CREATE INDEX fki_fk_debours ON det_demande_debours USING btree (id_debours);
 "   DROP INDEX public.fki_fk_debours;
       public         postgres    false    219            l           1259    1265868    fki_fk_demandeur    INDEX     M   CREATE INDEX fki_fk_demandeur ON demande_debours USING btree (id_demandeur);
 $   DROP INDEX public.fki_fk_demandeur;
       public         postgres    false    217            Y           1259    1290666    fki_fk_director    INDEX     @   CREATE INDEX fki_fk_director ON mission USING btree (director);
 #   DROP INDEX public.fki_fk_director;
       public         postgres    false    207            ?           1259    1274095    fki_fk_echeance    INDEX     L   CREATE INDEX fki_fk_echeance ON paiement_facture USING btree (id_echeance);
 #   DROP INDEX public.fki_fk_echeance;
       public         postgres    false    233            ?           1259    1274081    fki_fk_echeance_mission    INDEX     T   CREATE INDEX fki_fk_echeance_mission ON echeance_paiement USING btree (id_mission);
 +   DROP INDEX public.fki_fk_echeance_mission;
       public         postgres    false    231            ?           1259    1274163    fki_fk_entete_detail    INDEX     S   CREATE INDEX fki_fk_entete_detail ON detail_feuille_temps USING btree (id_entete);
 (   DROP INDEX public.fki_fk_entete_detail;
       public         postgres    false    241            ?           1259    1274151    fki_fk_entete_pers    INDEX     O   CREATE INDEX fki_fk_entete_pers ON entete_feuille_temps USING btree (id_pers);
 &   DROP INDEX public.fki_fk_entete_pers;
       public         postgres    false    239            ?           1259    1274157    fki_fk_feuille_mission    INDEX     V   CREATE INDEX fki_fk_feuille_mission ON detail_feuille_temps USING btree (id_mission);
 *   DROP INDEX public.fki_fk_feuille_mission;
       public         postgres    false    241            ~           1259    1274035    fki_fk_grade_hon    INDEX     E   CREATE INDEX fki_fk_grade_hon ON prev_honoraire USING btree (grade);
 $   DROP INDEX public.fki_fk_grade_hon;
       public         postgres    false    227            ?           1259    1274199    fki_fk_grandt_mission    INDEX     L   CREATE INDEX fki_fk_grandt_mission ON prev_tache USING btree (grand_tache);
 )   DROP INDEX public.fki_fk_grandt_mission;
       public         postgres    false    247                       1259    1274041    fki_fk_honoraire_miss    INDEX     O   CREATE INDEX fki_fk_honoraire_miss ON prev_honoraire USING btree (id_mission);
 )   DROP INDEX public.fki_fk_honoraire_miss;
       public         postgres    false    227            ?           1259    1274047    fki_fk_honoraire_monnaie    INDEX     O   CREATE INDEX fki_fk_honoraire_monnaie ON prev_honoraire USING btree (monnaie);
 ,   DROP INDEX public.fki_fk_honoraire_monnaie;
       public         postgres    false    227            m           1259    1265862    fki_fk_mission    INDEX     I   CREATE INDEX fki_fk_mission ON demande_debours USING btree (id_mission);
 "   DROP INDEX public.fki_fk_mission;
       public         postgres    false    217            {           1259    1265963    fki_fk_mission_prevu    INDEX     L   CREATE INDEX fki_fk_mission_prevu ON prev_debours USING btree (id_mission);
 (   DROP INDEX public.fki_fk_mission_prevu;
       public         postgres    false    225            Z           1259    1265944    fki_fk_monnaie    INDEX     >   CREATE INDEX fki_fk_monnaie ON mission USING btree (monnaie);
 "   DROP INDEX public.fki_fk_monnaie;
       public         postgres    false    207            n           1259    1265886    fki_fk_permis    INDEX     M   CREATE INDEX fki_fk_permis ON demande_debours USING btree (personne_permis);
 !   DROP INDEX public.fki_fk_permis;
       public         postgres    false    217            u           1259    1265924    fki_fk_pers    INDEX     G   CREATE INDEX fki_fk_pers ON det_demande_debours USING btree (id_pers);
    DROP INDEX public.fki_fk_pers;
       public         postgres    false    219            o           1259    1265892    fki_fk_pers_paiement    INDEX     V   CREATE INDEX fki_fk_pers_paiement ON demande_debours USING btree (personne_paiement);
 (   DROP INDEX public.fki_fk_pers_paiement;
       public         postgres    false    217            [           1259    1290629    fki_fk_produit    INDEX     >   CREATE INDEX fki_fk_produit ON mission USING btree (produit);
 "   DROP INDEX public.fki_fk_produit;
       public         postgres    false    207            v           1259    1265930    fki_fk_region    INDEX     K   CREATE INDEX fki_fk_region ON det_demande_debours USING btree (id_region);
 !   DROP INDEX public.fki_fk_region;
       public         postgres    false    219            ?           1259    1290594    fki_fk_section    INDEX     F   CREATE INDEX fki_fk_section ON sous_section USING btree (id_section);
 "   DROP INDEX public.fki_fk_section;
       public         postgres    false    253            \           1259    1290617    fki_fk_senior    INDEX     D   CREATE INDEX fki_fk_senior ON mission USING btree (senior_manager);
 !   DROP INDEX public.fki_fk_senior;
       public         postgres    false    207            ?           1259    1290605    fki_fk_soustache    INDEX     P   CREATE INDEX fki_fk_soustache ON detail_feuille_temps USING btree (sous_tache);
 $   DROP INDEX public.fki_fk_soustache;
       public         postgres    false    241            ?           1259    1274185    fki_fk_tache    INDEX     C   CREATE INDEX fki_fk_tache ON sous_tache USING btree (grand_tache);
     DROP INDEX public.fki_fk_tache;
       public         postgres    false    245            a           1259    1282374    fki_fk_type_prd    INDEX     @   CREATE INDEX fki_fk_type_prd ON produit USING btree (type_prd);
 #   DROP INDEX public.fki_fk_type_prd;
       public         postgres    false    209            p           1259    1265874    fki_fk_user    INDEX     C   CREATE INDEX fki_fk_user ON demande_debours USING btree (id_user);
    DROP INDEX public.fki_fk_user;
       public         postgres    false    217            C           1259    1265898    fki_fk_user_pers    INDEX     D   CREATE INDEX fki_fk_user_pers ON utilisateur USING btree (id_pers);
 $   DROP INDEX public.fki_fk_user_pers;
       public         postgres    false    197            q           1259    1265880    fki_fk_visa    INDEX     I   CREATE INDEX fki_fk_visa ON demande_debours USING btree (personne_visa);
    DROP INDEX public.fki_fk_visa;
       public         postgres    false    217            ?           2606    1290655    mission fk_associate_dir    FK CONSTRAINT     ?   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_associate_dir FOREIGN KEY (associate_director) REFERENCES personnel(id) ON DELETE RESTRICT;
 B   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_associate_dir;
       public       postgres    false    207    203    2898            ?           2606    1290635    mission fk_associe    FK CONSTRAINT     l   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_associe FOREIGN KEY (associe_resp) REFERENCES personnel(id);
 <   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_associe;
       public       postgres    false    207    203    2898            ?           2606    1274056    billet_avion fk_avion_miss    FK CONSTRAINT     ?   ALTER TABLE ONLY billet_avion
    ADD CONSTRAINT fk_avion_miss FOREIGN KEY (id_mission) REFERENCES mission(id) ON DELETE RESTRICT;
 D   ALTER TABLE ONLY public.billet_avion DROP CONSTRAINT fk_avion_miss;
       public       postgres    false    229    2910    207            ?           2606    1274062    billet_avion fk_avion_pers    FK CONSTRAINT     ?   ALTER TABLE ONLY billet_avion
    ADD CONSTRAINT fk_avion_pers FOREIGN KEY (id_pers) REFERENCES personnel(id) ON DELETE RESTRICT;
 D   ALTER TABLE ONLY public.billet_avion DROP CONSTRAINT fk_avion_pers;
       public       postgres    false    2898    203    229            ?           2606    1290645    mission fk_chef    FK CONSTRAINT     |   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_chef FOREIGN KEY (chef_mission) REFERENCES personnel(id) ON DELETE RESTRICT;
 9   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_chef;
       public       postgres    false    2898    203    207            ?           2606    1257619    contrat fk_clcontrat    FK CONSTRAINT     h   ALTER TABLE ONLY contrat
    ADD CONSTRAINT fk_clcontrat FOREIGN KEY (id_client) REFERENCES client(id);
 >   ALTER TABLE ONLY public.contrat DROP CONSTRAINT fk_clcontrat;
       public       postgres    false    2887    201    199            ?           2606    1274104     contact_client fk_client_contact    FK CONSTRAINT     ?   ALTER TABLE ONLY contact_client
    ADD CONSTRAINT fk_client_contact FOREIGN KEY (id_client) REFERENCES client(id) ON DELETE RESTRICT;
 J   ALTER TABLE ONLY public.contact_client DROP CONSTRAINT fk_client_contact;
       public       postgres    false    235    199    2887            ?           2606    1290567    mission fk_contrat_mission    FK CONSTRAINT     ?   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_contrat_mission FOREIGN KEY (id_contrat) REFERENCES contrat(id) ON DELETE RESTRICT;
 D   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_contrat_mission;
       public       postgres    false    2891    207    201            ?           2606    1274121    cv_personnel fk_cv    FK CONSTRAINT     z   ALTER TABLE ONLY cv_personnel
    ADD CONSTRAINT fk_cv FOREIGN KEY (id_pers) REFERENCES personnel(id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY public.cv_personnel DROP CONSTRAINT fk_cv;
       public       postgres    false    237    203    2898            ?           2606    1265913    det_demande_debours fk_debours    FK CONSTRAINT     ?   ALTER TABLE ONLY det_demande_debours
    ADD CONSTRAINT fk_debours FOREIGN KEY (id_debours) REFERENCES debours(id) ON DELETE RESTRICT;
 H   ALTER TABLE ONLY public.det_demande_debours DROP CONSTRAINT fk_debours;
       public       postgres    false    215    2921    219            ?           2606    1265863    demande_debours fk_demandeur    FK CONSTRAINT     ?   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT fk_demandeur FOREIGN KEY (id_demandeur) REFERENCES personnel(id) ON DELETE RESTRICT;
 F   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT fk_demandeur;
       public       postgres    false    217    203    2898            ?           2606    1290661    mission fk_director    FK CONSTRAINT     |   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_director FOREIGN KEY (director) REFERENCES personnel(id) ON DELETE RESTRICT;
 =   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_director;
       public       postgres    false    2898    207    203            ?           2606    1274090    paiement_facture fk_echeance    FK CONSTRAINT     ?   ALTER TABLE ONLY paiement_facture
    ADD CONSTRAINT fk_echeance FOREIGN KEY (id_echeance) REFERENCES echeance_paiement(id) ON DELETE RESTRICT;
 F   ALTER TABLE ONLY public.paiement_facture DROP CONSTRAINT fk_echeance;
       public       postgres    false    233    231    2952            ?           2606    1274076 %   echeance_paiement fk_echeance_mission    FK CONSTRAINT     ?   ALTER TABLE ONLY echeance_paiement
    ADD CONSTRAINT fk_echeance_mission FOREIGN KEY (id_mission) REFERENCES mission(id) ON DELETE RESTRICT;
 O   ALTER TABLE ONLY public.echeance_paiement DROP CONSTRAINT fk_echeance_mission;
       public       postgres    false    231    2910    207            ?           2606    1274158 %   detail_feuille_temps fk_entete_detail    FK CONSTRAINT     ?   ALTER TABLE ONLY detail_feuille_temps
    ADD CONSTRAINT fk_entete_detail FOREIGN KEY (id_entete) REFERENCES entete_feuille_temps(id) ON DELETE RESTRICT;
 O   ALTER TABLE ONLY public.detail_feuille_temps DROP CONSTRAINT fk_entete_detail;
       public       postgres    false    241    2964    239            ?           2606    1274146 #   entete_feuille_temps fk_entete_pers    FK CONSTRAINT     ?   ALTER TABLE ONLY entete_feuille_temps
    ADD CONSTRAINT fk_entete_pers FOREIGN KEY (id_pers) REFERENCES personnel(id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY public.entete_feuille_temps DROP CONSTRAINT fk_entete_pers;
       public       postgres    false    2898    203    239            ?           2606    1274152 '   detail_feuille_temps fk_feuille_mission    FK CONSTRAINT     ?   ALTER TABLE ONLY detail_feuille_temps
    ADD CONSTRAINT fk_feuille_mission FOREIGN KEY (id_mission) REFERENCES mission(id) ON DELETE RESTRICT;
 Q   ALTER TABLE ONLY public.detail_feuille_temps DROP CONSTRAINT fk_feuille_mission;
       public       postgres    false    241    207    2910            ?           2606    1274030    prev_honoraire fk_grade_hon    FK CONSTRAINT     }   ALTER TABLE ONLY prev_honoraire
    ADD CONSTRAINT fk_grade_hon FOREIGN KEY (grade) REFERENCES grade(id) ON DELETE RESTRICT;
 E   ALTER TABLE ONLY public.prev_honoraire DROP CONSTRAINT fk_grade_hon;
       public       postgres    false    227    205    2900            ?           2606    1274194    prev_tache fk_grandt_mission    FK CONSTRAINT     ?   ALTER TABLE ONLY prev_tache
    ADD CONSTRAINT fk_grandt_mission FOREIGN KEY (grand_tache) REFERENCES tache(id) ON DELETE RESTRICT;
 F   ALTER TABLE ONLY public.prev_tache DROP CONSTRAINT fk_grandt_mission;
       public       postgres    false    2972    243    247            ?           2606    1274036     prev_honoraire fk_honoraire_miss    FK CONSTRAINT     ?   ALTER TABLE ONLY prev_honoraire
    ADD CONSTRAINT fk_honoraire_miss FOREIGN KEY (id_mission) REFERENCES mission(id) ON DELETE RESTRICT;
 J   ALTER TABLE ONLY public.prev_honoraire DROP CONSTRAINT fk_honoraire_miss;
       public       postgres    false    207    227    2910            ?           2606    1274042 #   prev_honoraire fk_honoraire_monnaie    FK CONSTRAINT     ?   ALTER TABLE ONLY prev_honoraire
    ADD CONSTRAINT fk_honoraire_monnaie FOREIGN KEY (monnaie) REFERENCES monnaie(id) ON DELETE RESTRICT;
 M   ALTER TABLE ONLY public.prev_honoraire DROP CONSTRAINT fk_honoraire_monnaie;
       public       postgres    false    227    2938    223            ?           2606    1265857    demande_debours fk_mission    FK CONSTRAINT     ?   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT fk_mission FOREIGN KEY (id_mission) REFERENCES mission(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 D   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT fk_mission;
       public       postgres    false    207    217    2910            ?           2606    1265953    prev_debours fk_mission    FK CONSTRAINT     ?   ALTER TABLE ONLY prev_debours
    ADD CONSTRAINT fk_mission FOREIGN KEY (id_mission) REFERENCES mission(id) ON DELETE RESTRICT;
 A   ALTER TABLE ONLY public.prev_debours DROP CONSTRAINT fk_mission;
       public       postgres    false    2910    207    225            ?           2606    1265958    prev_debours fk_mission_prevu    FK CONSTRAINT     ?   ALTER TABLE ONLY prev_debours
    ADD CONSTRAINT fk_mission_prevu FOREIGN KEY (id_mission) REFERENCES mission(id) ON DELETE RESTRICT;
 G   ALTER TABLE ONLY public.prev_debours DROP CONSTRAINT fk_mission_prevu;
       public       postgres    false    207    2910    225            ?           2606    1265939    mission fk_monnaie    FK CONSTRAINT     x   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_monnaie FOREIGN KEY (monnaie) REFERENCES monnaie(id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_monnaie;
       public       postgres    false    207    223    2938            ?           2606    1265881    demande_debours fk_permis    FK CONSTRAINT     ?   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT fk_permis FOREIGN KEY (personne_permis) REFERENCES personnel(id) ON DELETE RESTRICT;
 C   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT fk_permis;
       public       postgres    false    203    217    2898            ?           2606    1265919    det_demande_debours fk_pers    FK CONSTRAINT     ?   ALTER TABLE ONLY det_demande_debours
    ADD CONSTRAINT fk_pers FOREIGN KEY (id_pers) REFERENCES personnel(id) ON DELETE RESTRICT;
 E   ALTER TABLE ONLY public.det_demande_debours DROP CONSTRAINT fk_pers;
       public       postgres    false    219    203    2898            ?           2606    1265887     demande_debours fk_pers_paiement    FK CONSTRAINT     ?   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT fk_pers_paiement FOREIGN KEY (personne_paiement) REFERENCES personnel(id) ON DELETE RESTRICT;
 J   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT fk_pers_paiement;
       public       postgres    false    203    2898    217            ?           2606    1290595    prev_tache fk_prev_section    FK CONSTRAINT     q   ALTER TABLE ONLY prev_tache
    ADD CONSTRAINT fk_prev_section FOREIGN KEY (grand_tache) REFERENCES section(id);
 D   ALTER TABLE ONLY public.prev_tache DROP CONSTRAINT fk_prev_section;
       public       postgres    false    247    251    2980            ?           2606    1290650    mission fk_produit    FK CONSTRAINT     x   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_produit FOREIGN KEY (produit) REFERENCES produit(id) ON DELETE RESTRICT;
 <   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_produit;
       public       postgres    false    207    209    2915            ?           2606    1265925    det_demande_debours fk_region    FK CONSTRAINT     ?   ALTER TABLE ONLY det_demande_debours
    ADD CONSTRAINT fk_region FOREIGN KEY (id_region) REFERENCES region(id) ON DELETE RESTRICT;
 G   ALTER TABLE ONLY public.det_demande_debours DROP CONSTRAINT fk_region;
       public       postgres    false    221    219    2936            ?           2606    1290589    sous_section fk_section    FK CONSTRAINT     ?   ALTER TABLE ONLY sous_section
    ADD CONSTRAINT fk_section FOREIGN KEY (id_section) REFERENCES section(id) ON DELETE RESTRICT;
 A   ALTER TABLE ONLY public.sous_section DROP CONSTRAINT fk_section;
       public       postgres    false    251    253    2980            ?           2606    1290640    mission fk_senior    FK CONSTRAINT     ?   ALTER TABLE ONLY mission
    ADD CONSTRAINT fk_senior FOREIGN KEY (senior_manager) REFERENCES personnel(id) ON DELETE RESTRICT;
 ;   ALTER TABLE ONLY public.mission DROP CONSTRAINT fk_senior;
       public       postgres    false    2898    203    207            ?           2606    1290600 !   detail_feuille_temps fk_soustache    FK CONSTRAINT     |   ALTER TABLE ONLY detail_feuille_temps
    ADD CONSTRAINT fk_soustache FOREIGN KEY (sous_tache) REFERENCES sous_section(id);
 K   ALTER TABLE ONLY public.detail_feuille_temps DROP CONSTRAINT fk_soustache;
       public       postgres    false    2983    253    241            ?           2606    1274180    sous_tache fk_tache    FK CONSTRAINT     h   ALTER TABLE ONLY sous_tache
    ADD CONSTRAINT fk_tache FOREIGN KEY (grand_tache) REFERENCES tache(id);
 =   ALTER TABLE ONLY public.sous_tache DROP CONSTRAINT fk_tache;
       public       postgres    false    2972    243    245            ?           2606    1282369    produit fk_type_prd    FK CONSTRAINT     l   ALTER TABLE ONLY produit
    ADD CONSTRAINT fk_type_prd FOREIGN KEY (type_prd) REFERENCES type_produit(id);
 =   ALTER TABLE ONLY public.produit DROP CONSTRAINT fk_type_prd;
       public       postgres    false    249    2978    209            ?           2606    1265869    demande_debours fk_user    FK CONSTRAINT     ?   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES utilisateur(id) ON DELETE RESTRICT;
 A   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT fk_user;
       public       postgres    false    197    217    2885            ?           2606    1265893    utilisateur fk_user_pers    FK CONSTRAINT     ?   ALTER TABLE ONLY utilisateur
    ADD CONSTRAINT fk_user_pers FOREIGN KEY (id_pers) REFERENCES personnel(id) ON DELETE RESTRICT;
 B   ALTER TABLE ONLY public.utilisateur DROP CONSTRAINT fk_user_pers;
       public       postgres    false    197    203    2898            ?           2606    1265875    demande_debours fk_visa    FK CONSTRAINT     ?   ALTER TABLE ONLY demande_debours
    ADD CONSTRAINT fk_visa FOREIGN KEY (personne_visa) REFERENCES personnel(id) ON DELETE RESTRICT;
 A   ALTER TABLE ONLY public.demande_debours DROP CONSTRAINT fk_visa;
       public       postgres    false    203    2898    217            i      x?????? ? ?      K   f   x?3??p????ut?t???/??K)J???????Å?9]?|!?P??kH0?of^fqIjQ?BbzQfriNIiQ*?????????????)^Sc???? ?%?      o      x?????? ? ?      M   F   x?m???0??.)??
X?t?9HycY???! ?$m8?K??|i?5k(?i??ӓ??v???ǟ????na?      q      x?????? ? ?      [   -   x?3???w???ON,????4?tI-?ILN?M?+????????? ?C
f      ]      x?????? ? ?      _      x?????? ? ?      u      x?????? ? ?      W      x?????? ? ?      k      x?????? ? ?      s      x?????? ? ?      Q   7   x?3?t?t,.?O?<???Ӑˈ3??-?385/3?H?71/1=??ӈ+F??? Tb      Y      x?????? ? ?      S   U   x?3?4000?52?50?t,M?,QHI-VH??-(I-?4B??(2D0?!4?!? CG_}#CK?P???`??(?+F??? .)       c   =   x?3??uw?t?t??2?v?t???I,*Vp?M-?LN???2?t?t--??????? }C      m      x?????? ? ?      O   U   x?3?00??JM?Sp?I,MI?4?406V04R051S0????CF\?@???E??yy
?)??y??@-&
??
F?@l??%F??? ??      e      x?????? ? ?      g      x?????? ? ?      {      x?????? ? ?      U   f   x?3?tu????J-+MU????,9??Ӑ˘???9?3?SW?9?77??8?(3?D!??B!9???$?X?L!1??ӈ?d????ciJf	H}ANj	А=... ???      a      x?????? ? ?         .   x?3?4000?t,M?,QHI-V????O???,N,???+?????? ?'}      ?   ?   x?3?4000?50?;??(3-39?$3?O!?T?8?'%U!?Q???ҲԢ??" /U!(?Z?Z?????i?i?e5????Ĥ???R??b??????̜?b?t1X?1T?1gX*?V????????L??=... ?:i      y   }   x?=?A?0??+?D@<??????,Ţ8%v?OZ	.+??3??D?t7?y???9cu?b-???h??&?"6??6)\?i??0?u5,?(??DV???k???JU^?????]??n?w??C???23?      w   X   x?3??H,N??u??,?VH,.N-.?M?+?u?(J?????K,?THL.?,?,?L-?2??q????X??Y?P???????????? ??"}      }   ^   x??1?  ??}/?h?8?????X#??|?:w??F	TZ+e?{??<k????(gOoT^>uqzJ?8?uf9`a?ы?/??g?????]      I   ?   x?m??N?0@g?+P?Tw?9?? ?@*ز?}v ?#????=???)???S|??????h??ri??j?k????!??U??}???kE@??:'4P_??zt??U?~??X?؂k?n?????ӕ^?g?h?dU\?hs?B?t?<x؎?0i侮hR?	~? ??@a???0???<n?yl?}?4??<?     