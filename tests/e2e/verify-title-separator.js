import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
console.log('🚀 Starting E2E Verification: Browser Title Separator (-) & No Double Suffix Across All Menus...');

const browser = await chromium.launch({ headless: true });
const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const page = await ctx.newPage();
page.setDefaultTimeout(60000);
page.setDefaultNavigationTimeout(60000);

// 1. Verify Login Title
console.log('\n--- 1. Checking Login Title ---');
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
const loginTitle = await page.title();
console.log(`Page [Login] Title: "${loginTitle}"`);

if (loginTitle.includes('—')) {
    console.error(`❌ FAILED: Login title still contains em-dash ("—")!`);
    process.exit(1);
}
if ((loginTitle.match(/gajiku\./g) || []).length > 1) {
    console.error(`❌ FAILED: Login title contains duplicate "gajiku."!`);
    process.exit(1);
}
if (loginTitle !== 'Masuk ke Akun - gajiku.') {
    console.error(`❌ FAILED: Unexpected login title: "${loginTitle}"`);
    process.exit(1);
}
console.log('✅ PASSED: Login title is clean and uses "-" separator!');

// 2. Login via Auto-Fill (Admin Role)
console.log('\n--- 2. Login via Auto-Fill (Admin Role) ---');
await page.locator('button:has-text("Isi otomatis")').click();
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button[type="submit"]'),
]);
console.log(`Current URL: ${page.url()}`);
if (!page.url().endsWith('/dashboard')) {
    console.error('❌ FAILED: Admin login failed!');
    process.exit(1);
}
console.log('✅ PASSED: Admin logged in to /dashboard!');

// 3. Check All Backoffice Menus
const testMenus = [
    { name: 'Dashboard', path: '/dashboard', expected: 'Dashboard - gajiku.' },
    { name: 'Profil Perusahaan', path: '/pengaturan-perusahaan', expected: 'Profil Perusahaan - gajiku.' },
    { name: 'Data Presensi & Perizinan', path: '/presensi', expected: 'Data Presensi & Perizinan - gajiku.' },
    { name: 'Data Karyawan', path: '/karyawan', expected: 'Data Karyawan - gajiku.' },
    { name: 'Data Jabatan', path: '/jabatan', expected: 'Data Jabatan - gajiku.' },
    { name: 'Data Penggajian', path: '/penggajian', expected: 'Data Penggajian - gajiku.' },
    { name: 'Slip Gaji', path: '/slip-gaji', expected: 'Slip Gaji - gajiku.' },
    { name: 'Laporan Penggajian', path: '/laporan', expected: 'Laporan Penggajian - gajiku.' },
    { name: 'Halaman 404', path: '/halaman-random-pasti-404', expected: 'Halaman Tidak Ditemukan - gajiku.' },
];

console.log('\n--- 3. Checking Backoffice Pages Titles ---');
for (const m of testMenus) {
    await page.goto(`${BASE}${m.path}`, { waitUntil: 'domcontentloaded' });
    const currentTitle = await page.title();
    console.log(`Menu [${m.name}] Title: "${currentTitle}"`);

    if (currentTitle.includes('—')) {
        console.error(`❌ FAILED: [${m.name}] title contains em-dash ("—")! Title: "${currentTitle}"`);
        process.exit(1);
    }
    const gajikuCount = (currentTitle.match(/gajiku\./g) || []).length;
    if (gajikuCount > 1) {
        console.error(`❌ FAILED: [${m.name}] title has DUPLICATE "gajiku." (${gajikuCount} times)! Title: "${currentTitle}"`);
        process.exit(1);
    }
    if (currentTitle !== m.expected) {
        console.error(`❌ FAILED: [${m.name}] expected "${m.expected}" but got "${currentTitle}"!`);
        process.exit(1);
    }
    console.log(`✅ PASSED: [${m.name}] title matches "${m.expected}"!`);
}

// 4. Check Kiosk Terminal Title
console.log('\n--- 4. Checking Kiosk Terminal Title ---');
await page.goto(`${BASE}/absen-masuk`, { waitUntil: 'domcontentloaded' });
const kioskTitle = await page.title();
console.log(`Page [Kiosk] Title: "${kioskTitle}"`);

if (kioskTitle.includes('—')) {
    console.error(`❌ FAILED: Kiosk title contains em-dash ("—")!`);
    process.exit(1);
}
if ((kioskTitle.match(/gajiku\./g) || []).length > 1) {
    console.error(`❌ FAILED: Kiosk title contains duplicate "gajiku."!`);
    process.exit(1);
}
if (kioskTitle !== 'Terminal Presensi Karyawan - gajiku.') {
    console.error(`❌ FAILED: Unexpected kiosk title: "${kioskTitle}"`);
    process.exit(1);
}
console.log('✅ PASSED: Kiosk title matches "Terminal Presensi Karyawan - gajiku."!');

await browser.close();
console.log('\n🎉 ALL BROWSER TITLE SEPARATOR & SUFFIX TESTS PASSED (100% SUCCESS)!');
process.exit(0);
