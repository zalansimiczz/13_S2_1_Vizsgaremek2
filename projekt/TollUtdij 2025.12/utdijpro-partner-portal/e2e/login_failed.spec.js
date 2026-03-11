import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/partner/login');
  await page.getByRole('textbox', { name: 'Email cím' }).click();
  await page.getByRole('textbox', { name: 'Email cím' }).fill('zalansimiczhibas@gmail.com');
  await page.getByRole('textbox', { name: 'Jelszó' }).click();
  await page.getByRole('textbox', { name: 'Jelszó' }).fill('1234567');
  await page.getByRole('button', { name: ' Bejelentkezés' }).click();
  await page.locator('div').nth(2).click();
  await page.getByText('Hibás email cím vagy jelszó,').click();
});