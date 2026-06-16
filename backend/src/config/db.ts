import { Pool } from 'pg';
import dotenv from 'dotenv';

dotenv.config();

let pool: Pool | null = null;

try {
  // Graceful initialization: if connection string is missing or server is offline,
  // we fallback to mock memory structures rather than crashing the Express app.
  if (process.env.DATABASE_URL || process.env.DB_HOST) {
    pool = new Pool({
      connectionString: process.env.DATABASE_URL,
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
      port: Number(process.env.DB_PORT || 5432),
      ssl: process.env.NODE_ENV === 'production' ? { rejectUnauthorized: false } : undefined
    });
    
    // Quick probe
    pool.query('SELECT NOW()').catch(err => {
      console.warn('PostgreSQL server connection failed. Ecosystem APIs will run in-memory mock mode.');
      pool = null;
    });
  } else {
    console.log('No database credentials in environment variables. Running in-memory mock mode.');
  }
} catch (e) {
  console.warn('Failed to configure PostgreSQL database connection pool. Running in-memory mock mode.', e);
  pool = null;
}

export const getDb = () => pool;
