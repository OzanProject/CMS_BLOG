import React from 'react';
import { Search, Menu, X, Rocket, ChevronDown } from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface NavbarProps {
    settings: any;
    categories: Category[];
}

export function Navbar({ settings, categories }: NavbarProps) {
    const [isScrolled, setIsScrolled] = React.useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = React.useState(false);

    React.useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 20);
        };
        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    const siteName = settings.site_name || "ModernBlog";
    const siteLogo = settings.site_logo ? `/storage/${settings.site_logo}` : null;

    return (
        <nav
            className={`fixed top-0 z-50 w-full transition-all duration-300 ${isScrolled ? 'bg-background/80 border-b border-white/10 backdrop-blur-lg py-3' : 'bg-transparent py-5'}`}
        >
            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                <div className="flex items-center justify-between">
                    <a href="/" className="group flex items-center gap-2">
                        {siteLogo ? (
                            <img src={siteLogo} alt={siteName} className="h-10 w-auto" />
                        ) : (
                            <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                                <Rocket className="h-6 w-6 text-white" />
                            </div>
                        )}
                        <span className="text-xl font-black italic tracking-tighter text-white">
                            {siteName}
                        </span>
                    </a>

                    {/* Desktop Menu */}
                    <div className="hidden lg:flex items-center gap-8">
                        <a href="/" className="text-sm font-semibold hover:text-indigo-400 transition-colors">Home</a>
                        {categories.map((cat) => (
                            <a 
                                key={cat.id} 
                                href={`/category/${cat.slug}`}
                                className="text-sm font-semibold hover:text-indigo-400 transition-colors"
                            >
                                {cat.name}
                            </a>
                        ))}
                    </div>

                    <div className="flex items-center gap-4">
                        <button className="hidden sm:flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:bg-indigo-500 hover:shadow-lg hover:shadow-indigo-500/20">
                            <Search className="h-5 w-5" />
                        </button>
                        <button 
                            className="lg:hidden h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:bg-indigo-500"
                            onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                        >
                            {isMobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
                        </button>
                    </div>
                </div>
            </div>

            {/* Mobile Menu Overlay */}
            <AnimatePresence>
                {isMobileMenuOpen && (
                    <motion.div
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: "auto" }}
                        exit={{ opacity: 0, height: 0 }}
                        className="lg:hidden border-t border-white/10 bg-background overflow-hidden"
                    >
                        <div className="p-6 space-y-4">
                            <a href="/" className="block text-lg font-bold">Home</a>
                            {categories.map((cat) => (
                                <a key={cat.id} href={`/category/${cat.slug}`} className="block text-lg font-medium text-muted-foreground hover:text-white transition-colors">
                                    {cat.name}
                                </a>
                            ))}
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </nav>
    );
}
