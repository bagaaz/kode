# Kode

Catálogo de perfumes com páginas públicas de produtos e painel para gerenciar fragrâncias e usuários.

## Desenvolvimento local

**Requisitos** · PHP 8.4+, Composer 2, Node 22.12+ e MySQL.

```bash
git clone https://github.com/bagaaz/kode.git
cd kode
cp .env.example .env
```

Crie um banco MySQL para desenvolvimento e ajuste `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` no `.env`. Use `127.0.0.1` em `DB_HOST` quando o MySQL estiver na mesma máquina.

```bash
composer install
php artisan key:generate
php artisan migrate
npm ci
composer run dev
```

Acesse [http://localhost:8000](http://localhost:8000). Para acessar `/admin`, defina `ADMIN_EMAIL`, `ADMIN_NAME` e `ADMIN_PASSWORD` no `.env` e execute `php artisan db:seed --class=AdminUserSeeder`.
