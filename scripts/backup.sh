#!/bin/bash

# A simple script to back up the MySQL database using credentials from the .env file.
# Ensure this script is run from the project's root directory.

# --- Configuration ---
ENV_FILE=".env"
BACKUP_DIR="./storage/backups"
DATE_FORMAT=$(date +"%Y-%m-%d_%H-%M-%S")

# --- Functions ---
function load_env() {
    if [ -f $ENV_FILE ]; then
        export $(grep -v '^#' $ENV_FILE | xargs)
    else
        echo "Error: .env file not found. Please create one from .env.example."
        exit 1
    fi
}

function check_deps() {
    if ! command -v mysqldump &> /dev/null; then
        echo "Error: mysqldump could not be found. Please install a MySQL client."
        exit 1
    fi
    if ! command -v gzip &> /dev/null; then
        echo "Error: gzip could not be found."
        exit 1
    fi
}

# --- Main Script ---
echo "Starting database backup..."

# 1. Check dependencies
check_deps

# 2. Load environment variables
load_env

# 3. Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# 4. Define backup file path
BACKUP_FILE="$BACKUP_DIR/${DB_DATABASE}_${DATE_FORMAT}.sql.gz"

# 5. Run mysqldump and compress the output
# Note: This uses the `mysql` client on the host machine.
# If running Docker, you might execute this command inside the container.
echo "Dumping database: $DB_DATABASE to $BACKUP_FILE"

mysqldump -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE | gzip > $BACKUP_FILE

# 6. Check if the backup was successful
if [ ${PIPESTATUS[0]} -eq 0 ]; then
    echo "Backup successful!"
    echo "File created: $BACKUP_FILE"
else
    echo "Error: Database backup failed."
    # Clean up failed backup file
    rm $BACKUP_FILE
    exit 1
fi

exit 0
