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
fomenu.child_window(auto_id="btnjarmukez", control_type="Button").click()

try:
    jarmukezeles = app.window(auto_id="jarmukezeles")
    jarmukezeles.wait("visible", timeout=5)

    textbox = jarmukezeles.child_window(auto_id="txbkategoria", control_type="Edit")
    textbox.wait("visible", timeout=5)

    original_text = textbox.get_value()
    print("Eredeti szöveg:", original_text)


    textbox.set_text("teszt")
    jarmukezeles.child_window(auto_id="btnmentes", control_type="Button").click()

    time.sleep(1)


    jarmukezeles.child_window(auto_id="btnvissza", control_type="Button").click()
    fomenu.child_window(auto_id="btnjarmukez", control_type="Button").click()

    jarmukezeles.wait("visible", timeout=5)
    textbox = jarmukezeles.child_window(auto_id="txbkategoria", control_type="Edit")

    new_text = textbox.get_value()

    if new_text == "teszt":
        print("Sikeresen módosítva. Sikeres teszt.")
    else:
        print("Nem módosult. Hiba mentés során.")

except Exception as e:
    print("Hiba a teszt futtatása során:", e)

finally:
    textbox.set_text(original_text)
    jarmukezeles.child_window(auto_id="btnmentes", control_type="Button").click()
    time.sleep(1)
    print("Eredeti érték visszaállítva.")
    app.kill()