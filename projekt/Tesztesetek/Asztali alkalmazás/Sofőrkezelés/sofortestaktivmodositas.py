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
fomenu.child_window(auto_id="btnsofor", control_type="Button").click()

try:
    soforkezeles = app.window(auto_id="soforkezeles")
    soforkezeles.wait("visible", timeout=5)

    textbox = soforkezeles.child_window(auto_id="txbnev", control_type="Edit")

    original_text = textbox.get_value()
    print("Inaktiválandó sofőr neve:", original_text)
    combo = soforkezeles.child_window(auto_id="cbbaktiv", control_type="ComboBox")
    combo.wait("visible enabled", timeout=5)
    original_value = combo.selected_text()
    combo.expand()
    combo.type_keys("{DOWN}")
    combo.type_keys("{ENTER}")
    combo.collapse()
    soforkezeles.child_window(auto_id="btnmentes", control_type="Button").click()
    time.sleep(1)
    soforkezeles.child_window(auto_id="btnvissza", control_type="Button").click()
    fomenu.child_window(auto_id="btnsofor", control_type="Button").click()
    new_value = combo.selected_text()

    if new_value == original_value:
        print("nem került inaktiválásra a sofőr. Sikertelen teszt.")
    else:
        print("Sofőr sikeresen inaktiválva. Sikeres teszt.")

except Exception as e:
    print("Hiba a teszt futtatása során:", e)

finally:
    soforkezeles = app.window(auto_id="soforkezeles")
    combo = soforkezeles.child_window(auto_id="cbbaktiv", control_type="ComboBox")
    combo.wait("visible enabled", timeout=5)
    original_value = combo.selected_text()
    combo.expand()
    combo.type_keys("{UP}")
    combo.type_keys("{ENTER}")
    combo.collapse()
    soforkezeles.child_window(auto_id="btnmentes", control_type="Button").click()
    print("Eredeti érték visszaállítva.")
    app.kill()