import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import Alpine from 'alpinejs';

import ModernPage from './components/sections/modern-page';

// Declare Alpine on window
declare global {
    interface Window {
        Alpine: any;
    }
}

window.Alpine = Alpine;
Alpine.start();

// React Mounting Logic
console.log('React Mounting Logic initialized');
const components: Record<string, React.ComponentType<any>> = {
    'ModernPage': ModernPage,
};

console.log('Available components:', Object.keys(components));

document.addEventListener('DOMContentLoaded', () => {
    const mountPoints = document.querySelectorAll('[data-react-component]');
    console.log(`Found ${mountPoints.length} mount points`);
    mountPoints.forEach((mount) => {
        const componentName = mount.getAttribute('data-react-component');
        console.log(`Mounting component: ${componentName}`);
        if (!componentName) return;

        const Component = components[componentName];
        
        if (Component) {
            try {
                const propsData = mount.getAttribute('data-props');
                const props = JSON.parse(propsData || '{}');
                console.log(`Props for ${componentName}:`, props);
                const root = createRoot(mount);
                root.render(<Component {...props} />);
                console.log(`${componentName} rendered successfully`);
            } catch (error) {
                console.error(`Error rendering ${componentName}:`, error);
            }
        } else {
            console.warn(`Component ${componentName} not found in registry`);
        }
    });
});
