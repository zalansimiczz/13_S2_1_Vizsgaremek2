from pywinauto import Application
import time
import subprocess

#subprocess.run(["TollÚtdíj.exe"])
app_path = r"C:\Users\boban\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"
app = Application(backend="uia").start(app_path)


form = app.window(title="Bejelentkezés")
form.wait('visible', timeout=5)


form.child_window(auto_id="txbusername", control_type="Edit").set_text("placeholder@demo.hu")
form.child_window(auto_id="txbpass", control_type="Edit").set_text("demo_hsh")
form.child_window(auto_id="btnlogin", control_type="Button").click()


time.sleep(1)

try:

    fomenu = app.window(auto_id="userinterface")
    fomenu.wait('visible', timeout=2)
    fomenu.child_window(auto_id="btnlogout", control_type="Button").click()
    print("Bejelentkezve Hibás adatokkal. Hiba a login során.")
    time.sleep(1)
    app.kill()

except:
    error_label = form.child_window(auto_id="lblhibas", control_type="Text")
    error_label.wait("visible", timeout=2)

    error_text = error_label.window_text()

    if error_text == "Kérjük, ellenőrizze a jelszavát\r\nés az E-mail címét, majd próbálja újra.":
        print("A főmenü nem jelent meg. Sikeres teszt")
    else:
        print(f"Nem várt hibaüzenet: {error_text}")

    app.kill()









