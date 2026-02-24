from pywinauto import Application
import time

app_path = r"C:\Users\bobanpetrik\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"


app = Application(backend="uia").start(app_path)

# LOGIN
form = app.window(title="Bejelentkezés")
form.wait("visible", timeout=5)

form.child_window(auto_id="txbusername", control_type="Edit").set_text("placeholder@demo.hu")
form.child_window(auto_id="txbpass", control_type="Edit").set_text("demo_hash")
form.child_window(auto_id="btnlogin", control_type="Button").click()


try:
    fomenu = app.window(auto_id="userinterface")
    fomenu.wait("visible", timeout=5)
    print("Sikeres bejelentkezés!")
except:
    print("A főmenü nem jelent meg. Hiba a bejelentkezés során.")
    app.kill()
    raise SystemExit

# CÉGKEZELÉS
fomenu.child_window(auto_id="btnjarmukez", control_type="Button").click()

try:
    jarmukezeles = app.window(auto_id="jarmukezeles")
    jarmukezeles.wait("visible", timeout=5)
    jarmukezeles.child_window(auto_id="btnhozzaadas", control_type="Button").click()
    jarmukezeles.child_window(auto_id="txbrendszam", control_type="Edit").set_text("teszt")
    jarmukezeles.child_window(auto_id="txbtipus", control_type="Edit").set_text("teszt")
    jarmukezeles.child_window(auto_id="txbkategoria", control_type="Edit").set_text("teszt")
    jarmukezeles.child_window(auto_id="txbtomeg", control_type="Edit").set_text("1111")
    jarmukezeles.child_window(auto_id="txbmarka", control_type="Edit").set_text("teszt")
    jarmukezeles.child_window(auto_id="txbtengely", control_type="Edit").set_text("2222")
    jarmukezeles.child_window(auto_id="txbvin", control_type="Edit").set_text("teszt")
    combo = jarmukezeles.child_window(auto_id="cbbeuro", control_type="ComboBox")
    combo.wait("visible enabled", timeout=3)
    combo.expand()
    combo.type_keys("{DOWN}")
    combo.type_keys("{ENTER}")
    combo.collapse()


    jarmukezeles.child_window(auto_id="btnmentes", control_type="Button").click()

    time.sleep(1)


    jarmukezeles.child_window(auto_id="btnvissza", control_type="Button").click()
    fomenu.child_window(auto_id="btnjarmukez", control_type="Button").click()

    jarmukezeles.wait("visible", timeout=5)


    if  jarmukezeles.child_window(auto_id="txbrendszam", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  jarmukezeles.child_window(auto_id="txbtipus", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  jarmukezeles.child_window(auto_id="txbtomeg", control_type="Edit") == "1111":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  jarmukezeles.child_window(auto_id="txbmarka", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  jarmukezeles.child_window(auto_id="txbtengely", control_type="Edit") == "2222":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  jarmukezeles.child_window(auto_id="txbvin", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")

except Exception as e:
    print("Hiba a teszt futtatása során:", e)

finally:
    jarmukezeles = app.window(auto_id="jarmukezeles")
    combo = jarmukezeles.child_window(auto_id="cbbjarmulista", control_type="ComboBox")
    combo.wait("visible enabled", timeout=5)

    combo.expand()
    time.sleep(1)
    count = combo.item_count()
    print("Jelenlegi tartalom számban:", count)
    combo.collapse()
    for i in range(0, count, 1):
        combo.expand()
        time.sleep(0.5)
        for _ in range(i):
            combo.type_keys("{DOWN}")
        combo.type_keys("{ENTER}")
        print(f"Kiválasztott elem index: {i}, szöveg: {combo.selected_text()}")


        other_value = jarmukezeles.child_window(auto_id="txbrendszam", control_type="Edit").get_value()
        combo.collapse()
        time.sleep(0.5)
        if combo.selected_text() == "teszt":
            jarmukezeles.child_window(auto_id="btntorles", control_type="Button").click()
            print("Eredeti érték visszaállítva.")
        else:
            print("Hiba törléskor")

    app.kill()