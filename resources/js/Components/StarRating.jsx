import { useState } from 'react';

export default function StarRating({ value = 0, onChange, accent = '#6EE7B7' }) {
    const [hover, setHover] = useState(0);
    const display = hover || value;

    return (
        <div className="flex items-center gap-1" role="radiogroup" aria-label="Note">
            {[1, 2, 3, 4, 5].map((star) => {
                const active = star <= display;
                return (
                    <button
                        key={star}
                        type="button"
                        role="radio"
                        aria-checked={star === value}
                        aria-label={`${star} étoiles`}
                        onClick={() => onChange?.(star)}
                        onMouseEnter={() => setHover(star)}
                        onMouseLeave={() => setHover(0)}
                        className={`group h-9 w-9 transition-all duration-150 hover:scale-125 focus:outline-none focus:ring-2 rounded ${
                            active
                                ? 'drop-shadow-lg'
                                : 'text-slate-500 hover:text-slate-300'
                        }`}
                        style={active ? { color: '#FBBF24' } : {}}
                    >
                        <svg viewBox="0 0 24 24" fill="currentColor" className="h-full w-full">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                );
            })}
            <span className="ml-3 text-sm font-medium text-slate-300 min-w-[3rem]">
                {value ? `${value}/5` : 'Votre note'}
            </span>
        </div>
    );
}
