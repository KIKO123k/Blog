import { useEffect, useState } from 'react';
import MediaGallery from './MediaGallery';
import StarRating from './StarRating';
import SlidingPuzzle from './SlidingPuzzle';
import JoinForm from './JoinForm';

const TABS = [
    { id: 'discover', label: 'Découvrir', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
    { id: 'video', label: 'Vidéo', icon: 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z' },
    { id: 'gallery', label: 'Galerie', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { id: 'join', label: 'Rejoindre', icon: 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z' },
    { id: 'reviews', label: 'Avis', icon: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' },
    { id: 'puzzle', label: 'Puzzle', icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' },
];

function InstagramIcon() {
    return (
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zM12 16c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
        </svg>
    );
}

function LinkedInIcon() {
    return (
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
        </svg>
    );
}

export default function ClubModal({ club, presentationVideo, onClose }) {
    const [tab, setTab] = useState('discover');
    const [rating, setRating] = useState(0);
    const [comments, setComments] = useState(club.mock_comments.map((c) => ({ ...c })));
    const [newComment, setNewComment] = useState('');

    useEffect(() => {
        const onKey = (e) => {
            if (e.key === 'Escape') onClose();
        };
        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', onKey);
        return () => {
            document.body.style.overflow = '';
            document.removeEventListener('keydown', onKey);
        };
    }, [onClose]);

    const submitComment = (e) => {
        e.preventDefault();
        const text = newComment.trim();
        if (!text) return;
        setComments((c) => [{ author: 'Vous', text, time: "À l'instant" }, ...c]);
        setNewComment('');
    };

    const iconSvg = (d) => (
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="shrink-0">
            <path d={d} />
        </svg>
    );

    return (
        <div
            className="fixed inset-0 z-50 flex items-end justify-center bg-slate-950/80 p-0 backdrop-blur-md sm:items-center sm:p-4 animate-[fadeIn_0.2s_ease-out]"
            onClick={(e) => e.target === e.currentTarget && onClose()}
            role="dialog"
            aria-modal="true"
            aria-label={club.name}
        >
            <div className="relative flex max-h-[95vh] w-full max-w-4xl flex-col overflow-hidden rounded-t-2xl sm:rounded-2xl border border-white/10 bg-slate-900 shadow-2xl animate-[slideUp_0.3s_ease-out]">
                {/* Hero */}
                <div className="relative h-48 sm:h-60 shrink-0 overflow-hidden">
                    <img src={club.background} alt="" className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 hover:scale-105" />
                    <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent" />
                    <div
                        className="absolute -left-10 -bottom-10 h-40 w-40 rounded-full opacity-40 blur-3xl"
                        style={{ background: club.accent }}
                    />
                    <div
                        className="absolute -right-10 top-10 h-32 w-32 rounded-full opacity-20 blur-3xl"
                        style={{ background: club.accent }}
                    />
                    <button
                        type="button"
                        onClick={onClose}
                        aria-label="Fermer"
                        className="absolute right-3 top-3 grid h-10 w-10 place-items-center rounded-full bg-black/60 text-white backdrop-blur transition-all hover:bg-black/80 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                    <div className="absolute bottom-4 left-5 right-5">
                        <span
                            className="mb-2 inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-slate-950"
                            style={{ background: club.accent }}
                        >
                            {club.acronym}
                        </span>
                        <h2 className="text-2xl sm:text-3xl font-bold text-white drop-shadow-lg">{club.full_name}</h2>
                        <p className="text-sm text-slate-200/90">{club.acronym} — ENSA Kénitra</p>
                    </div>
                </div>

                {/* Tabs */}
                <nav className="flex shrink-0 overflow-x-auto border-b border-white/10 bg-slate-900/50 px-2 backdrop-blur scrollbar-thin" aria-label="Sections">
                    {TABS.map((t) => (
                        <button
                            key={t.id}
                            type="button"
                            onClick={() => setTab(t.id)}
                            className={`relative flex items-center gap-1.5 whitespace-nowrap px-4 py-3 text-sm font-semibold transition-all duration-200 ${
                                tab === t.id
                                    ? 'text-white'
                                    : 'text-slate-400 hover:text-slate-200 hover:bg-white/5'
                            }`}
                        >
                            {iconSvg(t.icon)}
                            {t.label}
                            {tab === t.id && (
                                <span
                                    className="absolute inset-x-2 -bottom-px h-0.5 rounded-full"
                                    style={{ background: club.accent }}
                                />
                            )}
                        </button>
                    ))}
                </nav>

                {/* Body */}
                <div className="flex-1 overflow-y-auto p-5 sm:p-6">
                    {tab === 'discover' && (
                        <div className="space-y-5 animate-[fadeIn_0.25s_ease-out]">
                            <div className="flex items-start gap-4">
                                <div
                                    className="shrink-0 grid h-12 w-12 place-items-center rounded-xl"
                                    style={{ background: `${club.accent}20` }}
                                >
                                    <span className="text-2xl">{club.acronym[0]}</span>
                                </div>
                                <div>
                                    <p className="text-sm leading-relaxed text-slate-200">{club.long_description}</p>
                                </div>
                            </div>
                            <div className="rounded-xl border border-white/5 bg-slate-900/40 p-4">
                                <h4 className="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Réseaux sociaux officiels
                                </h4>
                                <div className="flex flex-wrap gap-3">
                                    <a
                                        href={club.instagram}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 px-4 py-2 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 hover:shadow-pink-500/40 focus:outline-none focus:ring-2 focus:ring-pink-300"
                                    >
                                        <InstagramIcon /> Instagram
                                    </a>
                                    <a
                                        href={club.linkedin}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-2 rounded-full bg-sky-700 px-4 py-2 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 hover:bg-sky-600 hover:shadow-sky-500/40 focus:outline-none focus:ring-2 focus:ring-sky-300"
                                    >
                                        <LinkedInIcon /> LinkedIn
                                    </a>
                                </div>
                            </div>
                        </div>
                    )}

                    {tab === 'video' && (
                        <div className="space-y-3 animate-[fadeIn_0.25s_ease-out]">
                            <h4 className="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Vidéo de présentation
                            </h4>
                            <div className="overflow-hidden rounded-xl border border-white/10 bg-black aspect-video shadow-xl">
                                <video
                                    src={presentationVideo.src}
                                    poster={presentationVideo.poster}
                                    controls
                                    playsInline
                                    className="h-full w-full"
                                />
                            </div>
                            <p className="text-xs text-slate-400">{presentationVideo.caption}</p>
                        </div>
                    )}

                    {tab === 'gallery' && (
                        <div className="space-y-3 animate-[fadeIn_0.25s_ease-out]">
                            <h4 className="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Galerie photos & vidéos
                            </h4>
                            <MediaGallery items={club.gallery} accent={club.accent} />
                        </div>
                    )}

                    {tab === 'join' && (
                        <div className="animate-[fadeIn_0.25s_ease-out]">
                            <h4 className="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Formulaire d'inscription
                            </h4>
                            <JoinForm clubName={club.name} />
                        </div>
                    )}

                    {tab === 'reviews' && (
                        <div className="space-y-5 animate-[fadeIn_0.25s_ease-out]">
                            <div className="rounded-xl border border-white/10 bg-slate-900/40 p-4">
                                <h4 className="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Votre note
                                </h4>
                                <StarRating value={rating} onChange={setRating} accent={club.accent} />
                            </div>
                            <div>
                                <h4 className="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Commentaires ({comments.length})
                                </h4>
                                <ul className="space-y-3 mb-4">
                                    {comments.map((c, idx) => (
                                        <li
                                            key={idx}
                                            className="rounded-xl border border-white/5 bg-slate-900/40 p-4 transition hover:bg-slate-900/60"
                                        >
                                            <div className="mb-1 flex items-center justify-between text-xs">
                                                <span className="font-semibold text-white">{c.author}</span>
                                                <span className="text-slate-500">{c.time}</span>
                                            </div>
                                            <p className="text-sm text-slate-200">{c.text}</p>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                            <form onSubmit={submitComment} className="space-y-2">
                                <label htmlFor="club-comment" className="block text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Votre commentaire
                                </label>
                                <textarea
                                    id="club-comment"
                                    rows={3}
                                    required
                                    value={newComment}
                                    onChange={(e) => setNewComment(e.target.value)}
                                    placeholder="Partagez votre expérience avec ce club..."
                                    className="w-full rounded-lg border border-white/10 bg-slate-900/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 transition focus:border-emerald-400/60 focus:outline-none focus:ring-2 focus:ring-emerald-400/30"
                                />
                                <button
                                    type="submit"
                                    className="rounded-lg bg-gradient-to-r from-emerald-500 to-cyan-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition-all hover:shadow-emerald-500/50 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-emerald-300"
                                >
                                    Publier
                                </button>
                            </form>
                        </div>
                    )}

                    {tab === 'puzzle' && (
                        <div className="animate-[fadeIn_0.25s_ease-out]">
                            <SlidingPuzzle theme={club.theme} label={club.puzzle_label} accent={club.accent} />
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
