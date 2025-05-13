To install the project on your development machine, follow these steps:

## 📌 Project Setup and Dependencies

### 1 - Clone the project repository

Run the following command in your terminal to clone the project:

```bash
# Clone the repository via SSH
git clone https://github.com/UFSM-FW-Projetos-DCEx-2025/bicho-do-mato.git
```

### 2 - Set up the environment

Navigate to the project directory by running the following command:

```bash
cd bicho-do-mato/
```

Duplicate the `.env.example` file and rename the copy to `.env`:

```bash
cp .env.example .env
```

### 3 - Install the composer:
```ssh
composer install
```

### 4 - Start the Docker development container

Start the container by running the following command:

```bash
./vendor/bin/sail up -d
```

### 5 - Run migrations, generate the application key and build the frontend

Inside the project folder, run the following steps:

#### 5.1 - Run migrations and seed the database

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

#### 5.2 - Generate the application key

```bash
./vendor/bin/sail artisan key:generate
```

#### 5.3 - Run frontend

```bash
./vendor/bin/sail npm install && npm run build && npm run dev
```

## ⚡ Ready!

Your application should now be running under the following domain:
<a href="http://localhost" target="_blank">http://localhost</a>