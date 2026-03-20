# DS AXIS Connection - Ani-Senso Client App Integration Guide

> **Purpose**: This skill provides comprehensive documentation about the connection between the Ani-Senso Course client app and the DS AXIS (Dragon Scale Axis) admin backend system. It contains deep knowledge of database schemas, API endpoints, business logic, and integration patterns.

---

## 1. System Overview

### 1.1 Architecture Relationship

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    DRAGON SCALE WEB COMPANY                              │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │                         DS AXIS                                  │   │
│  │                  (Admin Backend System)                          │   │
│  │                  Location: C:\xampp\htdocs\btc-check             │   │
│  │                                                                   │   │
│  │  Sub-Ventures Managed:                                           │   │
│  │  ├── Dragon Scale Crypto (Crypto Investment)                     │   │
│  │  ├── Dragon Scale Store(s) (E-commerce)                          │   │
│  │  ├── Ani-Senso Academy (Courses) ◄── OUR FOCUS                  │   │
│  │  ├── CRM & Clients                                               │   │
│  │  ├── Access & Triggers                                           │   │
│  │  └── Affiliates                                                  │   │
│  │                                                                   │   │
│  └───────────────────────────┬─────────────────────────────────────┘   │
│                              │                                          │
│                              │ Shared MySQL Database                    │
│                              │ (onmartph_axis)                          │
│                              │                                          │
│  ┌───────────────────────────▼─────────────────────────────────────┐   │
│  │                    ANI-SENSO COURSE                              │   │
│  │               (Customer-Facing Client App)                       │   │
│  │             Location: C:\xampp\htdocs\anisenso-course            │   │
│  │                                                                   │   │
│  │  Features:                                                       │   │
│  │  ├── Student Login/Registration                                  │   │
│  │  ├── Course Browsing & Viewing                                   │   │
│  │  ├── Content Consumption                                         │   │
│  │  ├── Progress Tracking                                           │   │
│  │  ├── Quiz/Questionnaire Taking                                   │   │
│  │  ├── Review Submission                                           │   │
│  │  ├── Comments & Discussions                                      │   │
│  │  └── Certificate Generation                                      │   │
│  │                                                                   │   │
│  └─────────────────────────────────────────────────────────────────┘   │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### 1.2 DS AXIS Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel 12 on PHP 8.2+ |
| UI Template | Skote Admin Template v4.3.0 (Bootstrap 5) |
| Database | MySQL (Remote: `onmartph_axis`) |
| Build Tool | Vite with laravel-vite-plugin |
| Timezone | Asia/Manila (Philippines) |
| Auth | Laravel Session (Admin) / Sanctum (API) |

---

## 2. Database Schema - Ani-Senso Module

### 2.1 Core Course Tables

#### as_courses (Main Course Table)
```sql
as_courses
├── id (PK, int, auto_increment)
├── courseName (text)
├── courseSmallDescription (text)
├── courseBigDescription (text)
├── coursePrice (decimal 10,2)
├── courseImage (text) -- Image path
├── isActive (varchar 5) -- 'true'/'false' as STRING!
├── deleteStatus (varchar 5) -- SOFT DELETE: 'true'/'false' as STRING!
├── created_at (datetime)
└── updated_at (datetime)

⚠️ WARNING: isActive and deleteStatus are VARCHAR storing 'true'/'false' strings!
```

#### as_courses_chapters (Chapters)
```sql
as_courses_chapters
├── id (PK, int)
├── asCoursesId (int) -- FK to as_courses.id
├── chapterTitle (text)
├── chapterDescription (text)
├── chapterCoverPhoto (text)
├── chapterOrder (int) -- For drag-drop sorting
├── deleteStatus (int) -- SOFT DELETE: 1=active, 0=deleted
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_courses_topics (Topics)
```sql
as_courses_topics
├── id (PK, int)
├── chapterId (int) -- FK to as_courses_chapters.id
├── topicTitle (text)
├── topicDescription (text)
├── topicContent (text) -- Rich HTML content
├── topicsOrder (int) -- For sorting
├── deleteStatus (int) -- SOFT DELETE: 1=active
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_topics_resources (Downloadable Resources)
```sql
as_topics_resources
├── id (PK, int)
├── asTopicsId (int) -- FK to as_courses_topics.id
├── fileName (text)
├── fileLink (text) -- Resource URL/path
├── resourcesOrder (int)
├── created_at (datetime)
└── updated_at (datetime)
```

