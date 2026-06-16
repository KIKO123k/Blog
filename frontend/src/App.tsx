import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useLocation } from 'react-router-dom';
import { Sparkles, Code, ShieldAlert, Briefcase, GraduationCap } from 'lucide-react';
import { AISpace } from './pages/AISpace';
import { TeamFinder } from './pages/TeamFinder';
import { LostFound } from './pages/LostFound';
import { CareerCenter } from './pages/CareerCenter';

const NavigationHeader: React.FC = () => {
  const location = useLocation();

  const navItems = [
    { path: '/ai-space', label: 'AI Study Assistant', icon: Sparkles },
    { path: '/find-teammates', label: 'Find Teammates', icon: Code },
    { path: '/lost-found', label: 'Lost & Found', icon: ShieldAlert },
    { path: '/career-center', label: 'Career Center', icon: Briefcase }
  ];

  return (
    <header className="sticky top-0 z-50 bg-white/70 backdrop-blur-md border-b border-slate-900/10 shadow-sm px-6 py-4">
      <div className="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        {/* Brand Logo */}
        <Link to="/ai-space" className="flex items-center gap-2 group">
          <div className="p-2 bg-gradient-to-br from-emerald-300 to-teal-400 rounded-xl text-slate-900 shadow-sm group-hover:scale-105 transition-all duration-300">
            <GraduationCap size={22} />
          </div>
          <div>
            <span className="font-heading font-black text-slate-900 text-lg tracking-tight">EduBlog</span>
            <span className="text-xxs font-bold text-emerald-500 uppercase tracking-widest block -mt-1.5">Ecosystem</span>
          </div>
        </Link>

        {/* Center menu links */}
        <nav className="flex flex-wrap items-center justify-center gap-1 sm:gap-2">
          {navItems.map(item => {
            const Icon = item.icon;
            const isActive = location.pathname === item.path;
            return (
              <Link
                key={item.path}
                to={item.path}
                className={`flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 ${
                  isActive
                    ? 'bg-slate-900 text-white shadow-sm'
                    : 'text-slate-500 hover:bg-slate-900/5 hover:text-slate-800'
                }`}
              >
                <Icon size={14} className={isActive ? 'text-emerald-300' : 'text-slate-400'} />
                <span>{item.label}</span>
              </Link>
            );
          })}
        </nav>

        {/* Profile / Student quick stats */}
        <div className="flex items-center gap-3">
          <div className="text-right hidden sm:block">
            <span className="block text-xs font-bold text-slate-800">Khadija Nafia</span>
            <span className="block text-xxs font-medium text-slate-400">Génie Informatique • CI-2</span>
          </div>
          <div className="w-9 h-9 rounded-full bg-slate-900 text-emerald-300 flex items-center justify-center font-black text-xs shadow-sm">
            KN
          </div>
        </div>
      </div>
    </header>
  );
};

const Footer: React.FC = () => (
  <footer className="bg-slate-950 text-slate-400 py-8 px-6 border-t border-slate-900 mt-12">
    <div className="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
      <span>&copy; 2026 EduBlog ENSA Kénitra. Tous droits réservés.</span>
      <div className="flex gap-4 font-semibold">
        <a href="#rules" className="hover:text-white transition">Charte du campus</a>
        <a href="#help" className="hover:text-white transition">Support Technique</a>
      </div>
    </div>
  </footer>
);

const App: React.FC = () => {
  return (
    <Router basename="/ecosystem">
      <div className="min-h-screen flex flex-col bg-bgBase">
        <NavigationHeader />
        
        {/* Main Workspace */}
        <main className="flex-1 max-w-7xl w-full mx-auto px-6 py-8">
          <Routes>
            <Route path="/" element={<AISpace />} />
            <Route path="/ai-space" element={<AISpace />} />
            <Route path="/find-teammates" element={<TeamFinder />} />
            <Route path="/lost-found" element={<LostFound />} />
            <Route path="/career-center" element={<CareerCenter />} />
          </Routes>
        </main>

        <Footer />
      </div>
    </Router>
  );
};

export default App;
