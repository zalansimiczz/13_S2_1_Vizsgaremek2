*** Settings ***
Library           SeleniumLibrary

*** Test Cases ***
Alkalmazott hozzaadasa sikeres
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=alkalmazottak    timeout=10s
    Click Element    id=alkalmazottak
    Input Text    name=full_name    Teszt Alkalmazott
    Input Text    xpath=//input[@name="email"]    tesztalkalmazott3@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Input Text    xpath=//input[@name="password_confirm"]    12345678
    Click Button    xpath=//button[contains(., "Alkalmazott létrehozása")]
    Wait Until Page Contains    Teszt Alkalmazott    timeout=5s
    Wait Until Page Contains    Az új felhasználó sikeresen hozzáadásra került.    timeout=5s
    Close Browser

Alkalmazott hozzaadasa sikertelen
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=alkalmazottak    timeout=10s
    Click Element    id=alkalmazottak
    Input Text    name=full_name    Teszt Alkalmazott
    Input Text    xpath=//input[@name="email"]    tesztalkalmazott@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Input Text    xpath=//input[@name="password_confirm"]    12345678
    Click Button    xpath=//button[contains(., "Alkalmazott létrehozása")]
    Wait Until Page Contains    Áttekintés    timeout=10s

Alkalmazott inaktivalas
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=alkalmazottak    timeout=10s
    Click Element    id=alkalmazottak
    Click Element    xpath=//tr[td[contains(.,'zalansimicz111@gmail.com')]]//button[contains(.,'Letiltás')]
    Wait Until Page Contains    Inaktív    timeout=5s
    Sleep    5s
    Close Browser

Alkalmazott aktivalas
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=alkalmazottak    timeout=10s
    Click Element    id=alkalmazottak
    Click Element    xpath=//tr[td[contains(.,'zalansimicz111@gmail.com')]]//button[contains(.,'Aktiválás')]
    Wait Until Page Contains    Aktív    timeout=5s
    Sleep    5s
    Close Browser
