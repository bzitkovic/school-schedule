--
-- PostgreSQL database dump
--

-- Dumped from database version 13.1
-- Dumped by pg_dump version 13.1

-- Started on 2021-01-23 17:17:02

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 3122 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 221 (class 1255 OID 24972)
-- Name: arhiva_korisnika(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.arhiva_korisnika() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
UPDATE korisnik
SET vrijedece_vrijeme = tsrange(LOWER( vrijedece_vrijeme )::TIMESTAMP,NOW()::TIMESTAMP )
WHERE OLD.id_korisnika = id_korisnika
AND UPPER( vrijedece_vrijeme ) = 'infinity'::TIMESTAMP;
RETURN NULL;
END;
$$;


ALTER FUNCTION public.arhiva_korisnika() OWNER TO postgres;

--
-- TOC entry 222 (class 1255 OID 25039)
-- Name: arhiva_rasporeda(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.arhiva_rasporeda() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
UPDATE se_nalazi
SET vrijedece_vrijeme = tsrange(
LOWER( vrijedece_vrijeme )::TIMESTAMP,
NOW()::TIMESTAMP )
WHERE OLD.id_rasporeda = id_rasporeda
AND OLD.id_predmeta = id_predmeta;
RETURN NULL;
END;
$$;


ALTER FUNCTION public.arhiva_rasporeda() OWNER TO postgres;

--
-- TOC entry 223 (class 1255 OID 33144)
-- Name: izbrisi_kor_racun(integer); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.izbrisi_kor_racun(korisnik_id integer)
    LANGUAGE plpgsql
    AS $$
begin
    -- Brisanje korisničkog računa
    delete  
    from korisnik
    where id_korisnika = korisnik_id;
    commit;
end;$$;


ALTER PROCEDURE public.izbrisi_kor_racun(korisnik_id integer) OWNER TO postgres;

--
-- TOC entry 224 (class 1255 OID 33145)
-- Name: izbrisi_raspored(integer); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.izbrisi_raspored(raspored_id integer)
    LANGUAGE plpgsql
    AS $$
begin
    -- Brisanje korisničkog rasporeda
    delete  
    from raspored
    where id_rasporeda = raspored_id;
    commit;
end;$$;


ALTER PROCEDURE public.izbrisi_raspored(raspored_id integer) OWNER TO postgres;

--
-- TOC entry 220 (class 1255 OID 24967)
-- Name: validacija_registracije(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.validacija_registracije() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
duljinaLozinke INT:= 0;

BEGIN
IF(SELECT COUNT(*) FROM korisnik WHERE korisnicko_ime = NEW.korisnicko_ime) > 1 THEN
RAISE EXCEPTION 'Korisničko ime već postoji!';
END IF;

SELECT CHAR_LENGTH(NEW.lozinka) INTO duljinaLozinke;
IF duljinaLozinke < 5 THEN
RAISE EXCEPTION 'Lozinka mora imati 5 ili više znakova!';
END IF;

RETURN NEW;
END;
$$;


ALTER FUNCTION public.validacija_registracije() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 207 (class 1259 OID 24799)
-- Name: dvorana; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dvorana (
    id_dvorane bigint NOT NULL,
    naziv character varying NOT NULL,
    broj_mjesta bigint NOT NULL,
    id_zgrade bigint
);


ALTER TABLE public.dvorana OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 24797)
-- Name: dvorana_id_dvorane_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dvorana_id_dvorane_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dvorana_id_dvorane_seq OWNER TO postgres;

--
-- TOC entry 3123 (class 0 OID 0)
-- Dependencies: 206
-- Name: dvorana_id_dvorane_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dvorana_id_dvorane_seq OWNED BY public.dvorana.id_dvorane;


--
-- TOC entry 205 (class 1259 OID 24788)
-- Name: zgrada; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.zgrada (
    id_zgrade bigint NOT NULL,
    naziv character varying NOT NULL,
    adresa character varying NOT NULL
);


ALTER TABLE public.zgrada OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 33168)
-- Name: izlistaj_dvorane; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.izlistaj_dvorane AS
 SELECT d.id_dvorane,
    d.id_zgrade AS id_zgrade_dvorana,
    d.naziv AS naziv_dvorane,
    d.broj_mjesta,
    z.id_zgrade AS id_zgrade_zgrada,
    z.naziv AS naziv_zgrade
   FROM (public.dvorana d
     JOIN public.zgrada z ON ((z.id_zgrade = d.id_zgrade)));


ALTER TABLE public.izlistaj_dvorane OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 24735)
-- Name: korisnik; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.korisnik (
    id_korisnika bigint NOT NULL,
    korisnicko_ime character varying NOT NULL,
    lozinka character varying NOT NULL,
    email character varying NOT NULL,
    vrijedece_vrijeme tsrange DEFAULT tsrange((now())::timestamp without time zone, 'infinity'::timestamp without time zone) NOT NULL
);


