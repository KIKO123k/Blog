"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const multer_1 = __importDefault(require("multer"));
const router = (0, express_1.Router)();
const upload = (0, multer_1.default)({ dest: 'uploads/' });
router.post('/cv/analyze', upload.single('file'), (req, res) => {
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
router.post('/interview/prep', (req, res) => {
    res.json({
        questions: [
            "Expliquez la différence entre l'architecture MVC (utilisée par Laravel) et une architecture basée sur des microservices.",
            "Comment optimisez-vous le temps de chargement d'une application React SPA ?",
            "Décrivez une expérience où vous avez dû résoudre un conflit technique difficile au sein d'une équipe de projet."
        ]
    });
});
exports.default = router;
