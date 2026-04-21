# Felhasználói dokumentáció

## ÚtdíjPro rendszer

**Dokumentum célja:** ez a felhasználói dokumentáció az ÚtdíjPro rendszer használatát mutatja be teljes egészében. A rendszer nem egyetlen programból áll, hanem három egymáshoz kapcsolódó felületből: webes partner portálból, Windows asztali alkalmazásból és mobiltelefonos alkalmazásból. A dokumentáció úgy készült, hogy egy teljesen kezdő felhasználó is megértse, mi ez a rendszer, mire való, milyen eszköz kell hozzá, hogyan kell elindítani, hogyan kell használni, és mit jelentenek a tipikus hibajelzések.

**A dokumentáció által lefedett három alkalmazás:**

- **Webes partner portál:** böngészőből használható partnerfelület cégeknek, alkalmazottaknak, sofőröknek, járműveknek és útdíj-kalkulációnak.
- **Asztali alkalmazás:** Windows rendszerű számítógépen futó adminisztrációs program, amely cég-, sofőr-, jármű-, jogosítvány- és trackeradatok kezelésére szolgál.
- **Mobil alkalmazás:** Android telefonon futó Flutter alapú alkalmazás, amely bejelentkezés után GPS pozíciót küld a rendszer felé.

**Célközönség:** a dokumentáció fuvarozó cégek, cégadminisztrátorok, operátorok, sofőrök és rendszeradminisztrátorok számára készült. A webes és asztali alkalmazást főként adminisztratív munkatársak használják, a mobilalkalmazást pedig elsősorban sofőrök vagy járművet használó munkatársak.

---

## 1. A program célja és lényegesebb funkciói

### 1.1. Mi az ÚtdíjPro rendszer?

Az ÚtdíjPro egy számítógépes szoftverrendszer, amely fuvarozáshoz, járműnyilvántartáshoz, sofőrkezeléshez és járműkövetéshez kapcsolódó feladatokat támogat. A rendszer célja, hogy a céghez tartozó fontos adatok egy közös adatbázisban legyenek elérhetők, és azokat a megfelelő felhasználók különböző eszközökről tudják használni.

A rendszer három felületből áll:

- a webes partner portálból,
- a Windows asztali admin alkalmazásból,
- a mobil GPS-követő alkalmazásból.

Ez azért hasznos, mert nem minden felhasználó ugyanazt az eszközt használja. Egy irodai adminisztrátor kényelmesebben dolgozik számítógépen, egy cégvezető vagy partner böngészőből is eléri a fontos funkciókat, egy sofőr pedig útközben mobiltelefonról tud pozícióadatot küldeni.

### 1.2. Mire való a webes partner portál?

A webes partner portál böngészőből használható. Nem kell külön telepíteni a felhasználó gépére, elég megnyitni a megfelelő webcímet. A portál fő célja, hogy a partnercég saját adatait kezelni tudja.

A webes portál fő funkciói:

- partner regisztráció,
- email cím megerősítése,
- bejelentkezés email címmel és jelszóval,
- irányítópult megtekintése,
- alkalmazottak/felhasználók hozzáadása,
- alkalmazottak aktiválása vagy inaktiválása,
- sofőrök hozzáadása, szerkesztése, törlése,
- járművek hozzáadása, szerkesztése, törlése,
- útdíjkalkuláció indulási és érkezési cím alapján,
- cégadatok módosítása,
- riport jellegű összesítések megtekintése,
- kijelentkezés.

### 1.3. Mire való az asztali alkalmazás?

Az asztali alkalmazás Windows számítógépen futó program. Ez nem böngészőben nyílik meg, hanem külön alkalmazásként indul. A projektben a program neve TollÚtdíj, és .NET Framework 4.7.2 alapú Windows Forms alkalmazás.

Az asztali alkalmazás elsősorban adminisztrációs és belső kezelőfelület. A programban szerepkörtől függően más és más lehetőségek érhetők el. A rendszer megkülönböztet például operátort, cégadminisztrátort és rendszeradminisztrátort.

Az asztali alkalmazás fő funkciói:

- bejelentkezés email címmel és jelszóval,
- cégadatok áttekintése és módosítása,
- járművek kezelése,
- sofőrök kezelése,
- jogosítványkategóriák kezelése,
- tracker eszközök megtekintése,
- kijelentkezés.

### 1.4. Mire való a mobilalkalmazás?

A mobilalkalmazás telefonon használható. A projektben Flutter alapú alkalmazásként szerepel, UtdijPro Mobile / Toll Tracker néven. A mobilapp célja nem az összes adminisztratív adat kezelése, hanem a bejelentkezett felhasználó vagy sofőr aktuális GPS pozíciójának továbbítása a rendszer felé.

A mobilalkalmazás fő funkciói:

