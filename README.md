# 🐾 Állatkerti Nyilvántartó Rendszer – Laravel

Ez a projekt egy egyszerű állatkerti nyilvántartó rendszer, amely a Laravel keretrendszer felhasználásával készült. Az alkalmazás célja, hogy lehetőséget biztosítson állatok és kifutók kezelésére, adminisztrációjára, valamint különböző jogosultságokkal rendelkező felhasználók kezelésére.

## 📋 Funkciók

-   Autentikáció

-   Kifutók listázása, létrehozása, szerkesztése és törlése (admin jogosultsággal)

-   Állatok létrehozása, szerkesztése, archiválása és visszaállítása

-   Kifutók és állatok közötti kapcsolatok kezelése

-   Kép feltöltés állatokhoz

-   Főoldali statisztikák és teendők listája a gondozóknak

-   Jogosultságkezelés (admin vs gondozó)

-   Archivált állatok listája és visszaállítása

## 🗃 Technológiák

-   Laravel 10

-   Laravel Breeze (auth és frontend scaffold)

-   Blade sablonok

-   Bootstrap

-   SQLite

-   Faker (adatgenerálás seederekhez)

-   Carbon (időkezelés)

## ⚙️ Telepítés

### ✅ Előfeltételek

1. PHP (>= 8.1 ajánlott)
   Laravelhez szükséges minimum PHP 8.1.

    Ellenőrizhető: php -v

2. Composer
   PHP csomagkezelő, Laravel projektfüggőségek kezeléséhez.

    Telepítés: https://getcomposer.org/download/

    Ellenőrizhető: composer --version

3. Node.js és NPM
   Frontend eszközök (Vite, Tailwind, stb.) futtatásához szükséges.

    Ajánlott verzió: Node 18.x vagy újabb

    Ellenőrizhető: node -v és npm -v

```bash
git clone https://github.com/BurjanNorbi/zoo-registration-system-laravel.git
cd zoo-registration-system-laravel
./init.bat
```

### 🧪 Tesztfelhasználók

Alapértelmezett bejelentkezési adatok (seeder által generált):

Admin:
Email: q@q.hu
Jelszó: q

Gondozó:
Email: w@w.hu
Jelszó: w

## 🖼️ Képernyőképek

### Főoldal admin szemszögből

![main page admin](/screenshots/main_page_admin.png)

### Főoldal gondozó szemszögből

![main page user](/screenshots/main_page_user.png)

### Összes kifutó admin szemszögből

![enclosures page admin](/screenshots/enclosures_page_admin.png)

### Összes kifutó gondozó szemszögből

![enclosures page user](/screenshots/enclosures_page_user.png)

### Egy kifutó admin szemszögből

![enclosure page admin](/screenshots/enclosure_page_admin.png)

### Egy kifutó gondozó szemszögből

![enclosure page user](/screenshots/enclosure_page_user.png)
