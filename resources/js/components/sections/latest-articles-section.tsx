import React from 'react';
import { ArticleCard } from "../ui/article-card";
import { Coffee, ChevronRight, Hash, ArrowRight } from "lucide-react";

interface LatestArticlesProps {
    articles: any[];
    categories: any[];
    settings: any;
}

export function LatestArticlesSection({ articles, categories, settings }: LatestArticlesProps) {
    return (
        <section className="mx-auto max-w-7xl px-6 lg:px-8 mt-24">
            <div className="flex flex-col lg:flex-row gap-12">
                {/* Main Content */}
                <div className="lg:w-3/4">
                    <div className="flex items-center justify-between mb-8">
                        <div className="flex items-center gap-3">
                            <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 shadow-lg shadow-indigo-500/20">
                                <Coffee className="h-6 w-6 text-white" />
                            </div>
                            <div>
                                <h2 className="text-2xl font-black italic tracking-tighter text-white uppercase">Latest Insights</h2>
                                <p className="text-xs font-bold text-muted-foreground uppercase tracking-widest mt-0.5">Fresh from the editor</p>
                            </div>
                        </div>
                        <a href="/articles" className="group flex items-center gap-2 text-xs font-bold text-indigo-400 hover:text-white transition-colors">
                            VIEW ALL <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
                        </a>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {articles.map((article, index) => (
                            <ArticleCard key={article.id} article={article} index={index} />
                        ))}
                    </div>
                </div>

                {/* Sidebar */}
                <div className="lg:w-1/4 space-y-12">
                    {/* Categories Card */}
                    <div className="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md p-8">
                        <h4 className="flex items-center gap-2 text-sm font-black uppercase tracking-widest text-white mb-6">
                           <Hash className="h-5 w-5 text-indigo-500" /> Categories
                        </h4>
                        <div className="space-y-4">
                            {categories.map((cat) => (
                                <a 
                                    key={cat.id} 
                                    href={`/category/${cat.slug}`}
                                    className="group flex items-center justify-between transition-colors hover:text-indigo-400"
                                >
                                    <span className="text-sm font-bold text-muted-foreground group-hover:text-white transition-colors">
                                        {cat.name}
                                    </span>
                                    <ChevronRight className="h-4 w-4 text-white/20 group-hover:text-indigo-500 transition-colors" />
                                </a>
                            ))}
                        </div>
                    </div>

                    {/* Ad Placement */}
                    <div className="rounded-3xl border border-white/10 bg-indigo-500/10 backdrop-blur-md p-8 flex flex-col items-center justify-center min-h-[300px] text-center">
                        <div className="mb-4 rounded-full bg-white/10 p-4">
                            <Coffee className="h-8 w-8 text-indigo-400" />
                        </div>
                        <h5 className="text-sm font-bold text-white mb-2 italic">Space for AdSense</h5>
                        <p className="text-xs text-muted-foreground leading-relaxed">
                            {settings.ad_sidebar_placeholder || "Experience professional contents with modern design. This spot is reserved for ads."}
                        </p>
                        {/* Dynamic Ad Injected if script exists */}
                        <div className="mt-6 opacity-30 text-[10px] uppercase font-bold tracking-[0.2em] border border-white/10 px-4 py-2 rounded-lg">
                            Sponsored
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
