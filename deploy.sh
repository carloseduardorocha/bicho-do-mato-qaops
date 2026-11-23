#!/bin/bash

# Script de Manutenção e Deploy - Projeto Bicho do Mato

PROJECT_PATH="/var/www/bicho-do-mato"
PHP_SERVICE="php8.4-fpm"

echo "🚀 Iniciando manutenção/deploy em $(date +'%d/%m/%Y %H:%M:%S')"
cd $PROJECT_PATH || { echo "❌ Erro: Pasta do projeto não encontrada"; exit 1; }

# 1. Atualização do Código
echo "📥 Atualizando código via Git..."
git fetch && git pull origin main

# 2. Dependências PHP (sem build de front: Blade + Bootstrap por CDN)
echo "📦 Instalando dependências PHP (Composer)..."
composer install --no-dev --optimize-autoloader

# 3. Banco de Dados
echo "🗄️ Executando migrations..."
php artisan migrate --force

# 4. Otimização de Cache
echo "⚡ Otimizando caches do Laravel..."
php artisan optimize
php artisan view:clear

# 5. Permissões
echo "🔐 Ajustando permissões de pasta..."
sudo chown -R www-data:www-data $PROJECT_PATH
sudo chmod -R 775 storage bootstrap/cache

# 6. Reiniciar Serviços
echo "🔄 Reiniciando serviços web..."
sudo systemctl restart $PHP_SERVICE
sudo systemctl reload nginx

echo "✅ Deploy finalizado com sucesso!"