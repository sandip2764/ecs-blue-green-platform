#!/bin/sh
set -eu

: "${DB_HOST:?DB_HOST is required}"
: "${DB_NAME:?DB_NAME is required}"
: "${DB_USERNAME:?DB_USERNAME is required}"
: "${DB_PASSWORD:?DB_PASSWORD is required}"

DB_PORT="${DB_PORT:-3306}"
IMPORT_ID="initial-db-sql-v1"
export MYSQL_PWD="$DB_PASSWORD"

# server-level connection (database select kiye bina)
mysql_server() {
  mysql --protocol=TCP --connect-timeout=5 \
    --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USERNAME" "$@"
}

# karfect database ke andar
mysql_db() {
  mysql_server --database="$DB_NAME" "$@"
}

echo "Waiting for RDS to become reachable..."
ready=0
attempt=1
while [ "$attempt" -le 30 ]; do
  if mysql_server --execute="SELECT 1" >/dev/null 2>&1; then
    ready=1
    break
  fi
  echo "Not ready yet (attempt $attempt/30)"
  sleep 10
  attempt=$((attempt + 1))
done

if [ "$ready" -ne 1 ]; then
  echo "ERROR: Could not connect to RDS."
  exit 1
fi
echo "RDS connection successful."

# Safety: agar db_name se database bana hi nahi, to bana do
mysql_server --execute="CREATE DATABASE IF NOT EXISTS \`$DB_NAME\`"

# Marker check
MARKER_EXISTS=$(mysql_db --batch --skip-column-names --execute="
  SELECT COUNT(*) FROM information_schema.tables
  WHERE table_schema = DATABASE() AND table_name = 'database_import_history'")

if [ "$MARKER_EXISTS" -eq 1 ]; then
  DONE=$(mysql_db --batch --skip-column-names --execute="
    SELECT COUNT(*) FROM database_import_history WHERE import_id = '$IMPORT_ID'")
  if [ "$DONE" -gt 0 ]; then
    echo "Already imported. Skipping."
    exit 0
  fi
fi

# Non-empty DB me blindly import nahi karna
TABLE_COUNT=$(mysql_db --batch --skip-column-names --execute="
  SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE()")

if [ "$TABLE_COUNT" -gt 0 ]; then
  echo "ERROR: Database has tables but no success marker. Inspect manually."
  exit 1
fi

echo "Database is empty. Importing db.sql..."

if ! mysql_db < /import/db.sql; then
  echo "Import FAILED. Resetting database so next run can retry..."
  mysql_server --execute="DROP DATABASE \`$DB_NAME\`; CREATE DATABASE \`$DB_NAME\`;"
  exit 1
fi

echo "Import done. Writing success marker..."
mysql_db --execute="
  CREATE TABLE IF NOT EXISTS database_import_history (
    import_id VARCHAR(100) NOT NULL PRIMARY KEY,
    imported_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
  );
  INSERT INTO database_import_history (import_id) VALUES ('$IMPORT_ID');
"

echo "SUCCESS: Initial database import completed."