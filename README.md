<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
</p>

<h1 align="center">Freelance App</h1>

<p align="center">
    <strong>All-in-One Freelance Project Management & Tracking Platform</strong>
</p>

<p align="center">
    <a href="https://github.com/yourusername/freelancehub"><img src="https://img.shields.io/badge/version-1.0.0-blue" alt="Version"></a>
    <a href="https://github.com/yourusername/freelancehub/blob/main/LICENSE"><img src="https://img.shields.io/badge/license-MIT-green" alt="License"></a>
    <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-11.x-red" alt="Laravel"></a>
    <a href="#"><img src="https://img.shields.io/badge/Tailwind%20CSS-3.x-blue" alt="Tailwind"></a>
</p>

---

## 📋 Tentang Aplikasi

**FreelanceHub** adalah platform manajemen proyek dan pelacakan komprehensif yang dirancang khusus untuk membantu freelancer mengelola bisnis mereka dengan lebih efisien. Aplikasi ini mengintegrasikan AI untuk memberikan insights otomatis dan membantu pengambilan keputusan yang lebih baik.

### Visi
Memberdayakan freelancer di Indonesia untuk mengelola proyek, klien, keuangan, dan waktu mereka dengan mudah melalui satu platform terpadu yang intuitif dan powerful.

---

## ✨ Fitur Utama

### 📊 Dashboard Interaktif
- Overview statistik real-time tentang projects, tasks, dan earnings
- Widget revenue tracking dengan grafik visual
- Quick stats: Total Projects, In Progress, Completed, Near Deadline
- AI-powered insights dan rekomendasi

### 📁 Project Management
- Kelola semua proyek dalam satu tempat
- Track deadline, progress, dan status proyek
- Assign tasks ke team members
- Attachments dan file management
- Project timeline visualization

### ✅ Task Management
- **Kanban Board View**: Drag-drop tasks across columns (To Do, In Progress, Review, Completed)
- **List View**: Detailed table view dengan filtering & sorting
- Priority levels (High, Medium, Low)
- Task descriptions dan due dates
- Task progress tracking
- Team collaboration features

### 👥 Client Management
- Kelola data klien lengkap (contact, email, phone, address)
- Track communication history
- Project history per klien
- Client rating & feedback

### 💰 Financial Management
- Invoice generation & tracking
- Income & expense monitoring
- Payment status tracking (Paid, Pending, Overdue)
- Financial reports & analytics
- Tax calculation assistance

### ⏱️ Time Tracking
- Track billable hours per project/task
- Automatic time logging
- Timesheet management
- Rate calculation untuk invoicing

### 📈 Reports & Analytics
- Project performance metrics
- Income trends analysis
- Client profitability analysis
- Time spent analysis
- Comprehensive business reports (PDF export)

### 🤖 AI Integration
- **Ask AI Feature**: Query tentang project status, deadlines, earnings
- Predictive analytics untuk project completion
- Automated task suggestions
- Smart scheduling recommendations

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 11.x
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Auth
- **Job Queue**: Laravel Queue (Redis)
- **API**: RESTful API

### Frontend
- **Tailwind CSS 3.x**: Responsive UI styling
- **Chart.js**: Data visualization
- **Blade Templates**: Server-side rendering
- **Alpine.js**: Interactive components

### Additional Tools
- **Composer**: Dependency management
- **NPM/Yarn**: Asset compilation
- **Laravel Vite**: Modern asset bundling

---

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+ atau PostgreSQL 13+

### Langkah Instalasi

1. **Clone Repository**
```bash
   git clone https://github.com/yourusername/freelancehub.git
   cd freelancehub
```

2. **Install Dependencies**
```bash
   composer install
   npm install
```

3. **Setup Environment**
```bash
   cp .env.example .env
   php artisan key:generate
```

4. **Database Configuration**
   Update `.env` dengan database credentials:
```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=freelance_hub
   DB_USERNAME=root
   DB_PASSWORD=
```

5. **Migration & Seeding**
```bash
   php artisan migrate
   php artisan db:seed
```

6. **Build Assets**
```bash
   npm run dev     # Development
   npm run build   # Production
```

7. **Run Application**
```bash
   php artisan serve
```
   Akses di `http://localhost:8000`

---

## 📁 Struktur Project
