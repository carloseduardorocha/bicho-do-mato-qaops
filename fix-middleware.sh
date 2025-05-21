#!/bin/bash

echo "🧹 Limpando caches..."
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan optimize:clear

echo "📦 Apagando cache manual..."
rm -rf bootstrap/cache/*

echo "🛠 Recriando autoload..."
./vendor/bin/sail composer dump-autoload

echo "🔁 Reiniciando containers..."
./vendor/bin/sail down
./vendor/bin/sail up -d

echo "✅ Tudo pronto. Acesse http://localhost e teste novamente."