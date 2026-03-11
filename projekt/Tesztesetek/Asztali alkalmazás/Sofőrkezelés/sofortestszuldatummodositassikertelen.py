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

    textbox = soforkezeles.child_window(auto_id="txbszul", control_type="Edit")
    textbox.wait("visible", timeout=5)

    original_text = textbox.get_value()
    print("Eredeti szöveg:", original_text)


    textbox.set_text("teszt")
    soforkezeles.child_window(auto_id="btnmentes", control_type="Button").click()

    time.sleep(1)


    error_label = soforkezeles.child_window(auto_id="lblhibas", control_type="Text")
    error_label.wait("visible", timeout=5)
    error_text = error_label.window_text()
    if error_text == "Hibás születési dátum formátum.\r\nHasználja a következő formátumot: ÉÉÉÉ MM DD":
        print("Az elem nem került módosításra. Sikeres teszt")
    else:
        print(f"Nem várt hibaüzenet: {error_text}")





except Exception as e:
    print("Hiba a teszt futtatása során:", e)

finally:
    textbox.set_text(original_text)
    soforkezeles.child_window(auto_id="btnmentes", control_type="Button").click()
    time.sleep(1)
    print("Eredeti érték visszaállítva.")
    app.kill()