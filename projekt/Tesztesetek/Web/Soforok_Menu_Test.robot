*** Settings ***
Library           SeleniumLibrary

*** Test Cases ***
Uj sofor hozzaadas
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=soforok    timeout=10s
    Click Element    id=soforok
    Click Button    xpath=//button[contains(., "Új sofőr")]
    Wait Until Element Is Visible    id=driverForm    timeout=5s
    Sleep    0.5s
    Select From List By Label    id=driverActive    Igen
    ${fields}=    Get WebElements    xpath=//form[@id="driverForm"]//input[@type="text"]
    Input Text    ${fields}[0]    Teszt Elek1
    Input Text    ${fields}[1]    224195ME
    Input Text    ${fields}[2]    +36300803236
    Input Text    ${fields}[3]    6760 Kistelek, Tisza utca 11.
    Input Text    ${fields}[4]    12345678-1-26
    Execute JavaScript    document.querySelector('#driverBirthDate').value = '2000-01-01'
    Click Button    xpath=//button[contains(., "Mentés")]
    Wait Until Page Contains    Teszt Elek1    timeout=5s
    Close Browser

Sofor inaktivalasa
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=soforok    timeout=10s
    Click Element    id=soforok
    Click Element    xpath=//tr[td[contains(.,'Jani Király')]]//button[@title='Státusz váltása']
    Wait Until Page Contains    Inaktív    timeout=5s
    Close Browser

Sofor aktivalasa
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=soforok    timeout=10s
    Click Element    id=soforok
    Click Element    xpath=//tr[td[contains(.,'Jani Király')]]//button[@title='Státusz váltása']
    Wait Until Page Contains    Aktív    timeout=5s
    Close Browser

Sofor nev modositasa
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=soforok    timeout=10s
    Click Element    id=soforok
    Click Element    xpath=//tr[td[contains(.,'Jani Király')]]//button[@title='Szerkesztés']
    ${fields}=    Get WebElements    xpath=//form[@id="driverForm"]//input[@type="text"]
    Input Text    ${fields}[0]    Jani Nem Kiraly
    Click Button    xpath=//button[contains(., "Mentés")]
    Wait Until Page Contains    Jani Nem Kiraly    timeout=5s
    Close Browser

Sofor torlese
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=soforok    timeout=10s
    Click Element    id=soforok
    Click Element    xpath=//tr[td[contains(.,'Jani a Boss Apja')]]//button[@title='Törlés']
    Handle Alert    ACCEPT
    Wait Until Page Does Not Contain    Jani a Boss Apja    timeout=5s
    Close Browser