- bejelentkezés partner fiókkal,
- token alapú munkamenet tárolása,
- GPS helymeghatározás engedélyezése,
- pozíció automatikus elküldése,
- pozíció kézi elküldése gombnyomással,
- utolsó küldés idejének megjelenítése,
- szélességi és hosszúsági koordináta megjelenítése,
- sebesség megjelenítése, ha a készülék ezt tudja mérni,
- kijelentkezés.

### 1.5. A rendszer közös működési elve

A három alkalmazás ugyanahhoz a témakörhöz tartozik, és közös adatbázisra, illetve közös felhasználói adatokra épül. A felhasználó email címmel és jelszóval azonosítja magát. A rendszer ellenőrzi, hogy a fiók létezik-e, a jelszó helyes-e, valamint a fiók aktív-e.

A webes és asztali felület inkább adatkezelésre való. A mobilalkalmazás inkább adatküldésre, vagyis a helyadatok továbbítására szolgál.

### 1.6. Felhasználói szerepkörök

A rendszerben többféle felhasználói szerepkör fordulhat elő:

- **Sofőr vagy mobil felhasználó:** a mobilalkalmazásban jelentkezik be, és pozíciót küld.
- **Operátor:** alapvető adatkezelési feladatokat végezhet.
- **Cégadminisztrátor:** saját cégéhez tartozó adatokat kezelhet.
- **Rendszeradminisztrátor:** szélesebb körű jogosultsággal rendelkezik, több cég adatait is kezelheti.

A pontosan elérhető funkciók attól függnek, hogy a felhasználó milyen szerepkörrel rendelkezik.

---

## 2. Szükséges hardvereszközök és szoftverek

### 2.1. Közös felhasználói feltételek

A rendszer használatához általában szükséges:

- működő internetkapcsolat,
- érvényes felhasználói fiók,
- email cím és jelszó,
- aktív felhasználói állapot,
- a megfelelő eszköz: számítógép, laptop vagy okostelefon.

Ha nincs internetkapcsolat, a webes portál nem tölt be, az asztali alkalmazás nem tud adatbázishoz csatlakozni, a mobilalkalmazás pedig nem tudja elküldeni a GPS pozíciót.

### 2.2. Webes partner portál használatához szükséges eszközök

A webes portál használatához szükséges:

- asztali számítógép, laptop, tablet vagy okostelefon,
- modern böngésző,
- internetkapcsolat.

Ajánlott böngészők:

- Google Chrome,
- Mozilla Firefox,
- Microsoft Edge,
- Safari.

A webes portál nagyobb képernyőn kényelmesebb, mert táblázatok, menük és űrlapok is találhatók benne. Mobilon is megnyitható, de több adat rögzítésekor a számítógép vagy laptop ajánlott.

### 2.3. Asztali alkalmazás használatához szükséges eszközök

Az asztali alkalmazás használatához szükséges:

- Windows operációs rendszerű számítógép,
- billentyűzet és egér,
- internetkapcsolat vagy adatbázis-elérés,
- .NET Framework 4.7.2 vagy újabb kompatibilis futtatókörnyezet,
- az asztali alkalmazás telepített példánya.

A program a MySQL adatbázishoz kapcsolódik. Ha a hálózat vagy az adatbázis nem érhető el, a program hibaüzenetet jeleníthet meg, például adatbetöltési vagy csatlakozási hibát.

### 2.4. Mobilalkalmazás használatához szükséges eszközök

A mobilalkalmazás használatához szükséges:

- Android okostelefon,
- működő internetkapcsolat vagy mobiladat,
- bekapcsolt helymeghatározás,
- engedélyezett GPS/helyhozzáférés az alkalmazás számára,
- telepített ÚtdíjPro/Toll Tracker mobilapp,
- érvényes partner fiók.

A mobilalkalmazás akkor működik megfelelően, ha a telefonon be van kapcsolva a helymeghatározás, és az alkalmazás megkapta a helyadatok használatához szükséges engedélyt.

### 2.5. Fejlesztői környezethez szükséges szoftverek

Ha a rendszert fejlesztőként vagy vizsgabemutatóhoz helyi gépen kell futtatni, akkor a következők szükségesek:

- PHP 8.2 vagy újabb a Laravel webportálhoz,
- Composer a PHP csomagokhoz,
- Node.js és npm a frontend csomagokhoz,
- MySQL adatbázis,
- Laravel 12 környezet,
- Flutter SDK a mobilalkalmazáshoz,
- Android Studio vagy Android SDK az Android futtatáshoz,
- Visual Studio az asztali Windows Forms alkalmazáshoz,
- .NET Framework 4.7.2 fejlesztői csomag.

---

## 3. Telepítés és indítás lépései

### 3.1. Webes partner portál megnyitása felhasználóként

Átlagos felhasználónak a webes portált nem kell telepítenie. A használat lépései:

1. Nyissa meg a böngészőt.
2. Írja be a portál webcímét.
3. Nyomja meg az Enter billentyűt.
4. A rendszer a bejelentkezési oldalra irányítja.
5. Adja meg az email címét és jelszavát.
6. Kattintson a Bejelentkezés gombra.

