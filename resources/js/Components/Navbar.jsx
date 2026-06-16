import { Link } from '@inertiajs/inertia-react';

function UserChip() {
    return (
        <div className="group relative">
            <button
                type="button"
                className="flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-white backdrop-blur transition hover:bg-white/10 hover:border-white/20 focus:outline-none focus:ring-2 focus:ring-emerald-400/60"
            >
                <span className="grid h-7 w-7 place-items-center rounded-full bg-gradient-to-br from-emerald-400 to-cyan-500 text-[11px] font-bold text-slate-950">
                    KN
                </span>
                <span className="hidden sm:inline font-medium">Khadija Nafia</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="text-slate-400 transition group-hover:rotate-180">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div className="absolute right-0 top-full mt-2 w-48 origin-top-right scale-95 rounded-xl border border-white/10 bg-slate-900/95 p-1.5 opacity-0 shadow-2xl backdrop-blur transition-all duration-200 group-focus-within:scale-100 group-focus-within:opacity-100 group-hover:scale-100 group-hover:opacity-100">
                <a href="#" className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-white/5">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profil
                </a>
                <a href="#" className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-white/5">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Paramètres
                </a>
                <hr className="my-1 border-white/10" />
                <button type="button" className="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-rose-300 transition hover:bg-rose-500/10">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Déconnexion
                </button>
            </div>
        </div>
    );
}

const NAV_LINKS = [
    { href: '/', label: 'Accueil' },
    { href: '/formations/genie-informatique', label: 'Filière' },
    { href: '/clubs', label: 'Clubs', active: true },
    { href: '/posts', label: 'Ressources' },
];

export default function Navbar() {
    return (
        <header className="sticky top-0 z-40 border-b border-white/5 bg-slate-950/80 backdrop-blur-xl">
            <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <Link href="/" className="flex items-center gap-2.5 group">
                    <span className="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-emerald-400 to-cyan-500 text-lg font-extrabold tracking-tight text-slate-950 shadow-lg shadow-emerald-500/20 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                        b
                    </span>
                    <span className="text-xl font-bold tracking-tight text-white transition-colors group-hover:text-emerald-300">
                        <span className="text-emerald-400">ø</span>g
                    </span>
                </Link>

                <nav className="hidden items-center gap-1 sm:flex" aria-label="Navigation principale">
                    {NAV_LINKS.map((link) =>
                        link.active ? (
                            <span
                                key={link.href}
                                className="rounded-full bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 px-4 py-1.5 text-sm font-semibold text-white ring-1 ring-emerald-400/30"
                            >
                                {link.label}
                            </span>
                        ) : (
                            <Link
                                key={link.href}
                                href={link.href}
                                className="rounded-full px-4 py-1.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white"
                            >
                                {link.label}
                            </Link>
                        )
                    )}
                    <UserChip />
                </nav>

                <div className="flex items-center gap-2 sm:hidden">
                    <UserChip />
                    <button
                        type="button"
                        className="grid h-9 w-9 place-items-center rounded-lg text-slate-300 hover:bg-white/5 hover:text-white"
                        aria-label="Menu"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>
    );
}
