import fs from 'fs';
import path from 'path';

const dir = 'resources/views/pages';
const walk = d => fs.readdirSync(d, { withFileTypes: true }).flatMap(e => e.isDirectory() ? walk(path.join(d, e.name)) : [path.join(d, e.name)]);
for (const f of walk(dir).filter(f => f.endsWith('index.blade.php'))) {
  const c = fs.readFileSync(f, 'utf8');
  const n = c.replace(/onkeyup="(filter\w+\(\))"/g, 'oninput="$1"').replace('// Shortcut ⌘K / Ctrl+K', '// Shortcut Ctrl+K');
  if (n !== c) { fs.writeFileSync(f, n); console.log('updated', f); }
}
