FROM mysql:8.0

WORKDIR /import
COPY db.sql /import/db.sql
COPY import.sh /import/import.sh
RUN chmod 0555 /import/import.sh

ENTRYPOINT ["/bin/sh", "/import/import.sh"]