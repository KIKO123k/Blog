import { useState } from 'react';

const FILIERES = [
    ['GI', 'Génie Informatique'],
    ['RST', 'Réseaux & Systèmes Télécom'],
    ['GI2', 'Génie Industriel'],
    ['GE', 'Génie Électrique'],
    ['GM', 'Génie Mécatronique'],
    ['GER', 'Génie Énergétique'],
    ['AP', 'Années Préparatoires'],
];

const EMPTY = { name: '', email: '', filiere: '', motivation: '' };

export default function JoinForm({ clubName }) {
    const [form, setForm] = useState(EMPTY);
    const [submitted, setSubmitted] = useState(false);
    const [error, setError] = useState('');

    const update = (k) => (e) => setForm((f) => ({ ...f, [k]: e.target.value }));

    const onSubmit = (e) => {
        e.preventDefault();
        if (!form.name.trim() || !form.email.trim() || !form.filiere || !form.motivation.trim()) {
            setError('Tous les champs sont obligatoires.');
            return;
        }
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(form.email)) {
            setError('Email invalide.');
            return;
        }
        setError('');
        setSubmitted(true);
    };

    if (submitted) {
        return (
            <div
                role="status"
                className="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-6 text-center"
            >
                <div className="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-full bg-emerald-500/20 text-emerald-300">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <h4 className="mb-1 text-lg font-semibold text-white">Candidature envoyée !</h4>
                <p className="text-sm text-slate-300">
                    Le bureau de <strong>{clubName}</strong> vous contactera bientôt.
                </p>
            </div>
        );
    }

    const inputCls =
        'w-full rounded-lg border border-white/10 bg-slate-900/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 transition focus:border-emerald-400/60 focus:outline-none focus:ring-2 focus:ring-emerald-400/30';

    return (
        <form onSubmit={onSubmit} className="space-y-4">
            {error && (
                <div className="rounded-lg border border-rose-500/30 bg-rose-500/10 px-4 py-2 text-sm text-rose-200">
                    {error}
                </div>
            )}
            <div>
                <label htmlFor="club-name" className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Nom complet
                </label>
                <input
                    id="club-name"
                    type="text"
                    required
                    placeholder="Ex. Ahmed Benali"
                    value={form.name}
                    onChange={update('name')}
                    className={inputCls}
                />
            </div>
            <div>
                <label htmlFor="club-email" className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Email
                </label>
                <input
                    id="club-email"
                    type="email"
                    required
                    placeholder="Ex. ahmed@uit.ac.ma"
                    value={form.email}
                    onChange={update('email')}
                    className={inputCls}
                />
            </div>
            <div>
                <label htmlFor="club-filiere" className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Filière
                </label>
                <select
                    id="club-filiere"
                    required
                    value={form.filiere}
                    onChange={update('filiere')}
                    className={inputCls}
                >
                    <option value="">Choisir une filière</option>
                    {FILIERES.map(([v, l]) => (
                        <option key={v} value={v}>
                            {l}
                        </option>
                    ))}
                </select>
            </div>
            <div>
                <label htmlFor="club-motivation" className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Motivation
                </label>
                <textarea
                    id="club-motivation"
                    required
                    rows={4}
                    placeholder="Pourquoi souhaitez-vous rejoindre ce club ?"
                    value={form.motivation}
                    onChange={update('motivation')}
                    className={inputCls}
                />
            </div>
            <button
                type="submit"
                className="w-full rounded-lg bg-gradient-to-r from-emerald-500 to-cyan-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:shadow-emerald-500/50 hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-emerald-300"
            >
                Soumettre ma candidature
            </button>
        </form>
    );
}
