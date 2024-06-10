# EPI

# Dependencies
- Symfony
- Composer
- MySQL
- Nginx
- Docker
- Docker Compose

# Installation
1. Clone the repository
2. Run `docker-compose up --build -d`
3. Run `docker-compose exec app bin/console --no-interaction doctrine:migrations:migrate`

# Sample Data
If you want to load sample data: `docker-compose exec app bin/console doctrine:fixtures:load`