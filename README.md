# Laravel Inertia.js + Vue.js Project

## Projekt leírása
Ez a projekt egy Laravel alapú backend és Inertia.js-t használó frontend alkalmazás, amely Vue.js-t alkalmaz az interaktív felhasználói felület megvalósításához. A cél egy modern webes alkalmazás létrehozása, amely gyors és dinamikus működést biztosít.

## Telepítés

### Rendszerkövetelmények
- PHP >= 8.1
- Composer
- Node.js (npm vagy yarn csomagkezelővel)
- MySQL vagy más támogatott adatbázis
- Laravel 11
- Laragon vagy más helyi fejlesztői környezet (opcionális)

### 1. Projekt klónozása
```bash
git clone <repository-url>
cd <repository-name>
```

### 2. Függőségek telepítése
#### Backend
```bash
composer install
```
#### Frontend
```bash
npm install
# vagy
yarn install
```

### 3. Környezeti változók beállítása
Másold az `.env.example` fájlt `.env` néven, majd konfiguráld a környezeti változókat:
```bash
cp .env.example .env
```
Állítsd be az adatbázis-kapcsolati adatokat az `.env` fájlban:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adatbazis_nev
DB_USERNAME=felhasznalonev
DB_PASSWORD=jelszo
```

### 4. Adatbázis migrációk futtatása
```bash
php artisan migrate
```

Teszt adatok feltöltéséhez
```bash
php artisan migrate:fresh --seed
```

### 5. Frontend buildelése
Fejlesztői mód:
```bash
npm run dev
# vagy
yarn dev
```

### 6. Laravel fejlesztői szerver indítása
```bash
php artisan serve
```

Ezután az alkalmazás elérhető lesz a [http://localhost:8000](http://localhost:8000) címen.

## Főbb technológiák
- **Laravel**: Backend API és üzleti logika
- **Inertia.js**: SPA (Single Page Application) közvetítő Laravel és Vue.js között
- **Vue.js**: Komponens alapú frontend fejlesztés
- **Tailwind CSS**: Stílusok gyors és testreszabható kialakításához (opcionális)
