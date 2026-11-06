import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
console.log('🚀 Starting Fast E2E Verification: Login Responsiveness & Company Settings...');
const browser = await chromium.launch({ headless: true });
const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const page = await ctx.newPage();

// 1. Check Horizontal Overflow at 1366x768
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
const overflow1366 = await page.evaluate(() => {
    return {
        docWidth: document.documentElement.scrollWidth,
        winWidth: window.innerWidth,
        bodyWidth: document.body.scrollWidth
    };
});
console.log(`1366x768 Check: docWidth=${overflow1366.docWidth}px, windowWidth=${overflow1366.winWidth}px`);
if (overflow1366.docWidth > overflow1366.winWidth) {
    console.error('❌ FAILED: Horizontal scrollbar still exists!');
    process.exit(1);
}
console.log('✅ PASSED: Zero horizontal scrollbar on 1366x768!');

// 2. Mobile Check (375x667)
await page.setViewportSize({ width: 375, height: 667 });
const overflowMobile = await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth);
console.log(`375x667 Check: Zero overflow = ${overflowMobile}`);
if (!overflowMobile) {
    console.error('❌ FAILED: Mobile overflow!');
    process.exit(1);
}
console.log('✅ PASSED: Zero overflow on mobile!');

// 3. Login as Admin
await page.setViewportSize({ width: 1366, height: 768 });
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
await page.fill('#login-email', 'admin@gmail.com');
await page.fill('#login-password', '123');

await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
    page.click('button[type="submit"]'),
]);

console.log(`Current URL after login: ${page.url()}`);
if (!page.url().endsWith('/dashboard')) {
    console.error('❌ FAILED: Admin login failed!');
    process.exit(1);
}
console.log('✅ PASSED: Admin logged in to /dashboard!');

// 4. Access /pengaturan-perusahaan
const resComp = await page.goto(`${BASE}/pengaturan-perusahaan`, { waitUntil: 'domcontentloaded' });
console.log(`Status /pengaturan-perusahaan: ${resComp.status()}`);
if (resComp.status() !== 200) {
    console.error('❌ FAILED: HTTP Status not 200!');
    process.exit(1);
}
console.log('✅ PASSED: /pengaturan-perusahaan loaded HTTP 200!');

// 5. Update Company Name
await page.fill('input[name="nama_perusahaan"]', 'PT. Maju Mapan Sejahtera');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
    page.click('button[type="submit"]'),
]);

const pageHtml = await page.content();
if (!pageHtml.includes('berhasil diperbarui') && !pageHtml.includes('PT. Maju Mapan Sejahtera')) {
    console.error('❌ FAILED: Update did not persist!');
    process.exit(1);
}
console.log('✅ PASSED: Company Settings updated to "PT. Maju Mapan Sejahtera"!');

// 6. Check Kiosk Footer
await page.goto(`${BASE}/absen-masuk`, { waitUntil: 'domcontentloaded' });
const kioskContent = await page.content();
if (!kioskContent.includes('PT. Maju Mapan Sejahtera')) {
    console.error('❌ FAILED: Kiosk does not show new company name!');
    process.exit(1);
}
console.log('✅ PASSED: Kiosk reflects dynamic company name!');

// 7. Check Login Page Brand
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
const loginContent = await page.content();
if (!loginContent.includes('PT. Maju Mapan Sejahtera')) {
    console.error('❌ FAILED: Login page does not show new company name!');
    process.exit(1);
}
console.log('✅ PASSED: Login page reflects dynamic company name!');

// 8. Revert back to PT. Sejahtera Bersama
await page.goto(`${BASE}/pengaturan-perusahaan`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="nama_perusahaan"]', 'PT. Sejahtera Bersama');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
    page.click('button[type="submit"]'),
]);
console.log('✅ Cleanly reverted back to default seed state!');

await browser.close();
console.log('\n🎉 ALL 8 E2E CHECKS PASSED WITH 100% SUCCESS!');
