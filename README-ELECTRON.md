# Electron Desktop Wrapper for Materials Management

Quick steps:

1. Install Node.js (LTS) and npm
2. From project root:

```bash
cd electron
npm install
npm start
```

3. From project root via Composer:

```bash
composer desktop:start
```

4. Build (Windows):

```bash
cd electron
npm run build:win
```

Notes:
- Ensure PHP is available on PATH for development. For production builds, bundle a PHP binary under `electron/php/` and update `main.js` if necessary.
- Replace `electron/icon.ico` with your real icon file.
