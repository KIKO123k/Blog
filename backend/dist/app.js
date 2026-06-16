"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = __importDefault(require("express"));
const cors_1 = __importDefault(require("cors"));
const dotenv_1 = __importDefault(require("dotenv"));
const ai_routes_1 = __importDefault(require("./routes/ai.routes"));
const team_routes_1 = __importDefault(require("./routes/team.routes"));
const lostfound_routes_1 = __importDefault(require("./routes/lostfound.routes"));
const career_routes_1 = __importDefault(require("./routes/career.routes"));
dotenv_1.default.config();
const app = (0, express_1.default)();
const PORT = process.env.PORT || 5000;
app.use((0, cors_1.default)());
app.use(express_1.default.json());
// Routes Integration
app.use('/api/v2/ai', ai_routes_1.default);
app.use('/api/v2/teams', team_routes_1.default);
app.use('/api/v2/lost-found', lostfound_routes_1.default);
app.use('/api/v2/career', career_routes_1.default);
app.get('/health', (req, res) => {
    res.json({ status: 'ok', service: 'EduBlog Ecosystem API' });
});
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
exports.default = app;
