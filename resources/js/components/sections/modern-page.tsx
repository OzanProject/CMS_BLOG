import React from 'react';
import { Navbar } from "../layout/navbar";
import { Footer } from "../layout/footer";
import { HeroSection } from "../blocks/hero-section-1";
import { TrendingGrid } from "./trending-grid";
import { LatestArticlesSection } from "./latest-articles-section";

interface ModernPageProps {
    settings: any;
    categories: any[];
    bannerArticles: any[];
    trendingArticles: any[];
    latestArticles: any[];
}

export default function ModernPage({ settings, categories, bannerArticles, trendingArticles, latestArticles }: ModernPageProps) {
    return (
        <div className="min-h-screen bg-background text-foreground font-sans selection:bg-indigo-500/30">
            <Navbar settings={settings} categories={categories} />
            
            <main>
                {/* Hero Section */}
                <HeroSection articles={bannerArticles} settings={settings} />

                {/* Trending Section */}
                <TrendingGrid articles={trendingArticles} />

                {/* Ad Placement (Placeholder) */}
                <div className="mx-auto max-w-7xl px-6 lg:px-8 mt-24">
                    <div className="rounded-3xl border border-white/5 bg-white/5 p-6 flex items-center justify-center min-h-[100px] text-muted-foreground italic text-sm">
                        AdSense Horizontal Banner Slot
                    </div>
                </div>

                {/* Latest Articles + Sidebar */}
                <LatestArticlesSection 
                    articles={latestArticles} 
                    categories={categories} 
                    settings={settings} 
                />
            </main>

            <Footer settings={settings} categories={categories} />
        </div>
    );
}
