import React from 'react';
import { MailIcon } from "lucide-react";

interface FooterProps {
    settings: any;
    categories: any[];
}

export function Footer({ settings, categories }: FooterProps) {
    const currentYear = new Date().getFullYear();
    const siteName = settings.site_name || "ModernBlog";

    return (
        <footer className="mt-20 border-t border-white/10 bg-black/30 backdrop-blur-md pt-16 pb-8">
            <div className="mx-auto max-w-7xl px-6 lg:px-8 text-white">
                <div className="flex items-center gap-2">
                    <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500">
                        <MailIcon className="h-6 w-6 text-white" />
                    </div>
                    <span className="text-xl font-black tracking-tighter">
                        {siteName}
                    </span>
                </div>
                <p className="mt-4 text-sm text-muted-foreground">
                    &copy; {currentYear} {siteName}. All rights reserved.
                </p>
            </div>
        </footer>
    );
}