Ha nincs fiókja, a regisztrációs oldalon új partner fiókot hozhat létre.

### 3.2. Webes partner portál helyi indítása fejlesztői környezetben

A webes alkalmazás Laravel alapú. Helyi indításhoz a projekt főkönyvtárában a következő lépések szükségesek:

```bash
composer install
npm install
php artisan migrate
php artisan serve
npm run dev
```

Ezután a böngészőben megnyitható például:

```text
http://127.0.0.1:8000
```

A projekt tartalmazhat összetett fejlesztői indító parancsot is:

```bash
composer run dev
```

Ez több folyamatot is elindíthat egyszerre, például Laravel szervert, queue listenert, naplófigyelést és Vite fejlesztői szervert.

### 3.3. Asztali alkalmazás telepítése

Az asztali alkalmazás Windows alatt használható. A projektben található telepítőcsomag alapján a telepítés általános lépései:

1. Keresse meg a `TollÚtdíj_setup.zip` fájlt.
2. Csomagolja ki a ZIP fájlt.
3. Indítsa el a telepítőfájlt vagy a közzétett alkalmazást.
4. Ha a Windows biztonsági figyelmeztetést jelenít meg, csak akkor folytassa, ha biztos benne, hogy a fájl megbízható forrásból származik.
5. Kövesse a telepítő lépéseit.
6. A telepítés után indítsa el a TollÚtdíj alkalmazást.

Ha a gépen hiányzik a .NET Framework 4.7.2, a telepítő kérheti annak telepítését.

### 3.4. Asztali alkalmazás indítása

Az asztali alkalmazás indításának lépései:

1. Nyissa meg a Windows Start menüt vagy az alkalmazás telepítési mappáját.
2. Indítsa el a TollÚtdíj programot.
3. A bejelentkezési ablakban adja meg az email címét.
4. Adja meg a jelszavát.
5. Opcionálisan jelölje be a Maradjak bejelentkezve lehetőséget.
6. Kattintson a Bejelentkezés gombra.

Sikeres bejelentkezés után megjelenik a főmenü.

### 3.5. Mobilalkalmazás telepítése

A mobilalkalmazás Android telefonra telepíthető. Felhasználói szempontból a telepítés általános módja:

1. Szerezze be az alkalmazás telepítőfájlját vagy telepítse a megadott forrásból.
2. Nyissa meg a telepítőt a telefonon.
3. Ha a telefon engedélyt kér ismeretlen forrásból származó alkalmazás telepítésére, csak megbízható forrás esetén engedélyezze.
4. Telepítse az alkalmazást.
5. Indítsa el az UtdijPro Mobile / Toll Tracker appot.

Fejlesztői környezetben a mobilapp Flutterrel indítható:

```bash
flutter pub get
flutter run
```

### 3.6. Mobil backend beállítása fejlesztőként

A mobilalkalmazás a szerver felé API hívásokat küld. A projektben külön PHP API mappa is található. Fejlesztői használat esetén:

1. A PHP API fájlokat másolja az Apache/AMMPS `www` mappájába.
2. Hozzon létre MySQL adatbázist.
3. Állítsa be a `config.php` fájlban az adatbázis nevét, felhasználóját és jelszavát.
4. Ellenőrizze, hogy a mobilapp API alap URL-je a megfelelő szerverre mutat.

A Flutter appban az API alap URL a `MOBILE_API_BASE_URL` értékkel állítható. Emulátor esetén az alapértelmezett cím például:

```text
http://10.0.2.2:8000/api/mobile
```

Valós telefonon a szerver helyi hálózati IP-címét kell használni.

---

## 4. A program részletes bemutatása

### 4.1. Webes partner portál: regisztráció

A regisztráció célja, hogy új partnercég és első felhasználó jöjjön létre. A regisztrációs űrlapon a következő adatokat kell megadni:

- cégnév,
- adószám,
- cím,
- teljes név,
- email cím,
- jelszó,
- jelszó megerősítése.

A felhasználónak működő email címet kell megadnia, mert a rendszer email-megerősítést kérhet. A jelszónak legalább 8 karakterből kell állnia, és a két jelszómezőnek meg kell egyeznie.

### 4.2. Webes partner portál: email-megerősítés

Regisztráció után a rendszer megerősítő emailt küldhet. A felhasználónak meg kell nyitnia a levelet, és rá kell kattintania a megerősítő linkre.

Ha az email nem érkezik meg:

- ellenőrizze a spam vagy levélszemét mappát,
- várjon néhány percet,
- kattintson az újraküldés gombra,
- ha rossz email címet adott meg, jelentkezzen ki és regisztráljon újra helyes címmel.

### 4.3. Webes partner portál: bejelentkezés

A bejelentkezési oldalon email címet és jelszót kell megadni. Sikeres bejelentkezés után a felhasználó az irányítópultra kerül. Hibás adatok esetén a rendszer hibaüzenetet jelenít meg.

