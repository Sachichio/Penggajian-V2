import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
console.log('🚀 Starting E2E Verification: Workspace Switcher & Dynamic Company Identity...');

const browser = await chromium.launch({ headless: true });
const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const page = await ctx.newPage();
page.setDefaultTimeout(60000);
page.setDefaultNavigationTimeout(60000);

// 1. Login via Demo Auto-Fill (Role Admin)
console.log('\n--- 1. Login via Auto-Fill (Admin Role) ---');
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
const btnIsi = page.locator('button:has-text("Isi otomatis")');
await btnIsi.click();

await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button[type="submit"]'),
]);

console.log(`Current URL after login: ${page.url()}`);
if (!page.url().endsWith('/dashboard')) {
    console.error('❌ FAILED: Login failed!');
    process.exit(1);
}
console.log('✅ PASSED: Logged in successfully to /dashboard!');

// 2. Inspect Workspace Switcher on Dashboard
console.log('\n--- 2. Inspect Workspace Switcher Element ---');
const wsSwitch = page.locator('.workspace-switch');
const tagName = await wsSwitch.evaluate(el => el.tagName.toLowerCase());
const href = await wsSwitch.getAttribute('href');
const companyText = await page.locator('.workspace-switch strong').innerText();

console.log(`Tag: <${tagName}>, Href: ${href}, Company Name: ${companyText.trim()}`);
if (tagName !== 'a' || !href.includes('pengaturan-perusahaan')) {
    console.error('❌ FAILED: .workspace-switch is not an <a> tag linking to /pengaturan-perusahaan!');
    process.exit(1);
}
console.log('✅ PASSED: .workspace-switch is an anchor linking directly to /pengaturan-perusahaan!');

// 3. Click Workspace Switcher
console.log('\n--- 3. Click Workspace Switcher ---');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    wsSwitch.click()
]);

console.log(`Navigated URL: ${page.url()}`);
if (!page.url().includes('/pengaturan-perusahaan')) {
    console.error('❌ FAILED: Clicking workspace switcher did not navigate to /pengaturan-perusahaan!');
    process.exit(1);
}
console.log('✅ PASSED: Workspace switcher navigated directly to /pengaturan-perusahaan!');

// 4. Update Company Name and Verify Realtime Sync
console.log('\n--- 4. Update Company Name to "PT. Maju Mapan Sejahtera" ---');
await page.fill('input[name="nama_perusahaan"]', 'PT. Maju Mapan Sejahtera');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button:has-text("Simpan Perubahan Profil")')
]);

const updatedSidebarName = await page.locator('.workspace-switch strong').innerText();
console.log(`Updated Sidebar Company Name: ${updatedSidebarName.trim()}`);
if (updatedSidebarName.trim() !== 'PT. Maju Mapan Sejahtera') {
    console.error('❌ FAILED: Sidebar workspace switcher did not reflect new company name!');
    process.exit(1);
}
console.log('✅ PASSED: Sidebar workspace switcher dynamically reflects updated company name!');

// 5. Test Error 404 Page Footer Reflection
console.log('\n--- 5. Verify 404 Error Page Dynamic Copyright ---');
await page.goto(`${BASE}/non-existent-page-test-404`, { waitUntil: 'domcontentloaded' });
const pageContent404 = await page.content();
if (!pageContent404.includes('PT. Maju Mapan Sejahtera')) {
    console.error('❌ FAILED: 404 error page does not reflect dynamic company name!');
    process.exit(1);
}
console.log('✅ PASSED: 404 error page reflects dynamic company name!');

// 6. Revert back cleanly to PT. Sejahtera Bersama
console.log('\n--- 6. Revert Company Name back to PT. Sejahtera Bersama ---');
await page.goto(`${BASE}/pengaturan-perusahaan`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="nama_perusahaan"]', 'PT. Sejahtera Bersama');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button:has-text("Simpan Perubahan Profil")')
]);

const finalSidebarName = await page.locator('.workspace-switch strong').innerText();
console.log(`Final Sidebar Company Name: ${finalSidebarName.trim()}`);
if (finalSidebarName.trim() !== 'PT. Sejahtera Bersama') {
    console.error('❌ FAILED: Failed to revert company name!');
    process.exit(1);
}
console.log('✅ PASSED: State cleanly reverted back to default seed!');

await browser.close();
console.log('\n🎉 ALL WORKSPACE SWITCHER E2E TESTS PASSED WITH 100% SUCCESS!');
process.exit(0);
