import React from 'react';
import { motion } from "framer-motion";
import { Calendar, User, Eye, ArrowUpRight } from "lucide-react";

interface Article {
    id: number;
    title: string;
    slug: string;
    excerpt: string;
    featured_image: string;
    published_at: string;
    views: number;
    category?: {
        name: string;
        slug: string;
    };
    user?: {
        name: string;
    };
}

interface ArticleCardProps {
    article: Article;
    variant?: "default" | "compact" | "wide";
    index?: number;
}

export function ArticleCard({ article, variant = "default", index = 0 }: ArticleCardProps) {
    const formattedDate = new Date(article.published_at).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });

    const isWide = variant === "wide";

    return (
        <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.5, delay: index * 0.1 }}
            className={`group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm transition-all hover:bg-white/10 hover:shadow-2xl hover:shadow-indigo-500/10 ${isWide ? 'flex md:flex-row flex-col' : 'flex flex-col'}`}
        >
            <div className={`relative overflow-hidden ${isWide ? 'md:w-1/3' : 'aspect-video'}`}>
                <img
                    src={article.featured_image ? `/storage/${article.featured_image}` : '/placeholder.jpg'}
                    alt={article.title}
                    className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 transition-opacity group-hover:opacity-100" />
                {article.category && (
                    <div className="absolute left-4 top-4">
                        <span className="rounded-full bg-indigo-500/80 px-3 py-1 text-xs font-medium text-white backdrop-blur-md">
                            {article.category.name}
                        </span>
                    </div>
                )}
            </div>

            <div className="flex flex-1 flex-col p-6">
                <div className="mb-3 flex items-center gap-4 text-[11px] font-medium uppercase tracking-wider text-muted-foreground">
                    <span className="flex items-center gap-1.5">
                        <Calendar className="h-3.5 w-3.5" />
                        {formattedDate}
                    </span>
                    <span className="flex items-center gap-1.5">
                        <Eye className="h-3.5 w-3.5" />
                        {article.views}
                    </span>
                </div>

                <a href={`/article/${article.slug}`} className="group/title flex items-start justify-between gap-2">
                    <h3 className="mb-2 text-xl font-bold leading-tight group-hover/title:text-indigo-400">
                        {article.title}
                    </h3>
                    <div className="mt-1 shrink-0 rounded-full bg-white/10 p-1.5 opacity-0 transition-all group-hover/title:opacity-100 group-hover/title:translate-x-1 group-hover/title:-translate-y-1">
                        <ArrowUpRight className="h-4 w-4" />
                    </div>
                </a>

                <p className="line-clamp-2 text-sm text-muted-foreground flex-grow mb-4">
                    {article.excerpt}
                </p>

                <div className="mt-auto pt-4 border-t border-white/10 flex items-center justify-between">
                    <div className="flex items-center gap-2">
                        {/* Avatar Placeholder */}
                        <div className="h-8 w-8 rounded-full bg-indigo-500/20 border border-indigo-500/40 flex items-center justify-center">
                            <User className="h-4 w-4 text-indigo-400" />
                        </div>
                        <span className="text-xs font-semibold">{article.user?.name || "Admin"}</span>
                    </div>
                    <a href={`/article/${article.slug}`} className="text-xs font-bold text-indigo-400 hover:underline underline-offset-4">
                        Read More
                    </a>
                </div>
            </div>
        </motion.div>
    );
}
