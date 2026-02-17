from pywinauto import Application
import unittest
import time

APP_PATH = r"C:\Users\boban\Documents\GitHub\13_S2_1_Vizsgaremek2\projekt\Asztali alkalmazás\TollÚtdíj\bin\Debug\TollÚtdíj.exe"

class SmokeTest(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        cls.app = Application(backend="uia").start(APP_PATH)
        time.sleep(2)

    def test_login(self):
        login = self.app.window(title_re=".*Bejelentkezes.*")
        self.assertTrue(login.exists(), "Nem találom a login ablakot")

    @classmethod
    def tearDownClass(cls):
        cls.app.kill()

if __name__ == "__main__":
    unittest.main()
