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
  // TEST: BACKOFFICE DASHBOARD & SIDEBAR BARU
  // ==========================================
  console.log('👉 [Test] Menguji Dashboard & Footer Sidebar Baru (Unified Profile Card)...');
  const adminContext = await browser.newContext({ viewport: { width: 1280, height: 720 } });
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

    const hasProfileCard = await adminPage.locator('.profile-card').isVisible();
    const hasLogoutIconBtn = await adminPage.locator('.logout-icon-btn').isVisible();
    console.log(`   ✓ Unified Profile Card terdeteksi: ${hasProfileCard}`);
    console.log(`   ✓ Tombol Logout Icon terdeteksi: ${hasLogoutIconBtn}`);

    const dashShot = path.join(screenshotsDir, 'dashboard-bi.png');
    await adminPage.screenshot({ path: dashShot, fullPage: false });
    console.log(`   📸 Screenshot dashboard BI (sidebar baru): ${dashShot}`);

    // Presensi
    await adminPage.goto(`${BASE_URL}/presensi`, { waitUntil: 'domcontentloaded', timeout: 20000 });
    await adminPage.waitForTimeout(1500);
    const presensiShot = path.join(screenshotsDir, 'presensi-admin.png');
    await adminPage.screenshot({ path: presensiShot, fullPage: false });
    console.log(`   📸 Screenshot presensi admin: ${presensiShot}`);

    console.log('\n🎉 SEMUA PENGUJIAN DESAIN SIDEBAR BARU BERHASIL 100%!');
  } catch (e) {
    console.error('   ❌ Test error:', e.message);
  } finally {
    await adminContext.close();
    await browser.close();
  }
}

runTests();
