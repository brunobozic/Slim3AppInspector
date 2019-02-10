# Quick run via php from the public folder
 - php -S 0.0.0.0:8181 -t public public/index.php
 
# How to reverse engineer entities from an existing database (Doctrine 2)
 - Run in /home/brunobozic/pac-wisp-lab-healthcheck
 - /home/brunobozic/Projects/ApplicationInspector/vendor/bin/doctrine orm:convert-mapping --from-database annotation /home/brunobozic/Projects/ApplicationInspector/doctrine_reverse_entities -f
 - /home/brunobozic/Projects/ApplicationInspector/vendor/bin/doctrine orm:convert-mapping --from-database annotation /home/brunobozic/Projects/ApplicationInspector/src -f --namespace 'App\Entities\'

# How to create a schema (database)
 - /home/brunobozic/Projects/ApplicationInspector/vendor/bin/doctrine orm:schema-tool:create
 - /home/brunobozic/ToTransplantSave/ApplicationInspector/vendor/bin/doctrine orm:schema-tool:create
 - /home/brunobozic/ToTransplantSave/ApplicationInspector/vendor/bin/doctrine orm:schema-tool:update -f
 
 

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_health_check_url phcu on pf.id = phcu.portal_feature_id;

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_health_check_url phcu on pf.id = phcu.portal_feature_id
Inner JOIN portal_health_check_pulse phcp on phcp.portal_health_check_url_id = phcu.id;

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_version_check_path pvcp on pf.id = pvcp.portal_feature_id;

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_version_check_path pvcp on pf.id = pvcp.portal_feature_id
Inner JOIN portal_version_check_pulse phcp on pvcp.portal_feature_id = phcp.portal_version_check_path_id;


#
- composer phplint  '**/*.php' '!**/vendor/**' .


#
- composer dump-autoload -o




# Quick run via php from the public folder
 - php -S 0.0.0.0:8181 -t public public/index.php

# PHPUnit tests
 - run "./vendor/bin/phpunit UnitTest.php"
 - ./vendor/bin/phpunit ./src/Tests/Unit/SampleTest.php

# List of routes
 URL                               HTTP Verb    Operation



# Request a token
- curl "http://127.0.0.1:8080/api/v1/token" --request POST --include --insecure --header "Content-Type: application/json" --data '["portal.getAll"]' --user test:test


# List users
- curl "http://127.0.0.1:8080/api/v1/user" --request POST --include --insecure --header "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MjgzNjA2OTQsImV4cCI6MTUyODM2Nzg5NCwianRpIjoibElsQlJjV1BTV3dkTFc1UE5oVmltIiwic2NvcGUiOlsicG9ydGFsLmNyZWF0ZSIsInBvcnRhbC5yZWFkIiwicG9ydGFsLnVwZGF0ZSIsInBvcnRhbC5kZWxldGUiLCJwb3J0YWwubGlzdCIsInBvcnRhbC5hbGwiXX0.7F-7lISZOadgGQrweZhwl-vwDFliOLj6SnMOKzsVgjM" --data '["portal.getAll"]' --user test:test


# restart postgres
pg ctl -D "C:\PostgreSQL\data" restart

# list datatables on postgres
postgres-# \dt+ *.*

# set default schema to a user (I think)
alter user postgres set search_path = app_inspector

# grant all privileges on a target db to a user (schema)
GRANT ALL PRIVILEGES ON DATABASE app_inspector TO postgres;

# postgres config file
- You probably want to tweak postgresql config too: see /etc/postgresql/{8.4|9.1}/main/postgresql.conf 
- password_encryption="on"
- If you want postgresql to listen to not only localhost: 
- listen_adress="*"

# config file that governs who can access the server (linux)
sudo gedit /etc/postgresql/8.2/main/pg_hba.conf

### Database administrative login by UNIX sockets
local all postgres ident sameuser
### TYPE DATABASE USER CIDR-ADDRESS METHOD
### "local" is for Unix domain socket connections only
local all all md5
### IPv4 local connections:
host all all 127.0.0.1/32 md5
### IPv6 local connections:
host all all ::1/128 md5
### Connections for all PCs on the subnet
###
### TYPE DATABASE USER IP-ADDRESS IP-MASK METHOD
host all all [ip address] [subnet mask] md5

# alter default password
ALTER USER postgres WITH ENCRYPTED PASSWORD 'myhardtoguesspassword'

