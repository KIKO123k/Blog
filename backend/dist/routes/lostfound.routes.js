"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
const items = [
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
    }
];
router.get('/items', (req, res) => {
    res.json(items);
});
router.post('/items', (req, res) => {
    const { type, title, description, category, location } = req.body;
    const newItem = {
        id: String(items.length + 1),
        type,
        title,
        description,
        category,
        location,
        date: new Date().toLocaleDateString('fr-FR'),
        status: 'open',
        contactName: 'Étudiant anonyme'
    };
    items.unshift(newItem);
    res.json(newItem);
});
router.post('/items/:id/claim', (req, res) => {
    const { id } = req.params;
    res.json({ message: `Claim registered successfully for item ID ${id}` });
});
exports.default = router;