### 4.4. Webes partner portál: irányítópult

Az irányítópult a webes portál kezdőképernyője. Bal oldalon található a menü, jobb oldalon az aktuális tartalom. Kisebb képernyőn a menü külön gombbal nyitható meg.

A fő menüpontok:

- Irányítópult,
- Útdíj kalkulátor,
- Alkalmazottak,
- Sofőrök,
- Flotta vagy járművek,
- Riportok,
- Beállítások.

### 4.5. Webes partner portál: útdíjkalkulátor

Az útdíjkalkulátor becslést ad egy útvonal távolságára és várható díjára. A használat lépései:

1. Nyissa meg az Útdíj kalkulátor menüpontot.
2. Írja be az indulási helyet, például `Szeged, Magyarország`.
3. Írja be az érkezési helyet, például `Győr, Magyarország`.
4. Válassza ki a járműtípust.
5. Ha szükséges, adjon hozzá köztes megállót.
6. Kattintson a kalkuláció gombra.
7. Tekintse meg a becsült útdíjat, távolságot és térképet.

A kalkuláció becslés, nem hivatalos fizetési bizonylat.

### 4.6. Webes partner portál: alkalmazottak kezelése

Az Alkalmazottak menüpontban új felhasználó adható hozzá a céghez. Szükséges adatok:

- teljes név,
- email cím,
- jelszó,
- jelszó megerősítése.

A meglévő felhasználók aktív vagy inaktív állapotba kapcsolhatók. Az inaktív felhasználó nem tud belépni.

### 4.7. Webes partner portál: sofőrök kezelése

A Sofőrök menüpontban a cég sofőrjei kezelhetők. Megadható adatok:

- név,
- aktív állapot,
- személyi azonosító,
- születési dátum,
- telefonszám,
- cím,
- adószám.

A sofőrök listázhatók, kereshetők, szerkeszthetők, inaktiválhatók és törölhetők.

### 4.8. Webes partner portál: járművek kezelése

A Járművek vagy Flotta menüpontban a cég járművei kezelhetők. Megadható adatok:

- rendszám,
- márka,
- típus,
- kategória,
- tengelyszám,
- VIN/alvázszám,
- Euro-besorolás,
- össztömeg,
- pótkocsi-képesség,
- aktív állapot.

A rendszám egyedi adat, ezért ugyanazt a rendszámot nem lehet több járműhöz rögzíteni.

### 4.9. Webes partner portál: riportok és beállítások

A Riportok menüpont összesítő adatokat mutat, például sofőrök, járművek és felhasználók számát. A Beállítások menüpontban a cég neve, adószáma és címe módosítható.

### 4.10. Asztali alkalmazás: bejelentkezés

Az asztali alkalmazás indításakor bejelentkezési ablak jelenik meg. A mezők:

- E-mail cím,
- Jelszó,
- Maradjak bejelentkezve jelölőnégyzet,
- Bejelentkezés gomb.

Ha a felhasználó nem ír email címet vagy jelszót, a program a hiányzó mezőre irányítja a figyelmet. Ha az adatbázis nem érhető el, adatbetöltési vagy kapcsolat hiba jelenik meg.

### 4.11. Asztali alkalmazás: főmenü

Sikeres bejelentkezés után a főmenü jelenik meg. A főmenüben elérhető gombok:

- Cég áttekintése,
- Járművek kezelése,
- Jogosítványok kezelése,
- Trackerek megtekintése,
- Sofőrök kezelése,
- Kijelentkezés.

A program címsora szerepkör szerint változhat, például Operátor, Adminisztrátor vagy Rendszer adminisztrátor felirattal.

### 4.12. Asztali alkalmazás: cégadatok kezelése

A Cég áttekintése menüpontban a felhasználó megtekintheti és módosíthatja a cég adatait. A mezők:

- Cégnév,
- Adószám,
- Cím.

A Változtatások mentése gombbal a módosítások menthetők. Új cég létrehozása nem az asztali programban történik, hanem a webes felületen.

### 4.13. Asztali alkalmazás: sofőrök kezelése

A Sofőrök kezelése ablakban a meglévő sofőrök listából választhatók ki. A kiválasztott sofőr adatai betöltődnek a mezőkbe.

Kezelhető adatok:

- cégazonosító,
- aktív állapot,
- adószám,
- cím,
- telefonszám,
- személyi azonosító,
- születési dátum,
- név.

Elérhető műveletek:

- új sofőr hozzáadása,
- változtatások mentése,
- sofőr törlése,
- visszalépés a főmenübe.

A születési dátum formátuma az asztali alkalmazásban `ÉÉÉÉ HH NN`, például `1990 05 21`.

### 4.14. Asztali alkalmazás: járművek kezelése

A Járművek kezelése ablakban a meglévő járművek listából választhatók ki. A kiválasztott jármű adatai megjelennek az űrlapon.

Kezelhető adatok:

