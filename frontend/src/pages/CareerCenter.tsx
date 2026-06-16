import React, { useState } from 'react';
import { Upload, Briefcase, FileCheck, CheckCircle2, AlertTriangle, Play, Sparkles } from 'lucide-react';

export const CareerCenter: React.FC = () => {
  const [cvFile, setCvFile] = useState<string | null>(null);
  const [isAnalyzing, setIsAnalyzing] = useState(false);
  const [analysisReport, setAnalysisReport] = useState<any | null>(null);
  
  // Job database
  const [opportunities] = useState([
    {
      id: '1',
      title: 'Stage PFE - Développeur Full-Stack (React/Laravel)',
      company: 'Capgemini Maroc',
      location: 'Rabat (Hybride)',
      type: 'PFE',
      salary: 'Indemnité de stage',
      skills: ['React', 'Laravel', 'REST APIs']
    },
    {
      id: '2',
      title: 'Stage technique - Ingénieur DevOps',
      company: 'Orange Business Services',
      location: 'Casablanca',
      type: 'internship',
      salary: 'À négocier',
      skills: ['Docker', 'CI/CD', 'Linux', 'Git']
    },
    {
      id: '3',
      title: 'Stage d\'initiation - Développeur Python & Data Science',
      company: 'DXC Technology',
      location: 'Rabat Techopolis',
      type: 'internship',
      salary: 'Non rémunéré',
      skills: ['Python', 'Pandas', 'SQL']
    }
  ]);

  // Interview Simulator
  const [interviewStarted, setInterviewStarted] = useState(false);
  const [currentQuestionIdx, setCurrentQuestionIdx] = useState(0);
  const [questions] = useState([
    "Expliquez la différence entre l'architecture MVC (utilisée par Laravel) et une architecture basée sur des microservices.",
    "Comment optimisez-vous le temps de chargement d'une application React SPA ?",
    "Décrivez une expérience où vous avez dû résoudre un conflit technique difficile au sein d'une équipe de projet."
  ]);
  const [answers, setAnswers] = useState<Record<number, string>>({});
  const [isSubmittingAnswers, setIsSubmittingAnswers] = useState(false);
  const [interviewFeedback, setInterviewFeedback] = useState<string | null>(null);

  const handleCvUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (!e.target.files?.[0]) return;
    setCvFile(e.target.files[0].name);
    setIsAnalyzing(true);

    setTimeout(() => {
      setAnalysisReport({
        score: 82,
        positives: [
          "Bonne mise en valeur des compétences techniques (React, PHP).",
          "Structure claire et lisible sur une page.",
          "Expériences de projets académiques bien détaillées."
        ],
        gaps: [
          "Manque de certifications Cloud (AWS, Azure) ou DevOps.",
          "Section 'Langues' un peu succincte.",
          "Absence de lien vers un portfolio hébergé en ligne."
        ],
        keywordsMatched: ["TypeScript", "PHP", "Laravel", "MySQL", "React", "Git"],
        keywordsMissing: ["CI/CD", "Docker", "Unit Testing", "Kubernetes"],
        careerPath: "Architecte Logiciel / Développeur Full-stack"
      });
      setIsAnalyzing(false);
    }, 2000);
  };

  const handleStartInterview = () => {
    setInterviewStarted(true);
    setCurrentQuestionIdx(0);
    setAnswers({});
    setInterviewFeedback(null);
  };

  const handleNextQuestion = () => {
    if (currentQuestionIdx < questions.length - 1) {
      setCurrentQuestionIdx(prev => prev + 1);
    } else {
      setIsSubmittingAnswers(true);
      setTimeout(() => {
        setInterviewFeedback("### Feedback d'entretien simulé par IA\n\n- **Points forts** : Vos explications sur la séparation des responsabilités dans le modèle MVC sont précises et montrent une bonne compréhension théorique.\n- **Axe d'amélioration** : Sur l'optimisation des bundles React, pensez à mentionner le *Code Splitting* (React.lazy / Suspense) et la compression GZIP/Brotli.\n- **Score estimé** : **15/20** (Excellent niveau technique).");
        setIsSubmittingAnswers(false);
      }, 2000);
    }
  };

  return (
    <div className="space-y-6">
      {/* Title */}
      <div>
        <h1 className="text-3xl font-heading text-slate-900">Career Center</h1>
        <p className="text-sm text-slate-500">Préparez votre avenir professionnel avec nos outils de révision de CV, d'offres de stage et de simulations d'entretien par IA.</p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {/* CV Upload and Analysis */}
        <div className="lg:col-span-1 bg-white/70 backdrop-blur-md border border-slate-900/10 p-5 rounded-2xl shadow-glass space-y-4">
          <h2 className="text-lg font-heading text-slate-800 font-bold flex items-center gap-2">
            <FileCheck size={18} className="text-emerald-500" />
            Analyseur de CV par IA
          </h2>
          
          <div className="border-2 border-dashed border-slate-900/10 hover:border-emerald-300 rounded-xl p-6 text-center cursor-pointer transition-all bg-white/40">
            <input type="file" accept=".pdf" onChange={handleCvUpload} className="hidden" id="cv-upload-input" />
            <label htmlFor="cv-upload-input" className="cursor-pointer space-y-2 block">
              <Upload className="mx-auto text-slate-400" size={28} />
              <p className="text-xs font-semibold text-slate-600">
                {cvFile ? `Fichier : ${cvFile}` : 'Glissez-déposez votre CV au format PDF'}
              </p>
              <span className="block text-xxs text-slate-400">Taille maximale : 10 Mo</span>
            </label>
          </div>

          {isAnalyzing && (
            <div className="p-3 bg-emerald-50 rounded-xl flex items-center gap-2.5 animate-pulse text-emerald-800 text-xs font-semibold">
              <Sparkles size={14} className="animate-spin" />
              <span>Analyse sémantique du CV en cours...</span>
            </div>
          )}

          {analysisReport && (
            <div className="space-y-4 pt-2">
              <div className="flex items-center justify-between p-3 bg-slate-900 text-white rounded-xl">
                <span className="text-xs font-bold">Score d'employabilité</span>
                <span className="text-lg font-black text-emerald-300">{analysisReport.score} / 100</span>
              </div>
              
              <div className="space-y-2">
                <span className="block text-xxs font-bold text-slate-400 uppercase">Points Forts</span>
                <ul className="space-y-1">
                  {analysisReport.positives.map((p: string, i: number) => (
                    <li key={i} className="text-xxs text-slate-600 flex items-start gap-1">
                      <CheckCircle2 size={11} className="text-emerald-500 mt-0.5 flex-shrink-0" />
                      <span>{p}</span>
                    </li>
                  ))}
                </ul>
              </div>

              <div className="space-y-2">
                <span className="block text-xxs font-bold text-slate-400 uppercase">Éléments Manquants / Pistes d'amélioration</span>
                <ul className="space-y-1">
                  {analysisReport.gaps.map((g: string, i: number) => (
                    <li key={i} className="text-xxs text-slate-600 flex items-start gap-1">
                      <AlertTriangle size={11} className="text-amber-500 mt-0.5 flex-shrink-0" />
                      <span>{g}</span>
                    </li>
                  ))}
                </ul>
              </div>

              <div className="pt-2 text-xxs text-slate-400 font-semibold border-t border-slate-900/5">
                <span>Métier conseillé : </span>
                <span className="text-slate-700 font-bold">{analysisReport.careerPath}</span>
              </div>
            </div>
          )}
        </div>

        {/* Opportunities List & Interview Prep */}
        <div className="lg:col-span-2 space-y-6">
          
          {/* Opportunities Section */}
          <div className="bg-white/70 backdrop-blur-md border border-slate-900/10 p-5 rounded-2xl shadow-glass space-y-4">
            <h2 className="text-lg font-heading text-slate-800 font-bold flex items-center gap-2">
              <Briefcase size={18} className="text-emerald-500" />
              Stages & Opportunités PFE
            </h2>
            <div className="space-y-3">
              {opportunities.map(opp => (
                <div key={opp.id} className="p-4 bg-white border border-slate-900/10 rounded-xl hover:-translate-y-0.5 transition duration-200 flex justify-between items-start">
                  <div>
                    <span className={`px-2 py-0.5 rounded-full text-xxs font-bold uppercase ${
                      opp.type === 'PFE' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600'
                    }`}>
                      {opp.type === 'PFE' ? 'Stage PFE' : 'Stage Technique'}
                    </span>
                    <h3 className="font-bold text-sm text-slate-800 mt-1.5">{opp.title}</h3>
                    <p className="text-xxs text-slate-400">{opp.company} • {opp.location}</p>
                    <div className="flex gap-1.5 mt-2.5">
                      {opp.skills.map(s => (
                        <span key={s} className="px-1.5 py-0.5 bg-slate-900/5 text-slate-600 rounded text-xxs font-medium">{s}</span>
                      ))}
                    </div>
                  </div>
                  <button className="px-3 py-1.5 bg-slate-900 hover:bg-slate-850 text-white rounded-lg text-xxs font-bold transition">
                    Postuler
                  </button>
                </div>
              ))}
            </div>
          </div>

          {/* Interview Simulator */}
          <div className="bg-white/70 backdrop-blur-md border border-slate-900/10 p-5 rounded-2xl shadow-glass space-y-4">
            <h2 className="text-lg font-heading text-slate-800 font-bold flex items-center gap-2">
              <Sparkles size={18} className="text-emerald-500" />
              Simulateur d'Entretien IA
            </h2>
            
            {!interviewStarted ? (
              <div className="text-center py-6 space-y-3">
                <p className="text-slate-500 text-xs font-semibold">Testez vos compétences devant notre IA entraînée aux exigences des recruteurs techniques.</p>
                <button
                  onClick={handleStartInterview}
                  className="px-6 py-2.5 bg-slate-950 hover:bg-slate-900 text-white font-bold rounded-xl text-xs transition flex items-center gap-1.5 mx-auto"
                >
                  <Play size={12} />
                  Démarrer la simulation
                </button>
              </div>
            ) : (
              <div className="space-y-4">
                {interviewFeedback ? (
                  <div className="space-y-3">
                    <div className="prose text-xs text-slate-700 bg-emerald-50/70 border border-emerald-200 p-5 rounded-2xl whitespace-pre-line leading-relaxed">
                      {interviewFeedback}
                    </div>
                    <button
                      onClick={handleStartInterview}
                      className="px-4 py-2 bg-slate-950 text-white font-bold rounded-xl text-xs hover:bg-slate-850 transition"
                    >
                      Recommencer un nouvel entretien
                    </button>
                  </div>
                ) : (
                  <div className="space-y-3 bg-white p-5 border border-slate-900/10 rounded-2xl">
                    <div className="flex justify-between items-center text-xxs text-slate-400 font-bold uppercase">
                      <span>Question {currentQuestionIdx + 1} sur {questions.length}</span>
                      <span className="text-emerald-500">En cours</span>
                    </div>
                    <p className="text-sm font-bold text-slate-800">{questions[currentQuestionIdx]}</p>
                    <textarea
                      rows={4}
                      value={answers[currentQuestionIdx] || ''}
                      onChange={(e) => setAnswers(prev => ({ ...prev, [currentQuestionIdx]: e.target.value }))}
                      placeholder="Saisissez votre réponse ici..."
                      className="w-full p-3 text-xs border border-slate-900/10 rounded-xl focus:outline-none focus:border-emerald-400"
                    />
                    <div className="flex justify-end pt-2">
                      <button
                        onClick={handleNextQuestion}
                        disabled={isSubmittingAnswers || !(answers[currentQuestionIdx]?.trim())}
                        className="px-5 py-2.5 bg-slate-950 text-white hover:bg-slate-850 transition rounded-xl text-xs font-bold disabled:opacity-50"
                      >
                        {isSubmittingAnswers ? 'Analyse...' : currentQuestionIdx === questions.length - 1 ? 'Terminer l\'entretien' : 'Question suivante'}
                      </button>
                    </div>
                  </div>
                )}
              </div>
            )}
          </div>

        </div>

      </div>
    </div>
  );
};
