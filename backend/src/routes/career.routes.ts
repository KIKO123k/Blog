import { Router, Request, Response } from 'express';
import multer from 'multer';

const router = Router();
const upload = multer({ dest: 'uploads/' });

router.post('/cv/analyze', upload.single('file'), (req: Request, res: Response) => {
  // Simulate AI CV parser
  setTimeout(() => {
    res.json({
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
  }, 1500);
});

router.post('/interview/prep', (req: Request, res: Response) => {
  res.json({
    questions: [
      "Expliquez la différence entre l'architecture MVC (utilisée par Laravel) et une architecture basée sur des microservices.",
      "Comment optimisez-vous le temps de chargement d'une application React SPA ?",
      "Décrivez une expérience où vous avez dû résoudre un conflit technique difficile au sein d'une équipe de projet."
    ]
  });
});

export default router;