### 2.2 Enrollment & Progress Tables

#### as_course_enrollments
```sql
as_course_enrollments
├── id (PK, int)
├── asCourseId (int) -- FK to as_courses.id
├── accessClientId (int) -- FK to clients_access_login.id
├── enrollmentStatus (varchar) -- 'active', 'completed', 'expired', 'suspended'
├── enrolledAt (datetime)
├── expiresAt (datetime, nullable)
├── completedAt (datetime, nullable)
├── progressPercentage (decimal 5,2, default 0)
├── lastAccessedAt (datetime, nullable)
├── deleteStatus (int) -- SOFT DELETE
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_topic_progress
```sql
as_topic_progress
├── id (PK, int)
├── enrollmentId (int) -- FK to as_course_enrollments.id
├── topicId (int) -- FK to as_courses_topics.id
├── status (varchar) -- 'not_started', 'in_progress', 'completed'
├── startedAt (datetime, nullable)
├── completedAt (datetime, nullable)
├── timeSpentSeconds (int, default 0)
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_content_progress
```sql
as_content_progress
├── id (PK, int)
├── enrollmentId (int)
├── contentId (int)
├── status (varchar)
├── startedAt (datetime, nullable)
├── completedAt (datetime, nullable)
├── timeSpentSeconds (int, default 0)
├── created_at (datetime)
└── updated_at (datetime)
```

### 2.3 Review & Comment Tables

#### as_course_reviews
```sql
as_course_reviews
├── id (PK, int)
├── asCourseId (int) -- FK to as_courses.id
├── accessClientId (int) -- FK to clients_access_login.id
├── rating (int) -- 1-5 stars
├── reviewTitle (varchar, nullable)
├── reviewContent (text)
├── isApproved (tinyint, default 0)
├── isFeatured (tinyint, default 0)
├── deleteStatus (int) -- SOFT DELETE
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_review_replies
```sql
as_review_replies
├── id (PK, int)
├── reviewId (int) -- FK to as_course_reviews.id
├── usersId (int) -- FK to users.id (admin user)
├── replyContent (text)
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_content_comments
```sql
as_content_comments
├── id (PK, int)
├── contentId (int) -- FK to content
├── accessClientId (int) -- FK to clients_access_login.id
├── parentId (int, nullable) -- For threaded replies
├── commentContent (text)
├── isAnswered (tinyint, default 0)
├── deleteStatus (int)
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_comment_reactions
```sql
as_comment_reactions
├── id (PK, int)
├── commentId (int) -- FK to as_content_comments.id
├── accessClientId (int)
├── reactionType (varchar) -- 'like', 'helpful', etc.
├── created_at (datetime)
└── updated_at (datetime)
```

### 2.4 Quiz/Questionnaire Tables

#### as_questionnaires
```sql
as_questionnaires
├── id (PK, int)
├── topicId (int) -- FK to as_courses_topics.id
├── questionnaireName (text)
├── questionnaireDescription (text)
├── questionnaireOrder (int)
├── passingScore (int, default 70)
├── maxAttempts (int, nullable)
├── timeLimitMinutes (int, nullable)
├── deleteStatus (int)
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_questions
```sql
as_questions
├── id (PK, int)
├── questionnaireId (int) -- FK to as_questionnaires.id
├── questionText (text)
├── questionType (varchar) -- 'multiple_choice', 'true_false', 'short_answer'
├── questionImage (text, nullable)
├── options (json) -- For multiple choice
├── correctAnswer (text)
├── points (int, default 1)
├── questionOrder (int)
├── explanation (text, nullable)
├── deleteStatus (int)
├── created_at (datetime)
└── updated_at (datetime)
```

