from pywinauto import Application
import time


app_path = r"C:\Users\bobanpetrik\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"
app = Application(backend="uia").start(app_path)


form = app.window(title="Bejelentkezés")
form.wait('visible', timeout=5)


form.child_window(auto_id="txbusername", control_type="Edit").set_text("placehlder@demo.hu")
form.child_window(auto_id="txbpass", control_type="Edit").set_text("demo_hash")
form.child_window(auto_id="btnlogin", control_type="Button").click()


time.sleep(1)

try:
    fomenu = app.window(auto_id="userinterface")
    fomenu.wait('visible', timeout=5)
    fomenu.child_window(auto_id="btnlogout", control_type="Button").click()
    print("Sikeres bejelentkezés!")
    time.sleep(1)
    app.kill()

except:
    print("A főmenü nem jelent meg. Hiba a login során.")
    app.kill()










