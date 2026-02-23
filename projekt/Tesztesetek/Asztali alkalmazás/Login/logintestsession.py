from pywinauto import Application
import time


app_path = r"C:\Users\boban\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"
app = Application(backend="uia").start(app_path)


form = app.window(title="Bejelentkezés")
form.wait('visible', timeout=5)


form.child_window(auto_id="txbusername", control_type="Edit").set_text("placeholder@demo.hu")
form.child_window(auto_id="txbpass", control_type="Edit").set_text("demo_hash")
form.child_window(auto_id="chkrememberme", control_type="CheckBox").toggle()
form.child_window(auto_id="btnlogin", control_type="Button").click()
time.sleep(1)

try:
    fomenu = app.window(auto_id="userinterface")
    fomenu.wait('visible', timeout=5)
    app.kill()
    print("Sikeres bejelentkezés Session használatával!")
    time.sleep(1)
    app = Application(backend="uia").start(app_path)

    fomenu = app.window(auto_id="userinterface")
    fomenu.wait('visible', timeout=5)
    fomenu.child_window(auto_id="btnlogout", control_type="Button").click()
    app.kill()
except:
    print("A főmenü nem jelent meg. Hiba a session használata során.")
    app.kill()










