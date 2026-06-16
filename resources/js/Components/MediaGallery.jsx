import { useState } from 'react';

export default function MediaGallery({ items = [], accent = '#6EE7B7' }) {
    const [index, setIndex] = useState(0);
    const safe = items.length ? items : [];
    if (!safe.length) {
        return (
            <div className="rounded-xl border border-white/10 bg-slate-900/40 p-6 text-sm text-slate-400">
                Galerie bientôt disponible.
            </div>
        );
    }

    const prev = () => setIndex((i) => (i - 1 + safe.length) % safe.length);
    const next = () => setIndex((i) => (i + 1) % safe.length);
    const current = safe[index];

    return (
        <div className="space-y-3">
            <div className="relative overflow-hidden rounded-xl border border-white/10 bg-slate-900/40 aspect-video shadow-xl">
                {current.type === 'video' ? (
                    <video
                        key={current.src}
                        src={current.src}
                        controls
                        className="h-full w-full object-cover"
                    />
                ) : (
                    <img
                        key={current.src}
                        src={current.src}
                        alt={`Media ${index + 1}`}
                        className="h-full w-full object-cover transition-opacity duration-500"
                        loading="lazy"
                    />
                )}

                <button
                    type="button"
                    onClick={prev}
                    aria-label="Précédent"
                    className="absolute left-3 top-1/2 -translate-y-1/2 grid h-10 w-10 place-items-center rounded-full bg-black/60 text-white backdrop-blur transition-all hover:bg-black/80 hover:scale-110"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </button>
                <button
                    type="button"
                    onClick={next}
                    aria-label="Suivant"
                    className="absolute right-3 top-1/2 -translate-y-1/2 grid h-10 w-10 place-items-center rounded-full bg-black/60 text-white backdrop-blur transition-all hover:bg-black/80 hover:scale-110"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </button>

                <div
                    className="absolute bottom-3 left-1/2 -translate-x-1/2 rounded-full bg-black/60 px-3 py-1 text-xs text-white backdrop-blur"
                >
                    {index + 1} / {safe.length}
                </div>
            </div>

            <div className="flex gap-2 overflow-x-auto pb-1 scrollbar-thin">
                {safe.map((m, i) => (
                    <button
                        key={i}
                        type="button"
                        onClick={() => setIndex(i)}
                        className={`relative h-16 w-24 shrink-0 overflow-hidden rounded-lg border-2 transition-all duration-200 hover:scale-105 ${
                            i === index ? 'opacity-100' : 'border-transparent opacity-50 hover:opacity-80'
                        }`}
                        style={i === index ? { borderColor: accent } : {}}
                        aria-label={`Aller au média ${i + 1}`}
                    >
                        {m.type === 'video' ? (
                            <>
                                <video src={m.src} className="h-full w-full object-cover" muted />
                                <span className="absolute inset-0 grid place-items-center text-white">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </span>
                            </>
                        ) : (
                            <img src={m.src} alt="" className="h-full w-full object-cover" />
                        )}
                    </button>
                ))}
            </div>
        </div>
    );
}