- cégazonosító,
- kategória,
- típus,
- rendszám,
- össztömeg,
- márka,
- tengelyszám,
- Euro-besorolás,
- alvázszám,
- pótkocsi-képesség.

Elérhető műveletek:

- új jármű hozzáadása,
- változtatások mentése,
- jármű törlése,
- visszalépés.

A program ellenőrzi, hogy az össztömeg és a tengelyszám számként értelmezhető-e.

### 4.15. Asztali alkalmazás: jogosítványok kezelése

A Jogosítványok kezelése ablakban sofőrhöz tartozó jogosítványkategóriák kezelhetők. A felhasználó kiválaszt egy sofőrt, majd kategóriát adhat hozzá vagy módosíthat.

Kezelhető adatok:

- sofőr,
- jogosítványkategória,
- érvényesség kezdete,
- érvényesség vége.

Elérhető műveletek:

- új kategória hozzáadása,
- változtatások mentése,
- kategória törlése,
- visszalépés.

Ha ugyanaz a kategória már létezik az adott sofőrnél, a program figyelmeztető hibaüzenetet jelenít meg.

### 4.16. Asztali alkalmazás: trackerek megtekintése

A Trackerek megtekintése ablakban a rendszerben rögzített tracker eszközök adatai láthatók. Megjelenő adatok lehetnek:

- IMEI,
- SIM ICCID,
- modell,
- firmware verzió,
- aktív/inaktív állapot,
- hozzárendelt jármű.

Ez a felület elsősorban megtekintésre szolgál, hogy az adminisztrátor lássa, milyen követőeszközök vannak a rendszerben.

### 4.17. Mobilalkalmazás: bejelentkezés

A mobilalkalmazás indításakor bejelentkező képernyő jelenik meg. A felhasználónak ugyanazzal a partner fiókkal kell belépnie, amelyet a webes portálon is használ.

Mezők:

- Email cím,
- Jelszó,
- Bejelentkezés gomb.

Sikeres belépés után az app eltárolja a munkamenethez szükséges tokent. Ez azért fontos, hogy a felhasználónak ne kelljen minden indításkor újra megadnia az adatait.

### 4.18. Mobilalkalmazás: GPS követés

Bejelentkezés után a mobilalkalmazás a Mobil követés képernyőre lép. Az app automatikusan lekéri a telefon aktuális GPS pozícióját, majd elküldi a szervernek. A pozícióküldés ismétlődően történik, körülbelül 10 másodpercenként.

A képernyőn látható lehet:

- aktuális státusz,
- utolsó sikeres küldés ideje,
- szélességi koordináta,
- hosszúsági koordináta,
- sebesség km/h-ban,
- Pozíció küldése most gomb,
- kijelentkezés ikon.

### 4.19. Mobilalkalmazás: kézi pozícióküldés

Ha a felhasználó nem akar várni az automatikus küldésre, megnyomhatja a Pozíció küldése most gombot. Ilyenkor az app azonnal megpróbálja lekérni és elküldeni az aktuális helyadatot.

Sikeres küldés esetén az app visszajelzést ad, például hogy a pozíció sikeresen el lett küldve.

### 4.20. Mobilalkalmazás: kijelentkezés

A kijelentkezés ikon megnyomásakor az app törli a helyben tárolt tokent és felhasználói adatokat, majd visszalép a bejelentkezési képernyőre. Ez akkor fontos, ha másik sofőr használja a telefont, vagy ha a felhasználó biztonságosan le akarja zárni a munkamenetet.

---

## 5. Helytelen használatból adódó hibajelzések magyarázata

### 5.1. Hibás email cím vagy jelszó

Webes portálon és asztali alkalmazásban is előfordulhat, hogy a rendszer hibás bejelentkezési adatokat jelez.

Lehetséges okok:

- az email cím el lett gépelve,
- a jelszó hibás,
- a felhasználó nem létezik,
- a fiók inaktív,
- az adatbázisban hibás vagy hiányzó jelszóadat található.

Teendő:

1. Ellenőrizze az email címet.
2. Ellenőrizze, hogy nincs-e bekapcsolva a Caps Lock.
3. Írja be újra a jelszót.
4. Ha továbbra sem sikerül, forduljon adminisztrátorhoz.

### 5.2. A fiók nincs aktiválva

Az asztali alkalmazásban előforduló hibaüzenet:

```text
A fiók nincs aktiválva. Forduljon az adminisztrátorhoz.
```

Ez azt jelenti, hogy a felhasználói fiók létezik, de inaktív. Ilyenkor a felhasználó nem tud belépni, amíg egy adminisztrátor újra aktívvá nem teszi.

### 5.3. Kötelező mező hiányzik

Ha egy kötelező mező üresen marad, a mentés nem sikerülhet. Ilyen mező lehet például:

- email cím,
- jelszó,
- cégnév,
- sofőr neve,
- telefonszám,
- rendszám,
- jármű típusa,
- jogosítványkategória,
- GPS koordináta.

