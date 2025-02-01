   DO
   $do$
   BEGIN
      IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = 'admin') THEN
         CREATE USER admin WITH PASSWORD 'admin';
      END IF;
   END
   $do$;

   DO
   $do$
   BEGIN
      IF NOT EXISTS (SELECT FROM pg_database WHERE datname = 'app_db_name') THEN
         CREATE DATABASE app_db_name OWNER admin;
      END IF;
   END
   $do$;

   DO
   $do$
   BEGIN
      IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = 'test') THEN
         CREATE USER test WITH PASSWORD 'test';
      END IF;
   END
   $do$;

   DO
   $do$
   BEGIN
      IF NOT EXISTS (SELECT FROM pg_database WHERE datname = 'test') THEN
         CREATE DATABASE test OWNER test;
      END IF;
   END
   $do$;

  