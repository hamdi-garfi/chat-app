#!/bin/bash
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" -d "$POSTGRES_DB"  <<-EOSQL
     #!/bin/sh
psql -U postgres -c "CREATE USER $DB_USER PASSWORD '$DB_PASS'"
psql -U postgres -c "CREATE DATABASE $DB_NAME OWNER '$DB_USER'"

EOSQL
