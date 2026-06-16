import React, { useState } from 'react';
import { Search, Tag, MapPin, Calendar, Plus, MessageSquare, BadgeAlert, CheckCircle2 } from 'lucide-react';
import type { LostFoundItem } from '../types';

export const LostFound: React.FC = () => {
  const [items, setItems] = useState<LostFoundItem[]>([
    {
      id: '1',
      type: 'lost',
      title: 'Carte d\'étudiant ENSAK',
      description: 'Perdue près de la bibliothèque. Nom écrit dessus : El Amrani Youssef.',
      category: 'Student Card',
      location: 'Bibliothèque',
      date: '15/06/2026',
      status: 'open',
      contactName: 'Youssef El Amrani'
    },
    {
      id: '2',
      type: 'found',
      title: 'Calculatrice Casio Graph 35+',
      description: 'Trouvée dans la salle de cours TD 4 après le cours d\'Algèbre.',
      category: 'Calculator',
      location: 'Salle TD 4',
      date: '14/06/2026',
      status: 'open',
      contactName: 'Nihad Mansouri'
    },
    {
      id: '3',
      type: 'lost',
      title: 'Clé USB SanDisk 64GB',
      description: 'Clé USB rouge contenant des projets informatiques. Perdue dans les labos de TP.',
      category: 'USB Drive',
      location: 'Salle TP Informatique',
      date: '10/06/2026',
      status: 'resolved',
      contactName: 'Amine Bensaid'
    }
  ]);

  const [isFormOpen, setIsFormOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedCat, setSelectedCat] = useState('All');
  const [selectedType, setSelectedType] = useState<'all' | 'lost' | 'found'>('all');

  // New report form states
  const [newTitle, setNewTitle] = useState('');
  const [newDesc, setNewDesc] = useState('');
  const [newCat, setNewCat] = useState<any>('Student Card');
  const [newLoc, setNewLoc] = useState('');
  const [newType, setNewType] = useState<'lost' | 'found'>('lost');

  const handleCreateReport = (e: React.FormEvent) => {
    e.preventDefault();
    if (!newTitle.trim() || !newDesc.trim() || !newLoc.trim()) return;

    const newItem: LostFoundItem = {
      id: String(items.length + 1),
      type: newType,
      title: newTitle,
      description: newDesc,
      category: newCat,
      location: newLoc,
      date: new Date().toLocaleDateString('fr-FR'),
      status: 'open',
      contactName: 'Moi'
    };

    setItems([newItem, ...items]);
    setIsFormOpen(false);
    // Reset form states
    setNewTitle('');
    setNewDesc('');
    setNewLoc('');
  };

  const filteredItems = items.filter(item => {
    const matchesSearch = item.title.toLowerCase().includes(searchQuery.toLowerCase()) || 
                          item.description.toLowerCase().includes(searchQuery.toLowerCase());
    const matchesCat = selectedCat === 'All' || item.category === selectedCat;
    const matchesType = selectedType === 'all' || item.type === selectedType;
    return matchesSearch && matchesCat && matchesType;
  });

  return (
    <div className="space-y-6">
      {/* Title */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-3xl font-heading text-slate-900">Campus Lost & Found</h1>
          <p className="text-sm text-slate-500">Signalez des objets perdus ou retrouvés sur le campus de l'ENSA Kénitra.</p>
        </div>
        <button
          onClick={() => setIsFormOpen(!isFormOpen)}
          className="flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-300 to-teal-400 text-slate-900 font-semibold rounded-xl hover:shadow-lg transition-all"
        >
          <Plus size={16} />
          <span>Déclarer un objet</span>
        </button>
      </div>

      {/* Report Form modal-drawer overlay */}
      {isFormOpen && (
        <div className="bg-white/90 backdrop-blur-md border border-slate-900/10 p-6 rounded-2xl shadow-glass space-y-4 max-w-xl mx-auto">
          <h2 className="text-lg font-heading text-slate-800 font-bold">Déclarer un nouvel objet</h2>
          <form onSubmit={handleCreateReport} className="space-y-3">
            <div className="flex gap-4">
              <label className="flex-1 flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-slate-50">
                <input
                  type="radio"
                  name="type"
                  checked={newType === 'lost'}
                  onChange={() => setNewType('lost')}
                  className="accent-slate-950"
                />
                <span className="text-xs font-semibold text-rose-600 uppercase">Objet Perdu</span>
              </label>
              <label className="flex-1 flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-slate-50">
                <input
                  type="radio"
                  name="type"
                  checked={newType === 'found'}
                  onChange={() => setNewType('found')}
                  className="accent-slate-950"
                />
                <span className="text-xs font-semibold text-emerald-600 uppercase">Objet Trouvé</span>
              </label>
            </div>
            
            <div>
              <label className="block text-xxs font-bold text-slate-400 uppercase mb-1">Nom de l'objet</label>
              <input
                type="text"
                placeholder="Ex: Clés de voiture Peugeot, Cartable bleu..."
                value={newTitle}
                onChange={(e) => setNewTitle(e.target.value)}
                className="w-full p-2.5 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400"
                required
              />
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-xxs font-bold text-slate-400 uppercase mb-1">Catégorie</label>
                <select
                  value={newCat}
                  onChange={(e) => setNewCat(e.target.value as any)}
                  className="w-full p-2.5 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400 text-slate-700"
                >
                  <option>Student Card</option>
                  <option>Laptop</option>
                  <option>Smartphone</option>
                  <option>Calculator</option>
                  <option>USB Drive</option>
                  <option>Keys</option>
                  <option>Books</option>
                  <option>Other</option>
                </select>
              </div>
              <div>
                <label className="block text-xxs font-bold text-slate-400 uppercase mb-1">Lieu</label>
                <input
                  type="text"
                  placeholder="Ex: Amphi A, Buvette..."
                  value={newLoc}
                  onChange={(e) => setNewLoc(e.target.value)}
                  className="w-full p-2.5 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400"
                  required
                />
              </div>
            </div>

            <div>
              <label className="block text-xxs font-bold text-slate-400 uppercase mb-1">Description & indices</label>
              <textarea
                placeholder="Décrivez l'objet, sa couleur, marque, état..."
                rows={3}
                value={newDesc}
                onChange={(e) => setNewDesc(e.target.value)}
                className="w-full p-2.5 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400"
                required
              />
            </div>

            <div className="flex gap-3 pt-2">
              <button
                type="submit"
                className="flex-1 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs transition"
              >
                Publier la déclaration
              </button>
              <button
                type="button"
                onClick={() => setIsFormOpen(false)}
                className="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs transition font-semibold"
              >
                Annuler
              </button>
            </div>
          </form>
        </div>
      )}

      {/* Filter and search parameters */}
      <div className="flex flex-col md:flex-row gap-3 bg-white/70 backdrop-blur-md border border-slate-900/10 p-4 rounded-2xl shadow-glass">
        <div className="flex-1 relative">
          <Search className="absolute left-3 top-2.5 text-slate-400" size={16} />
          <input
            type="text"
            placeholder="Rechercher un objet perdu ou retrouvé..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            className="w-full pl-9 pr-4 py-2 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400"
          />
        </div>
        <div className="flex gap-2">
          <select
            value={selectedCat}
            onChange={(e) => setSelectedCat(e.target.value)}
            className="p-2 text-xs border border-slate-900/10 rounded-xl bg-white focus:outline-none focus:border-emerald-400 text-slate-600"
          >
            <option value="All">Toutes catégories</option>
            <option value="Student Card">Student Card</option>
            <option value="Laptop">Laptop</option>
            <option value="Smartphone">Smartphone</option>
            <option value="Calculator">Calculator</option>
            <option value="USB Drive">USB Drive</option>
            <option value="Keys">Keys</option>
            <option value="Books">Books</option>
            <option value="Other">Other</option>
          </select>
          <div className="flex border border-slate-900/10 rounded-xl overflow-hidden bg-white">
            <button
              onClick={() => setSelectedType('all')}
              className={`px-3 py-2 text-xs font-semibold ${selectedType === 'all' ? 'bg-slate-900 text-white' : 'hover:bg-slate-50 text-slate-600'}`}
            >
              Tous
            </button>
            <button
              onClick={() => setSelectedType('lost')}
              className={`px-3 py-2 text-xs font-semibold ${selectedType === 'lost' ? 'bg-rose-500 text-white' : 'hover:bg-rose-50 text-rose-600'}`}
            >
              Perdus
            </button>
            <button
              onClick={() => setSelectedType('found')}
              className={`px-3 py-2 text-xs font-semibold ${selectedType === 'found' ? 'bg-emerald-500 text-white' : 'hover:bg-emerald-50 text-emerald-600'}`}
            >
              Trouvés
            </button>
          </div>
        </div>
      </div>

      {/* Grid List */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {filteredItems.map(item => (
          <div
            key={item.id}
            className={`bg-white/70 backdrop-blur-md border border-slate-900/10 rounded-2xl shadow-glass flex flex-col justify-between hover:shadow-lg transition-all duration-200 ${
              item.status === 'resolved' ? 'opacity-70' : ''
            }`}
          >
            <div className="p-5 space-y-3">
              <div className="flex items-center justify-between">
                <span className={`px-2 py-0.5 rounded-full text-xxs font-bold uppercase ${
                  item.type === 'lost' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100'
                }`}>
                  {item.type === 'lost' ? 'Perdu' : 'Trouvé'}
                </span>
                
                {/* Status tag */}
                {item.status === 'resolved' ? (
                  <span className="flex items-center gap-1 text-xxs font-semibold text-slate-500 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-full">
                    <CheckCircle2 size={10} /> Restitué
                  </span>
                ) : (
                  <span className="flex items-center gap-1 text-xxs font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                    <BadgeAlert size={10} /> En attente
                  </span>
                )}
              </div>

              <div>
                <h3 className="font-heading text-sm text-slate-800 font-bold leading-tight">{item.title}</h3>
                <p className="text-xs text-slate-500 mt-2 leading-relaxed">{item.description}</p>
              </div>

              <div className="pt-3 flex flex-col gap-1.5 text-xxs text-slate-400 font-semibold">
                <div className="flex items-center gap-1.5">
                  <Tag size={12} className="text-slate-400" />
                  <span>Catégorie : {item.category}</span>
                </div>
                <div className="flex items-center gap-1.5">
                  <MapPin size={12} className="text-slate-400" />
                  <span>Lieu : {item.location}</span>
                </div>
                <div className="flex items-center gap-1.5">
                  <Calendar size={12} className="text-slate-400" />
                  <span>Signalé le : {item.date}</span>
                </div>
              </div>
            </div>

            <div className="p-4 bg-slate-50/50 border-t border-slate-900/5 flex items-center justify-between rounded-b-2xl">
              <span className="text-xxs font-medium text-slate-400">Par {item.contactName}</span>
              {item.status !== 'resolved' && (
                <button className="flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-slate-850 text-white rounded-lg text-xxs font-semibold transition">
                  <MessageSquare size={12} />
                  <span>Contacter</span>
                </button>
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};
