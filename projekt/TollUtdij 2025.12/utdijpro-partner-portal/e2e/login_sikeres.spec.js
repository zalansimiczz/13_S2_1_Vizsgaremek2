import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/partner/login');
  await page.getByRole('textbox', { name: 'Email cím' }).click();
  await page.getByRole('textbox', { name: 'Email cím' }).fill('zalansimicz@gmail.com');
  await page.getByRole('textbox', { name: 'Jelszó' }).click();
  await page.getByRole('textbox', { name: 'Jelszó' }).fill('12345678');
  await page.getByRole('button', { name: ' Bejelentkezés' }).click();
});