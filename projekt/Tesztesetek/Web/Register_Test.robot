*** Settings ***
Library           SeleniumLibrary

*** Test Cases ***
Regisztráció Sikeres
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Click Link    Regisztráljon partnerként
    Input Text    name=ceg_nev    Demo Kft 2026
    Input Text    name=adoszam    12345678-1-26
    Input Text    name=cim    6760 Kistelek, Tisza utca 11
    Input Text    name=teljes_nev    Simicz Zalán
    Input Text    name=email    ujteszt1234568@gmail.com
    Input Text    name=password    12345678
    Input Text    name=password_confirm    12345678
    Click Button    xpath=//button[contains(., "Regisztráció")]
    Wait Until Location Contains    verify    timeout=10s
    Close Browser

Regisztráció Sikertelen
    Open Browser    http://127.0.0.1:8000/partner/login    Chrome
    Maximize Browser Window
    Click Link    Regisztráljon partnerként
    Input Text    name=ceg_nev    Demo Kft 2026
    Input Text    name=adoszam    12345678-1-26
    Input Text    name=cim    6760 Kistelek, Tisza utca 11
    Input Text    name=teljes_nev    Simicz Zalán
    Input Text    name=email    ujteszt1234568@gmail.com
    Input Text    name=password    1234567
    Input Text    name=password_confirm    12345677
    Click Button    xpath=//button[contains(., "Regisztráció")]
    Wait Until Page Contains    The password field must be at least 8 characters.    timeout=5s
    Location Should Contain    partner/register
    Close Browser