Teendő: töltse ki a hiányzó mezőt, majd próbálja újra a műveletet.

### 5.4. A két jelszó nem egyezik

Regisztrációnál vagy új alkalmazott felvitelénél a jelszót kétszer kell megadni. Ha a két mező nem azonos, a rendszer nem menti az adatokat.

Teendő: törölje mindkét jelszómezőt, írja be újra ugyanazt a jelszót mindkét helyre, majd mentse az űrlapot.

### 5.5. Érvénytelen email cím

Ha az email cím formátuma hibás, a rendszer nem fogadja el. Helyes példa:

```text
felhasznalo@ceg.hu
```

Helytelen példa:

```text
felhasznaloceg.hu
```

### 5.6. Már létező email cím

Ha regisztrációkor vagy új alkalmazott hozzáadásakor a rendszer azt jelzi, hogy az email cím már létezik, akkor az adott email címmel már van felhasználó.

Teendő:

- használjon másik email címet,
- vagy próbáljon bejelentkezni a meglévő fiókkal,
- szükség esetén kérjen adminisztrátori segítséget.

### 5.7. Már létező rendszám

Jármű rögzítésekor a rendszámnak egyedinek kell lennie. Ha a rendszám már szerepel az adatbázisban, a mentés hibával leállhat.

Teendő:

- keresse meg a meglévő járművet,
- ellenőrizze a rendszám írásmódját,
- ha ugyanarról a járműről van szó, szerkessze a meglévő adatot.

### 5.8. Hibás születési dátum formátum

Az asztali alkalmazásban a sofőr születési dátumánál előfordulhat a következő hiba:

```text
Hibás születési dátum formátum. Használja a következő formátumot: ÉÉÉÉ HH NN
```

Példa helyes formátumra:

```text
1990 05 21
```

### 5.9. Hibás össztömeg vagy tengelyszám

Az asztali alkalmazás járműkezelésénél előfordulhat:

```text
Hibás össztömeg érték!
Hibás tengelyszám érték!
Hibás számérték!
```

Ez azt jelenti, hogy a mezőbe nem megfelelő szám került. Az össztömeg és a tengelyszám mezőbe számot kell írni.

### 5.10. Adatbetöltési hiba vagy adatbázis kapcsolat hiba

Asztali alkalmazásban gyakori hibaüzenet lehet:

```text
Adatbetöltési hiba. Ellenőrizze az internetkapcsolatot, majd próbálja újra.
```

vagy:

```text
Nem sikerült csatlakozni az adatbázishoz.
```

Lehetséges okok:

- nincs internetkapcsolat,
- nem érhető el az adatbázisszerver,
- hibás adatbázis-beállítás,
- a szerver karbantartás alatt áll.

Teendő:

1. Ellenőrizze az internetkapcsolatot.
2. Próbálja újra később.
3. Jelezze a hibát az üzemeltetőnek.

### 5.11. Sikertelen útdíjkalkuláció

A webes portálon a kalkuláció sikertelen lehet, ha:

- nincs indulási cím,
- nincs érkezési cím,
- a cím nem található,
- nincs internetkapcsolat,
- a külső térképes szolgáltatás nem elérhető,
- az útvonaltervező nem tud útvonalat számolni.

Teendő:

- írja be pontosabban a címet,
- adja hozzá az országot is,
- ellenőrizze az internetkapcsolatot,
- próbálja újra később.

### 5.12. Mobilapp: a helymeghatározás ki van kapcsolva

A mobilalkalmazás hibaüzenete lehet:

```text
A helymeghatározás ki van kapcsolva a készüléken.
```

Ez azt jelenti, hogy a telefonon nincs bekapcsolva a GPS vagy helymeghatározási szolgáltatás.

Teendő:

1. Nyissa meg a telefon Beállítások menüjét.
2. Keresse meg a Hely vagy Helymeghatározás beállítást.
3. Kapcsolja be.
4. Térjen vissza az alkalmazásba.

### 5.13. Mobilapp: helyhozzáférés engedélyezése szükséges

A mobilapp hibaüzenete lehet:

```text
A helyhozzáférés engedélyezése szükséges.
```

Ez azt jelenti, hogy az alkalmazás nem kapott engedélyt a telefon helyadatainak használatára.

Teendő:

- amikor a telefon engedélyt kér, válassza az engedélyezést,
- ha korábban elutasította, nyissa meg az alkalmazás engedélyeit a telefon beállításaiban,
- engedélyezze a helyadatok használatát.

### 5.14. Mobilapp: helyhozzáférés véglegesen letiltva

A mobilapp hibaüzenete lehet:

```text
A helyhozzáférés véglegesen le van tiltva.
```

Ez akkor fordul elő, ha a felhasználó korábban úgy tiltotta le az engedélyt, hogy az app már nem kérheti újra automatikusan.

Teendő:

