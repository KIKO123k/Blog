"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
const teammates = [
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
    }
];
router.get('/profiles/recommend', (req, res) => {
    res.json(teammates);
});
router.post('/profiles', (req, res) => {
    const { department, academicYear, skills, languages, interests } = req.body;
    // Simulate successful profile update
    res.json({ message: 'Profile updated successfully', profile: { department, academicYear, skills, languages, interests } });
});
router.post('/groups/:id/invite', (req, res) => {
    const { targetUserId } = req.body;
    res.json({ message: `Invitation successfully sent to user ${targetUserId}` });
});
exports.default = router;
