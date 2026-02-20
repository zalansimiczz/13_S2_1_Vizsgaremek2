*** Settings ***
Library           SeleniumLibrary

*** Test Cases ***
Login Sikeres
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Close Browser

Login sikertelen
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimiczhibas@gmail.com
    Input Text    xpath=//input[@name="password"]    1234567
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Page Contains    Hibás email cím vagy jelszó, vagy a felhasználó inaktív.    timeout=5s
    Location Should Contain    partner/login
    Close Browser