1. Nyissa meg a telefon Beállítások menüjét.
2. Keresse meg az alkalmazások listáját.
3. Válassza ki az ÚtdíjPro/Toll Tracker alkalmazást.
4. Nyissa meg az Engedélyek részt.
5. Engedélyezze a helyhozzáférést.

### 5.15. Mobilapp: a munkamenet lejárhatott

A mobilapp hibaüzenete lehet:

```text
A munkamenet lejárhatott. Jelentkezz be újra.
```

Ez azt jelenti, hogy a korábban kapott token már nem érvényes, vagy törlődött a telefonról.

Teendő:

- jelentkezzen ki,
- indítsa újra az alkalmazást,
- jelentkezzen be újra email címmel és jelszóval.

### 5.16. Mobilapp: pozíció küldése sikertelen

A pozíció küldése sikertelen lehet, ha:

- nincs internetkapcsolat,
- a szerver nem elérhető,
- a token érvénytelen,
- a telefon nem tud helyadatot lekérni,
- az API alap URL hibásan van beállítva.

Teendő:

- ellenőrizze a mobilinternetet vagy Wi-Fi kapcsolatot,
- ellenőrizze, hogy a GPS be van-e kapcsolva,
- jelentkezzen be újra,
- fejlesztői környezetben ellenőrizze az API címet.

### 5.17. Törlés megerősítése

A webes és asztali alkalmazásban is lehetőség van sofőr, jármű vagy jogosítványadat törlésére. A törlés végleges adatvesztéssel járhat.

Teendő: törlés előtt mindig ellenőrizze, hogy valóban a megfelelő rekordot választotta-e ki.

### 5.18. Keresés nem ad találatot

A keresés vagy listaüres állapot nem feltétlenül hiba. Lehetséges, hogy:

- az adat nincs rögzítve,
- elgépelés történt,
- másik céghez tartozik az adat,
- a rekord törölve lett,
- a felhasználónak nincs jogosultsága az adat megtekintésére.

---

## 6. Információkérés lehetőségei

### 6.1. Mikor kell segítséget kérni?

Segítséget akkor érdemes kérni, ha:

- nem sikerül bejelentkezni,
- a fiók inaktív,
- nem érkezik meg a megerősítő email,
- az asztali alkalmazás nem tud adatbázishoz csatlakozni,
- a mobilalkalmazás nem küld pozíciót,
- a GPS engedélyezése után is hiba marad,
- a jármű vagy sofőr mentése sikertelen,
- téves adatot rögzített,
- törölni vagy visszaállítani kellene adatot,
- ismeretlen hibaüzenet jelenik meg.

### 6.2. Mit írjon bele a hibabejelentésbe?

A gyors segítséghez a hibabejelentésben szerepeljen:

- a felhasználó neve,
- a cég neve,
- melyik alkalmazásban történt a hiba: web, asztali vagy mobil,
- melyik menüpontban történt,
- mit szeretett volna csinálni,
- pontosan milyen hibaüzenet jelent meg,
- mikor történt a hiba,
- milyen eszközt használt,
- ha lehet, képernyőkép a hibáról.

### 6.3. Példa hibabejelentésre

```text
Tárgy: Mobilapp pozícióküldési hiba

A Demo Trans Kft. felhasználójaként bejelentkeztem a mobilalkalmazásba, de a pozíció küldése nem sikerült.
A telefonon a helymeghatározás be van kapcsolva, az alkalmazásnak engedélyeztem a helyhozzáférést.
A hibaüzenet: A pozíció küldése sikertelen.
A hiba 2026.04.21-én 09:45 körül történt Android telefonon, mobilinternettel.
```

### 6.4. Kapcsolattartási lehetőség

A felhasználók az alábbi email címen kérhetnek segítséget:

```text
utdijpro.support@example.com
```

Ez a dokumentációban szereplő mintacím. Éles használat előtt érdemes valós, rendszeresen ellenőrzött támogatási email címet létrehozni.

### 6.5. Kapcsolat űrlap lehetősége

A rendszer továbbfejlesztéseként létrehozható Kapcsolat menüpont vagy hibabejelentő űrlap. Ebben a felhasználó megadhatja:

- nevét,
- email címét,
- cégnevét,
- az érintett alkalmazást,
- a hiba rövid tárgyát,
- a részletes leírást.

Az email cím akkor is fontos, ha később kapcsolat űrlap készül, mert a felhasználónak szüksége lehet közvetlen elérhetőségre is.

---

## 7. Gyakorlati használati példák

### 7.1. Új partnercég regisztrálása a webes portálon

1. Nyissa meg a webes portált.
2. Kattintson a regisztrációs hivatkozásra.
3. Adja meg a cég nevét.
4. Adja meg az adószámot és címet.
5. Adja meg a saját teljes nevét.
6. Írja be az email címét.
7. Adjon meg legalább 8 karakteres jelszót.
8. Írja be újra ugyanazt a jelszót.
9. Küldje el a regisztrációt.
10. Erősítse meg az email címét.

