# 🚀 Team Task Manager

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
  <strong>Modern Collaborative Task Management System built with Laravel</strong>
</p>

<p align="center">
  Workspace • Task Board • Collaboration • Dashboard • Notifications
</p>

---

# 📖 About Project

Team Task Manager adalah aplikasi manajemen tugas berbasis workspace/team yang dirancang untuk membantu kolaborasi tim secara realtime dan terstruktur.

Aplikasi ini mendukung:
- Multi Workspace / Team
- Task Assignment
- Kanban Drag & Drop Board
- Activity & Audit Log
- Comment Collaboration
- Attachment Upload
- Dashboard Monitoring
- Notification System
- Personal Dashboard
- Dark Mode Support

Project ini dibangun menggunakan:
- Laravel 13
- Laravel Breeze
- Blade Template Engine
- MySQL
- TailwindCSS
- Repository Pattern Architecture
- Service Layer Architecture

---

# ✨ Main Features

## 🔐 Authentication
- Register
- Login
- Logout
- Session Authentication
- Password Hashing
- Protected Routes

---

## 🏢 Workspace Management
- Create Workspace
- Update Workspace
- Archive Workspace
- Delete Workspace
- Workspace Access Control

---

## 👥 Team Member Management
- Invite Member by Email
- Change Member Role
- Remove Member
- Multi Workspace Membership

---

## ✅ Task Management
- Create Task
- Assign Task
- Deadline Management
- Task Status Workflow
- Soft Delete Task
- Overdue Detection

---

## 📋 Kanban Board
- Drag & Drop Task
- Todo / In Progress / Done
- Task Reordering
- Live Status Update

---

## 💬 Collaboration
- Task Comments
- File Attachments
- Activity Timeline
- Status History

---

## 📊 Dashboard
- Workspace Dashboard
- Personal Dashboard
- Task Distribution
- Overdue Monitoring
- Latest Activities

---

## 🔔 Notifications
- In-App Notifications
- Email Notifications
- Deadline Reminder
- Overdue Reminder

---

# 🏗️ Architecture

```txt
app/
├── Actions/
├── Constants/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Policies/
├── Queries/
├── Repositories/
├── RepositoryInterfaces/
└── Services/
```

---

# 🧱 Core Entities

| Entity | Description |
|---|---|
| Users | Data pengguna aplikasi |
| Teams | Workspace / Team |
| Team Members | Relasi user & workspace |
| Tasks | Task utama |
| Task Comments | Diskusi task |
| Task Attachments | File attachment |
| Task Status Histories | Riwayat status |
| Workspace Activities | Audit log |
| Notifications | Sistem notifikasi |
| User Preferences | Dark mode & setting |
| Task Board Positions | Posisi drag-drop |
| Dashboard Metrics | Summary dashboard |

---

# ⚡ Tech Stack

| Technology | Usage |
|---|---|
| Laravel 12 | Backend Framework |
| PHP 8.3+ | Programming Language |
| MySQL | Database |
| Blade | Templating Engine |
| TailwindCSS | Styling |
| Laravel Breeze | Authentication |
| Vite | Frontend Build Tool |

---

# 🚀 Installation

## Clone Repository

```bash
git clone https://github.com/your-username/team-task-manager.git
```

---

## Masuk ke Folder Project

```bash
cd team-task-manager
```

---

## Install Dependency

```bash
composer install
npm install
```

---

## Setup Environment

```bash
cp .env.example .env
```

---

## Generate Application Key

```bash
php artisan key:generate
```

---

## Setup Database

Edit file `.env`

```env
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

---

## Run Migration

```bash
php artisan migrate
```

---

## Install Breeze

```bash
php artisan breeze:install blade
npm install
npm run dev
```

---

## Run Seeder

```bash
php artisan db:seed
```

---

## Start Development Server

```bash
php artisan serve
```

---

# 📂 Main Modules

| Module | Status |
|---|---|
| Authentication | 🚧 |
| Workspace Management | 🚧 |
| Team Member Management | 🚧 |
| Task Management | 🚧 |
| Task Board | 🚧 |
| Dashboard | 🚧 |
| Notifications | 🚧 |
| Activity Log | 🚧 |
| User Preferences | 🚧 |

---

# 🔐 Roles & Permissions

## Owner / Admin
- Manage Workspace
- Manage Members
- Create/Edit/Delete Tasks
- Assign Tasks
- View Dashboard
- Remove Attachments & Comments

## Member
- View Workspace
- Create Task
- Update Own Task
- Change Task Status
- Add Comment
- Upload Attachment

---

# 📊 Task Workflow

```txt
TODO
  ↓
IN PROGRESS
  ↓
DONE
```

Task overdue dihitung otomatis berdasarkan:
- deadline telah lewat
- status belum DONE

---

# 🧪 Future Improvements

- Realtime Notification
- Realtime Collaboration
- Activity Streaming
- Team Chat
- Calendar Integration
- API Support
- Mobile App
- WebSocket Integration
- Advanced Analytics

---

# 📸 Screenshots

> Coming Soon 🚀

---

# 🤝 Contributing

Pull request dan contribution sangat terbuka.

## Contribution Flow

```bash
fork → create branch → commit → pull request
```

---

# 📄 License

Project ini menggunakan lisensi MIT.

---

# 👨‍💻 Author

Developed with ❤️ using Laravel.

<p align="center">
  <strong>Team Task Manager v1.0.0</strong>
</p>
