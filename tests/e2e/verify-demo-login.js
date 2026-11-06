import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
const results = [];
const check = (name, ok, info = '') => {
    results.push(ok);
    console.log(`${ok ? '✅' : '❌'} ${name} ${info}`);
};

const browser = await chromium.launch({ headless: true });
const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const page = await ctx.newPage();
const jsErrors = [];
page.on('pageerror', e => jsErrors.push(e.message));

page.setDefaultTimeout(60000);
page.setDefaultNavigationTimeout(60000);

// 1. Uji Halaman Login & UI Elemen
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
const pageHtml = await page.content();

check('Placeholder email adalah nama@sacchio.com', pageHtml.includes('placeholder="nama@sacchio.com"'));
check('Label "Email kantor" sudah dihapus', !pageHtml.includes('Email kantor'));
check('Teks "Privasi" dan "Ketentuan" sudah dihapus di footer', !pageHtml.includes('Privasi') && !pageHtml.includes('Ketentuan'));
check('Teks password eksplisit (123) tidak ditampilkan di box demo', !pageHtml.includes('· 123'));
check('Box demo menampilkan email demo@gmail.com', pageHtml.includes('demo@gmail.com'));
check('Tombol "Isi otomatis" tersedia di box demo', pageHtml.includes('Isi otomatis'));

// 2. Uji Klik "Isi otomatis" mengisi input form
const btnIsi = page.locator('button:has-text("Isi otomatis")');
await btnIsi.click();

const valEmail = await page.inputValue('#login-email');
const valPass = await page.inputValue('#login-password');
check('Klik "Isi otomatis" mengisi email demo@gmail.com', valEmail === 'demo@gmail.com');
check('Klik "Isi otomatis" mengisi password 123 ke input', valPass === '123');

// 3. Submit Form Login
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button[type="submit"]'),
]);

check('Login akun demo berhasil masuk ke /dashboard', page.url().endsWith('/dashboard'));

// 4. Uji Session Alert & Error Banner di Halaman Karyawan, Jabatan, Penggajian
for (const p of ['karyawan', 'jabatan', 'penggajian']) {
    const res = await page.goto(`${BASE}/${p}`, { waitUntil: 'domcontentloaded' });
    check(`Halaman /${p} HTTP 200`, res.status() === 200);
}

// 5. Uji Pembatasan Kuota Laporan & Slip Gaji
await page.goto(`${BASE}/laporan`, { waitUntil: 'domcontentloaded' });
const rowCountLaporan = await page.$$eval('#laporan-table tbody tr', rs => rs.filter(r => !r.id.endsWith('empty-row')).length);
check('Laporan dibatasi maksimal 10 data untuk akun demo', rowCountLaporan <= 10, `jumlah baris: ${rowCountLaporan}`);

await page.goto(`${BASE}/slip-gaji`, { waitUntil: 'domcontentloaded' });
const rowCountSlip = await page.$$eval('#slip-table tbody tr', rs => rs.filter(r => !r.id.endsWith('empty-row')).length);
check('Slip Gaji dibatasi maksimal 20 data untuk akun demo', rowCountSlip <= 20, `jumlah baris: ${rowCountSlip}`);

check('Tidak ada error JavaScript di halaman login & setelah login', jsErrors.length === 0, jsErrors.join('; '));

await browser.close();
const passed = results.filter(Boolean).length;
console.log(`\nHasil Pengujian Demo & Login V2: ${passed}/${results.length} lulus`);
process.exit(passed === results.length ? 0 : 1);
