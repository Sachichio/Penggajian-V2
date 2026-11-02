import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
const results = [];
const check = (name, ok, info = '') => {
  results.push(ok);
  console.log(`${ok ? '✅' : '❌'} ${name} ${info}`);
};
const visibleRows = (page, table) =>
  page.$$eval(`${table} tbody tr`, rs => rs.filter(r => r.style.display !== 'none' && !r.id.endsWith('empty-row') && r.offsetParent !== null).length);

const browser = await chromium.launch({ headless: true });
const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
const page = await ctx.newPage();
const jsErrors = [];
page.on('pageerror', e => jsErrors.push(e.message));

page.setDefaultTimeout(60000);
page.setDefaultNavigationTimeout(60000);
await page.goto(`${BASE}/`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="email"]', 'admin@gmail.com');
await page.fill('input[name="password"]', '123');
await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }), page.click('button[type="submit"]')]);

// Semua halaman: status 200, tanpa halaman error Laravel
for (const p of ['dashboard', 'karyawan', 'jabatan', 'penggajian', 'slip-gaji', 'laporan', 'presensi']) {
  const res = await page.goto(`${BASE}/${p}`, { waitUntil: 'domcontentloaded' });
  const body = await page.content();
  check(`/${p} status`, res.status() === 200 && !/Whoops|Exception|ErrorException/.test(body), `HTTP ${res.status()}`);
}

// Dashboard
await page.goto(`${BASE}/dashboard`, { waitUntil: 'domcontentloaded' });
const today = await page.locator('.today').first().innerText();
check('Tanggal topbar dinamis', /02 November 2026|2 November 2026/i.test(today) || !/31 Juli/.test(today), `"${today.trim()}"`);
check('Checkbox dashboard hilang', (await page.locator('#payroll-main-table input[type=checkbox]').count()) === 0);
check('Badge ⌘K hilang', !(await page.content()).includes('⌘K'));

// Karyawan
await page.goto(`${BASE}/karyawan`, { waitUntil: 'domcontentloaded' });
const kTotal = await visibleRows(page, '#karyawan-main-table');
await page.fill('#karyawan-search-input', 'zzzzzz');
check('Karyawan: search tanpa hasil → 0 baris + pesan kosong', (await visibleRows(page, '#karyawan-main-table')) === 0 && await page.locator('#karyawan-empty-row').isVisible());
await page.fill('#karyawan-search-input', '');
await page.selectOption('#karyawan-status-filter', 'Aktif');
const aktifRows = await page.$$eval('#karyawan-main-table tbody tr', rs => rs.filter(r => r.style.display !== 'none' && !r.id.endsWith('empty-row')).map(r => r.textContent));
check('Karyawan: filter Aktif tidak memuat Nonaktif', aktifRows.every(t => !/Nonaktif/.test(t)), `(${aktifRows.length}/${kTotal})`);
await page.selectOption('#karyawan-status-filter', 'Nonaktif');
const nonRows = await page.$$eval('#karyawan-main-table tbody tr', rs => rs.filter(r => r.style.display !== 'none' && !r.id.endsWith('empty-row')).map(r => r.textContent));
check('Karyawan: filter Nonaktif hanya Nonaktif', nonRows.every(t => /Nonaktif/.test(t)), `(${nonRows.length})`);

// Jabatan
await page.goto(`${BASE}/jabatan`, { waitUntil: 'domcontentloaded' });
await page.fill('#jabatan-search-input', 'zzzzzz');
check('Jabatan: search tanpa hasil', (await visibleRows(page, '#jabatan-main-table')) === 0);
await page.fill('#jabatan-search-input', '');
check('Jabatan: reset menampilkan data', (await visibleRows(page, '#jabatan-main-table')) > 0);

// Penggajian & Slip: filter bulan
for (const [url, tbl, sel, inp] of [['penggajian', '#penggajian-main-table', '#penggajian-month-filter', '#penggajian-search-input'], ['slip-gaji', '#slip-main-table', '#slip-month-filter', '#slip-search-input']]) {
  await page.goto(`${BASE}/${url}`, { waitUntil: 'domcontentloaded' });
  await page.selectOption(sel, 'Juli');
  const rows = await page.$$eval(`${tbl} tbody tr`, rs => rs.filter(r => r.style.display !== 'none' && !r.id.endsWith('empty-row')).map(r => r.children[3]?.textContent || ''));
  check(`${url}: filter Juli hanya periode Juli`, rows.every(t => /Juli/.test(t)), `(${rows.length} baris)`);
  await page.selectOption(sel, '');
  await page.fill(inp, 'zzzzzz');
  check(`${url}: search tanpa hasil`, (await visibleRows(page, tbl)) === 0);
}

// Laporan
await page.goto(`${BASE}/laporan`, { waitUntil: 'domcontentloaded' });
await page.fill('#laporan-search-input', 'zzzzzz');
check('Laporan: search tanpa hasil', (await visibleRows(page, '#laporan-main-table')) === 0);

// Presensi
await page.goto(`${BASE}/presensi`, { waitUntil: 'domcontentloaded' });
check('Presensi: input search log ada', await page.locator('#presensi-search-input').isVisible());
check('Presensi: input search izin ada', await page.locator('#izin-search-input').isVisible());
check('Presensi: filter kategori izin ada', await page.locator('#izin-kategori-filter').isVisible());
await page.selectOption('#izin-kategori-filter', 'Cuti');
await page.fill('#izin-search-input', 'zzzzzz');
check('Presensi: search izin jalan', jsErrors.length === 0);
await page.fill('#presensi-search-input', 'zzzzzz');
check('Presensi: search log jalan tanpa error JS', jsErrors.length === 0);

check('Tidak ada error JavaScript di semua halaman', jsErrors.length === 0, jsErrors.join(' | '));

await browser.close();
const failed = results.filter(r => !r).length;
console.log(`\nHasil: ${results.length - failed}/${results.length} lulus`);
process.exit(failed ? 1 : 0);
