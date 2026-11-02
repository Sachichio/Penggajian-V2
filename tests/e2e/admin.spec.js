import { test, expect } from '@playwright/test';

test.describe('Backoffice Admin & Executive Dashboard Tests', () => {
  test('login as admin and verify dashboard analytics', async ({ page }) => {
    // 1. Kunjungi halaman login
    await page.goto('/login');

    // 2. Isi kredensial admin
    await page.fill('input[name="email"]', 'admin@gmail.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');

    // 3. Pastikan dialihkan ke dashboard
    await expect(page).toHaveURL(/.*dashboard/);
    await expect(page.locator('h1')).toContainText('Semua lebih mudah');

    // 4. Verifikasi elemen Chart.js terpasang
    await expect(page.locator('#payrollTrendChart')).toBeVisible();
    await expect(page.locator('#departmentChart')).toBeVisible();

    // 5. Tangkap screenshot dashboard BI
    await page.waitForTimeout(1000);
    await page.screenshot({ path: 'tests/e2e/screenshots/dashboard-bi.png', fullPage: true });

    // 6. Kunjungi halaman manajemen Presensi & Cuti
    await page.goto('/presensi');
    await expect(page.locator('h1')).toContainText('Presensi & Pengajuan Izin');
    await page.screenshot({ path: 'tests/e2e/screenshots/presensi-admin.png', fullPage: true });
  });
});
