# CLAUDE.md - Ani-Senso Course Client App Guide

This file provides guidance to Claude Code when working with the Ani-Senso Course client application. This is the **customer-facing frontend** that connects to the DS AXIS admin backend.

---

## 1. Project Identity

| Property | Value |
|----------|-------|
| **Project Name** | Ani-Senso Course (Client App) |
| **Company** | Dragon Scale Web Company |
| **Purpose** | Customer-facing course platform / Learning Management System |
| **Parent System** | DS AXIS (Dragon Scale Axis) - Admin Backend |
| **Parent Location** | `C:\xampp\htdocs\btc-check` |
| **Timezone** | Asia/Manila (Philippines) |
| **Framework** | Laravel 12 |
| **PHP Version** | 8.2+ |
| **UI Framework** | Tailwind CSS (CDN) |
| **JS Framework** | Alpine.js |
| **URL** | http://localhost:8001 |

### What is Ani-Senso Course?

Ani-Senso Course is the **customer-facing frontend** for the Ani-Senso Academy sub-venture under Dragon Scale Web Company. While the admin system (DS AXIS) manages courses, content, and students, this client app:

- Displays courses to students/customers
- Handles student authentication (via `clients_access_login`)
- Shows course content (chapters, topics, resources)
- Tracks student progress
- Handles questionnaires and quizzes
- Manages reviews and comments
- Generates and displays certificates

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    ANI-SENSO ARCHITECTURE                                │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ┌─────────────────────────────────┐                                   │
│  │         DS AXIS                 │                                   │
│  │    (btc-check - Admin)          │                                   │
│  │                                 │                                   │
│  │  • Course Management            │                                   │
│  │  • Content Creation             │                                   │
│  │  • Student Enrollment           │                                   │
│  │  • Access Tag Management        │                                   │
│  │  • Certificate Templates        │                                   │
│  │  • Reviews Moderation           │                                   │
│  └───────────────┬─────────────────┘                                   │
│                  │                                                      │
│                  │ Shared Database                                      │
│                  │ (onmartph_axis)                                      │
│                  │                                                      │
│                  ▼                                                      │
│  ┌─────────────────────────────────┐                                   │
│  │     ANI-SENSO COURSE            │                                   │
│  │    (This Client App)            │                                   │
│  │                                 │                                   │
│  │  • Student Login/Register       │                                   │
│  │  • Browse Courses               │                                   │
│  │  • View Course Content          │                                   │
│  │  • Track Progress               │                                   │
│  │  • Take Quizzes                 │                                   │
│  │  • Submit Reviews               │                                   │
│  │  • Download Certificates        │                                   │
│  └─────────────────────────────────┘                                   │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Reference Skills

### CRITICAL: Before any development, read these skills from DS AXIS:

| Skill | Location | Purpose |
|-------|----------|---------|
| **ds-axis-connection** | `.claude/skills/ds-axis-connection.md` | Connection to admin backend |
| **codebase-architect** | `C:\xampp\htdocs\btc-check\.claude\skills\codebase-architect.md` | Admin system structure |
| **database-architect** | `C:\xampp\htdocs\btc-check\.claude\skills\database-architect.md` | Complete database schema |
| **logic-architect** | `C:\xampp\htdocs\btc-check\.claude\skills\logic-architect.md` | Business logic flows |

### When to Reference DS AXIS Skills:

1. **Understanding database schema** - Read `database-architect.md`
2. **Understanding content structure** - Read `codebase-architect.md` (Ani-Senso module)
3. **Understanding API endpoints** - Read `logic-architect.md`
4. **Understanding relationships** - Read all three architect skills

---

## 3. Database Connection

This client app connects to the **SAME database** as DS AXIS:

| Property | Value |
|----------|-------|
| **Database Name** | `onmartph_axis` |
| **Host** | `15.235.219.232` (Production) or `localhost` (Development) |
| **Port** | `3306` |

### Key Tables for Client App

| Table | Purpose | Soft Delete |
|-------|---------|-------------|
| `as_courses` | Course listings | `deleteStatus = 'true'` |
| `as_courses_chapters` | Chapter structure | `deleteStatus = 1` |
| `as_courses_topics` | Topics within chapters | `deleteStatus = 1` |
| `as_topics_resources` | Downloadable resources | N/A |
| `as_course_enrollments` | Student enrollments | `deleteStatus = 1` |
| `as_topic_progress` | Progress tracking | N/A |
| `as_course_reviews` | Student reviews | `deleteStatus = 1` |
| `as_content_comments` | Comments on content | `deleteStatus = 1` |
| `as_questionnaires` | Quizzes/questionnaires | `deleteStatus = 1` |
| `as_questions` | Quiz questions | `deleteStatus = 1` |
| `as_certificate_templates` | Certificate designs | N/A |
| `clients_access_login` | Student accounts | `deleteStatus = 1` |
| `axis_tags` | Access control tags | `deleteStatus = 1` |