ALTER TABLE public.korisnik OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 33162)
-- Name: izlistaj_korisnike; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.izlistaj_korisnike AS
 SELECT korisnik.id_korisnika,
    korisnik.korisnicko_ime,
    korisnik.lozinka,
    korisnik.email,
    korisnik.vrijedece_vrijeme
   FROM public.korisnik;


ALTER TABLE public.izlistaj_korisnike OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 24733)
-- Name: korisnik_id_korisnika_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.korisnik_id_korisnika_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.korisnik_id_korisnika_seq OWNER TO postgres;

--
-- TOC entry 3124 (class 0 OID 0)
-- Dependencies: 200
-- Name: korisnik_id_korisnika_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.korisnik_id_korisnika_seq OWNED BY public.korisnik.id_korisnika;


--
-- TOC entry 213 (class 1259 OID 24856)
-- Name: nastavnik; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nastavnik (
    id_nastavnika bigint NOT NULL,
    ime character varying NOT NULL,
    prezime character varying NOT NULL,
    email character varying NOT NULL
);


ALTER TABLE public.nastavnik OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 24854)
-- Name: nastavnik_id_nastavnika_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nastavnik_id_nastavnika_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.nastavnik_id_nastavnika_seq OWNER TO postgres;

--
-- TOC entry 3125 (class 0 OID 0)
-- Dependencies: 212
-- Name: nastavnik_id_nastavnika_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nastavnik_id_nastavnika_seq OWNED BY public.nastavnik.id_nastavnika;


--
-- TOC entry 214 (class 1259 OID 24865)
-- Name: predaje; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.predaje (
    id_predmeta bigint NOT NULL,
    id_nastavnika bigint NOT NULL
);


ALTER TABLE public.predaje OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 24762)
-- Name: predmet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.predmet (
    id_predmeta bigint NOT NULL,
    naziv character varying NOT NULL,
    ects bigint NOT NULL,
    opis character varying
);


ALTER TABLE public.predmet OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 24760)
-- Name: predmet_id_predmeta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.predmet_id_predmeta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.predmet_id_predmeta_seq OWNER TO postgres;

--
-- TOC entry 3126 (class 0 OID 0)
-- Dependencies: 202
-- Name: predmet_id_predmeta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.predmet_id_predmeta_seq OWNED BY public.predmet.id_predmeta;


--
-- TOC entry 216 (class 1259 OID 24998)
-- Name: raspored; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.raspored (
    id_rasporeda bigint NOT NULL,
    naziv character varying NOT NULL,
    id_korisnika bigint
);


ALTER TABLE public.raspored OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 24996)
-- Name: raspored_id_rasporeda_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.raspored_id_rasporeda_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.raspored_id_rasporeda_seq OWNER TO postgres;

--
-- TOC entry 3127 (class 0 OID 0)
-- Dependencies: 215
-- Name: raspored_id_rasporeda_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.raspored_id_rasporeda_seq OWNED BY public.raspored.id_rasporeda;


--
-- TOC entry 208 (class 1259 OID 24813)
-- Name: se_izvodi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.se_izvodi (
    id_predmeta bigint NOT NULL,
    id_dvorane bigint NOT NULL
);


ALTER TABLE public.se_izvodi OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 25019)
-- Name: se_nalazi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.se_nalazi (
    id_predmeta bigint NOT NULL,
    id_rasporeda bigint NOT NULL,
    vrijedece_vrijeme tsrange DEFAULT tsrange((now())::timestamp without time zone, 'infinity'::timestamp without time zone) NOT NULL
);


ALTER TABLE public.se_nalazi OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 24839)
-- Name: traje; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.traje (
    id_vremena bigint NOT NULL,
    id_predmeta bigint NOT NULL
);


