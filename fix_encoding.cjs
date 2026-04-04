const fs = require('fs');
const path = require('path');

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(function(file) {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            results.push(file);
        }
    });
    return results;
}

const files = walk('resources/js');

files.forEach(file => {
    if (file.endsWith('.tsx') || file.endsWith('.ts')) {
        let content = fs.readFileSync(file, 'utf-8');
        // Remove BOM if present
        if (content.charCodeAt(0) === 0xFEFF) {
            content = content.slice(1);
        }
        // Normalize React imports (handle optional semicolon)
        content = content.replace(/import \* as React from (['"])react\1;?/g, "import React from 'react';");
        fs.writeFileSync(file, content, 'utf-8');
    }
});
console.log('Fixed BOM and Normalized imports for', files.length, 'files');
