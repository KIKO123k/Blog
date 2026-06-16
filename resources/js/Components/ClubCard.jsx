export default function ClubCard({ club, onOpen }) {
    return (
        <button
            type="button"
            onClick={() => onOpen(club)}
            aria-label={`Découvrir ${club.name}`}
            className="group relative flex h-80 w-full flex-col justify-end overflow-hidden rounded-2xl text-left shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-500/10 focus:outline-none focus:ring-2 focus:ring-emerald-400/60"
            style={{ '--accent': club.accent }}
        >
            <img
                src={club.background}
                alt=""
                loading="lazy"
                className="absolute inset-0 h-full w-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:brightness-110"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent" />
            {/* Multi-layer glow effect */}
            <div
                className="absolute -right-10 -top-10 h-32 w-32 rounded-full opacity-40 blur-3xl transition-all duration-500 group-hover:opacity-70 group-hover:scale-150"
                style={{ background: club.accent }}
            />
            <div
                className="absolute -bottom-20 -left-20 h-40 w-40 rounded-full opacity-0 blur-3xl transition-all duration-700 group-hover:opacity-30"
                style={{ background: club.accent }}
            />

            <span
                className="absolute right-4 top-4 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider text-slate-950 shadow-lg backdrop-blur transition-all duration-300 group-hover:scale-110"
                style={{ background: club.accent }}
            >
                {club.acronym}
            </span>

            <span className="absolute right-4 top-1/2 -translate-y-1/2 grid h-10 w-10 place-items-center rounded-full bg-white/10 text-white opacity-0 backdrop-blur transition-all duration-500 group-hover:opacity-100 group-hover:right-6 group-hover:scale-110">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </span>

            {/* Animated border glow on hover */}
            <div className="absolute inset-0 rounded-2xl border-2 border-transparent transition-all duration-500 group-hover:border-emerald-400/20" />

            <div className="relative p-5">
                <h3 className="mb-1 text-xl font-bold text-white drop-shadow-lg">{club.name}</h3>
                <p className="mb-3 line-clamp-2 text-sm text-slate-200/90">{club.description}</p>
                <span
                    className="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group-hover:translate-x-2"
                    style={{ color: club.accent }}
                >
                    Découvrir
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="transition-transform duration-300 group-hover:translate-x-1">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </span>
            </div>
        </button>
    );
}
