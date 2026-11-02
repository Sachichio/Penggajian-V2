import { test, expect } from '@playwright/test';

test.describe('Smart Kiosk Attendance E2E Tests', () => {
  test('kiosk page loads and allows check-in attempt', async ({ page }) => {
    // 1. Kunjungi halaman kiosk
    await page.goto('/absen-masuk');

    // 2. Pastikan elemen brand dan form ada
    await expect(page.locator('text=Terminal Presensi')).toBeVisible();
    await expect(page.locator('#live-clock')).toBeVisible();

    // 3. Masukkan NIK DONO (CN-001) dan PIN 1234
    await page.fill('#nik', 'CN-001');
    await page.fill('#pin', '1234');

    // 4. Klik tombol Check In
    const checkInBtn = page.locator('#btn-checkin');
    await expect(checkInBtn).toBeVisible();
    await checkInBtn.click();

    // 5. Tangkap screenshot
    await page.waitForTimeout(1500);
    await page.screenshot({ path: 'tests/e2e/screenshots/kiosk-checkin.png', fullPage: true });

    // 6. Test modal Pengajuan Cuti / Izin
    const modalTrigger = page.locator('button:has-text("Ajukan Cuti / Sakit")');
    await expect(modalTrigger).toBeVisible();
    await modalTrigger.click();

    // Pastikan modal muncul
    await expect(page.locator('#modal-izin')).not.toHaveClass(/hidden/);
    await page.screenshot({ path: 'tests/e2e/screenshots/kiosk-modal-izin.png', fullPage: false });
  });
});
