import { useEffect, useState } from 'react';

const SOLVED = [1, 2, 3, 4, 5, 6, 7, 8, 0];

function shuffleSolvable() {
    let arr;
    do {
        arr = [...SOLVED];
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
    } while (!isSolvable(arr) || JSON.stringify(arr) === JSON.stringify(SOLVED));
    return arr;
}

function isSolvable(arr) {
    const flat = arr.filter((n) => n !== 0);
    let inv = 0;
    for (let i = 0; i < flat.length; i++) {
        for (let j = i + 1; j < flat.length; j++) {
            if (flat[i] > flat[j]) inv++;
        }
    }
    return inv % 2 === 0;
}

function themeEmoji(theme) {
    return {
        code: ['{', '}', ';', '<', '/', '>', '=', '(', '✦'],
        robotics: ['🤖', '⚙', '🔋', '🔌', '📡', '🛠', '⚡', '🔧', '★'],
        ai: ['🧠', '∑', 'π', 'λ', 'σ', '∇', '∞', '∂', '✦'],
        cyber: ['01', '10', '11', '0x', 'FF', '42', 'AE', '7C', '✦'],
        network: ['↑', '↓', '⇆', '⌬', '⇄', '⇡', '⇣', '≈', '✦'],
        industrial: ['⚙', '📦', '🏭', '📊', '🛒', '🚚', '📈', '⚖', '✦'],
    }[theme] || ['{', '}', ';', '<', '/', '>', '=', '(', '✦'];
}

export default function SlidingPuzzle({ theme = 'code', label = 'Puzzle', accent = '#6EE7B7' }) {
    const [tiles, setTiles] = useState(() => shuffleSolvable());
    const [moves, setMoves] = useState(0);
    const [won, setWon] = useState(false);

    useEffect(() => {
        if (JSON.stringify(tiles) === JSON.stringify(SOLVED)) setWon(true);
    }, [tiles]);

    const reset = () => {
        setTiles(shuffleSolvable());
        setMoves(0);
        setWon(false);
    };

    const move = (i) => {
        if (won) return;
        const empty = tiles.indexOf(0);
        const row = Math.floor(i / 3);
        const col = i % 3;
        const er = Math.floor(empty / 3);
        const ec = empty % 3;
        if (Math.abs(row - er) + Math.abs(col - ec) !== 1) return;
        const next = [...tiles];
        [next[i], next[empty]] = [next[empty], next[i]];
        setTiles(next);
        setMoves((m) => m + 1);
    };

    const glyphs = themeEmoji(theme);

    return (
        <div className="rounded-xl border border-white/10 bg-slate-900/40 p-5">
            <p className="mb-3 text-sm text-slate-300">
                Reconstituez le puzzle <strong className="text-white">{label}</strong> en faisant glisser les tuiles !
            </p>
            <div className="mb-3 flex items-center justify-between text-sm">
                <span className="text-slate-300">
                    Coups : <strong className="text-white">{moves}</strong>
                </span>
                {won ? (
                    <span className="flex items-center gap-1.5 font-semibold text-emerald-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5"><polyline points="20 6 9 17 4 12" /></svg>
                        Résolu !
                    </span>
                ) : (
                    <span className="text-xs text-slate-500">Glissez les tuiles pour reconstituer</span>
                )}
            </div>
            <div className="mx-auto grid w-full max-w-[280px] grid-cols-3 gap-2">
                {tiles.map((t, i) => (
                    <button
                        key={i}
                        type="button"
                        onClick={() => move(i)}
                        aria-label={t === 0 ? 'case vide' : `tuile ${t}`}
                        className={`aspect-square rounded-lg text-2xl font-bold transition-all duration-200 ${
                            t === 0
                                ? 'cursor-default bg-transparent'
                                : won
                                ? 'shadow-lg scale-105'
                                : 'shadow hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2'
                        }`}
                        style={
                            t === 0
                                ? {}
                                : won
                                ? { background: `${accent}cc`, color: '#fff', boxShadow: `0 0 20px ${accent}40` }
                                : { background: 'linear-gradient(135deg, #334155, #1e293b)', color: '#fff' }
                        }
                    >
                        {t === 0 ? '' : glyphs[t - 1]}
                    </button>
                ))}
            </div>
            <button
                type="button"
                onClick={reset}
                className="mt-4 w-full rounded-lg border border-white/10 bg-white/5 py-2 text-sm font-medium text-white transition-all hover:bg-white/10 hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-emerald-400/60"
                style={{ '--tw-ring-color': accent }}
            >
                Recommencer
            </button>
        </div>
    );
}
