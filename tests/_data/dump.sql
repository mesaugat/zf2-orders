--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: customers; Type: TABLE; Schema: public; Owner: saugat; Tablespace: 
--

CREATE TABLE customers (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    address character varying(255) NOT NULL,
    created timestamp(0) without time zone NOT NULL
);


ALTER TABLE customers OWNER TO saugat;

--
-- Name: customers_id_seq; Type: SEQUENCE; Schema: public; Owner: saugat
--

CREATE SEQUENCE customers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE customers_id_seq OWNER TO saugat;

--
-- Name: items; Type: TABLE; Schema: public; Owner: saugat; Tablespace: 
--

CREATE TABLE items (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    rate numeric(15,2) NOT NULL,
    created timestamp(0) without time zone NOT NULL
);


ALTER TABLE items OWNER TO saugat;

--
-- Name: items_id_seq; Type: SEQUENCE; Schema: public; Owner: saugat
--

CREATE SEQUENCE items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE items_id_seq OWNER TO saugat;

--
-- Name: order_items; Type: TABLE; Schema: public; Owner: saugat; Tablespace: 
--

CREATE TABLE order_items (
    id integer NOT NULL,
    order_id integer,
    item_id integer,
    quantity integer NOT NULL,
    rate numeric(10,0) NOT NULL,
    line_total numeric(10,0) NOT NULL
);


ALTER TABLE order_items OWNER TO saugat;

--
-- Name: order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: saugat
--

CREATE SEQUENCE order_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE order_items_id_seq OWNER TO saugat;

--
-- Name: orders; Type: TABLE; Schema: public; Owner: saugat; Tablespace: 
--

CREATE TABLE orders (
    id integer NOT NULL,
    customer_id integer,
    order_no integer NOT NULL,
    grand_total numeric(10,0) NOT NULL,
    created timestamp(0) without time zone NOT NULL
);


ALTER TABLE orders OWNER TO saugat;

--
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: saugat
--

CREATE SEQUENCE orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE orders_id_seq OWNER TO saugat;

--
-- Name: user; Type: TABLE; Schema: public; Owner: saugat; Tablespace: 
--

CREATE TABLE "user" (
    user_id integer NOT NULL,
    username character varying(255) DEFAULT NULL::character varying,
    email character varying(255) DEFAULT NULL::character varying,
    display_name character varying(50) DEFAULT NULL::character varying,
    password character varying(128) NOT NULL,
    state smallint
);


ALTER TABLE "user" OWNER TO saugat;

--
-- Name: user_user_id_seq; Type: SEQUENCE; Schema: public; Owner: saugat
--

CREATE SEQUENCE user_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_user_id_seq OWNER TO saugat;

--
-- Name: users; Type: TABLE; Schema: public; Owner: saugat; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    display_name character varying(255) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    state integer NOT NULL,
    created timestamp(0) without time zone NOT NULL
);


ALTER TABLE users OWNER TO saugat;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: saugat
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_id_seq OWNER TO saugat;

--
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: saugat
--

COPY customers (id, name, address, created) FROM stdin;
\.


--
-- Name: customers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saugat
--

SELECT pg_catalog.setval('customers_id_seq', 1, false);


--
-- Data for Name: items; Type: TABLE DATA; Schema: public; Owner: saugat
--

COPY items (id, name, rate, created) FROM stdin;
1	Soap	12.00	2015-05-19 11:28:27
3	Android	23.98	2015-05-19 11:31:43
2	Item	35.00	2015-05-19 11:28:49
\.


--
-- Name: items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saugat
--

SELECT pg_catalog.setval('items_id_seq', 3, true);


--
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: saugat
--

COPY order_items (id, order_id, item_id, quantity, rate, line_total) FROM stdin;
\.


--
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saugat
--

SELECT pg_catalog.setval('order_items_id_seq', 1, false);


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: saugat
--

COPY orders (id, customer_id, order_no, grand_total, created) FROM stdin;
\.


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saugat
--

SELECT pg_catalog.setval('orders_id_seq', 1, false);


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: saugat
--

COPY "user" (user_id, username, email, display_name, password, state) FROM stdin;
\.


--
-- Name: user_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saugat
--

SELECT pg_catalog.setval('user_user_id_seq', 1, false);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: saugat
--

COPY users (id, display_name, username, password, email, state, created) FROM stdin;
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: saugat
--

SELECT pg_catalog.setval('users_id_seq', 1, false);


--
-- Name: customers_pkey; Type: CONSTRAINT; Schema: public; Owner: saugat; Tablespace: 
--

ALTER TABLE ONLY customers
    ADD CONSTRAINT customers_pkey PRIMARY KEY (id);


--
-- Name: items_pkey; Type: CONSTRAINT; Schema: public; Owner: saugat; Tablespace: 
--

ALTER TABLE ONLY items
    ADD CONSTRAINT items_pkey PRIMARY KEY (id);


--
-- Name: order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: saugat; Tablespace: 
--

ALTER TABLE ONLY order_items
    ADD CONSTRAINT order_items_pkey PRIMARY KEY (id);


--
-- Name: orders_pkey; Type: CONSTRAINT; Schema: public; Owner: saugat; Tablespace: 
--

ALTER TABLE ONLY orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: saugat; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: saugat; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: idx_62809db0126f525e; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE INDEX idx_62809db0126f525e ON order_items USING btree (item_id);


--
-- Name: idx_62809db08d9f6d38; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE INDEX idx_62809db08d9f6d38 ON order_items USING btree (order_id);


--
-- Name: idx_e52ffdee9395c3f3; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE INDEX idx_e52ffdee9395c3f3 ON orders USING btree (customer_id);


--
-- Name: uniq_1483a5e9e7927c74; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON users USING btree (email);


--
-- Name: uniq_1483a5e9f85e0677; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE UNIQUE INDEX uniq_1483a5e9f85e0677 ON users USING btree (username);


--
-- Name: uniq_8d93d649e7927c74; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON "user" USING btree (email);


--
-- Name: uniq_8d93d649f85e0677; Type: INDEX; Schema: public; Owner: saugat; Tablespace: 
--

CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON "user" USING btree (username);


--
-- Name: fk_62809db0126f525e; Type: FK CONSTRAINT; Schema: public; Owner: saugat
--

ALTER TABLE ONLY order_items
    ADD CONSTRAINT fk_62809db0126f525e FOREIGN KEY (item_id) REFERENCES items(id);


--
-- Name: fk_62809db08d9f6d38; Type: FK CONSTRAINT; Schema: public; Owner: saugat
--

ALTER TABLE ONLY order_items
    ADD CONSTRAINT fk_62809db08d9f6d38 FOREIGN KEY (order_id) REFERENCES orders(id);


--
-- Name: fk_e52ffdee9395c3f3; Type: FK CONSTRAINT; Schema: public; Owner: saugat
--

ALTER TABLE ONLY orders
    ADD CONSTRAINT fk_e52ffdee9395c3f3 FOREIGN KEY (customer_id) REFERENCES customers(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: saugat
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM saugat;
GRANT ALL ON SCHEMA public TO saugat;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