ALTER TABLE public.traje OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 24830)
-- Name: vrijeme; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vrijeme (
    id_vremena bigint NOT NULL,
    dan character varying NOT NULL,
    vrijeme_od time without time zone NOT NULL,
    vrijeme_do time without time zone NOT NULL
);


ALTER TABLE public.vrijeme OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 24828)
-- Name: vrijeme_id_vremena_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vrijeme_id_vremena_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vrijeme_id_vremena_seq OWNER TO postgres;

--
-- TOC entry 3128 (class 0 OID 0)
-- Dependencies: 209
-- Name: vrijeme_id_vremena_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vrijeme_id_vremena_seq OWNED BY public.vrijeme.id_vremena;


--
-- TOC entry 204 (class 1259 OID 24786)
-- Name: zgrada_ID_zgrade_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."zgrada_ID_zgrade_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."zgrada_ID_zgrade_seq" OWNER TO postgres;

--
-- TOC entry 3129 (class 0 OID 0)
-- Dependencies: 204
-- Name: zgrada_ID_zgrade_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."zgrada_ID_zgrade_seq" OWNED BY public.zgrada.id_zgrade;


--
-- TOC entry 2927 (class 2604 OID 24802)
-- Name: dvorana id_dvorane; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dvorana ALTER COLUMN id_dvorane SET DEFAULT nextval('public.dvorana_id_dvorane_seq'::regclass);


--
-- TOC entry 2923 (class 2604 OID 24738)
-- Name: korisnik id_korisnika; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.korisnik ALTER COLUMN id_korisnika SET DEFAULT nextval('public.korisnik_id_korisnika_seq'::regclass);


--
-- TOC entry 2929 (class 2604 OID 24859)
-- Name: nastavnik id_nastavnika; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nastavnik ALTER COLUMN id_nastavnika SET DEFAULT nextval('public.nastavnik_id_nastavnika_seq'::regclass);


--
-- TOC entry 2925 (class 2604 OID 24765)
-- Name: predmet id_predmeta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.predmet ALTER COLUMN id_predmeta SET DEFAULT nextval('public.predmet_id_predmeta_seq'::regclass);


--
-- TOC entry 2930 (class 2604 OID 25001)
-- Name: raspored id_rasporeda; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.raspored ALTER COLUMN id_rasporeda SET DEFAULT nextval('public.raspored_id_rasporeda_seq'::regclass);


--
-- TOC entry 2928 (class 2604 OID 24833)
-- Name: vrijeme id_vremena; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vrijeme ALTER COLUMN id_vremena SET DEFAULT nextval('public.vrijeme_id_vremena_seq'::regclass);


--
-- TOC entry 2926 (class 2604 OID 24791)
-- Name: zgrada id_zgrade; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zgrada ALTER COLUMN id_zgrade SET DEFAULT nextval('public."zgrada_ID_zgrade_seq"'::regclass);


--
-- TOC entry 3106 (class 0 OID 24799)
-- Dependencies: 207
-- Data for Name: dvorana; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dvorana (id_dvorane, naziv, broj_mjesta, id_zgrade) FROM stdin;
5	Dvorana 10	80	3
6	Dvorana 9	81	1
7	Dvorana 6	76	1
1	Dvorana 1	188	1
\.


--
-- TOC entry 3100 (class 0 OID 24735)
-- Dependencies: 201
-- Data for Name: korisnik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.korisnik (id_korisnika, korisnicko_ime, lozinka, email, vrijedece_vrijeme) FROM stdin;
1	bruno	123	bzitkovic@foi.hr	["2021-01-08 22:59:51.433152",infinity)
2	jura	11111	jura@foi.hr	["2021-01-08 22:59:51.433152",infinity)
68	ivek	12345	ivek@foi.hr	["2021-01-09 19:20:04.083125","2021-01-09 19:20:21.13466")
67	marko	12345	marko@foi.hr	["2021-01-08 22:59:51.433152","2021-01-09 19:40:52.816089")
71	Ivek	12345	ivek@foi.hr	["2021-01-23 16:56:07.258265","2021-01-23 17:08:44.689158")
\.


--
-- TOC entry 3112 (class 0 OID 24856)
-- Dependencies: 213
-- Data for Name: nastavnik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nastavnik (id_nastavnika, ime, prezime, email) FROM stdin;
1	Markus	Schatten	mschatten@foi.hr
5	Zlatko	Stapić	zstapic@foi.unizg.hr
6	Miroslav	Bača	miroslav.baca@foi.hr
7	Goran	Bubaš	gbubas@foi.unizg.hr
2	Bogdan	Okreša Đurić	dokresa@foi.unizg.hr
8	Marko p22rof	Markic	mm@foi.hr
\.