#### as_questionnaire_attempts
```sql
as_questionnaire_attempts
├── id (PK, int)
├── questionnaireId (int)
├── accessClientId (int)
├── enrollmentId (int)
├── score (decimal 5,2)
├── isPassed (tinyint)
├── startedAt (datetime)
├── completedAt (datetime, nullable)
├── timeSpentSeconds (int)
├── answers (json) -- Stored answers
├── created_at (datetime)
└── updated_at (datetime)
```

### 2.5 Certificate Table

#### as_certificate_templates
```sql
as_certificate_templates
├── id (PK, int)
├── asCourseId (int) -- FK to as_courses.id
├── templateName (varchar)
├── templateData (json) -- Certificate design data
├── backgroundImage (text, nullable)
├── created_at (datetime)
└── updated_at (datetime)
```

### 2.6 Student/Client Authentication Tables

#### clients_access_login
```sql
clients_access_login
├── id (PK, int)
├── clientFirstName (text)
├── clientMiddleName (text)
├── clientLastName (text)
├── productStore (text) -- Store access identifier
├── clientPhoneNumber (text)
├── clientEmailAddress (text)
├── clientPassword (text) -- Hashed with bcrypt
├── isActive (int) -- 1=active
├── deleteStatus (int) -- SOFT DELETE: 1=active
├── created_at (datetime)
└── updated_at (datetime)
```

#### clients_all_database (Master Client Record)
```sql
clients_all_database
├── id (PK, int)
├── clientFirstName (text)
├── clientMiddleName (text)
├── clientLastName (text)
├── clientPhoneNumber (text)
├── clientEmailAddress (text)
├── created_at (datetime)
└── updated_at (datetime)
```

### 2.7 Access Control Tables

#### axis_tags
```sql
axis_tags
├── id (PK, int)
├── tagName (text) -- Tag identifier
├── tagType (text) -- 'access', 'discount', etc.
├── targetId (int) -- Related entity ID
├── expirationLength (int) -- Days until expiry
├── deleteStatus (int) -- SOFT DELETE
├── created_at (datetime)
└── updated_at (datetime)
```

---

## 3. Entity Relationship Diagram

```
                    clients_access_login
                           │
              ┌────────────┼────────────┐
              ▼            │            ▼
    as_course_enrollments  │    as_course_reviews
              │            │            │
              │            ▼            │
              │     as_courses ◄────────┘
              │            │
              │    ┌───────┴───────┐
              │    ▼               ▼
              │ as_courses_    as_certificate_
              │  chapters        templates
              │    │
              │    ▼
              │ as_courses_topics
              │    │
              ├────┼──────────────────────────────┐
              │    │                              │
              ▼    ▼                              ▼
    as_topic_progress  as_topics_resources   as_questionnaires
                                                    │
                                                    ▼
                                              as_questions
                                                    │
                                                    ▼
                                      as_questionnaire_attempts
```

---

## 4. Query Patterns

### 4.1 Get Active Courses

```php
// Note the STRING comparison for courses
$courses = DB::table('as_courses')
    ->where('isActive', 'true')      // STRING 'true'
    ->where('deleteStatus', 'true')  // STRING 'true'
    ->orderBy('created_at', 'desc')
    ->get();
```

### 4.2 Get Course with Chapters and Topics (Ordered)

```php
$course = DB::table('as_courses')
    ->where('id', $courseId)
    ->where('deleteStatus', 'true')  // STRING
    ->first();

$chapters = DB::table('as_courses_chapters')
    ->where('asCoursesId', $courseId)
    ->where('deleteStatus', 1)  // INTEGER
    ->orderBy('chapterOrder', 'ASC')
    ->get();

foreach ($chapters as $chapter) {
    $chapter->topics = DB::table('as_courses_topics')
        ->where('chapterId', $chapter->id)
        ->where('deleteStatus', 1)  // INTEGER
        ->orderBy('topicsOrder', 'ASC')
        ->get();
}
```

