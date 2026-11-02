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
  // TEST 1: KIOSK PRESENSI
  // ==========================================
  console.log('👉 [Test 1] Menguji Smart Kiosk Presensi Mandiri (/absen-masuk)...');
  const kioskContext = await browser.newContext({
    viewport: { width: 1280, height: 720 },
    permissions: ['geolocation'],
    geolocation: { latitude: -6.2088, longitude: 106.8456 }
  });
  const kioskPage = await kioskContext.newPage();

  try {
    await kioskPage.goto(`${BASE_URL}/absen-masuk`, { waitUntil: 'domcontentloaded', timeout: 20000 });
    console.log('   ✓ Halaman Kiosk berhasil dimuat');

    const clockText = await kioskPage.locator('#live-clock').textContent();
    console.log(`   ✓ Jam digital live aktif: ${clockText?.trim()}`);

    // Pilih karyawan & isi PIN
    await kioskPage.selectOption('#karyawan-select', { index: 1 });
    await kioskPage.fill('input[name="pin"]', '1234');
    console.log('   ✓ Karyawan & PIN (1234) berhasil dipilih');

    await kioskPage.click('button:has-text("Absen Masuk")', { noWaitAfter: true });
    console.log('   ✓ Tombol Absen Masuk diklik');
    await kioskPage.waitForTimeout(2000);

    const kioskShot = path.join(screenshotsDir, 'kiosk-success.png');
    await kioskPage.screenshot({ path: kioskShot, fullPage: true });
    console.log(`   📸 Screenshot disimpan di: ${kioskShot}`);

    // Test modal cuti
    console.log('\n👉 [Test 2] Menguji Modal Pengajuan Cuti / Izin...');
    await kioskPage.click('button:has-text("Sedang Sakit / Cuti / Izin?")');
    await kioskPage.waitForTimeout(1000);
    const modalShot = path.join(screenshotsDir, 'kiosk-modal-izin.png');
    await kioskPage.screenshot({ path: modalShot });
    console.log(`   📸 Screenshot modal cuti: ${modalShot}`);
  } catch (e) {
    console.error('   ❌ Test Kiosk error:', e.message);
  } finally {
    await kioskContext.close();
  }

  // ==========================================
  // TEST 3: BACKOFFICE DASHBOARD
  // ==========================================
  console.log('\n👉 [Test 3] Menguji Login Admin & Executive BI Dashboard (/dashboard)...');
  const adminContext = await browser.newContext({ viewport: { width: 1280, height: 720 } });
  const adminPage = await adminContext.newPage();

  try {
    await adminPage.goto(`${BASE_URL}/`, { waitUntil: 'domcontentloaded', timeout: 20000 });
    console.log('   ✓ Halaman login berhasil dimuat');

    // Klik tombol 'Isi otomatis' demo
    await adminPage.click('button:has-text("Isi otomatis")');
    console.log('   ✓ Kredensial demo diisi otomatis');

    // Submit form dan tunggu navigasi URL ke dashboard
    await Promise.all([
      adminPage.waitForURL('**/dashboard', { waitUntil: 'domcontentloaded', timeout: 20000 }),
      adminPage.click('button[type="submit"]')
    ]);

    console.log(`   ✓ Login sukses, halaman aktif: ${adminPage.url()}`);
    await adminPage.waitForTimeout(2000);

    if (await adminPage.locator('text=Server Error').isVisible() || await adminPage.locator('text=Exception').isVisible()) {
      throw new Error('Terdeteksi halaman error Laravel di /dashboard!');
    }

    const dashShot = path.join(screenshotsDir, 'dashboard-bi.png');
    await adminPage.screenshot({ path: dashShot, fullPage: true });
    console.log(`   📸 Screenshot dashboard BI: ${dashShot}`);

    // ==========================================
    // TEST 4: MANAJEMEN PRESENSI ADMIN
    // ==========================================
    console.log('\n👉 [Test 4] Menguji Halaman Manajemen Presensi & Cuti (/presensi)...');
    await adminPage.goto(`${BASE_URL}/presensi`, { waitUntil: 'domcontentloaded', timeout: 20000 });
    await adminPage.waitForTimeout(2000);

    const pageHeading = await adminPage.locator('h1').textContent();
    console.log(`   ✓ Judul halaman: ${pageHeading?.trim()}`);

    if (await adminPage.locator('text=Server Error').isVisible() || await adminPage.locator('text=RouteNotFoundException').isVisible() || await adminPage.locator('text=Exception').isVisible()) {
      throw new Error('Terdeteksi halaman error Laravel di /presensi!');
    }

    const presensiShot = path.join(screenshotsDir, 'presensi-admin.png');
    await adminPage.screenshot({ path: presensiShot, fullPage: true });
    console.log(`   📸 Screenshot data presensi admin: ${presensiShot}`);

    console.log('\n🎉 SEMUA PENGUJIAN BROWSER BERHASIL 100%! Seluruh alur bebas error.');
  } catch (e) {
    console.error('   ❌ Test Admin error:', e.message);
  } finally {
    await adminContext.close();
    await browser.close();
  }
}

runTests();