### Soft Delete Warning

**CRITICAL**: Ani-Senso module has INCONSISTENT soft delete patterns:

- `as_courses`: Uses `deleteStatus = 'true'/'false'` (string!)
- Other `as_*` tables: Use `deleteStatus = 1/0` (integer)

Always check the specific table pattern before querying.

---

## 4. Client Authentication

Students authenticate via `clients_access_login` table:

```
clients_access_login
├── id (PK)
├── clientFirstName
├── clientMiddleName
├── clientLastName
├── productStore (store access)
├── clientPhoneNumber
├── clientEmailAddress
├── clientPassword (hashed)
├── isActive
├── deleteStatus
├── created_at
└── updated_at
```

### Authentication Flow

```
Student ──► Login Page
              │
              ▼
         Validate credentials against clients_access_login
              │
              ▼
         Check isActive = 1 AND deleteStatus = 1
              │
              ▼
         Check enrollment in as_course_enrollments
              │
              ▼
         Grant access to enrolled courses
```

---

## 5. Course Content Hierarchy

```
Course (as_courses)
    │
    ├── Chapters (as_courses_chapters)
    │       │   └── chapterOrder for sorting
    │       │
    │       └── Topics (as_courses_topics)
    │               │   └── topicsOrder for sorting
    │               │
    │               ├── Contents (as_topic_contents)
    │               │       └── contentOrder for sorting
    │               │
    │               ├── Questionnaires (as_questionnaires)
    │               │       └── Questions (as_questions)
    │               │
    │               └── Resources (as_topics_resources)
    │                       └── resourcesOrder for sorting
    │
    ├── Enrollments (as_course_enrollments)
    │       └── Progress (as_topic_progress)
    │
    ├── Reviews (as_course_reviews)
    │       └── Replies (as_review_replies)
    │
    └── Comments (as_content_comments)
            └── Reactions (as_comment_reactions)
```

---

## 6. Development Commands

```bash
# Install dependencies
composer install

# Start development server (on port 8001 to avoid conflict with btc-check)
php artisan serve --port=8001

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run database migrations (if needed)
php artisan migrate

# Generate application key (already done)
php artisan key:generate
```

### Project Structure

```
anisenso-course/
├── app/
│   ├── Http/Controllers/Auth/LoginController.php  # Authentication
│   └── Models/ClientAccessLogin.php               # User model
├── config/auth.php                                 # Auth guards (client guard)
├── resources/views/
│   ├── layouts/app.blade.php                      # Main layout (mobile-first)
│   ├── auth/login.blade.php                       # Login page
│   └── dashboard.blade.php                        # Dashboard
├── routes/web.php                                  # Web routes
└── .env                                            # Environment config
```

---

## 7. Quick Reference Checklist

### Before Implementing Features:

- [ ] Read ds-axis-connection.md skill
- [ ] Reference DS AXIS database-architect.md for schema
- [ ] Check soft delete pattern for target tables
- [ ] Verify access tag requirements for features

### When Querying Courses:

- [ ] Filter by `isActive = 'true'` AND `deleteStatus = 'true'`
- [ ] Include chapter/topic ordering
- [ ] Check enrollment status for current student
- [ ] Load progress data if needed

### When Handling Student Auth:

- [ ] Validate against `clients_access_login`
- [ ] Check `isActive = 1` AND `deleteStatus = 1`
- [ ] Load enrollments from `as_course_enrollments`
- [ ] Check access tags if applicable

---

## 8. API Integration Options

### Option 1: Direct Database Connection

Both apps share the same database, so direct model queries work.

### Option 2: API Calls to DS AXIS

DS AXIS has API endpoints at `/api/anisenso/*` that can be used if needed.

### Decision Point:

The preferred approach depends on:
- Performance requirements
- Separation of concerns needs
- Authentication mechanism chosen

---

## 9. Related Resources

| Resource | Location |
|----------|----------|
| Admin System | `C:\xampp\htdocs\btc-check` |
| Admin CLAUDE.md | `C:\xampp\htdocs\btc-check\CLAUDE.md` |
| Database Schema | `C:\xampp\htdocs\btc-check\.claude\skills\database-architect.md` |
| Admin Agents | `C:\xampp\htdocs\btc-check\.claude\agents\` |
| Admin Skills | `C:\xampp\htdocs\btc-check\.claude\skills\` |

---

*This document should be consulted before implementing any feature. For detailed database schema and admin system patterns, always reference the DS AXIS skill files.*