### 4.3 Get Student Enrollments

```php
$enrollments = DB::table('as_course_enrollments as e')
    ->join('as_courses as c', 'e.asCourseId', '=', 'c.id')
    ->where('e.accessClientId', $studentId)
    ->where('e.deleteStatus', 1)
    ->where('e.enrollmentStatus', 'active')
    ->where('c.deleteStatus', 'true')  // STRING for courses!
    ->select('e.*', 'c.courseName', 'c.courseImage')
    ->get();
```

### 4.4 Track Topic Progress

```php
// Update or create progress
DB::table('as_topic_progress')->updateOrInsert(
    [
        'enrollmentId' => $enrollmentId,
        'topicId' => $topicId
    ],
    [
        'status' => 'completed',
        'completedAt' => now(),
        'updated_at' => now()
    ]
);

// Update overall progress percentage
$totalTopics = DB::table('as_courses_topics')
    ->join('as_courses_chapters', 'as_courses_topics.chapterId', '=', 'as_courses_chapters.id')
    ->where('as_courses_chapters.asCoursesId', $courseId)
    ->where('as_courses_topics.deleteStatus', 1)
    ->count();

$completedTopics = DB::table('as_topic_progress')
    ->where('enrollmentId', $enrollmentId)
    ->where('status', 'completed')
    ->count();

$percentage = ($completedTopics / $totalTopics) * 100;

DB::table('as_course_enrollments')
    ->where('id', $enrollmentId)
    ->update(['progressPercentage' => $percentage]);
```

### 4.5 Student Authentication

```php
// Login validation
$student = DB::table('clients_access_login')
    ->where('clientEmailAddress', $email)
    ->where('isActive', 1)
    ->where('deleteStatus', 1)
    ->first();

if ($student && Hash::check($password, $student->clientPassword)) {
    // Login successful
    // Create session or token
}
```

---

## 5. DS AXIS API Endpoints (Ani-Senso)

### 5.1 Internal Admin APIs (Session Auth)