# create a user
CREATE USER openempi WITH ENCRYPTED PASSWORD 'openempi';

--DROP SCHEMA app_inspector CASCADE;
--DROP DATABASE app_inspector;
--CREATE SCHEMA app_inspector;
--CREATE DATABASE app_inspector;

# list all tables from postgres meta data
SELECT table_name
FROM information_schema.tables;

SELECT datname FROM pg_database WHERE datistemplate = false;

SELECT name, setting FROM pg_settings WHERE category = 'File Locations';
SELECT name, sourcefile, sourceline, setting, applied FROM pg_file_settings WHERE name IN ('listen_addresses','deadlock_timeout','shared_buffers',    'effective_cache_size','work_mem','maintenance_work_mem') ORDER BY name;
 "vendor\bin\doctrine" orm:schema-tool:create

ALTER SYSTEM SET work_mem = '500MB'; 
SELECT pg_reload_conf(); 














 Retrieve a listing of recent connections and process IDs (PIDs): SELECT * FROM pg_stat_activity; pg_stat_activity is a view that lists the last query running on each connection, the connected user (usename), the database (datname) in use, and the start times of the queries. Review the list to identify the PIDs of connections you wish to terminate. 
 Cancel active queries on a connection with PID 1234: SELECT pg_cancel_backend(1234); This does not terminate the connection itself, though
 Terminate the connection: SELECT pg_terminate_backend(1234); 
 
 
 CREATE ROLE leo LOGIN PASSWORD 'king' VALID UNTIL 'infinity' CREATEDB; 
 CREATE ROLE regina LOGIN PASSWORD 'queen' VALID UNTIL '2020-1-1 00:00' SUPERUSER
 REVOKE EXECUTE ON ALL FUNCTIONS IN SCHEMA my_schema FROM PUBLIC; 
 
 
 
 
 GRANT USAGE ON SCHEMA my_schema TO PUBLIC; 
 ALTER DEFAULT PRIVILEGES IN SCHEMA my_schema GRANT SELECT, REFERENCES ON TABLES TO PUBLIC; 
 ALTER DEFAULT PRIVILEGES IN SCHEMA my_schema GRANT ALL ON TABLES TO mydb_admin WITH GRANT OPTION;  
 ALTER DEFAULT PRIVILEGES IN SCHEMA my_schema  GRANT SELECT, UPDATE ON SEQUENCES TO public;
 ALTER DEFAULT PRIVILEGES IN SCHEMA my_schema GRANT ALL ON FUNCTIONS TO mydb_admin WITH GRANT OPTION;
 ALTER DEFAULT PRIVILEGES IN SCHEMA my_schema GRANT USAGE ON TYPES TO PUBLIC;
 Allows all users that can connect to the database to also be able to use and create objects in a schema if they have rights to those objects in the schema. GRANT USAGE on a schema is the first step to granting access to objects in the schema. If a user has rights to select from a table in a schema but no USAGE on the schema, then he will not be able to query the table. Grant read and reference rights (the ability to create foreign key constraints against columns in a table) for all future tables created in a schema to all users that have USAGE of the schema. GRANT ALL permissions on future tables to role mydb_admin. In addition, allow members in mydb_admin to be able to grant a subset or all privileges to other users to future tables in this schema. GRANT ALL gives permission to add/ update/delete/truncate rows, add triggers, and create constraints on the tables. GRANT permissions on future sequences, functions, and types. 
 
 
 
 SELECT name, default_version, installed_version, left(comment,30) As comment FROM pg_available_extensions WHERE installed_version IS NOT NULL ORDER BY name;
  
  
  
  
  
  
  
  
  
  
SELECT '2012-02-28 10:00 PM America/Los_Angeles'::timestamptz AT TIME ZONE 'Europe/Paris';

SELECT '2012-02-10 11:00 PM'::timestamp + interval '1 hour';

SELECT dt, date_part('hour',dt) As hr, to_char(dt,'HH12:MI AM') As mn FROM
generate_series( '2012-03-11 12:30 AM', '2012-03-11 3:00 AM', interval '15 minutes' ) As dt;



Unnesting unbalanced arrays with multiargument unnest
SELECT * FROM unnest('{blind,mouse}'::text[], '{1,2,3}'::int[]) AS f(t,i);
t      | i 
-------+--
blind  | 1 mouse  | 2 <NULL> | 3