--
-- TOC entry 3113 (class 0 OID 24865)
-- Dependencies: 214
-- Data for Name: predaje; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.predaje (id_predmeta, id_nastavnika) FROM stdin;
12	1
13	7
10	1
1	1
14	6
\.


--
-- TOC entry 3102 (class 0 OID 24762)
-- Dependencies: 203
-- Data for Name: predmet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.predmet (id_predmeta, naziv, ects, opis) FROM stdin;
12	Analiza i razvoj programa	6	Cilj kolegija Analiza i razvoj programa je upoznavanje studenata s životnim ciklusom i razvojnim fazama suvremenog programskog proizvoda. Kolegij prolazi sve faze životnog ciklusa koje pri nastanku prolazi novi programski produkt: analizu domene sustava, specifikaciju programskih zahtjeva, metode i tehnike modeliranja programa, razvoj programa, ispitivanje programa itd.\r\n        
13	Računalom posredovana komunikacija	4	Komunikacija putem Interneta sve je prisutnija u suvremenom obrazovnom i poslovnom okruženju. Kolegij omogućava stjecanje znanja, vještina i specifičnih kompetencija iz različitih područja korištenja Interneta u poslovnoj i privatnoj komunikaciji na razini pojedinca, grupa ili timova, kao i u masovnoj komunikaciji putem Interneta
10	Deklarativno programiranje	6	Cilj predmeta Deklarativno programiranje je upoznavanje studenata s idejom deklarativnog programiranja, njegovim teorijskim osnovama, deklarativnim programskim jezicima (npr. Prolog, Lisp, SQL te raznim izvedenim jezicima i proširenjima navedenih) i specifičnim alatima. Deklarativno programiranje zauzima važno mjesto u cjelokupnom korpusu programiranja). \r\n         \r\n         \r\n        
1	Teorija baza podataka	5	Cilj kolegija Teorija baza podataka je upoznati studente s teorijom, koja je temelj za izgradnju sustava za upravljanje: relacijskim bazama podataka, temporalnim bazama podataka, deduktivnim bazama podataka (bazama znanja), poopćenim bazama podataka i objektno-orijentiranim bazama podataka.  \r\n         \r\n        
14	Sigurnost informacijskih sustava	5	Upoznavanje studenata s problematikom sigurnosti informacijskih sustava, posebno u uvjetima ovisnosti poslovnih sustava o komunikaciji i poslovnim sadržajem, potporom informacijske tehnologije. Europska zakonska regulativa te načini udovoljavanja toj regulativi kao uvjet certifikacije. Upoznavanje s metodama izgradnje i razvoja sustava sigurnosti.\r\n         \r\n         \r\n        
\.


--
-- TOC entry 3115 (class 0 OID 24998)
-- Dependencies: 216
-- Data for Name: raspored; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.raspored (id_rasporeda, naziv, id_korisnika) FROM stdin;
1	BPBZ	1
2	markovRaspored	67
6	RasporedIveka	71
\.


--
-- TOC entry 3107 (class 0 OID 24813)
-- Dependencies: 208
-- Data for Name: se_izvodi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.se_izvodi (id_predmeta, id_dvorane) FROM stdin;
12	1
13	7
10	1
1	1
14	1
\.


--
-- TOC entry 3116 (class 0 OID 25019)
-- Dependencies: 217
-- Data for Name: se_nalazi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.se_nalazi (id_predmeta, id_rasporeda, vrijedece_vrijeme) FROM stdin;
10	1	["2021-01-10 20:19:23.146044",infinity)
12	1	["2021-01-11 20:15:04.293074",infinity)
13	1	["2021-01-11 20:15:10.294828",infinity)
14	1	["2021-01-11 20:15:17.03258",infinity)
1	1	["2021-01-11 20:15:40.47115",infinity)
12	6	["2021-01-23 16:56:42.429808",infinity)
1	6	["2021-01-23 16:56:48.103974",infinity)
\.


--
-- TOC entry 3110 (class 0 OID 24839)
-- Dependencies: 211
-- Data for Name: traje; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.traje (id_vremena, id_predmeta) FROM stdin;
1	1
10	10
12	12
13	13
14	14
\.


