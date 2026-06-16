import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  base: '/ecosystem/',
  build: {
    outDir: '../public/ecosystem',
    emptyOutDir: true
  }
})
