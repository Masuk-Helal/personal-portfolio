#!/usr/bin/env python3
"""Builds the ThemeForest download package for Heliolisk.

Run from anywhere:  python tools/build-themeforest.py

What it does
  1. Zips the companion plugin into the theme's plugins/ folder (the TGM Plugin
     Activation source) and copies the Codestar Framework zip next to it.
  2. Zips the theme (root folder "heliolisk/").
  3. Assembles dist/heliolisk-<version>/ with the folders ThemeForest expects
     (theme, plugins, documentation, demo-data, licensing) and zips it.
  4. Checks the result (versions agree, no junk files, required files present).

Zips are written with Python's zipfile (forward slashes, no PaxHeaders).
"""

import re
import shutil
import sys
import zipfile
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
THEME = ROOT / 'wp-content' / 'themes' / 'heliolisk'
PLUGIN = ROOT / 'wp-content' / 'plugins' / 'heliolisk'
CODESTAR_ZIP = ROOT / 'wp-content' / 'plugins' / 'codestar-framework.zip'
DOCS = ROOT / 'docs'
DEMO_ZIP = ROOT / 'sample-data' / 'demo-data' / 'demo-import.zip'
LICENSING = ROOT / 'licensing'
DESC = ROOT / 'desc'
DIST = ROOT / 'dist'

JUNK = re.compile(r'(^|/)(\.DS_Store|Thumbs\.db|desktop\.ini|\.git|\.gitignore|\.svn|node_modules|__MACOSX|PaxHeaders[^/]*)(/|$)|\.(log|bak|orig|tmp)$', re.I)


def die(msg):
    print('ERROR: ' + msg)
    sys.exit(1)


def read(path, pattern, label):
    m = re.search(pattern, path.read_text(encoding='utf-8'), re.M)
    if not m:
        die('could not read %s from %s' % (label, path))
    return m.group(1).strip()


def zip_dir(src, dest, root_name, skip=lambda rel: False):
    dest.parent.mkdir(parents=True, exist_ok=True)
    if dest.exists():
        dest.unlink()
    count = 0
    with zipfile.ZipFile(dest, 'w', zipfile.ZIP_DEFLATED, compresslevel=9) as z:
        for f in sorted(src.rglob('*')):
            if not f.is_file():
                continue
            rel = f.relative_to(src).as_posix()
            if JUNK.search(rel) or skip(rel):
                continue
            z.write(f, root_name + '/' + rel)
            count += 1
    return count


def main():
    version = read(THEME / 'style.css', r'^Version:\s*(.+)$', 'theme version')
    plugin_version = read(PLUGIN / 'heliolisk.php', r'^\s*\*\s*Version:\s*(.+)$', 'plugin version')
    bundled = read(THEME / 'inc' / 'plugins.php', r"HELIOLISK_BUNDLED_PLUGIN_VERSION',\s*'([^']+)'", 'bundled plugin version')
    const = read(THEME / 'functions.php', r"HELIOLISK_THEME_VERSION',\s*'([^']+)'", 'theme constant')
    if len({version, const}) != 1:
        die('theme version differs: style.css %s, functions.php %s' % (version, const))
    if plugin_version != bundled:
        die('plugin version %s differs from HELIOLISK_BUNDLED_PLUGIN_VERSION %s' % (plugin_version, bundled))
    for need in (CODESTAR_ZIP, DEMO_ZIP, LICENSING / 'licensing.txt', DOCS / 'index.html'):
        if not need.exists():
            die('missing ' + str(need))

    print('Heliolisk theme %s, plugin %s' % (version, plugin_version))

    # 1. bundled plugins inside the theme
    plugins_dir = THEME / 'plugins'
    plugins_dir.mkdir(exist_ok=True)
    n = zip_dir(PLUGIN, plugins_dir / 'heliolisk.zip', 'heliolisk')
    shutil.copy2(CODESTAR_ZIP, plugins_dir / 'codestar-framework.zip')
    print('  plugin zip: %d files' % n)

    # 2. theme zip
    out = DIST / ('heliolisk-' + version)
    if out.exists():
        shutil.rmtree(out)
    (out / 'theme').mkdir(parents=True)
    n = zip_dir(THEME, out / 'theme' / 'heliolisk.zip', 'heliolisk')
    print('  theme zip: %d files' % n)

    # 3. package folders
    (out / 'plugins').mkdir()
    shutil.copy2(plugins_dir / 'heliolisk.zip', out / 'plugins' / 'heliolisk-core.zip')
    (out / 'demo-data').mkdir()
    shutil.copy2(DEMO_ZIP, out / 'demo-data' / 'demo-import.zip')
    shutil.copytree(DOCS, out / 'documentation', ignore=shutil.ignore_patterns('.DS_Store', 'Thumbs.db'))
    (out / 'licensing').mkdir()
    shutil.copy2(LICENSING / 'licensing.txt', out / 'licensing' / 'licensing.txt')
    (out / 'readme.txt').write_text(
        'Heliolisk %s\n\n'
        '  theme/          heliolisk.zip - upload in Appearance > Themes > Add New > Upload Theme\n'
        '  plugins/        heliolisk-core.zip - companion plugin (also bundled in the theme)\n'
        '  demo-data/      demo-import.zip - demo content, Customizer settings and widgets\n'
        '  documentation/  open index.html in a browser\n'
        '  licensing/      licenses and credits of third-party resources\n' % version, encoding='utf-8')

    # separate upload for the item page
    if DESC.exists():
        shutil.copytree(DESC, DIST / ('item-preview-' + version), dirs_exist_ok=True)

    # keep the author's source/ folder current
    src = ROOT / 'source'
    if src.exists():
        shutil.copy2(out / 'theme' / 'heliolisk.zip', src / 'heliolisk.zip')
        shutil.copy2(out / 'plugins' / 'heliolisk-core.zip', src / 'heliolisk-core.zip')

    # 4. final archive
    final = DIST / ('heliolisk-%s.zip' % version)
    n = zip_dir(out, final, 'heliolisk-' + version)
    size = final.stat().st_size / 1048576
    print('  package: %s (%d files, %.1f MB)' % (final.relative_to(ROOT), n, size))

    # checks
    problems = []
    with zipfile.ZipFile(out / 'theme' / 'heliolisk.zip') as z:
        names = z.namelist()
        for need in ('heliolisk/style.css', 'heliolisk/screenshot.jpg', 'heliolisk/readme.txt', 'heliolisk/functions.php',
                     'heliolisk/plugins/heliolisk.zip', 'heliolisk/plugins/codestar-framework.zip'):
            if need not in names:
                problems.append('theme zip lacks ' + need)
        for nme in names:
            if JUNK.search(nme) or '\\' in nme:
                problems.append('junk in theme zip: ' + nme)
    with zipfile.ZipFile(out / 'plugins' / 'heliolisk-core.zip') as z:
        if 'heliolisk/heliolisk.php' not in z.namelist():
            problems.append('plugin zip lacks heliolisk/heliolisk.php')
    for p in problems:
        print('  PROBLEM: ' + p)
    if problems:
        sys.exit(1)
    print('OK')


if __name__ == '__main__':
    main()
