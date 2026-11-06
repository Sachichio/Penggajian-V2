import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
console.log('🚀 Starting E2E Verification: Global Master Footer & Dynamic Identity Across All Menus...');

const browser = await chromium.launch({ headless: true });
const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const page = await ctx.newPage();
page.setDefaultTimeout(60000);
page.setDefaultNavigationTimeout(60000);

// 1. Login via Demo Auto-Fill
console.log('\n--- 1. Login via Auto-Fill (Admin Role) ---');
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
await page.locator('button:has-text("Isi otomatis")').click();

await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button[type="submit"]'),
]);

console.log(`Current URL: ${page.url()}`);
if (!page.url().endsWith('/dashboard')) {
    console.error('❌ FAILED: Login failed!');
    process.exit(1);
}
console.log('✅ PASSED: Admin logged in to /dashboard!');

// 2. Change Company Name to "PT. Indonesia Raya"
console.log('\n--- 2. Update Company Name to "PT. Indonesia Raya" ---');
await page.goto(`${BASE}/pengaturan-perusahaan`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="nama_perusahaan"]', 'PT. Indonesia Raya');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button:has-text("Simpan Perubahan Profil")')
]);
console.log('✅ PASSED: Company profile updated to "PT. Indonesia Raya"!');

// 3. Verify Global Footer on 5 Different Menus
const testRoutes = [
    { name: 'Dashboard', path: '/dashboard' },
    { name: 'Data Karyawan', path: '/karyawan' },
    { name: 'Data Jabatan', path: '/jabatan' },
    { name: 'Penggajian', path: '/penggajian' },
    { name: 'Profil Perusahaan', path: '/pengaturan-perusahaan' }
];

console.log('\n--- 3. Verifying Global Footer Across All 5 Menus ---');
for (const r of testRoutes) {
    await page.goto(`${BASE}${r.path}`, { waitUntil: 'domcontentloaded' });
    const footer = page.locator('.main-footer');
    const isVisible = await footer.isVisible();
    const footerText = await footer.innerText();

    console.log(`Menu [${r.name}] -> Footer Visible: ${isVisible}, Content: "${footerText.replace(/\s+/g, ' ').trim()}"`);
    
    if (!isVisible) {
        console.error(`❌ FAILED: .main-footer not visible on ${r.name} (${r.path})!`);
        process.exit(1);
    }

    if (!footerText.includes('PT. Indonesia Raya')) {
        console.error(`❌ FAILED: .main-footer on ${r.name} does NOT contain "PT. Indonesia Raya"!`);
        process.exit(1);
    }

    if (!footerText.includes('Sistem berjalan normal') || !footerText.includes('Made simple with gajiku.')) {
        console.error(`❌ FAILED: .main-footer on ${r.name} missing system normal text!`);
        process.exit(1);
    }

    console.log(`✅ PASSED: Footer on [${r.name}] contains "PT. Indonesia Raya" & "Sistem berjalan normal"!`);
}

// 4. Revert Company Name back to "PT. Sejahtera Bersama"
console.log('\n--- 4. Revert Company Name back to "PT. Sejahtera Bersama" ---');
await page.goto(`${BASE}/pengaturan-perusahaan`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="nama_perusahaan"]', 'PT. Sejahtera Bersama');
await page.click('button:has-text("Simpan Perubahan Profil")');
await page.waitForSelector('.main-footer:has-text("PT. Sejahtera Bersama")', { timeout: 90000 });

// Verify Dashboard reflects reverted name
await page.goto(`${BASE}/dashboard`, { waitUntil: 'domcontentloaded' });
const finalFooterText = await page.locator('.main-footer').innerText();
console.log(`Final Dashboard Footer: "${finalFooterText.replace(/\s+/g, ' ').trim()}"`);
if (!finalFooterText.includes('PT. Sejahtera Bersama')) {
    console.error('❌ FAILED: Dashboard footer does NOT reflect reverted "PT. Sejahtera Bersama"!');
    process.exit(1);
}
console.log('✅ PASSED: Cleanly reverted back to default seed!');

await browser.close();
console.log('\n🎉 ALL GLOBAL FOOTER VERIFICATION TESTS PASSED (100% SUCCESS)!');
process.exit(0);
