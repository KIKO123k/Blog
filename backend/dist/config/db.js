"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.getDb = void 0;
const pg_1 = require("pg");
const dotenv_1 = __importDefault(require("dotenv"));
dotenv_1.default.config();
let pool = null;
try {
    // Graceful initialization: if connection string is missing or server is offline,
    // we fallback to mock memory structures rather than crashing the Express app.
    if (process.env.DATABASE_URL || process.env.DB_HOST) {
        pool = new pg_1.Pool({
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
    }
    else {
        console.log('No database credentials in environment variables. Running in-memory mock mode.');
    }
}
catch (e) {
    console.warn('Failed to configure PostgreSQL database connection pool. Running in-memory mock mode.', e);
    pool = null;
}
const getDb = () => pool;
exports.getDb = getDb;