Base URL: `{DS_AXIS_URL}/api/anisenso`

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/chapters/{id}` | Get chapter details |
| POST | `/chapters` | Create chapter |
| PUT | `/chapters/{id}` | Update chapter |
| DELETE | `/chapters/{id}` | Delete chapter |
| PUT | `/chapters/order` | Update chapter order |
| GET | `/topics/{id}` | Get topic details |
| POST | `/topics` | Create topic |
| PUT | `/topics/{id}` | Update topic |
| DELETE | `/topics/{id}` | Delete topic |
| PUT | `/topics/order` | Update topic order |
| GET | `/contents/{id}` | Get content details |
| POST | `/contents` | Create content |
| POST | `/contents/{id}` | Update content (with files) |
| DELETE | `/contents/{id}` | Delete content |
| GET | `/questionnaires/{id}` | Get questionnaire |
| POST | `/questionnaires` | Create questionnaire |
| PUT | `/questionnaires/{id}` | Update questionnaire |
| DELETE | `/questionnaires/{id}` | Delete questionnaire |
| GET | `/courses/{courseId}/comments` | Get course comments |
| POST | `/comments` | Create comment |
| POST | `/comments/{id}/reply` | Reply to comment |
| POST | `/comments/{id}/reaction` | Add reaction |

### 5.2 Public API Considerations

For the client app, you may want to create dedicated public APIs with:
- Token-based authentication for students
- Rate limiting
- Proper CORS headers

---

## 6. Business Rules

### 6.1 Enrollment Rules

1. Student must have `clients_access_login` account
2. Enrollment created in `as_course_enrollments`
3. Check `enrollmentStatus = 'active'`
4. Check `expiresAt` if set
5. Access tags may restrict certain courses

### 6.2 Progress Tracking Rules

1. Progress tracked at topic level (`as_topic_progress`)
2. Content progress tracked separately (`as_content_progress`)
3. Overall percentage calculated from completed topics
4. Questionnaire completion affects progress

### 6.3 Quiz Rules

1. Check `maxAttempts` before allowing new attempt
2. Enforce `timeLimitMinutes` if set
3. Calculate score against `passingScore`
4. Store all answers in JSON format
5. Mark `isPassed` based on score vs passing score

### 6.4 Certificate Rules

1. Course must have certificate template
2. Student must have `enrollmentStatus = 'completed'`
3. All required questionnaires must be passed
4. Certificate generated from `as_certificate_templates.templateData`

---

## 7. File Storage Paths (DS AXIS)

| Content Type | Path |
|--------------|------|
| Course Images | `public/images/courses/` |
| Chapter Images | `public/images/chapters/` |
| Topic Images | `public/images/topics/` |
| Resources | `public/uploads/resources/` |
| Question Images | `public/images/anisenso/questions/` |
| Certificate Assets | `public/images/anisenso/certificates/assets/` |
| Content Photos | `public/images/anisenso/content-photos/` |

---

## 8. Integration Approaches

### Option A: Direct Database Connection (Recommended)

Both apps share the same database. Create models in client app that:
- Connect to same database
- Follow same naming conventions
- Use same soft delete patterns

### Option B: API Integration

Create API layer in DS AXIS for client app to consume:
- Student auth endpoints
- Course listing/detail endpoints
- Progress tracking endpoints
- Quiz submission endpoints

### Option C: Hybrid Approach

- Direct DB for read operations (courses, content)
- API calls for write operations (progress, reviews)

---

## 9. Development Checklist

### Before Starting:

- [ ] Understand DS AXIS architecture
- [ ] Read database-architect.md from DS AXIS
- [ ] Review Ani-Senso routes in DS AXIS
- [ ] Check clients_access_login table structure

### When Implementing Features:

- [ ] Use correct soft delete pattern per table
- [ ] Implement proper ordering (chapterOrder, topicsOrder)
- [ ] Handle STRING vs INTEGER comparisons
- [ ] Check enrollment status before showing content
- [ ] Track all progress changes

### For Testing:

- [ ] Test with actual DS AXIS data
- [ ] Verify soft delete filters work
- [ ] Test enrollment expiration logic
- [ ] Test quiz scoring and attempts

---

## 10. Quick Reference

### Soft Delete Summary

| Table | Column | Active Value |
|-------|--------|--------------|
| as_courses | deleteStatus | `'true'` (STRING) |
| as_courses_chapters | deleteStatus | `1` (INTEGER) |
| as_courses_topics | deleteStatus | `1` (INTEGER) |
| as_course_enrollments | deleteStatus | `1` (INTEGER) |
| as_course_reviews | deleteStatus | `1` (INTEGER) |
| as_content_comments | deleteStatus | `1` (INTEGER) |
| as_questionnaires | deleteStatus | `1` (INTEGER) |
| as_questions | deleteStatus | `1` (INTEGER) |
| clients_access_login | deleteStatus | `1` (INTEGER) |

### Key Foreign Keys

| Child Table | FK Column | Parent Table |
|-------------|-----------|--------------|
| as_courses_chapters | asCoursesId | as_courses |
| as_courses_topics | chapterId | as_courses_chapters |
| as_topics_resources | asTopicsId | as_courses_topics |
| as_course_enrollments | asCourseId | as_courses |
| as_course_enrollments | accessClientId | clients_access_login |
| as_topic_progress | enrollmentId | as_course_enrollments |
| as_topic_progress | topicId | as_courses_topics |
| as_course_reviews | asCourseId | as_courses |
| as_course_reviews | accessClientId | clients_access_login |
| as_questionnaires | topicId | as_courses_topics |
| as_questions | questionnaireId | as_questionnaires |

---

*This skill document provides complete integration knowledge for the Ani-Senso Course client app. Always reference this and the DS AXIS architect skills when developing features.*
