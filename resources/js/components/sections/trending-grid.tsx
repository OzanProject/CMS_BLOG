import React from 'react';
import { motion } from "framer-motion";
import { TrendingUp, Clock, Eye } from "lucide-react";

interface Article {
    id: number;
    title: string;
    slug: string;
    featured_image: string;
    published_at: string;
    views: number;
    category?: { name: string };
}

interface TrendingGridProps {
    articles: Article[];
}

export function TrendingGrid({ articles }: TrendingGridProps) {
    if (!articles || articles.length === 0) return null;

    return (
        <section className="mx-auto max-w-7xl px-6 lg:px-8 mt-24">
            <div className="flex items-center gap-3 mb-10">
                <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500 shadow-lg shadow-orange-500/20">
                    <TrendingUp className="h-6 w-6 text-white" />
                </div>
                <div>
                    <h2 className="text-2xl font-black italic tracking-tighter text-white uppercase">Trending Now</h2>
                    <p className="text-xs font-bold text-muted-foreground uppercase tracking-widest mt-0.5">Most read articles this week</p>
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-4 h-[600px]">
                {articles.slice(0, 5).map((article, index) => (
                    <motion.a
                        key={article.id}
                        href={`/article/${article.slug}`}
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ delay: index * 0.1 }}
                        className={`group relative overflow-hidden rounded-3xl border border-white/10 ${
                            index === 0 ? 'md:col-span-2 md:row-span-2' : 
                            index === 1 ? 'md:col-span-2' : ''
                        }`}
                    >
                        <img
                            src={article.featured_image ? `/storage/${article.featured_image}` : '/placeholder.jpg'}
                            alt={article.title}
                            className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                        <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent group-hover:from-black/100 transition-colors" />
                        
                        <div className="absolute inset-0 p-6 flex flex-col justify-end">
                            <div className="flex items-center gap-2 mb-3">
                                <span className="rounded-full bg-orange-500 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white backdrop-blur-md">
                                    {article.category?.name || "Hot"}
                                </span>
                                <div className="flex items-center gap-1.5 text-[10px] font-bold text-white/60 uppercase tracking-widest">
                                    <Clock className="h-3 w-3" />
                                    {new Date(article.published_at).toLocaleDateString()}
                                </div>
                            </div>
                            <h3 className={`font-black tracking-tight text-white group-hover:text-orange-400 transition-colors ${index === 0 ? 'text-3xl' : 'text-lg'}`}>
                                {article.title}
                            </h3>
                            {index === 0 && (
                                <div className="mt-4 flex items-center gap-4 text-xs font-bold text-white/50">
                                    <span className="flex items-center gap-1.5"><Eye className="h-3.5 w-3.5" /> {article.views} Views</span>
                                </div>
                            )}
                        </div>
                    </motion.a>
                ))}
            </div>
        </section>
    );
}