--
-- TOC entry 3109 (class 0 OID 24830)
-- Dependencies: 210
-- Data for Name: vrijeme; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vrijeme (id_vremena, dan, vrijeme_od, vrijeme_do) FROM stdin;
2	Ponedjeljak	23:00:00	13:00:00
3	Ponedjeljak	23:00:00	13:00:00
4	Ponedjeljak	23:00:00	13:00:00
5	Ponedjeljak	10:00:00	13:00:00
6	Ponedjeljak	11:02:00	00:22:00
7	Ponedjeljak	11:00:00	00:00:00
8	Srijeda	08:00:00	10:00:00
9	Ponedjeljak	01:12:00	02:02:00
11	Ponedjeljak	11:11:00	12:21:00
12	Ponedjeljak	08:00:00	11:00:00
13	Srijeda	14:00:00	15:00:00
10	Ponedjeljak	08:00:00	10:00:00
15	Srijeda	10:00:00	12:00:00
16	Srijeda	10:00:00	12:00:00
17	Ponedjeljak	23:00:00	12:00:00
1	Ponedjeljak	10:00:00	12:00:00
18	Četvrtak	08:00:00	10:00:00
14	Ponedjeljak	11:00:00	13:00:00
\.


--
-- TOC entry 3104 (class 0 OID 24788)
-- Dependencies: 205
-- Data for Name: zgrada; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.zgrada (id_zgrade, naziv, adresa) FROM stdin;
1	FOI 1	Pavlinska ul. 2, 42000, Varaždin
3	FOI 2	Prilaz Fausta Vrančića 3, 42000, Varaždin
\.


--
-- TOC entry 3130 (class 0 OID 0)
-- Dependencies: 206
-- Name: dvorana_id_dvorane_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dvorana_id_dvorane_seq', 8, true);


--
-- TOC entry 3131 (class 0 OID 0)
-- Dependencies: 200
-- Name: korisnik_id_korisnika_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.korisnik_id_korisnika_seq', 71, true);


--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 212
-- Name: nastavnik_id_nastavnika_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nastavnik_id_nastavnika_seq', 8, true);


--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 202
-- Name: predmet_id_predmeta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.predmet_id_predmeta_seq', 18, true);


--
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 215
-- Name: raspored_id_rasporeda_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.raspored_id_rasporeda_seq', 8, true);


--
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 209
-- Name: vrijeme_id_vremena_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vrijeme_id_vremena_seq', 18, true);


--
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 204
-- Name: zgrada_ID_zgrade_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."zgrada_ID_zgrade_seq"', 4, true);


--
-- TOC entry 2939 (class 2606 OID 24807)
-- Name: dvorana dvorana_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dvorana
    ADD CONSTRAINT dvorana_pkey PRIMARY KEY (id_dvorane);


--
-- TOC entry 2933 (class 2606 OID 25008)
-- Name: korisnik korisnik_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.korisnik
    ADD CONSTRAINT korisnik_pkey PRIMARY KEY (id_korisnika);


--
-- TOC entry 2947 (class 2606 OID 24864)
-- Name: nastavnik nastavnik_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nastavnik
    ADD CONSTRAINT nastavnik_pkey PRIMARY KEY (id_nastavnika);


--
-- TOC entry 2949 (class 2606 OID 24869)
-- Name: predaje predaje_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.predaje
    ADD CONSTRAINT predaje_pkey PRIMARY KEY (id_predmeta, id_nastavnika);


--
-- TOC entry 2935 (class 2606 OID 24770)
-- Name: predmet predmet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.predmet
    ADD CONSTRAINT predmet_pkey PRIMARY KEY (id_predmeta);


--
-- TOC entry 2951 (class 2606 OID 25006)
-- Name: raspored raspored_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.raspored
    ADD CONSTRAINT raspored_pkey PRIMARY KEY (id_rasporeda);


--
-- TOC entry 2941 (class 2606 OID 24817)
-- Name: se_izvodi se_izvodi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.se_izvodi
    ADD CONSTRAINT se_izvodi_pkey PRIMARY KEY (id_predmeta, id_dvorane);


--
-- TOC entry 2953 (class 2606 OID 25042)
-- Name: se_nalazi se_nalazi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.se_nalazi
    ADD CONSTRAINT se_nalazi_pkey PRIMARY KEY (id_predmeta, id_rasporeda, vrijedece_vrijeme);


