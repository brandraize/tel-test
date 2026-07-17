const { app, BrowserWindow, Menu, shell, ipcMain, dialog } = require('electron');
const { exec, spawn } = require('child_process');
const path = require('path');
const fs = require('fs');

let mainWindow;
let phpProcess;
let isQuitting = false;

const projectRoot = path.join(__dirname, '..');
const isDev = process.env.NODE_ENV === 'development' || !app.isPackaged;

function getPhpBinary() {
    if (isDev) {
        return 'php';
    }
    const phpPath = path.join(process.resourcesPath, 'php', 'php.exe');
    return phpPath;
}

function startPhpServer() {
    return new Promise((resolve, reject) => {
        const php = getPhpBinary();
        const port = 8000;

        if (process.platform === 'win32') {
            try {
                exec(`netstat -ano | findstr :${port}`, (error, stdout) => {
                    if (stdout) {
                        const lines = stdout.split('\n');
                        lines.forEach(line => {
                            const parts = line.trim().split(/\s+/);
                            if (parts.length > 4) {
                                const pid = parts[parts.length - 1];
                                try {
                                    process.kill(parseInt(pid));
                                } catch (e) {}
                            }
                        });
                    }
                });
            } catch (e) {}
        }

        const phpArgs = ['artisan', 'serve', `--host=127.0.0.1`, `--port=${port}`];

        console.log(`Starting PHP server: ${php} ${phpArgs.join(' ')}`);

        phpProcess = spawn(php, phpArgs, {
            cwd: projectRoot,
            shell: true,
            detached: false
        });

        phpProcess.stdout.on('data', (data) => {
            const output = data.toString();
            console.log(`PHP Server: ${output}`);
            if (output.includes('Server running')) {
                resolve();
            }
        });

        phpProcess.stderr.on('data', (data) => {
            console.error(`PHP Error: ${data}`);
        });

        phpProcess.on('error', (err) => {
            console.error('Failed to start PHP server:', err);
            reject(err);
        });

        phpProcess.on('close', (code) => {
            console.log(`PHP process exited with code ${code}`);
            if (!isQuitting && code !== 0) {
                setTimeout(() => {
                    startPhpServer().then(resolve).catch(reject);
                }, 2000);
            }
        });

        setTimeout(() => {
            resolve();
        }, 15000);
    });
}

function createWindow() {
    mainWindow = new BrowserWindow({
        width: 1200,
        height: 800,
        minWidth: 800,
        minHeight: 600,
        icon: path.join(__dirname, 'icon.ico'),
        webPreferences: {
            nodeIntegration: false,
            contextIsolation: true,
            enableRemoteModule: false,
            devTools: isDev
        },
        show: false
    });

    const url = `http://127.0.0.1:8000`;
    mainWindow.loadURL(url);

    mainWindow.once('ready-to-show', () => {
        mainWindow.show();
        if (isDev) mainWindow.webContents.openDevTools();
    });

    mainWindow.webContents.setWindowOpenHandler(({ url }) => {
        if (url.startsWith('http')) {
            shell.openExternal(url);
            return { action: 'deny' };
        }
        return { action: 'allow' };
    });

    mainWindow.webContents.on('will-navigate', (event, url) => {
        if (!url.startsWith('http://127.0.0.1:8000')) {
            event.preventDefault();
            shell.openExternal(url);
        }
    });

    mainWindow.on('closed', () => {
        mainWindow = null;
    });
}

app.whenReady().then(async () => {
    try {
        await startPhpServer();
        createWindow();
    } catch (error) {
        console.error('Failed to start application:', error);
        dialog.showErrorBox('Error', 'Failed to start the application. Please make sure PHP is installed.');
        app.quit();
    }
});

app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') app.quit();
});

app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) createWindow();
});

app.on('before-quit', () => {
    isQuitting = true;
    if (phpProcess) phpProcess.kill();
});

ipcMain.handle('get-app-version', () => app.getVersion());
ipcMain.handle('open-external', (event, url) => shell.openExternal(url));
ipcMain.handle('print', (event, options) => {
    const win = BrowserWindow.getFocusedWindow();
    if (win) win.webContents.print(options);
});
const { app, BrowserWindow, Menu, shell, ipcMain, dialog } = require('electron');
const { exec, spawn } = require('child_process');
const path = require('path');
const fs = require('fs');

// Keep a global reference of the window object
let mainWindow;
let phpProcess;
let isQuitting = false;

// Get the project root directory
const projectRoot = path.join(__dirname, '..');

