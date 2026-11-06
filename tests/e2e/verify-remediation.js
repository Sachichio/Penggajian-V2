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

// 1. Login Admin
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="email"]', 'admin@gmail.com');
await page.fill('input[name="password"]', '123');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('button[type="submit"]'),
]);

// 2. Cek Bug 7: Sidebar badge count karyawan dinamis
const navCount = await page.locator('.nav-count').first().innerText();
check('Sidebar badge count karyawan dinamis', /^\d+$/.test(navCount.trim()), `count=${navCount.trim()}`);

// 3. Cek Bug 1: Modul Potongan (Index, Create, Store, Edit, Update, Destroy)
const resPotIdx = await page.goto(`${BASE}/potongan/1`, { waitUntil: 'domcontentloaded' });
const bodyPotIdx = await page.content();
check('/potongan/1 bebas Error 500 ($potongans)', resPotIdx.status() === 200 && !/Whoops|Exception|Undefined variable/i.test(bodyPotIdx), `HTTP ${resPotIdx.status()}`);

const resPotCreate = await page.goto(`${BASE}/potongan/1/create`, { waitUntil: 'domcontentloaded' });
const hasJenisInput = (await page.locator('input[name="jenis_potongan"]').count()) === 1;
check('/potongan/1/create punya input[name="jenis_potongan"]', resPotCreate.status() === 200 && hasJenisInput);

// Uji tambah potongan nyata lalu hapus kembali
await page.fill('input[name="jenis_potongan"]', 'Potongan Uji QA');
await page.fill('input[name="nominal"]', '50000');
await page.fill('textarea[name="keterangan"]', 'Tes QA E2E');
await Promise.all([
    page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    page.click('.form-card button[type="submit"]'),
]);
const afterStoreBody = await page.content();
check('Tambah potongan berhasil & tampil jenis_potongan di tabel', afterStoreBody.includes('Potongan Uji QA'));

// Hapus potongan uji yang baru dibuat agar DB tetap bersih
page.once('dialog', d => d.accept());
const delForms = page.locator('table form[action*="/potongan/"]');
const delCount = await delForms.count();
if (delCount > 0) {
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
        delForms.last().locator('button[type="submit"]').click(),
    ]);
}
const afterDelBody = await page.content();
check('Hapus potongan berhasil', !afterDelBody.includes('Potongan Uji QA'));

// 4. Cek Bug 2: Modul Karyawan (jenis_kelamin Laki-laki / Perempuan)
await page.goto(`${BASE}/karyawan`, { waitUntil: 'domcontentloaded' });
const karTableText = await page.locator('#karyawan-main-table tbody').innerText();
check('Tabel karyawan menampilkan Laki-laki dengan benar', karTableText.includes('Laki-laki'));

await page.goto(`${BASE}/karyawan/1`, { waitUntil: 'domcontentloaded' });
const karShowText = await page.content();
check('Detail karyawan #1 menampilkan jenis kelamin yang benar', karShowText.includes('Laki-laki') || karShowText.includes('Perempuan'));

await page.goto(`${BASE}/karyawan/create`, { waitUntil: 'domcontentloaded' });
const optL = await page.locator('select[name="jenis_kelamin"] option[value="Laki-laki"]').count();
const optP = await page.locator('select[name="jenis_kelamin"] option[value="Perempuan"]').count();
check('Form karyawan memiliki option value Laki-laki dan Perempuan', optL === 1 && optP === 1);

// 5. Cek Bug 3: API Attendance Summary (query string & path param + jam_lembur key)
const apiRes1 = await page.request.get(`${BASE}/api/karyawan/1/attendance-summary?bulan=7&tahun=2026`);
const apiJson1 = await apiRes1.json();
check('API attendance-summary via query string HTTP 200 & key jam_lembur tersedia', apiRes1.status() === 200 && apiJson1.jam_lembur !== undefined && apiJson1.total_lembur !== undefined);

const apiRes2 = await page.request.get(`${BASE}/api/karyawan/1/attendance-summary/7/2026`);
const apiJson2 = await apiRes2.json();
check('API attendance-summary via route param HTTP 200 & key jam_lembur tersedia', apiRes2.status() === 200 && apiJson2.jam_lembur !== undefined);

// 6. Cek Bug 4: Detail Penggajian badge status approval sesuai enum DB
const resPengShow = await page.goto(`${BASE}/penggajian/1`, { waitUntil: 'domcontentloaded' });
const pengShowText = await page.content();
check('Detail penggajian #1 HTTP 200 & menampilkan status Disetujui Owner', resPengShow.status() === 200 && pengShowText.includes('Disetujui Owner'));

// 7. Cek Bug 6: Login sebagai Owner & akses /penggajian serta /penggajian/1
const ctxOwner = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const pageOwner = await ctxOwner.newPage();
pageOwner.setDefaultTimeout(60000);
pageOwner.setDefaultNavigationTimeout(60000);

await pageOwner.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
await pageOwner.fill('input[name="email"]', 'owner@gmail.com');
await pageOwner.fill('input[name="password"]', '123');
await Promise.all([
    pageOwner.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
    pageOwner.click('button[type="submit"]'),
]);

const resOwnerIdx = await pageOwner.goto(`${BASE}/penggajian`, { waitUntil: 'domcontentloaded' });
check('Owner dapat mengakses /penggajian (tidak diredirect ke dashboard)', resOwnerIdx.status() === 200 && pageOwner.url().endsWith('/penggajian'));

const resOwnerShow = await pageOwner.goto(`${BASE}/penggajian/1`, { waitUntil: 'domcontentloaded' });
check('Owner dapat mengakses detail /penggajian/1', resOwnerShow.status() === 200 && pageOwner.url().endsWith('/penggajian/1'));

check('Tidak ada error JavaScript selama pengujian remediasi', jsErrors.length === 0, jsErrors.join('; '));

await browser.close();
const passed = results.filter(Boolean).length;
console.log(`\nHasil Remediasi: ${passed}/${results.length} lulus`);
process.exit(passed === results.length ? 0 : 1);
