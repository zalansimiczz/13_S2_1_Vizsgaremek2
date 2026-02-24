from pywinauto import Application
import time

app_path = r"C:\Users\boban\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"


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
fomenu.child_window(auto_id="btnsofor", control_type="Button").click()

try:
    soforkezeles = app.window(auto_id="soforkezeles")
    soforkezeles.wait("visible", timeout=5)
    soforkezeles.child_window(auto_id="btnhozzaadas", control_type="Button").click()
    soforkezeles.child_window(auto_id="txbnev", control_type="Edit").set_text("teszt")
    soforkezeles.child_window(auto_id="txbszul", control_type="Edit").set_text("1111 11 1")
    soforkezeles.child_window(auto_id="txbszemazon", control_type="Edit").set_text("teszt")
    soforkezeles.child_window(auto_id="txbtelszam", control_type="Edit").set_text("teszt")
    soforkezeles.child_window(auto_id="txbcim", control_type="Edit").set_text("teszt")
    soforkezeles.child_window(auto_id="txbadoszam", control_type="Edit").set_text("teszt")

    combo = soforkezeles.child_window(auto_id="cbbaktiv", control_type="ComboBox")
    combo.wait("visible enabled", timeout=3)
    combo.expand()
    combo.type_keys("{DOWN}")
    combo.type_keys("{ENTER}")
    combo.collapse()


    soforkezeles.child_window(auto_id="btnmentes", control_type="Button").click()

    time.sleep(1)


    soforkezeles.child_window(auto_id="btnvissza", control_type="Button").click()
    fomenu.child_window(auto_id="btnsofor", control_type="Button").click()

    soforkezeles.wait("visible", timeout=5)


    if  soforkezeles.child_window(auto_id="txbnev", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  soforkezeles.child_window(auto_id="txbszul", control_type="Edit") == "1111 11 1":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  soforkezeles.child_window(auto_id="txbszemazon", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  soforkezeles.child_window(auto_id="txbtelszam", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  soforkezeles.child_window(auto_id="txbcim", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")
    if  soforkezeles.child_window(auto_id="txbadoszam", control_type="Edit") == "teszt":
        print("Sikeresen Hozzáadva. Sikeres teszt.")
    else:
        print("Nem lett hozzáadva. Hiba mentés során.")

except Exception as e:
    print("Hiba a teszt futtatása során:", e)

finally:
    soforkezeles = app.window(auto_id="soforkezeles")
    combo = soforkezeles.child_window(auto_id="cbbsoforlista", control_type="ComboBox")
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


        other_value = soforkezeles.child_window(auto_id="txbnev", control_type="Edit").get_value()
        combo.collapse()
        time.sleep(0.5)
        if combo.selected_text() == "teszt":
            soforkezeles.child_window(auto_id="btntorles", control_type="Button").click()
            print("Eredeti érték visszaállítva.")



    app.kill()