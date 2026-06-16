import { useState } from 'react';
import { Head } from '@inertiajs/inertia-react';
import Navbar from '../../Components/Navbar';
import ClubCard from '../../Components/ClubCard';
import ClubModal from '../../Components/ClubModal';

export default function ClubsIndex({ clubs, presentationVideo }) {
    const [activeClub, setActiveClub] = useState(null);

    return (
        <>
            <Head title="Clubs Étudiants · ENSA Kénitra" />

            <div className="min-h-screen bg-slate-950">
                <Navbar />

                <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
                    {/* Header */}
                    <header className="mb-10 sm:mb-14 text-center">
                        <div className="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-300">
                            <span className="relative flex h-2 w-2">
                                <span className="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" />
                                <span className="relative inline-flex h-2 w-2 rounded-full bg-emerald-400" />
                            </span>
                            Vie associative
                        </div>
                        <h1 className="mb-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Découvrez nos{' '}
                            <span className="bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent">
                                Clubs Étudiants
                            </span>
                        </h1>
                        <p className="mx-auto max-w-3xl text-base leading-relaxed text-slate-300 sm:text-lg">
                            L'excellence académique s'accompagne d'un engagement associatif fort. Explorez les clubs de
                            l'ENSA Kénitra, inscrivez-vous, partagez votre avis et relevez le défi puzzle !
                        </p>
                        <div className="mt-6 flex flex-wrap items-center justify-center gap-6 text-sm text-slate-400">
                            <span className="flex items-center gap-1.5">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                                {clubs.length} clubs actifs
                            </span>
                            <span className="flex items-center gap-1.5">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                200+ membres
                            </span>
                            <span className="flex items-center gap-1.5">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Depuis 2011
                            </span>
                        </div>
                    </header>

                    {/* Grid */}
                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {clubs.map((club) => (
                            <ClubCard key={club.id} club={club} onOpen={setActiveClub} />
                        ))}
                    </div>

                    {/* Footer note */}
                    <div className="mt-14 text-center text-xs text-slate-500">
                        {clubs.length} clubs actifs · ENSA Kénitra · {new Date().getFullYear()}
                    </div>
                </div>
            </div>

            {/* Modal */}
            {activeClub && (
                <ClubModal
                    club={activeClub}
                    presentationVideo={presentationVideo}
                    onClose={() => setActiveClub(null)}
                />
            )}
        </>
    );
}
