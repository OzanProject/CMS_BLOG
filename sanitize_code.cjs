const fs = require('fs');
const path = require('path');

const walk = (dir, callback) => {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        isDirectory ? walk(dirPath, callback) : callback(path.join(dir, f));
    });
};

const sanitizeFile = (filePath) => {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts') && !filePath.endsWith('.js')) return;

    let content = fs.readFileSync(filePath, 'utf8');
    let original = content;

    // Remove BOM
    if (content.charCodeAt(0) === 0xFEFF) {
        content = content.slice(1);
        console.log(`Removed BOM from: ${filePath}`);
    }

    // Replace non-breaking space (xA0) with normal space
    content = content.replace(/\u00A0/g, ' ');

    // Normalize line endings
    content = content.replace(/\r\n/g, '\n');

    // Standardize React imports: import * as React to import React
    content = content.replace(/import \* as React from ['"]react['"]/g, "import React from 'react'");

    if (content !== original) {
        fs.writeFileSync(filePath, content, 'utf8');
        console.log(`Sanitized: ${filePath}`);
    }
};

const jsDir = path.resolve(__dirname, 'resources/js');
console.log(`Starting sanitization in: ${jsDir}`);
walk(jsDir, sanitizeFile);
console.log('Sanitization complete.');
