# 🎓 College Alumni Management System  
A simple, clean, beginner-friendly project built step-by-step to help alumni connect with each other and interact with the college.  
Made by students, improved daily, and still growing.

---

## ✨ Features Completed So Far

### 🔐 Authentication
- Alumni Registration (with admin approval flow)
- Alumni Login (secure password hashing)
- Admin Login (with dark/light mode support)
- Sessions and role-based access

---

## 👨‍🎓 Alumni Features
- **Edit Profile** (name, batch, branch, contact, LinkedIn, city)
- **View College Alumni Directory**  
  - search by *name, batch, branch, city*
- **View Profiles of Other Alumni**
- **Create Posts** (sent to admin for approval)
- **My Posts Section**  
  - see own posts  
  - see approval status  
  - delete your own post
- **Comment on Posts** (AJAX — real-time feel)
- **Delete own comments**
- **Post Owner Controls**  
  - delete comments under your post  
  - delete your entire post
- **Report System**
  - report post  
  - report comment  
  - sent directly to admin notifications

---

## 🛡️ Admin Panel
Clean dashboard with instant stats:

### ✔ Current Features
- See pending alumni registrations  
- See pending posts for approval  
- Approve / Delete alumni  
- Approve / Delete posts  
- Manage all posts  
- **Notifications system**  
  - view reported posts  
  - view reported comments  
  - mark as reviewed  
  - take actions (delete post/comment)

### ✔ UI for Admin
- Light / Dark theme toggle  
- Clear cards, badges showing pending counts  
- Clean and simple to use  

---

## 💬 Comments System (NEW)
- AJAX-based (no page refresh)
- Live auto-refresh every few seconds
- Comment counter updates instantly
- Centered popup & toast on successful actions

---

## ⚠️ Reporting System (NEW)
- Three-dot professional menu for comments & posts  
- Any alumni can report inappropriate content  
- Reports reach admin instantly  
- Admin can:  
  - delete the content  
  - dismiss the report  
  - keep track of report history  

---

## 🎨 UI & UX
- Fully responsive (Bootstrap 5)
- Light/Dark theme toggle (global)
- Clean spacing, readable fonts  
- Modern three-dot action buttons  
- Toast notifications and popup animations

---

## 🛠️ Tech Used
- PHP (Core)
- MySQL (phpMyAdmin)
- Bootstrap 5
- JavaScript (AJAX, dynamic DOM updates)
- XAMPP / Apache (local server)
- Git + GitHub for version control

---

## 🚧 What’s Left (Upcoming Tasks)
Still working, still improving. Next features planned:

### 💡 High Priority
- Profile picture upload  
- Improve delete animations (fade-out)  
- Admin can edit alumni profile fields  
- Multi-image support for posts (optional)  

### 🔔 Future Enhancements
- Real-time notifications (WebSocket or SSE)  
- Email notifications for approvals  
- Admin analytics (most active alumni, post stats)  
- Mobile optimizations  
- Downloadable database export for submission  

---
 Why This Project Exists
We started this project as beginners — making mistakes, fixing them, learning step by step.  
This system is our proof that you **don’t need to be an expert to build something real**.  
Each feature was added with patience and teamwork.

Still learning. Still improving.  
More features coming. 

---
Teamwork
Anyone from the team can clone the repo, test, improve, and contribute.  
Every push shows progress and effort.

---

 How to Run (Local Setup)
1. Install XAMPP  
2. Copy project into:  
   `C:\xampp\htdocs\alumni_project`
3. Import the SQL database (tables: alumni, posts, comments, notifications, admin)
4. Start Apache + MySQL  
5. Open in browser:  
   **http://localhost/alumni_project**  
6. Admin Login (example):  
   - username: `admin`  
   - password: `admin123`  
   *(change later for security)*

---

Made with patience. Built with learning.  
Running with teamwork.  
Improving every day. 🌱
