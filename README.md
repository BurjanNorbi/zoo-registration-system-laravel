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

Projekt klónozása:

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
Email: user@example.com
Jelszó: password

🖼️ Képernyőképek
