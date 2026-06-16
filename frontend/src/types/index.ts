export interface User {
  id: string;
  name: string;
  email: string;
  avatar?: string;
  role: string;
}

export interface Document {
  id: string;
  title: string;
  fileSize: string;
  pageCount: number;
  uploadedAt: string;
}

export interface Message {
  id: string;
  sender: 'user' | 'assistant';
  content: string;
  timestamp: string;
}

export interface TeammateMatch {
  id: string;
  name: string;
  department: string;
  academicYear: string;
  skills: string[];
  languages: string[];
  compatibility: number;
  avatarLetter: string;
}

export interface LostFoundItem {
  id: string;
  type: 'lost' | 'found';
  title: string;
  description: string;
  category: 'Student Card' | 'Laptop' | 'Smartphone' | 'Calculator' | 'USB Drive' | 'Keys' | 'Books' | 'Other';
  location: string;
  date: string;
  status: 'open' | 'matched' | 'resolved';
  contactName: string;
}