### 7.2. Új sofőr felvitele webes portálon

1. Jelentkezzen be a webes portálon.
2. Nyissa meg a Sofőrök menüpontot.
3. Kattintson az új sofőr hozzáadása gombra.
4. Adja meg a sofőr nevét.
5. Adja meg a telefonszámát.
6. Töltse ki a többi adatot, ha ismert.
7. Mentse az űrlapot.
8. Ellenőrizze, hogy a sofőr megjelent-e a listában.

### 7.3. Új jármű felvitele webes portálon

1. Jelentkezzen be.
2. Nyissa meg a Flotta vagy Járművek menüpontot.
3. Kattintson az új jármű hozzáadása gombra.
4. Adja meg a rendszámot.
5. Adja meg a márkát, típust és kategóriát.
6. Válassza ki a tengelyszámot.
7. Adja meg az Euro-besorolást és az össztömeget.
8. Válassza ki, hogy pótkocsi-képes-e.
9. Mentse az adatokat.

### 7.4. Cégadat módosítása asztali alkalmazásban

1. Indítsa el a TollÚtdíj asztali alkalmazást.
2. Jelentkezzen be.
3. A főmenüben kattintson a Cég áttekintése gombra.
4. Ellenőrizze a cégnév, adószám és cím mezőket.
5. Módosítsa a szükséges adatokat.
6. Kattintson a Változtatások mentése gombra.
7. Várja meg a sikeres mentés üzenetet.

### 7.5. Jogosítványkategória hozzáadása asztali alkalmazásban

1. Jelentkezzen be az asztali alkalmazásba.
2. Nyissa meg a Jogosítványok kezelése menüpontot.
3. Válassza ki a sofőrt.
4. Kattintson az új kategória hozzáadása gombra.
5. Válassza ki vagy írja be a kategóriát.
6. Adja meg az érvényesség kezdetét és végét.
7. Mentse a változtatást.

### 7.6. Mobil GPS-követés indítása

1. Nyissa meg a mobilalkalmazást.
2. Adja meg az email címét és jelszavát.
3. Kattintson a Bejelentkezés gombra.
4. Engedélyezze a helyhozzáférést.
5. Ellenőrizze, hogy a státusz szerint a kapcsolat rendben van-e.
6. Ha szükséges, nyomja meg a Pozíció küldése most gombot.
7. Munka végén jelentkezzen ki.

---

## 8. Fogalomtár

**Webes alkalmazás:** böngészőben futó program, amelyet nem kell külön telepíteni a felhasználó gépére.

**Asztali alkalmazás:** számítógépre telepített program, amely külön ablakként indul.

**Mobilalkalmazás:** telefonra telepített app.

**Partner portál:** a cég felhasználói számára készült webes kezelőfelület.

**Felhasználói fiók:** email címből és jelszóból álló belépési azonosító.

**Token:** olyan azonosító, amelyet a rendszer sikeres mobilos bejelentkezés után használ a felhasználó azonosítására.

**GPS:** műholdas helymeghatározás, amely a telefon pozícióját adja meg.

**Tracker:** járműkövető eszköz vagy követéshez kapcsolódó azonosított eszköz.

**IMEI:** mobil vagy tracker eszköz egyedi azonosítója.

**SIM ICCID:** SIM kártya egyedi azonosítója.

**VIN/alvázszám:** a jármű egyedi gyári azonosítója.

**Euro-besorolás:** a jármű környezetvédelmi besorolása.

**Aktív felhasználó:** olyan fiók, amely beléphet és használhatja a rendszert.

**Inaktív felhasználó:** olyan fiók, amely le van tiltva vagy ideiglenesen nem használható.

---

## 9. Összegzés

Az ÚtdíjPro rendszer három különböző, de összekapcsolódó alkalmazásból áll. A webes partner portál a cég saját adatainak kényelmes böngészős kezelésére szolgál. Az asztali alkalmazás Windows környezetben biztosít részletesebb adminisztrációs lehetőségeket. A mobilalkalmazás a sofőrök és járművek aktuális helyadatainak továbbítását segíti.

A rendszer helyes használatának alaplépései:

1. A felhasználó rendelkezzen aktív fiókkal.
2. A megfelelő eszközön indítsa el a megfelelő alkalmazást.
3. Jelentkezzen be email címmel és jelszóval.
4. Csak valós és ellenőrzött adatokat rögzítsen.
5. Hibajelzés esetén olvassa el az üzenetet, és kövesse a dokumentációban leírt teendőket.
6. Munka végeztével jelentkezzen ki, különösen közös eszközön.

Ez a dokumentáció a vizsgakövetelmény szerinti felhasználói dokumentáció fejezet alapjaként használható, mert bemutatja a program célját, a szükséges eszközöket, a telepítést és indítást, a részletes használatot, a hibajelzések magyarázatát és az információkérés lehetőségeit mindhárom alkalmazásra vonatkozóan.
