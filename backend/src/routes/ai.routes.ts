import { Router, Request, Response } from 'express';
import multer from 'multer';

const router = Router();
const upload = multer({ dest: 'uploads/' });

// Simple in-memory storage fallback for simulation
const documents = [
  { id: '1', title: 'Cours_Algorithmique_Complexité.pdf', fileSize: '2.4 MB', pageCount: 42, uploadedAt: '16/06/2026' },
  { id: '2', title: 'Physique_Semiconducteurs.pdf', fileSize: '4.1 MB', pageCount: 88, uploadedAt: '12/06/2026' }
];

router.get('/documents', (req: Request, res: Response) => {
  res.json(documents);
});

router.post('/documents/upload', upload.single('file'), (req: Request, res: Response) => {
  if (!req.file) {
    return res.status(400).json({ error: 'No file uploaded' });
  }

  const newDoc = {
    id: String(documents.length + 1),
    title: req.file.originalname,
    fileSize: `${(req.file.size / (1024 * 1024)).toFixed(1)} MB`,
    pageCount: Math.floor(Math.random() * 50) + 10,
    uploadedAt: new Date().toLocaleDateString('fr-FR')
  };

  documents.unshift(newDoc);
  res.json(newDoc);
});

router.post('/sessions/:id/chat', (req: Request, res: Response) => {
  const { message } = req.body;
  const docId = req.params.id;

  const foundDoc = documents.find(d => d.id === docId);

  // If OpenAI API keys are configured, RAG would be executed here.
  // For the initial integration phase, we simulate the LLM response accurately.
  setTimeout(() => {
    res.json({
      sender: 'assistant',
      content: `D'après le cours "${foundDoc?.title || 'général'}", voici l'analyse : les notions fondamentales mettent en relief l'importance des structures de données linéaires et non-linéaires (comme les arbres binaires et les graphes) pour optimiser les performances des applications en production.`,
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    });
  }, 1000);
});

router.post('/documents/:id/generate', (req: Request, res: Response) => {
  const { type } = req.body; // 'summary' | 'flashcards' | 'quiz'
  const docId = req.params.id;
  const doc = documents.find(d => d.id === docId);

  if (type === 'summary') {
    return res.json({
      summary: `### Résumé Analytique de: ${doc?.title || 'Cours'}\n\n1. **Concepts Clés** : Modèles d'exécution, complexité moyenne, pire des cas et comportement asymptotique.\n2. **Structures associées** : Piles, files, listes et tables d'association (hachage).\n3. **Recherche sémantique** : Algorithmes gloutons et diviser pour régner.`
    });
  }

  if (type === 'flashcards') {
    return res.json({
      flashcards: [
        { q: "Qu'est-ce que l'évaluation paresseuse (Lazy evaluation) ?", a: "Une stratégie d'évaluation qui retarde le calcul d'une expression jusqu'à ce que sa valeur soit nécessaire." },
        { q: "Différence entre Pile (Stack) et File (Queue) :", a: "Stack utilise LIFO (Last In First Out), Queue utilise FIFO (First In First Out)." }
      ]
    });
  }

  if (type === 'quiz') {
    return res.json({
      quiz: [
        {
          q: "Quel est l'avantage principal des arbres de recherche équilibrés (AVL) ?",
          opts: ["Recherche en O(1)", "Garantie d'une hauteur O(log n) dans le pire des cas", "Facilité d'implémentation", "Consommation mémoire nulle"],
          ans: 1,
          explanation: "La hauteur équilibrée assure que les opérations d'insertion, suppression et recherche se fassent en O(log n)."
        }
      ]
    });
  }

  res.status(400).json({ error: 'Invalid generation type' });
});

export default router;