// Check if we're running in development or production
const isDev = process.env.NODE_ENV === 'development' || !app.isPackaged;

// Function to get PHP binary path
function getPhpBinary() {
    // In development, use system PHP
    if (isDev) {
        return 'php';
    }
    // In production, use bundled PHP
    const phpPath = path.join(process.resourcesPath, 'php', 'php.exe');
    return phpPath;
}

// Function to start PHP server
function startPhpServer() {
    return new Promise((resolve, reject) => {
        const php = getPhpBinary();
        const port = 8000;

        // Kill any process using port 8000
        if (process.platform === 'win32') {
            try {
                exec(`netstat -ano | findstr :${port}`, (error, stdout) => {
                    if (stdout) {
                        const lines = stdout.split('\n');
                        lines.forEach(line => {
                            const parts = line.trim().split(/\s+/);
                            if (parts.length > 4) {
                                const pid = parts[parts.length - 1];
                                try {
                                    process.kill(parseInt(pid));
                                } catch (e) {}
                            }
                        });
                    }
                });
            } catch (e) {}
        }

        // Start Laravel development server
        const phpArgs = ['artisan', 'serve', `--host=127.0.0.1`, `--port=${port}`];

        console.log(`Starting PHP server: ${php} ${phpArgs.join(' ')}`);

        phpProcess = spawn(php, phpArgs, {
            cwd: projectRoot,
            shell: true,
            detached: false
        });

        phpProcess.stdout.on('data', (data) => {
            const output = data.toString();
            console.log(`PHP Server: ${output}`);
            if (output.includes('Server running')) {
                resolve();
            }
        });

        phpProcess.stderr.on('data', (data) => {
            console.error(`PHP Error: ${data}`);
        });

        phpProcess.on('error', (err) => {
            console.error('Failed to start PHP server:', err);
            reject(err);
        });

        phpProcess.on('close', (code) => {
            console.log(`PHP process exited with code ${code}`);
            if (!isQuitting && code !== 0) {
                // Try to restart
                setTimeout(() => {
                    startPhpServer().then(resolve).catch(reject);
                }, 2000);
            }
        });

        // Timeout if server doesn't start within 10 seconds
        setTimeout(() => {
            resolve(); // Assume it might take longer
        }, 15000);
    });
}

// Function to create the main window
function createWindow() {
    mainWindow = new BrowserWindow({
        width: 1200,
        height: 800,
        minWidth: 800,
        minHeight: 600,
        icon: path.join(__dirname, 'icon.ico'),
        webPreferences: {
            nodeIntegration: false,
            contextIsolation: true,
            enableRemoteModule: false,
            devTools: isDev
        },
        show: false
    });

    // Load the Laravel app
    const url = `http://127.0.0.1:8000`;
    mainWindow.loadURL(url);

    // Show window when ready
    mainWindow.once('ready-to-show', () => {
        mainWindow.show();
        if (isDev) {
            mainWindow.webContents.openDevTools();
        }
    });

    // Handle external links
    mainWindow.webContents.setWindowOpenHandler(({ url }) => {
        if (url.startsWith('http')) {
            shell.openExternal(url);
            return { action: 'deny' };
        }
        return { action: 'allow' };
    });

    // Handle navigation
    mainWindow.webContents.on('will-navigate', (event, url) => {
        if (!url.startsWith('http://127.0.0.1:8000')) {
            event.preventDefault();
            shell.openExternal(url);
        }
    });

    // Handle closed window
    mainWindow.on('closed', () => {
        mainWindow = null;
    });
}

// Application lifecycle
app.whenReady().then(async () => {
    try {
        // Start PHP server
        await startPhpServer();
        // Create window
        createWindow();
    } catch (error) {
        console.error('Failed to start application:', error);
        dialog.showErrorBox('Error', 'Failed to start the application. Please make sure PHP is installed.');
        app.quit();
    }
});

// Quit when all windows are closed
app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        app.quit();
    }
});

app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
        createWindow();
    }
});

// Cleanup on quit
app.on('before-quit', () => {
    isQuitting = true;
    if (phpProcess) {
        phpProcess.kill();
    }
});

// IPC handlers (for communication between renderer and main process)
ipcMain.handle('get-app-version', () => {
    return app.getVersion();
});

ipcMain.handle('open-external', (event, url) => {
    shell.openExternal(url);
});

// Handle printing
ipcMain.handle('print', (event, options) => {
    const win = BrowserWindow.getFocusedWindow();
    if (win) {
        win.webContents.print(options);
    }
});
