from pywinauto import Application
import time


app_path = r"C:\Users\boban\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"  # ide írd az exe elérési útját
app = Application(backend="uia").start(app_path)


dlg = app.top_window()
dlg.wait('visible', timeout=20)


username_box = dlg.child_window(auto_id="txbusername", control_type="Edit")
password_box = dlg.child_window(auto_id="txbpass", control_type="Edit")
login_button = dlg.child_window(auto_id="btnlogin", control_type="Button")
remember_me = dlg.child_window(auto_id="chkrememberme", control_type="CheckBox")

username_box.set_text("placeholder@demo.hu")
password_box.set_text("demo_hash")



login_button.click()


time.sleep(3)

try:
    main_ui = app.top_window()
    main_ui.wait('visible', timeout=10)
    print("Sikeres bejelentkezés!")
except:
    print("A fő UI nem jelent meg. Hiba a login során.")

app.kill()
