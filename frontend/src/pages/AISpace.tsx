import React, { useState } from 'react';
import { Upload, FileText, Send, Sparkles, BookOpen, Layers, HelpCircle } from 'lucide-react';
import type { Message, Document } from '../types';

export const AISpace: React.FC = () => {
  const [documents, setDocuments] = useState<Document[]>([
    { id: '1', title: 'Cours_Algorithmique_Complexité.pdf', fileSize: '2.4 MB', pageCount: 42, uploadedAt: '16/06/2026' },
    { id: '2', title: 'Physique_Semiconducteurs.pdf', fileSize: '4.1 MB', pageCount: 88, uploadedAt: '12/06/2026' }
  ]);
  const [selectedDoc, setSelectedDoc] = useState<Document | null>(documents[0]);
  const [messages, setMessages] = useState<Message[]>([
    { id: '1', sender: 'assistant', content: 'Bonjour ! Je suis votre assistant de cours ENSA. Sélectionnez un document PDF et posez-moi des questions, générez un résumé, ou créez un quiz QCM !', timestamp: '17:00' }
  ]);
  const [inputValue, setInputValue] = useState('');
  const [isUploading, setIsUploading] = useState(false);
  const [isProcessing, setIsProcessing] = useState(false);
  const [currentTab, setCurrentTab] = useState<'chat' | 'summary' | 'flashcards' | 'quiz'>('chat');
  
  // Interactive generators
  const [summary, setSummary] = useState<string>('');
  const [flashcards, setFlashcards] = useState<{ q: string; a: string }[]>([]);
  const [quizzes, setQuizzes] = useState<{ q: string; opts: string[]; ans: number; explanation: string }[]>([]);
  const [userAnswers, setUserAnswers] = useState<Record<number, number>>({});
  const [score, setScore] = useState<number | null>(null);

  const handleFileUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (!e.target.files?.[0]) return;
    const file = e.target.files[0];
    setIsUploading(true);
    setTimeout(() => {
      const newDoc: Document = {
        id: String(documents.length + 1),
        title: file.name,
        fileSize: `${(file.size / (1024 * 1024)).toFixed(1)} MB`,
        pageCount: Math.floor(Math.random() * 50) + 10,
        uploadedAt: new Date().toLocaleDateString('fr-FR')
      };
      setDocuments([newDoc, ...documents]);
      setSelectedDoc(newDoc);
      setIsUploading(false);
    }, 1500);
  };

  const handleSendMessage = (e: React.FormEvent) => {
    e.preventDefault();
    if (!inputValue.trim() || !selectedDoc) return;

    const userMsg: Message = {
      id: String(messages.length + 1),
      sender: 'user',
      content: inputValue,
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    };

    setMessages(prev => [...prev, userMsg]);
    setInputValue('');
    setIsProcessing(true);

    setTimeout(() => {
      const reply: Message = {
        id: String(messages.length + 2),
        sender: 'assistant',
        content: `D'après le cours "${selectedDoc.title}", voici les informations concernant votre question: les concepts principaux décrivent une complexité algorithmique de type Big-O qui exprime le comportement asymptotique de l'algorithme lorsque la taille de l'entrée tend vers l'infini.`,
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
      };
      setMessages(prev => [...prev, reply]);
      setIsProcessing(false);
    }, 1500);
  };

  const generateSummary = () => {
    if (!selectedDoc) return;
    setIsProcessing(true);
    setTimeout(() => {
      setSummary(`### Résumé Analytique de: ${selectedDoc.title}\n\n1. **Concepts Fondamentaux** : Introduction générale aux structures de données et à l'analyse de complexité algorithmique temporelle et spatiale.\n\n2. **Théorème Maître** : Résolution des équations de récurrence de la forme $T(n) = aT(n/b) + f(n)$ appliquée aux méthodes Diviser pour Régner.\n\n3. **Optimisations clés** : Utilisation de mémoïsation en programmation dynamique pour réduire la complexité exponentielle à polynomiale.`);
      setIsProcessing(false);
    }, 2000);
  };

  const generateFlashcards = () => {
    if (!selectedDoc) return;
    setIsProcessing(true);
    setTimeout(() => {
      setFlashcards([
        { q: "Quelle est la complexité du Tri Fusion (Merge Sort) ?", a: "O(n log n) dans le pire et meilleur des cas, car il divise toujours le tableau en deux parties égales." },
        { q: "Qu'est-ce que la programmation dynamique ?", a: "Une méthode de résolution de problèmes qui combine les solutions de sous-problèmes chevauchants stockés dans une table (mémoïsation)." },
        { q: "Définition de la complexité spatiale :", a: "L'espace mémoire supplémentaire nécessaire à un algorithme pour s'exécuter en fonction de la taille de l'entrée." }
      ]);
      setIsProcessing(false);
    }, 2000);
  };

  const generateQuiz = () => {
    if (!selectedDoc) return;
    setIsProcessing(true);
    setScore(null);
    setUserAnswers({});
    setTimeout(() => {
      setQuizzes([
        {
          q: "Quelle est la complexité dans le pire des cas d'un accès dans une table de hachage bien dimensionnée ?",
          opts: ["O(1)", "O(log n)", "O(n)", "O(n^2)"],
          ans: 2,
          explanation: "Dans le pire des cas (toutes les clés entrent en collision dans le même seau), la table de hachage se comporte comme une liste chaînée simple, d'où O(n)."
        },
        {
          q: "Quel algorithme est utilisé pour trouver le plus court chemin dans un graphe avec des poids négatifs ?",
          opts: ["Dijkstra", "Bellman-Ford", "Floyd-Warshall", "Kruskal"],
          ans: 1,
          explanation: "Bellman-Ford gère les poids négatifs et détecte les cycles négatifs contrairement à Dijkstra."
        }
      ]);
      setIsProcessing(false);
    }, 2000);
  };

  const evaluateQuiz = () => {
    let correct = 0;
    quizzes.forEach((q, idx) => {
      if (userAnswers[idx] === q.ans) correct++;
    });
    setScore(correct);
  };

  return (
    <div className="space-y-6">
      {/* Title */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-3xl font-heading text-slate-900">AI Study Assistant</h1>
          <p className="text-sm text-slate-500">Uploadez vos cours ENSA et révisez intelligemment grâce à l'Intelligence Artificielle.</p>
        </div>
        
        {/* Document Selector & Upload */}
        <div className="flex items-center gap-3">
          <label className="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-300 to-teal-400 text-slate-900 font-semibold rounded-xl cursor-pointer hover:shadow-lg hover:shadow-emerald-300/20 transition-all duration-300">
            <Upload size={16} />
            <span>Charger un cours PDF</span>
            <input type="file" accept=".pdf" onChange={handleFileUpload} className="hidden" />
          </label>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {/* Left Panel: Course list */}
        <div className="lg:col-span-1 bg-white/70 backdrop-blur-md border border-slate-900/10 rounded-2xl shadow-glass p-4">
          <h2 className="text-lg font-heading text-slate-800 mb-4 flex items-center gap-2">
            <FileText size={18} className="text-emerald-500" />
            Mes documents
          </h2>
          {isUploading && (
            <div className="p-3 mb-3 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-3 animate-pulse">
              <div className="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" />
              <span className="text-xs font-medium text-emerald-700">Traitement du document...</span>
            </div>
          )}
          <div className="space-y-2">
            {documents.map(doc => (
              <button
                key={doc.id}
                onClick={() => { setSelectedDoc(doc); setSummary(''); setFlashcards([]); setQuizzes([]); }}
                className={`w-full text-left p-3 rounded-xl border transition-all duration-200 ${
                  selectedDoc?.id === doc.id
                    ? 'bg-emerald-50 border-emerald-300 shadow-sm'
                    : 'bg-white/40 border-slate-900/5 hover:bg-white/90'
                }`}
              >
                <p className="font-semibold text-sm truncate text-slate-800">{doc.title}</p>
                <div className="flex items-center justify-between mt-2 text-xxs text-slate-400">
                  <span>{doc.pageCount} pages</span>
                  <span>{doc.fileSize}</span>
                </div>
              </button>
            ))}
          </div>
        </div>

        {/* Right Panel: Tabs and Workspace */}
        <div className="lg:col-span-3 flex flex-col min-h-[550px] bg-white/70 backdrop-blur-md border border-slate-900/10 rounded-2xl shadow-glass overflow-hidden">
          {/* Tab bar */}
          <div className="flex border-b border-slate-900/5 bg-slate-50/50">
            {[
              { id: 'chat', label: 'Discuter avec le cours', icon: Send },
              { id: 'summary', label: 'Résumé de cours', icon: BookOpen },
              { id: 'flashcards', label: 'Flashcards', icon: Layers },
              { id: 'quiz', label: 'Quiz QCM', icon: HelpCircle }
            ].map(tab => {
              const Icon = tab.icon;
              return (
                <button
                  key={tab.id}
                  onClick={() => setCurrentTab(tab.id as any)}
                  className={`flex-1 flex items-center justify-center gap-2 py-3 px-4 text-xs font-semibold border-b-2 transition-all ${
                    currentTab === tab.id
                      ? 'border-emerald-400 text-emerald-600 bg-white'
                      : 'border-transparent text-slate-500 hover:bg-white/40'
                  }`}
                >
                  <Icon size={14} />
                  <span className="hidden sm:inline">{tab.label}</span>
                </button>
              );
            })}
          </div>

          {/* Workspace Area */}
          <div className="flex-1 p-6 flex flex-col justify-between">
            {/* Chat Workspace */}
            {currentTab === 'chat' && (
              <div className="flex-1 flex flex-col justify-between">
                <div className="space-y-4 max-h-[380px] overflow-y-auto pr-2">
                  {messages.map(msg => (
                    <div
                      key={msg.id}
                      className={`flex ${msg.sender === 'user' ? 'justify-end' : 'justify-start'}`}
                    >
                      <div
                        className={`max-w-[75%] rounded-2xl px-4 py-3 text-sm ${
                          msg.sender === 'user'
                            ? 'bg-slate-900 text-white rounded-tr-none'
                            : 'bg-white border border-slate-900/10 text-slate-800 rounded-tl-none shadow-sm'
                        }`}
                      >
                        <p className="leading-relaxed">{msg.content}</p>
                        <span className={`block text-xxs mt-1 text-right ${msg.sender === 'user' ? 'text-slate-400' : 'text-slate-400'}`}>
                          {msg.timestamp}
                        </span>
                      </div>
                    </div>
                  ))}
                  {isProcessing && (
                    <div className="flex justify-start">
                      <div className="bg-white border border-slate-900/10 text-slate-400 rounded-2xl rounded-tl-none px-4 py-3 text-sm shadow-sm flex items-center gap-2">
                        <Sparkles className="animate-spin text-emerald-400" size={16} />
                        <span>Recherche dans le cours...</span>
                      </div>
                    </div>
                  )}
                </div>
                
                {/* Input form */}
                <form onSubmit={handleSendMessage} className="mt-4 flex gap-2">
                  <input
                    type="text"
                    placeholder={selectedDoc ? `Posez une question sur "${selectedDoc.title}"...` : "Sélectionnez un document d'abord"}
                    value={inputValue}
                    disabled={!selectedDoc}
                    onChange={(e) => setInputValue(e.target.value)}
                    className="flex-1 px-4 py-3 bg-white border border-slate-900/10 rounded-xl text-sm focus:outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400/20 disabled:bg-slate-50"
                  />
                  <button
                    type="submit"
                    disabled={!selectedDoc || isProcessing}
                    className="px-4 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl transition disabled:opacity-50"
                  >
                    <Send size={16} />
                  </button>
                </form>
              </div>
            )}

            {/* Summary Workspace */}
            {currentTab === 'summary' && (
              <div className="flex-grow space-y-4">
                {!summary && (
                  <div className="text-center py-12">
                    <BookOpen size={48} className="mx-auto text-slate-300 mb-4" />
                    <p className="text-slate-500 font-medium mb-4">Générez un résumé structuré et clair de votre document.</p>
                    <button
                      onClick={generateSummary}
                      disabled={isProcessing}
                      className="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-sm transition-all"
                    >
                      {isProcessing ? 'Génération...' : 'Générer le résumé'}
                    </button>
                  </div>
                )}
                {summary && (
                  <div className="prose max-w-none text-slate-700 bg-white/40 border border-slate-900/5 p-5 rounded-2xl whitespace-pre-line leading-relaxed shadow-sm">
                    {summary}
                  </div>
                )}
              </div>
            )}

            {/* Flashcards Workspace */}
            {currentTab === 'flashcards' && (
              <div className="flex-grow space-y-4">
                {flashcards.length === 0 && (
                  <div className="text-center py-12">
                    <Layers size={48} className="mx-auto text-slate-300 mb-4" />
                    <p className="text-slate-500 font-medium mb-4">Générez des fiches de révision recto-verso basées sur le document.</p>
                    <button
                      onClick={generateFlashcards}
                      className="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-sm transition-all"
                    >
                      {isProcessing ? 'Génération...' : 'Créer les flashcards'}
                    </button>
                  </div>
                )}
                {flashcards.length > 0 && (
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {flashcards.map((fc, idx) => (
                      <div key={idx} className="group [perspective:1000px] h-48 cursor-pointer">
                        <div className="relative [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)] w-full h-full duration-500 bg-white border border-slate-900/10 rounded-2xl shadow-sm">
                          {/* Front */}
                          <div className="absolute inset-0 flex items-center justify-center p-4 text-center [backface-visibility:hidden]">
                            <p className="font-bold text-slate-800 text-sm">{fc.q}</p>
                          </div>
                          {/* Back */}
                          <div className="absolute inset-0 bg-emerald-50/80 border border-emerald-200 flex items-center justify-center p-4 text-center [transform:rotateY(180deg)] [backface-visibility:hidden] rounded-2xl">
                            <p className="text-xs text-emerald-800 leading-relaxed font-medium">{fc.a}</p>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            )}

            {/* Quiz Workspace */}
            {currentTab === 'quiz' && (
              <div className="flex-grow space-y-4">
                {quizzes.length === 0 && (
                  <div className="text-center py-12">
                    <HelpCircle size={48} className="mx-auto text-slate-300 mb-4" />
                    <p className="text-slate-500 font-medium mb-4">Générez un QCM dynamique pour valider vos connaissances.</p>
                    <button
                      onClick={generateQuiz}
                      className="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-sm transition-all"
                    >
                      Créer le quiz
                    </button>
                  </div>
                )}
                {quizzes.length > 0 && (
                  <div className="space-y-6">
                    {quizzes.map((q, qIdx) => (
                      <div key={qIdx} className="bg-white border border-slate-900/10 p-5 rounded-2xl shadow-sm">
                        <p className="font-bold text-slate-800 mb-3 text-sm">{qIdx + 1}. {q.q}</p>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                          {q.opts.map((opt, optIdx) => (
                            <button
                              key={optIdx}
                              onClick={() => setUserAnswers(prev => ({ ...prev, [qIdx]: optIdx }))}
                              className={`text-left px-4 py-3 rounded-xl border text-xs font-medium transition ${
                                userAnswers[qIdx] === optIdx
                                  ? 'bg-slate-900 text-white border-slate-900'
                                  : 'bg-slate-50 border-slate-900/5 hover:bg-slate-100 text-slate-700'
                              }`}
                            >
                              {opt}
                            </button>
                          ))}
                        </div>
                        {score !== null && (
                          <div className={`mt-3 p-3 rounded-xl text-xs ${userAnswers[qIdx] === q.ans ? 'bg-emerald-50 text-emerald-800' : 'bg-rose-50 text-rose-800'}`}>
                            <p className="font-bold">{userAnswers[qIdx] === q.ans ? '✓ Correct' : `✗ Incorrect (La bonne réponse était: ${q.opts[q.ans]})`}</p>
                            <p className="mt-1 font-medium text-slate-600">{q.explanation}</p>
                          </div>
                        )}
                      </div>
                    ))}
                    {score === null ? (
                      <button
                        onClick={evaluateQuiz}
                        className="px-6 py-3 bg-emerald-400 hover:bg-emerald-500 text-slate-950 font-bold rounded-xl text-sm w-full transition"
                      >
                        Soumettre mes réponses
                      </button>
                    ) : (
                      <div className="p-4 bg-emerald-100 border border-emerald-300 rounded-2xl flex items-center justify-between">
                        <div>
                          <p className="text-emerald-900 font-bold text-lg">Score final : {score} / {quizzes.length}</p>
                          <p className="text-xs text-emerald-800 font-medium">Excellent travail de révision ! Continuez ainsi.</p>
                        </div>
                        <button
                          onClick={generateQuiz}
                          className="px-4 py-2 bg-slate-950 text-white font-bold rounded-xl text-xs hover:bg-slate-850 transition"
                        >
                          Recommencer
                        </button>
                      </div>
                    )}
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
