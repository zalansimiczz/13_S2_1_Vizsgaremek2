
#  TollÚtDíj

Az ÚtdíjPro egy fuvarozó és logisztikai cégek számára készült rendszer, amely webes partner portálból, Windows asztali alkalmazásból és mobil GPS-követő alkalmazásból áll. A webes felületen a partnercégek kezelhetik a felhasználóikat, sofőrjeiket, járműveiket, cégadataikat és útdíj-kalkulációikat. A mobilalkalmazás bejelentkezés után pozícióadatokat küld a rendszernek, az asztali alkalmazás pedig belső adminisztrációra használható.



## Készítők

- [@PetrikBoban](https://github.com/PetrikBoban)
- [@zalansimiczz](https://github.com/zalansimiczz)
- [@NRicsi](https://github.com/NRicsi)
## Tesztek futtatása

Minden teszt futásának előfeltétele MYSQL Adatbázis futása

### Webfelület

Előfeltételek:

Frontend futása

[robotframework](https://github.com/robotframework/robotframework)

[RIDE](https://github.com/robotframework/RIDE)

[SeleniumLibrary](https://github.com/robotframework/SeleniumLibrary)

RIDE-on belüli navigáció:
```bash
  File -› Open Directory
```
Elérési út:
```bash
  Projekt/Tesztesetek/Web
```

Test suites menüpont alatt tetszőleges teszt kiválasztása után futtatható.

### Asztali alkalmazás

Előfeltételek:

[pywinauto](https://github.com/pywinauto/pywinauto)

[Python](https://www.python.org/downloads/)

Elérési út:

```bash
  Projekt/Tesztesetek/Asztali alkalmazás
```

Tetszőleges teszt kiválasztása után futtatható.

### Mobil alkalmazás

Megegyezik a Webfelület tesztelésével

## Dokumentáció

[Felhasználói Dokumentáció](https://github.com/zalansimiczz/13_S2_1_Vizsgaremek2/blob/main/projekt/Dokument%C3%A1ci%C3%B3/Toll%C3%BAtd%C3%ADj%20Felhaszn%C3%A1l%C3%B3i%20Dokument%C3%A1ci%C3%B3.pdf)

[Fejlesztői Dokumentáció](https://github.com/zalansimiczz/13_S2_1_Vizsgaremek2/blob/main/projekt/Dokument%C3%A1ci%C3%B3/Toll%C3%BAtd%C3%ADj%20fejleszt%C5%91i%20dokument%C3%A1ci%C3%B3.pdf)


[Általános Dokumentáció](https://github.com/zalansimiczz/13_S2_1_Vizsgaremek2/blob/main/projekt/Dokument%C3%A1ci%C3%B3/Toll%C3%BAtd%C3%ADj%20dokument%C3%A1ci%C3%B3.pdf)
## Környezeti Változók

A projekt futtatásához hozzá kell adni az alábbi környezeti változókat a .env fájlhoz:

`API_KEY` ENgEjoLiN5CNMBuAGsUtEGkt4A-l030o3ALOT9lnrjg




## Helyi futtatás

Klónozza a projektet:

```bash
  git clone https://github.com/zalansimiczz/13_S2_1_Vizsgaremek2
```

Lépjen be a projekt könyvtárába:

```bash
  cd projekt/TollUtdij 2025.12/utdijpro-partner-portal
```

Telepítse a függőségeket:

```bash
  composer install
```

Indítsa el a szervert:

```bash
  php artisan serve
```

## API referencia

> Megjegyzés: a projektben több végpont hagyományos webes űrlapként működik, ezért sikeres művelet után sok esetben nem JSON választ ad, hanem átirányítást (`302 redirect`). A tényleges JSON választ adó kalkulációs végpont a `/api/calculate`, illetve a mobil API hívások.

---

## Webes partner portál végpontok

### Bejelentkezési oldal lekérése

```http
GET /partner/login
```

Betölti a partner bejelentkezési oldalt.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nincs | - | - | A végpont nem vár paramétert. |

**Válasz:** HTML bejelentkezési oldal.

---

### Partner bejelentkezés

```http
POST /partner/login
```

Email cím és jelszó alapján belépteti a partner felhasználót.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| email | string | igen | A felhasználó email címe. |
| password | string | igen | A felhasználó jelszava. |

**Sikeres válasz:** átirányítás a partner irányítópultra.

**Hibás válasz:** visszatérés a bejelentkezési oldalra hibaüzenettel.

---

### Regisztrációs oldal lekérése

```http
GET /partner/register
```

Betölti az új partner regisztrációs oldalt.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nincs | - | - | A végpont nem vár paramétert. |

**Válasz:** HTML regisztrációs oldal.

---

### Partner regisztráció

```http
POST /partner/register
```

Új partnercéget és hozzá tartozó első felhasználót hoz létre.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| ceg_nev | string | igen | A cég neve. |
| adoszam | string | nem | A cég adószáma. |
| cim | string | nem | A cég címe vagy székhelye. |
| teljes_nev | string | igen | A regisztráló felhasználó teljes neve. |
| email | string | igen | A felhasználó email címe. Egyedinek kell lennie. |
| password | string | igen | A jelszó, legalább 8 karakter. |
| password_confirm | string | igen | A jelszó megerősítése. Meg kell egyeznie a `password` értékével. |

**Sikeres válasz:** átirányítás az email-megerősítő oldalra.

**Hibás válasz:** visszatérés az űrlapra validációs hibákkal.

---

### Kijelentkezés

```http
GET /partner/logout
```

Törli a felhasználó munkamenetét és kijelentkezteti.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nincs | - | - | A végpont nem vár paramétert. |

**Sikeres válasz:** átirányítás a bejelentkezési oldalra.

---

### Irányítópult lekérése

```http
GET /partner/dashboard
```

Betölti a bejelentkezett partner irányítópultját.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| tab | string | nem | Opcionális fülazonosító, például `driversContent` vagy `trucksContent`. |

**Sikeres válasz:** HTML dashboard oldal.

**Jogosultság:** bejelentkezett és emailben megerősített partner felhasználó szükséges.

---

### Új alkalmazott létrehozása

```http
POST /partner/users
```

Új felhasználót hoz létre a bejelentkezett partner cégéhez.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| full_name | string | igen | Az alkalmazott teljes neve. |
| email | string | igen | Az alkalmazott email címe. Egyedinek kell lennie. |
| password | string | igen | Az alkalmazott jelszava. |
| password_confirm | string | igen | A jelszó ismétlése. |

**Sikeres válasz:** átirányítás az alkalmazottak fülre.

**Hibás válasz:** visszatérés hibaüzenettel.

---

### Alkalmazott aktív/inaktív állapot váltása

```http
POST /partner/users/{id}/toggle
```

Átváltja a megadott felhasználó aktív állapotát.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A módosítandó felhasználó azonosítója. |

**Sikeres válasz:** átirányítás az alkalmazottak fülre.

**Jogosultság:** csak a bejelentkezett céghez tartozó felhasználó módosítható.

---

## Sofőr végpontok

### Új sofőr létrehozása

```http
POST /partner/soforok
```

Új sofőrt rögzít a bejelentkezett partner cégéhez.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| aktiv | boolean | igen | A sofőr aktív állapota. |
| nev | string | igen | A sofőr neve. |
| szemelyi_azonosito | string | nem | A sofőr személyi azonosítója. |
| szuletesi_datum | date | nem | A sofőr születési dátuma. |
| telefonszam | string | igen | A sofőr telefonszáma. |
| cim | string | nem | A sofőr címe. |
| adoszam | string | nem | A sofőr adószáma. |

**Sikeres válasz:** átirányítás a sofőrök fülre.

---

### Sofőr módosítása

```http
POST /partner/soforok/{id}/update
```

Módosítja egy meglévő sofőr adatait.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A sofőr azonosítója. |
| nev | string | igen | A sofőr neve. |
| szemelyi_azonosito | string | nem | A sofőr személyi azonosítója. |
| szuletesi_datum | date | nem | A sofőr születési dátuma. |
| telefonszam | string | igen | A sofőr telefonszáma. |
| cim | string | nem | A sofőr címe. |
| adoszam | string | nem | A sofőr adószáma. |
| aktiv | 0 vagy 1 | igen | Aktív állapot. |

**Sikeres válasz:** átirányítás a sofőrök fülre.

---

### Sofőr aktív/inaktív állapot váltása

```http
POST /partner/soforok/{id}/toggle
```

Átváltja a sofőr aktív állapotát.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A sofőr azonosítója. |

**Sikeres válasz:** visszatérés az előző oldalra sikerüzenettel.

---

### Sofőr törlése

```http
DELETE /partner/soforok/{id}
```

Törli a megadott sofőrt.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A törlendő sofőr azonosítója. |

**Sikeres válasz:** átirányítás a sofőrök fülre.

---

## Jármű végpontok

### Új jármű létrehozása

```http
POST /jarmuvek
```

Új járművet rögzít a bejelentkezett partner cégéhez.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| kategoria | string | igen | A jármű kategóriája. |
| marka | string | igen | A jármű márkája. |
| tipus | string | igen | A jármű típusa. |
| tengelyszam | integer | igen | Tengelyszám, 1 és 10 között. |
| rendszam | string | igen | A jármű rendszáma. Egyedinek kell lennie. |
| vin | string | nem | Alvázszám/VIN. |
| euro_besorolas | string | nem | Környezetvédelmi besorolás. |
| ossztomeg_kg | integer | nem | Össztömeg kilogrammban. |
| potkocsi_kepes | boolean | igen | Pótkocsi-képesség. |
| aktiv | boolean | igen | Aktív állapot. |

**Sikeres válasz:** átirányítás a járművek fülre.

---

### Jármű módosítása

```http
POST /jarmuvek/{id}/update
```

Módosítja egy meglévő jármű adatait.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A jármű azonosítója. |
| kategoria | string | igen | A jármű kategóriája. |
| marka | string | igen | A jármű márkája. |
| tipus | string | igen | A jármű típusa. |
| tengelyszam | integer | igen | Tengelyszám, 1 és 10 között. |
| rendszam | string | igen | A jármű rendszáma. |
| vin | string | nem | Alvázszám/VIN. |
| euro_besorolas | string | nem | Euro-besorolás. |
| ossztomeg_kg | integer | nem | Össztömeg kilogrammban. |
| potkocsi_kepes | 0 vagy 1 | igen | Pótkocsi-képesség. |
| aktiv | 0 vagy 1 | igen | Aktív állapot. |

**Sikeres válasz:** átirányítás a járművek fülre.

---

### Jármű aktív/inaktív állapot váltása

```http
POST /jarmuvek/{id}/toggle
```

Átváltja a jármű aktív állapotát.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A jármű azonosítója. |

**Sikeres válasz:** visszatérés az előző oldalra sikerüzenettel.

---

### Jármű törlése

```http
DELETE /jarmuvek/{id}
```

Törli a megadott járművet.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A törlendő jármű azonosítója. |

**Sikeres válasz:** átirányítás a járművek fülre.

---

## Útdíj-kalkulációs API

### Útdíj kalkuláció

```http
POST /api/calculate
```

Útvonalat számol az indulási és érkezési cím alapján, majd visszaadja a becsült útdíjat és távolságot JSON formátumban.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| from | string | igen | Indulási cím vagy település. |
| to | string | igen | Érkezési cím vagy település. |
| vehicleType | string | igen | Járműtípus, például `2AxlesTruck`, `3AxlesTruck`, `4AxlesTruck`. |
| waypoints | array | nem | Köztes megállók listája. |
| waypoints.*.address | string | nem | Egy köztes megálló címe. |

**Sikeres válasz példa:**

```json
{
  "costHUF": 12500,
  "currency": "Ft",
  "distanceKm": 104.2,
  "routeLink": "https://www.google.com/maps/dir/?...",
  "locations": [],
  "routeCoords": []
}
```

**Hibás válasz példa:**

```json
{
  "error": "A kalkuláció sikertelen.",
  "details": {
    "message": "A cím nem található: példa"
  }
}
```

---

### Útdíj kalkuláció webes route-on keresztül

```http
POST /calculate
```

Ugyanazt a kalkulációs logikát használja, mint a `/api/calculate`, de a webes partner felületen keresztül van meghívva.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| from | string | igen | Indulási cím. |
| to | string | igen | Érkezési cím. |
| vehicleType | string | igen | Járműtípus. |
| waypoints | array | nem | Köztes megállók. |

**Válasz:** JSON kalkulációs eredmény.

---

## Email-megerősítési végpontok

### Email-megerősítő oldal

```http
GET /email/verify
```

Megjeleníti az email-megerősítésre figyelmeztető oldalt.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nincs | - | - | A végpont nem vár paramétert. |

---

### Email cím megerősítése

```http
GET /email/verify/{id}/{hash}
```

Megerősíti a felhasználó email címét az aláírt link alapján.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| id | integer | igen | A felhasználó azonosítója. |
| hash | string | igen | Az email cím ellenőrzéséhez használt hash. |

**Sikeres válasz:** átirányítás az irányítópultra.

---

### Megerősítő email újraküldése

```http
POST /email/verification-notification
```

Újraküldi a megerősítő emailt.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nincs | - | - | A felhasználó azonosítója a munkamenetből kerül kiolvasásra. |

**Sikeres válasz:** visszatérés sikerüzenettel.

---

## Riport végpontok

### Riport oldal lekérése

```http
GET /reports
```

Betölti a riportok oldalát.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nincs | - | - | A végpont nem vár paramétert. |

---

### Riport generálása

```http
POST /reports
```

Riportot generál a megadott típus és dátumtartomány alapján.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| report_type | string | igen | A riport típusa. |
| date_from | date | nem | Kezdő dátum. |
| date_to | date | nem | Záró dátum. Nem lehet korábbi, mint a `date_from`. |

**Sikeres válasz:** riport oldal eredményekkel.

---

## Beállítások végpont

### Cégadatok módosítása

```http
PUT /partner/settings/company
```

Módosítja a bejelentkezett felhasználóhoz tartozó cég adatait.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| nev | string | nem | A cég neve. |
| adoszam | string | nem | A cég adószáma. |
| cim | string | nem | A cég címe. |

**Sikeres válasz:** visszatérés sikerüzenettel.

---

## Mobil API

> A mobil kliens kódja alapján az alapértelmezett API alap URL: `/api/mobile`. A külön PHP mobil backend fájlokban ugyanennek a logikának megfelelő `login.php` és `send_position.php` fájlok találhatók.

### Mobil bejelentkezés

```http
POST /api/mobile/login
```

Bejelentkezteti a mobil felhasználót, és tokent ad vissza.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| email | string | igen | A felhasználó email címe. |
| password | string | igen | A felhasználó jelszava. |

**Sikeres válasz példa:**

```json
{
  "success": true,
  "token": "generalt_token"
}
```

**Hibás válasz:** `401 Unauthorized`.

---

### Mobil pozíció küldése

```http
POST /api/mobile/positions
```

Elküldi a mobil eszköz aktuális GPS pozícióját.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| token | string | igen | A bejelentkezéskor kapott mobil token. |
| lat | number | igen | Földrajzi szélesség. |
| lon | number | igen | Földrajzi hosszúság. |
| speed_kmh | number | nem | Sebesség km/h-ban. |
| recorded_at | string | nem | A mérés időpontja ISO formátumban. |

**Sikeres válasz példa:**

```json
{
  "success": true
}
```

**Hibás válaszok:**

- `400 Bad Request`, ha hiányzik a koordináta.
- `401 Unauthorized`, ha hiányzik, lejárt vagy érvénytelen a token.

---

### Mobil kijelentkezés

```http
POST /api/mobile/logout
```

Kijelentkezteti a mobil felhasználót. A kliens törli a helyben tárolt tokent.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| token | string | igen | A bejelentkezéskor kapott mobil token. |

**Sikeres válasz:** nincs kötelező válaszstruktúra a kliens oldali kód alapján.

---

## Belső kalkulációs függvények

### estimateToll(distanceKm, vehicleType)

Kiszámolja a becsült útdíjat a távolság és a járműtípus alapján.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| distanceKm | number | igen | Távolság kilométerben. |
| vehicleType | string | igen | Járműtípus kulcs, például `2AxlesTruck`. |

**Visszatérés:** egész szám, becsült útdíj forintban.

---

### geocodeAddress(address)

Címből földrajzi koordinátát keres külső térképes szolgáltatással.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| address | string | igen | Keresendő cím vagy település. |

**Visszatérés:** szélesség és hosszúság.

---

### getRoute(points)

Több koordinátapont alapján útvonalat kér le.

| Paraméter | Típus | Kötelező | Leírás |
|---|---|---:|---|
| points | array | igen | Legalább két koordinátapontból álló tömb. |

**Visszatérés:** útvonal távolsága méterben és útvonal-koordináták.
