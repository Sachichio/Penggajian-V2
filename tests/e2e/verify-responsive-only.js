import { chromium } from '@playwright/test';

const BASE = 'http://127.0.0.1:8000';
console.log('🚀 Checking responsiveness across 3 viewports...');
const browser = await chromium.launch({ headless: true });

// 1. Laptop (1366x768)
const pLaptop = await browser.newPage({ viewport: { width: 1366, height: 768 } });
await pLaptop.goto(`${BASE}/`, { waitUntil: 'networkidle' });
const overflowLaptop = await pLaptop.evaluate(() => {
    return {
        docWidth: document.documentElement.scrollWidth,
        winWidth: window.innerWidth,
        hasOverflow: document.documentElement.scrollWidth > window.innerWidth
    };
});
console.log(`[1366x768] docWidth=${overflowLaptop.docWidth}px, winWidth=${overflowLaptop.winWidth}px, hasOverflow=${overflowLaptop.hasOverflow}`);

// 2. Full HD (1920x1080)
const pFHD = await browser.newPage({ viewport: { width: 1920, height: 1080 } });
await pFHD.goto(`${BASE}/`, { waitUntil: 'networkidle' });
const overflowFHD = await pFHD.evaluate(() => document.documentElement.scrollWidth > window.innerWidth);
console.log(`[1920x1080] hasOverflow=${overflowFHD}`);

// 3. Mobile (375x667)
const pMobile = await browser.newPage({ viewport: { width: 375, height: 667 } });
await pMobile.goto(`${BASE}/`, { waitUntil: 'networkidle' });
const overflowMobile = await pMobile.evaluate(() => document.documentElement.scrollWidth > window.innerWidth);
console.log(`[375x667] hasOverflow=${overflowMobile}`);

await browser.close();

if (overflowLaptop.hasOverflow || overflowFHD || overflowMobile) {
    console.error('❌ Overflow detected!');
    process.exit(1);
} else {
    console.log('🎉 ALL VIEWPORTS 100% RESPONSIVE WITH ZERO HORIZONTAL OVERFLOW!');
    process.exit(0);
}
