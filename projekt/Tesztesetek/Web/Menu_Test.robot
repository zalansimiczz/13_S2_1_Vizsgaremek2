*** Settings ***
Library           SeleniumLibrary

*** Test Cases ***
Utdij
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=openCalculator    timeout=10s
    Click Element    id=openCalculator
    Sleep    5s
    Close Browser

Alkalmazottak
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=alkalmazottak    timeout=10s
    Click Element    id=alkalmazottak
    Sleep    5s
    Close Browser

Soforok
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=soforok    timeout=10s
    Click Element    id=soforok
    Sleep    5s
    Close Browser

Flotta
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=flotta    timeout=10s
    Click Element    id=flotta
    Sleep    5s
    Close Browser

Riportok
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=riportok    timeout=10s
    Click Element    id=riportok
    Sleep    5s
    Close Browser

Beallitasok
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Input Text    xpath=//input[@name="email"]    zalansimicz@gmail.com
    Input Text    xpath=//input[@name="password"]    12345678
    Click Button    xpath=//button[contains(., "Bejelentkezés")]
    Wait Until Element Is Visible    id=beallitasok    timeout=10s
    Click Element    id=beallitasok
    Sleep    5s
    Close Browser
