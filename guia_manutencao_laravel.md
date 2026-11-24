# Guia de Manutenção Laravel – Produção

## 1. Atualização do Código
Atualizar o projeto com a versão mais recente do repositório Git.

```bash
cd /var/www/bicho-do-mato

# Verificar branch atual
git status

# Atualizar código do repositório
git pull origin main
```

## 2. Atualizar Dependências

### PHP
```bash
composer install --no-dev --optimize-autoloader
```

Não há build de front: as telas são Blade com Bootstrap por CDN.

## 3. Banco de Dados

### Migrar Migrations
```bash
php artisan migrate --force
```

### Rodar Seeds (opcional)
```bash
php artisan db:seed --class=NomeDaSeeder
```

## 4. Limpeza e Otimização de Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
```

## 5. Serviços Web

### PHP-FPM
```bash
sudo systemctl restart php8.4-fpm
```

### Nginx
```bash
sudo systemctl reload nginx
```

## 6. Logs

### Laravel
```bash
tail -f storage/logs/laravel.log
tail -n 100 storage/logs/laravel.log | grep "Exception"
```

### Nginx
```bash
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log
```

## 7. Permissões de Pastas
```bash
sudo chown -R www-data:www-data /var/www/bicho-do-mato
sudo chmod -R 775 storage bootstrap/cache
```

## 8. Deploy Completo
```bash
cd /var/www/bicho-do-mato
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R ug+rwX storage bootstrap/cache
sudo systemctl restart php8.4-fpm
sudo systemctl reload nginx
```

## 9. Backup Rápido

### Banco de Dados
```bash
mysqldump -u usuario -p nome_do_banco > backup_$(date +%F).sql
```

### Arquivos do Projeto
```bash
tar -czvf backup_bicho-do-mato_$(date +%F).tar.gz /var/www/bicho-do-mato
```

## 10. HTTPS e Certificados
```bash
sudo certbot renew --dry-run
sudo certbot renew
```

## 11. Dicas Adicionais
- Monitore a aplicação com `top` ou `htop`.  
- Configure **fail2ban** ou firewall.  
- Use logs rotativos (logrotate).  
- Evite rodar `composer install` como root.

