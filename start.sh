#!/bin/bash

# This script automates the setup and startup process for the DaurixSkills platform.
# It ensures all necessary steps are taken to get the application running.

# Exit immediately if a command exits with a non-zero status.
set -e

# --- Functions ---
function check_deps() {
    if ! command -v docker &> /dev/null; then
        echo -e "\033[0;31mError: docker could not be found. Please install Docker to continue.\033[0m"
        exit 1
    fi
    if ! command -v docker-compose &> /dev/null; then
        echo -e "\033[0;31mError: docker-compose could not be found. Please install Docker Compose to continue.\033[0m"
        exit 1
    fi
}

# --- Main Script ---
echo -e "\033[0;32m--- Starting DaurixSkills Platform Setup ---\033[0m"

# 1. Check for dependencies
echo "1. Checking for Docker and Docker Compose..."
check_deps
echo "   Dependencies found."

# 2. Create .env file if it doesn't exist
echo "2. Checking for .env file..."
if [ ! -f .env ]; then
    echo "   .env file not found. Creating from .env.example..."
    cp .env.example .env
    echo -e "   \033[0;33mAction Required: You may want to add your OpenAI API key to the new .env file.\033[0m"
else
    echo "   .env file already exists. Skipping creation."
fi

# 3. Build and start Docker containers
echo "3. Building and starting Docker containers... (this may take a few moments)"
docker-compose up --build -d

# 4. Install Composer dependencies inside the container
echo "4. Installing PHP dependencies with Composer..."
docker-compose exec app composer install --no-interaction --no-progress

echo ""
echo -e "\033[1;32m✅ Setup Complete! The DaurixSkills platform is running.\033[0m"
echo ""
echo -e "Access the web application here: \033[1;34mhttp://localhost:8080\033[0m"
echo ""
echo "You can log in with the default admin user:"
echo -e "  - \033[1mEmail:\033[0m    admin@daurix.local"
echo -e "  - \033[1mPassword:\033[0m Password123!"
echo ""
echo "To run the test suite, use: \033[0;33mdocker-compose exec app ./vendor/bin/phpunit\033[0m"
echo "To stop all services, use: \033[0;33mdocker-compose down\033[0m"
echo ""