--
-- TOC entry 2945 (class 2606 OID 24843)
-- Name: traje traje_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.traje
    ADD CONSTRAINT traje_pkey PRIMARY KEY (id_vremena, id_predmeta);


--
-- TOC entry 2943 (class 2606 OID 24838)
-- Name: vrijeme vrijeme_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vrijeme
    ADD CONSTRAINT vrijeme_pkey PRIMARY KEY (id_vremena);


--
-- TOC entry 2937 (class 2606 OID 24796)
-- Name: zgrada zgrada_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zgrada
    ADD CONSTRAINT zgrada_pkey PRIMARY KEY (id_zgrade);


--
-- TOC entry 2965 (class 2620 OID 24973)
-- Name: korisnik korisnik_arhiva; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER korisnik_arhiva BEFORE DELETE ON public.korisnik FOR EACH ROW EXECUTE FUNCTION public.arhiva_korisnika();


--
-- TOC entry 2966 (class 2620 OID 25044)
-- Name: se_nalazi raspored_arhiva; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER raspored_arhiva AFTER DELETE ON public.se_nalazi FOR EACH ROW EXECUTE FUNCTION public.arhiva_rasporeda();


--
-- TOC entry 2964 (class 2620 OID 24968)
-- Name: korisnik registracija; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER registracija AFTER INSERT OR UPDATE ON public.korisnik FOR EACH ROW EXECUTE FUNCTION public.validacija_registracije();


--
-- TOC entry 2954 (class 2606 OID 24808)
-- Name: dvorana dvorana_id_zgrade_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dvorana
    ADD CONSTRAINT dvorana_id_zgrade_fkey FOREIGN KEY (id_zgrade) REFERENCES public.zgrada(id_zgrade) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2960 (class 2606 OID 24875)
-- Name: predaje predaje_id_nastavnika_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.predaje
    ADD CONSTRAINT predaje_id_nastavnika_fkey FOREIGN KEY (id_nastavnika) REFERENCES public.nastavnik(id_nastavnika) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2959 (class 2606 OID 24870)
-- Name: predaje predaje_id_predmeta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.predaje
    ADD CONSTRAINT predaje_id_predmeta_fkey FOREIGN KEY (id_predmeta) REFERENCES public.predmet(id_predmeta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2961 (class 2606 OID 25009)
-- Name: raspored raspored_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.raspored
    ADD CONSTRAINT raspored_fk FOREIGN KEY (id_korisnika) REFERENCES public.korisnik(id_korisnika) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2956 (class 2606 OID 24823)
-- Name: se_izvodi se_izvodi_id_dvorane_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.se_izvodi
    ADD CONSTRAINT se_izvodi_id_dvorane_fkey FOREIGN KEY (id_dvorane) REFERENCES public.dvorana(id_dvorane) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2955 (class 2606 OID 24818)
-- Name: se_izvodi se_izvodi_id_predmeta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.se_izvodi
    ADD CONSTRAINT se_izvodi_id_predmeta_fkey FOREIGN KEY (id_predmeta) REFERENCES public.predmet(id_predmeta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2962 (class 2606 OID 25024)
-- Name: se_nalazi se_nalazi_id_predmeta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.se_nalazi
    ADD CONSTRAINT se_nalazi_id_predmeta_fkey FOREIGN KEY (id_predmeta) REFERENCES public.predmet(id_predmeta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2963 (class 2606 OID 25029)
-- Name: se_nalazi se_nalazi_id_rasporeda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.se_nalazi
    ADD CONSTRAINT se_nalazi_id_rasporeda_fkey FOREIGN KEY (id_rasporeda) REFERENCES public.raspored(id_rasporeda) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2958 (class 2606 OID 24849)
-- Name: traje traje_id_predmeta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.traje
    ADD CONSTRAINT traje_id_predmeta_fkey FOREIGN KEY (id_predmeta) REFERENCES public.predmet(id_predmeta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2957 (class 2606 OID 24844)
-- Name: traje traje_id_vremena_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.traje
    ADD CONSTRAINT traje_id_vremena_fkey FOREIGN KEY (id_vremena) REFERENCES public.vrijeme(id_vremena) ON UPDATE CASCADE ON DELETE CASCADE;


-- Completed on 2021-01-23 17:17:03

--
-- PostgreSQL database dump complete
--

