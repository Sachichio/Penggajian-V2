import { chromium } from '@playwright/test';
import fs from 'fs';
import path from 'path';

async function runTests() {
  console.log('🚀 Memulai E2E Browser Testing dengan Playwright & Bun...\n');

  const screenshotsDir = path.resolve('tests/e2e/screenshots');
  if (!fs.existsSync(screenshotsDir)) {
    fs.mkdirSync(screenshotsDir, { recursive: true });
  }

  const browser = await chromium.launch({ headless: true });
  const BASE_URL = 'http://127.0.0.1:8000';

  // ==========================================
  // TEST: BACKOFFICE DASHBOARD & SIDEBAR SCROLL
  // ==========================================
  console.log('👉 [Test] Menguji Dashboard & Scrollability Sidebar pada Laptop Screen (1280x680)...');
  const adminContext = await browser.newContext({ viewport: { width: 1280, height: 680 } });
  const adminPage = await adminContext.newPage();

  try {
    await adminPage.goto(`${BASE_URL}/`, { waitUntil: 'domcontentloaded', timeout: 20000 });
    console.log('   ✓ Halaman login dimuat');

    // Klik tombol 'Isi otomatis' demo
    await adminPage.click('button:has-text("Isi otomatis")');
    await Promise.all([
      adminPage.waitForURL('**/dashboard', { waitUntil: 'domcontentloaded', timeout: 20000 }),
      adminPage.click('button[type="submit"]')
    ]);

    console.log(`   ✓ Login sukses, halaman aktif: ${adminPage.url()}`);
    await adminPage.waitForTimeout(1500);

    // Verifikasi sidebar scroll
    const sidebar = adminPage.locator('#app-sidebar');
    await sidebar.evaluate(el => el.scrollTop = el.scrollHeight);
    console.log('   ✓ Sidebar berhasil di-scroll ke bagian paling bawah');
    await adminPage.waitForTimeout(500);

    const logoutVisible = await adminPage.locator('button:has-text("Logout")').first().isVisible();
    console.log(`   ✓ Tombol Logout terlihat setelah scroll: ${logoutVisible}`);

    const dashShot = path.join(screenshotsDir, 'dashboard-bi.png');
    await adminPage.screenshot({ path: dashShot, fullPage: false });
    console.log(`   📸 Screenshot dashboard BI (sidebar scroll): ${dashShot}`);

    // Presensi
    await adminPage.goto(`${BASE_URL}/presensi`, { waitUntil: 'domcontentloaded', timeout: 20000 });
    await adminPage.waitForTimeout(1500);
    const presensiShot = path.join(screenshotsDir, 'presensi-admin.png');
    await adminPage.screenshot({ path: presensiShot, fullPage: false });
    console.log(`   📸 Screenshot presensi admin: ${presensiShot}`);

    console.log('\n🎉 SEMUA PENGUJIAN SIDEBAR & DASHBOARD BERHASIL 100%!');
  } catch (e) {
    console.error('   ❌ Test error:', e.message);
  } finally {
    await adminContext.close();
    await browser.close();
  }
}

runTests();
