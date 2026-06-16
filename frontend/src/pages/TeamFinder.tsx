import React, { useState } from 'react';
import { Search, UserCheck, MessageSquare, Sparkles, Code, Info } from 'lucide-react';
import type { TeammateMatch } from '../types';

export const TeamFinder: React.FC = () => {
  const [profileCreated, setProfileCreated] = useState(true);
  const [invitedIds, setInvitedIds] = useState<string[]>([]);
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedDept, setSelectedDept] = useState('All');
  
  const [teammates] = useState<TeammateMatch[]>([
    {
      id: '1',
      name: 'Youssef El Amrani',
      department: 'Génie Informatique',
      academicYear: 'CI-2',
      skills: ['React', 'Node.js', 'PostgreSQL', 'Docker'],
      languages: ['TypeScript', 'JavaScript', 'SQL'],
      compatibility: 96,
      avatarLetter: 'Y'
    },
    {
      id: '2',
      name: 'Nihad Mansouri',
      department: 'Génie Informatique',
      academicYear: 'CI-1',
      skills: ['Vue.js', 'Express', 'MongoDB', 'Python'],
      languages: ['JavaScript', 'Python'],
      compatibility: 84,
      avatarLetter: 'N'
    },
    {
      id: '3',
      name: 'Amine Bensaid',
      department: 'Génie Réseaux & Télécoms',
      academicYear: 'CI-2',
      skills: ['Network Security', 'Linux', 'Ansible', 'Cisco'],
      languages: ['Bash', 'Python'],
      compatibility: 72,
      avatarLetter: 'A'
    },
    {
      id: '4',
      name: 'Khadija Nafia',
      department: 'Génie Informatique',
      academicYear: 'CI-3',
      skills: ['Laravel', 'Vue.js', 'MySQL', 'PHP', 'Tailwind CSS'],
      languages: ['PHP', 'JavaScript', 'HTML/CSS'],
      compatibility: 68,
      avatarLetter: 'K'
    }
  ]);

  const sendInvitation = (id: string) => {
    setInvitedIds(prev => [...prev, id]);
  };

  const filteredTeammates = teammates.filter(t => {
    const matchesSearch = t.name.toLowerCase().includes(searchQuery.toLowerCase()) || 
                          t.skills.some(s => s.toLowerCase().includes(searchQuery.toLowerCase()));
    const matchesDept = selectedDept === 'All' || t.department === selectedDept;
    return matchesSearch && matchesDept;
  });

  return (
    <div className="space-y-6">
      {/* Title */}
      <div>
        <h1 className="text-3xl font-heading text-slate-900">Find Teammates</h1>
        <p className="text-sm text-slate-500">Recommandations de binômes et de partenaires de projets techniques basées sur vos compétences et affinités.</p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {/* Left Side: Create/View Technical Profile */}
        <div className="lg:col-span-1 bg-white/70 backdrop-blur-md border border-slate-900/10 rounded-2xl shadow-glass p-5 space-y-4">
          <h2 className="text-lg font-heading text-slate-800 flex items-center gap-2">
            <Code size={18} className="text-emerald-500" />
            Mon Profil Technique
          </h2>
          {profileCreated ? (
            <div className="space-y-3 text-sm">
              <div>
                <span className="block text-slate-400 text-xxs font-bold uppercase">Filière / Année</span>
                <span className="font-semibold text-slate-800">Génie Informatique - CI-2</span>
              </div>
              <div>
                <span className="block text-slate-400 text-xxs font-bold uppercase">Langages</span>
                <div className="flex flex-wrap gap-1 mt-1">
                  {['PHP', 'JavaScript', 'TypeScript'].map(lang => (
                    <span key={lang} className="px-2 py-0.5 bg-slate-900/5 text-slate-700 rounded-md text-xxs font-medium">{lang}</span>
                  ))}
                </div>
              </div>
              <div>
                <span className="block text-slate-400 text-xxs font-bold uppercase">Technologies</span>
                <div className="flex flex-wrap gap-1 mt-1">
                  {['Laravel', 'React', 'MySQL', 'Tailwind'].map(tech => (
                    <span key={tech} className="px-2 py-0.5 bg-slate-900/5 text-slate-700 rounded-md text-xxs font-medium">{tech}</span>
                  ))}
                </div>
              </div>
              <button
                onClick={() => setProfileCreated(false)}
                className="w-full py-2 bg-slate-900 hover:bg-slate-850 text-white rounded-xl text-xs font-semibold transition"
              >
                Modifier mon profil
              </button>
            </div>
          ) : (
            <div className="space-y-3">
              <div>
                <label className="block text-slate-500 text-xs font-semibold mb-1">Filière</label>
                <select className="w-full p-2 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400">
                  <option>Génie Informatique</option>
                  <option>Génie Réseaux & Télécoms</option>
                  <option>Génie Industriel</option>
                  <option>Génie Mécatronique</option>
                </select>
              </div>
              <div>
                <label className="block text-slate-500 text-xs font-semibold mb-1">Année d'étude</label>
                <select className="w-full p-2 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400">
                  <option>CI-1 (1ère année)</option>
                  <option>CI-2 (2ème année)</option>
                  <option>CI-3 (3ème année)</option>
                </select>
              </div>
              <div>
                <label className="block text-slate-500 text-xs font-semibold mb-1">Compétences (séparées par des virgules)</label>
                <input
                  type="text"
                  defaultValue="React, Node.js, Tailwind, Postgres"
                  className="w-full p-2 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400"
                />
              </div>
              <button
                onClick={() => setProfileCreated(true)}
                className="w-full py-2 bg-gradient-to-r from-emerald-300 to-teal-400 text-slate-900 font-bold rounded-xl text-xs transition"
              >
                Enregistrer le profil
              </button>
            </div>
          )}
        </div>

        {/* Right Side: Recomended matches */}
        <div className="lg:col-span-3 space-y-4">
          {/* Filter Bar */}
          <div className="flex flex-col sm:flex-row gap-3 bg-white/70 backdrop-blur-md border border-slate-900/10 p-4 rounded-2xl shadow-glass">
            <div className="flex-1 relative">
              <Search className="absolute left-3 top-2.5 text-slate-400" size={16} />
              <input
                type="text"
                placeholder="Rechercher par nom ou compétence (ex: React, Python)..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-9 pr-4 py-2 text-xs border border-slate-900/10 rounded-xl bg-white focus:outline-none focus:border-emerald-400"
              />
            </div>
            
            <div className="flex gap-2">
              <select
                value={selectedDept}
                onChange={(e) => setSelectedDept(e.target.value)}
                className="p-2 text-xs border border-slate-900/10 rounded-xl bg-white focus:outline-none focus:border-emerald-400 text-slate-600"
              >
                <option value="All">Toutes les filières</option>
                <option value="Génie Informatique">Génie Informatique</option>
                <option value="Génie Réseaux & Télécoms">Génie Réseaux & Télécoms</option>
              </select>
            </div>
          </div>

          {/* Matches grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {filteredTeammates.map(teammate => (
              <div key={teammate.id} className="bg-white/70 backdrop-blur-md border border-slate-900/10 p-5 rounded-2xl shadow-glass flex flex-col justify-between hover:-translate-y-0.5 transition-all duration-200">
                <div>
                  <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-300 to-teal-400 flex items-center justify-center font-bold text-slate-900 shadow-sm">
                        {teammate.avatarLetter}
                      </div>
                      <div>
                        <h3 className="font-heading text-sm text-slate-800 font-bold">{teammate.name}</h3>
                        <p className="text-xxs text-slate-400">{teammate.department} • {teammate.academicYear}</p>
                      </div>
                    </div>
                    {/* Compatibility percentage pill */}
                    <div className="px-2.5 py-1 bg-emerald-50 border border-emerald-100 rounded-full flex items-center gap-1.5 shadow-sm">
                      <Sparkles size={11} className="text-emerald-500 animate-pulse" />
                      <span className="text-xxs font-bold text-emerald-700">{teammate.compatibility}%</span>
                    </div>
                  </div>

                  {/* Skills tags */}
                  <div className="mt-4">
                    <span className="block text-slate-400 text-xxs font-semibold mb-1.5 uppercase">Compétences :</span>
                    <div className="flex flex-wrap gap-1">
                      {teammate.skills.map(skill => (
                        <span key={skill} className="px-2 py-0.5 bg-slate-900/5 text-slate-700 border border-slate-900/5 rounded-md text-xxs font-medium">{skill}</span>
                      ))}
                    </div>
                  </div>
                </div>

                {/* Card actions */}
                <div className="mt-6 pt-3 border-t border-slate-900/5 flex gap-2">
                  <button
                    onClick={() => sendInvitation(teammate.id)}
                    disabled={invitedIds.includes(teammate.id)}
                    className={`flex-1 py-2 rounded-xl text-xxs font-bold flex items-center justify-center gap-1.5 transition ${
                      invitedIds.includes(teammate.id)
                        ? 'bg-slate-100 text-slate-400 border border-slate-200 cursor-default'
                        : 'bg-slate-900 hover:bg-slate-800 text-white'
                    }`}
                  >
                    <UserCheck size={12} />
                    <span>{invitedIds.includes(teammate.id) ? 'Invitation Envoyée' : 'Inviter au Projet'}</span>
                  </button>
                  <button className="px-3 py-2 bg-white border border-slate-900/10 hover:bg-slate-50 text-slate-700 rounded-xl text-xxs font-bold transition flex items-center justify-center gap-1">
                    <MessageSquare size={12} />
                    <span>Discuter</span>
                  </button>
                </div>
              </div>
            ))}
            {filteredTeammates.length === 0 && (
              <div className="col-span-2 text-center py-12 bg-white/70 rounded-2xl border border-slate-900/10">
                <Info className="mx-auto text-slate-300 mb-2" size={32} />
                <p className="text-slate-500 font-medium text-xs">Aucun partenaire trouvé avec ces critères de recherche.</p>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};
