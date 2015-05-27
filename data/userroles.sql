--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

TRUNCATE users CASCADE ;
TRUNCATE roles CASCADE ;
TRUNCATE user_role_linker CASCADE ;
--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: kabir
--

COPY roles (id, parent_id, role_id, created, name) FROM stdin;
32	\N	guest	2015-05-26 10:13:01	Guest
35	\N	user	2015-05-26 16:45:03	User
29	35	admin	2015-05-25 13:59:56	Administrator
36	35	operator	2015-05-26 16:45:03	Operator
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: kabir
--

COPY users (id, display_name, username, password, email, created, state) FROM stdin;
9	Admin	admin	$2y$14$7ucMc1rQ/5O66saF4eJ1T.rK//OoK4D5CQHUGAWqrzC4zXRgNcRei	admin@zf2orders.com	2015-05-27 11:13:04	1
\.


--
-- Data for Name: user_role_linker; Type: TABLE DATA; Schema: public; Owner: kabir
--

COPY user_role_linker (user_id, role_id) FROM stdin;
9	29
\.


--
-- PostgreSQL database dump complete
--

