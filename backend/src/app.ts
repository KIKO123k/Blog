import express from 'express';
import cors from 'cors';
import dotenv from 'dotenv';
import aiRoutes from './routes/ai.routes';
import teamRoutes from './routes/team.routes';
import lostFoundRoutes from './routes/lostfound.routes';
import careerRoutes from './routes/career.routes';

dotenv.config();

const app = express();
const PORT = process.env.PORT || 5000;

app.use(cors());
app.use(express.json());

// Routes Integration
app.use('/api/v2/ai', aiRoutes);
app.use('/api/v2/teams', teamRoutes);
app.use('/api/v2/lost-found', lostFoundRoutes);
app.use('/api/v2/career', careerRoutes);

app.get('/health', (req, res) => {
  res.json({ status: 'ok', service: 'EduBlog Ecosystem API' });
});

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});

export default app;
