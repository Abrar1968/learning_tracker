# API Documentation
## LearnForge — RESTful API Reference

**Version:** 4.0 (Windows + VSCode Edition)
**Last Updated:** March 2026
**Framework:** Laravel 12.x
**API Type:** RESTful API
**Base URL:** `/api/v1/`
**Authentication:** Laravel Sanctum (Session-based for web + Bearer token for external access)

---

## Table of Contents

1. [API Overview](#api-overview)
2. [Authentication](#authentication)
3. [Response Format](#response-format)
4. [Error Handling](#error-handling)
5. [Authentication Endpoints](#authentication-endpoints)
6. [Roadmap Endpoints](#roadmap-endpoints)
7. [Topic Endpoints](#topic-endpoints)
8. [Resource Endpoints](#resource-endpoints)
9. [Progress & Analytics Endpoints](#progress--analytics-endpoints)
10. [Certificate Endpoints](#certificate-endpoints)
11. [User Profile Endpoints](#user-profile-endpoints)
12. [Search Endpoints](#search-endpoints)
13. [AI Endpoints](#ai-endpoints)
14. [SRS / Flashcard Endpoints](#srs--flashcard-endpoints)
15. [Gamification Endpoints](#gamification-endpoints)
16. [Social Endpoints](#social-endpoints)
17. [Journal & Mood Endpoints](#journal--mood-endpoints)
18. [Productivity Endpoints](#productivity-endpoints)
19. [Analytics Endpoints](#analytics-endpoints)
20. [Integration Endpoints](#integration-endpoints)
21. [PWA & Push Endpoints](#pwa--push-endpoints)
22. [Admin Endpoints](#admin-endpoints)
23. [Public Endpoints](#public-endpoints)
24. [Webhook Events Reference](#webhook-events-reference)
25. [Rate Limiting](#rate-limiting)

---

## API Overview

### Base Information

- **Protocol**: HTTPS (enforced in production)
- **Authentication**: Session-based (CSRF token) for web; Bearer token for external API
- **Content-Type**: `application/json`
- **Rate Limiting**: 100 req/min (authenticated), 20 req/min (unauthenticated), 10 req/min (AI endpoints)
- **Pagination**: 20 items per page (default), max 50
- **API Documentation**: Auto-generated at `/api/docs` via Laravel Scribe

### HTTP Methods

- `GET`: Retrieve resources
- `POST`: Create new resources
- `PUT/PATCH`: Update existing resources
- `DELETE`: Delete resources

---

## Authentication

### Session-Based (Web — CSRF Token)

All POST, PUT, PATCH, DELETE requests require CSRF token:

```javascript
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

fetch('/api/v1/roadmaps', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(data)
});
```

### Bearer Token (External / Webhook / Automation)

Personal API tokens via Laravel Sanctum — generated in **Profile → Developer → API Tokens**:

```http
Authorization: Bearer {your-api-token}
Content-Type: application/json
```

Token scopes: `read`, `write`, `delete` (selected on creation).

---

## Response Format

### Success Response

```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Full Stack Developer Roadmap",
        "progress_percentage": 65.50
    },
    "message": "Roadmap created successfully"
}
```

### Paginated Response

```json
{
    "success": true,
    "data": [
        { "id": 1, "title": "Roadmap 1" },
        { "id": 2, "title": "Roadmap 2" }
    ],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "per_page": 20,
        "to": 20,
        "total": 95
    },
    "links": {
        "first": "/api/roadmaps?page=1",
        "last": "/api/roadmaps?page=5",
        "prev": null,
        "next": "/api/roadmaps?page=2"
    }
}
```

---

## Error Handling

### Error Response Format

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "estimated_hours": [
            "The estimated hours must be a number."
        ]
    }
}
```

### HTTP Status Codes

| Code | Meaning | Description |
|------|---------|-------------|
| 200 | OK | Request successful |
| 201 | Created | Resource created successfully |
| 204 | No Content | Resource deleted successfully |
| 400 | Bad Request | Invalid request data |
| 401 | Unauthorized | Authentication required |
| 403 | Forbidden | Insufficient permissions |
| 404 | Not Found | Resource not found |
| 422 | Unprocessable Entity | Validation failed |
| 429 | Too Many Requests | Rate limit exceeded |
| 500 | Internal Server Error | Server error |

---

## Authentication Endpoints

### Register New User

**POST** `/register`

**Request Body**:
```json
{
    "username": "johndoe",
    "email": "john@example.com",
    "password": "SecurePass123",
    "password_confirmation": "SecurePass123",
    "full_name": "John Doe",
    "profession": "Software Developer"
}
```

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "username": "johndoe",
        "email": "john@example.com",
        "full_name": "John Doe",
        "profession": "Software Developer",
        "created_at": "2025-12-11T10:00:00Z"
    },
    "message": "Registration successful"
}
```

### Login

**POST** `/login`

**Request Body**:
```json
{
    "email": "john@example.com",
    "password": "SecurePass123",
    "remember": true
}
```

**Response** (200):
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "username": "johndoe",
            "email": "john@example.com"
        }
    },
    "message": "Login successful"
}
```

### Logout

**POST** `/logout`

**Response** (204): No content

---

## Roadmap Endpoints

### List User's Roadmaps

**GET** `/roadmaps`

**Query Parameters**:
- `status` (string): Filter by status (all|active|completed|archived)
- `category` (string): Filter by category
- `page` (integer): Page number for pagination
- `per_page` (integer): Items per page (max 50)

**Response** (200):
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Full Stack Developer Roadmap",
            "slug": "full-stack-developer-roadmap",
            "description": "Complete roadmap to become a full stack developer",
            "category": "Software Development",
            "difficulty_level": "intermediate",
            "progress_percentage": 65.50,
            "total_score": 72.30,
            "status": "active",
            "total_topics": 20,
            "completed_topics": 13,
            "is_public": false,
            "target_completion_date": "2026-06-30",
            "created_at": "2025-01-15T08:00:00Z",
            "updated_at": "2025-12-10T14:30:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 5
    }
}
```

### Create Roadmap

**POST** `/roadmaps`

**Request Body**:
```json
{
    "title": "Machine Learning Engineer Roadmap",
    "description": "Path to becoming an ML engineer",
    "category": "Data Science",
    "difficulty_level": "advanced",
    "target_completion_date": "2026-12-31"
}
```

**Validation Rules**:
- `title`: required, string, max:255
- `description`: nullable, string, max:5000
- `category`: nullable, string, max:100
- `difficulty_level`: nullable, in:beginner,intermediate,advanced
- `target_completion_date`: nullable, date, after:today

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 6,
        "title": "Machine Learning Engineer Roadmap",
        "slug": "machine-learning-engineer-roadmap",
        "progress_percentage": 0,
        "status": "active",
        "created_at": "2025-12-11T10:00:00Z"
    },
    "message": "Roadmap created successfully"
}
```

### Get Roadmap Details

**GET** `/roadmaps/{id}`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Full Stack Developer Roadmap",
        "description": "Complete roadmap...",
        "category": "Software Development",
        "difficulty_level": "intermediate",
        "progress_percentage": 65.50,
        "total_score": 72.30,
        "status": "active",
        "topics": [
            {
                "id": 1,
                "title": "HTML & CSS Fundamentals",
                "description": "Learn HTML5 and CSS3",
                "estimated_hours": 40,
                "status": "completed",
                "completed_at": "2025-02-15T10:00:00Z",
                "resources_count": 5
            }
        ],
        "user": {
            "id": 1,
            "username": "johndoe",
            "full_name": "John Doe"
        },
        "created_at": "2025-01-15T08:00:00Z"
    }
}
```

### Update Roadmap

**PUT** `/roadmaps/{id}`

**Request Body**:
```json
{
    "title": "Updated Roadmap Title",
    "description": "Updated description",
    "target_completion_date": "2026-12-31",
    "is_public": true
}
```

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Updated Roadmap Title",
        "updated_at": "2025-12-11T10:30:00Z"
    },
    "message": "Roadmap updated successfully"
}
```

### Delete Roadmap

**DELETE** `/roadmaps/{id}`

**Response** (204): No content

### Reorder Topics

**PUT** `/roadmaps/{id}/reorder`

**Request Body**:
```json
{
    "topic_ids": [3, 1, 5, 2, 4]
}
```

**Response** (200):
```json
{
    "success": true,
    "message": "Topics reordered successfully"
}
```

### Clone Roadmap

**POST** `/roadmaps/{id}/clone`

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 7,
        "title": "Full Stack Developer Roadmap (Copy)",
        "slug": "full-stack-developer-roadmap-copy"
    },
    "message": "Roadmap cloned successfully"
}
```

### Generate Shareable Link

**POST** `/roadmaps/{id}/share`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "share_url": "https://app.com/public/johndoe/full-stack-developer-roadmap",
        "is_public": true
    },
    "message": "Shareable link generated"
}
```

---

## Topic Endpoints

### List Topics for Roadmap

**GET** `/roadmaps/{roadmap_id}/topics`

**Response** (200):
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "roadmap_id": 1,
            "parent_topic_id": null,
            "title": "HTML & CSS Fundamentals",
            "description": "Learn the basics...",
            "estimated_hours": 40,
            "difficulty_level": "beginner",
            "order_index": 0,
            "weight": 1,
            "status": "completed",
            "completed_at": "2025-02-15T10:00:00Z",
            "resources_count": 5,
            "sub_topics": []
        }
    ]
}
```

### Create Topic

**POST** `/roadmaps/{roadmap_id}/topics`

**Request Body**:
```json
{
    "title": "JavaScript ES6+",
    "description": "Modern JavaScript features",
    "estimated_hours": 50,
    "difficulty_level": "intermediate",
    "weight": 2,
    "parent_topic_id": null
}
```

**Validation Rules**:
- `title`: required, string, max:255
- `description`: nullable, string
- `estimated_hours`: required, numeric, min:0.5
- `difficulty_level`: nullable, in:beginner,intermediate,advanced
- `weight`: nullable, integer, min:1, max:10
- `parent_topic_id`: nullable, exists:topics,id

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 15,
        "title": "JavaScript ES6+",
        "status": "not_started",
        "order_index": 5
    },
    "message": "Topic created successfully"
}
```

### Update Topic

**PUT** `/topics/{id}`

**Request Body**:
```json
{
    "title": "Advanced JavaScript ES6+",
    "estimated_hours": 60,
    "description": "Updated description"
}
```

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 15,
        "title": "Advanced JavaScript ES6+",
        "estimated_hours": 60
    },
    "message": "Topic updated successfully"
}
```

### Update Topic Status

**PATCH** `/topics/{id}/status`

**Request Body**:
```json
{
    "status": "completed"
}
```

**Status Values**: `not_started`, `in_progress`, `completed`, `skipped`, `on_hold`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 15,
        "status": "completed",
        "completed_at": "2025-12-11T10:45:00Z"
    },
    "message": "Topic status updated"
}
```

### Delete Topic

**DELETE** `/topics/{id}`

**Response** (204): No content

---

## Resource Endpoints

### List Resources for Topic

**GET** `/topics/{topic_id}/resources`

**Response** (200):
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "topic_id": 1,
            "resource_type": "link",
            "title": "MDN Web Docs - HTML",
            "description": "Comprehensive HTML documentation",
            "url": "https://developer.mozilla.org/en-US/docs/Web/HTML",
            "is_favorite": true,
            "tags": ["documentation", "reference"],
            "created_at": "2025-01-20T09:00:00Z"
        },
        {
            "id": 2,
            "resource_type": "file",
            "title": "HTML Cheat Sheet.pdf",
            "file_path": "resources/user1/html-cheat-sheet.pdf",
            "file_size": 524288,
            "file_size_human": "512 KB",
            "download_url": "/resources/2/download",
            "is_favorite": false
        }
    ]
}
```

### Create Resource

**POST** `/topics/{topic_id}/resources`

**Request Body** (Link):
```json
{
    "resource_type": "link",
    "title": "React Official Documentation",
    "description": "Official React docs",
    "url": "https://react.dev",
    "tags": ["react", "documentation"]
}
```

**Request Body** (Note):
```json
{
    "resource_type": "note",
    "title": "My Learning Notes",
    "content": "# Important Concepts\n\n- Concept 1\n- Concept 2"
}
```

**Request Body** (File) - Multipart Form Data:
```
resource_type: file
title: JavaScript Guide
description: Comprehensive guide
file: [binary file data]
tags[]: javascript, guide
```

**Validation Rules**:
- `resource_type`: required, in:file,link,note,video
- `title`: required, string, max:255
- `description`: nullable, string
- `content`: required_if:resource_type,note
- `url`: required_if:resource_type,link|video, url
- `file`: required_if:resource_type,file, file, max:10240 (10MB)
- `tags`: nullable, array
- `tags.*`: string, max:50

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 25,
        "resource_type": "link",
        "title": "React Official Documentation",
        "url": "https://react.dev"
    },
    "message": "Resource added successfully"
}
```

### Update Resource

**PUT** `/resources/{id}`

**Request Body**:
```json
{
    "title": "Updated Title",
    "description": "Updated description",
    "is_favorite": true
}
```

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 25,
        "title": "Updated Title",
        "is_favorite": true
    },
    "message": "Resource updated successfully"
}
```

### Delete Resource

**DELETE** `/resources/{id}`

**Response** (204): No content

### Download Resource

**GET** `/resources/{id}/download`

**Response**: File download with appropriate headers

---

## Progress & Analytics Endpoints

### Get Roadmap Progress Details

**GET** `/roadmaps/{id}/progress`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "roadmap_id": 1,
        "progress_percentage": 65.50,
        "total_score": 72.30,
        "total_topics": 20,
        "completed_topics": 13,
        "in_progress_topics": 4,
        "not_started_topics": 3,
        "skipped_topics": 0,
        "estimated_total_hours": 200,
        "actual_total_hours": 145.5,
        "time_efficiency": 72.75,
        "average_quality_rating": 4.2,
        "milestones": [
            {
                "percentage": 25,
                "achieved": true,
                "achieved_at": "2025-03-15T10:00:00Z"
            },
            {
                "percentage": 50,
                "achieved": true,
                "achieved_at": "2025-08-20T14:30:00Z"
            },
            {
                "percentage": 75,
                "achieved": false,
                "achieved_at": null
            }
        ]
    }
}
```

### Get Dashboard Statistics

**GET** `/dashboard/stats`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "total_roadmaps": 5,
        "active_roadmaps": 3,
        "completed_roadmaps": 2,
        "total_topics": 87,
        "completed_topics": 45,
        "total_learning_hours": 320.5,
        "total_certificates": 2,
        "current_streak_days": 7,
        "recent_activity": [
            {
                "action": "completed_topic",
                "description": "Completed 'React Hooks'",
                "timestamp": "2025-12-11T09:30:00Z"
            }
        ]
    }
}
```

### Log Time on Topic

**POST** `/topics/{id}/log-time`

**Request Body**:
```json
{
    "actual_hours": 3.5,
    "notes": "Completed exercises and built a small project"
}
```

**Response** (200):
```json
{
    "success": true,
    "message": "Time logged successfully"
}
```

### Rate Topic Completion

**PUT** `/topics/{id}/rating`

**Request Body**:
```json
{
    "quality_rating": 4,
    "notes": "Great learning experience"
}
```

**Validation**: `quality_rating` must be integer between 1-5

**Response** (200):
```json
{
    "success": true,
    "data": {
        "quality_rating": 4
    },
    "message": "Rating saved successfully"
}
```

---

## Certificate Endpoints

### Generate Certificate

**POST** `/roadmaps/{id}/generate-certificate`

**Request Body** (optional):
```json
{
    "template_type": "modern"
}
```

**Template Types**: `modern`, `classic`, `minimalist`, `dark`, `neon`

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "uuid": "550e8400-e29b-41d4-a716-446655440000",
        "certificate_number": "LF-2026-A1B2C3D4",
        "composite_score": 87.50,
        "issued_at": "2026-03-09T10:00:00Z",
        "verification_url": "https://app.com/verify/550e8400-e29b-41d4-a716-446655440000",
        "download_url": "https://app.com/certificates/550e8400-e29b-41d4-a716-446655440000/download",
        "share_image_url": "https://app.com/certificates/550e8400-e29b-41d4-a716-446655440000/og-image.png",
        "qr_code_url": "https://app.com/certificates/550e8400-e29b-41d4-a716-446655440000/qr"
    },
    "message": "Certificate generated successfully"
```

### List User Certificates

**GET** `/certificates`

**Response** (200):
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "uuid": "550e8400-e29b-41d4-a716-446655440000",
            "certificate_number": "CERT-ABC1234567",
            "roadmap_title": "Full Stack Developer Roadmap",
            "issued_at": "2025-12-11T10:00:00Z",
            "total_topics": 20,
            "total_learning_hours": 200,
            "download_url": "/certificates/550e8400-e29b-41d4-a716-446655440000/download"
        }
    ]
}
```

### Download Certificate PDF

**GET** `/certificates/{uuid}/download`

**Response**: PDF file with appropriate headers

### Verify Certificate (Public)

**GET** `/api/public/verify/{uuid}`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "certificate_number": "LF-2026-A1B2C3D4",
        "issued_to": "John Doe",
        "roadmap_title": "Full Stack Developer Roadmap",
        "issued_at": "2026-03-09T10:00:00Z",
        "total_topics": 20,
        "total_learning_hours": 200,
        "composite_score": 87.50,
        "sha256_hash": "a3b4c5d6...",
        "is_valid": true,
        "is_revoked": false
    }
}
```

---

## User Profile Endpoints

### Get Current User

**GET** `/user`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "username": "johndoe",
        "email": "john@example.com",
        "full_name": "John Doe",
        "profession": "Software Developer",
        "bio": "Passionate about learning",
        "profile_picture_url": "https://app.com/storage/profiles/user1.jpg",
        "created_at": "2025-01-01T00:00:00Z"
    }
}
```

### Update User Profile

**PUT** `/user`

**Request Body**:
```json
{
    "full_name": "John Updated Doe",
    "profession": "Senior Software Developer",
    "bio": "Updated bio"
}
```

**Response** (200):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "full_name": "John Updated Doe",
        "updated_at": "2025-12-11T11:00:00Z"
    },
    "message": "Profile updated successfully"
}
```

### Update Profile Picture

**POST** `/user/profile-picture`

**Request**: Multipart form data with `profile_picture` file

**Response** (200):
```json
{
    "success": true,
    "data": {
        "profile_picture_url": "https://app.com/storage/profiles/user1-new.jpg"
    },
    "message": "Profile picture updated"
}
```

---

## Search Endpoints

### Global Search (TNTSearch / Laravel Scout)

**GET** `/api/v1/search`

**Query Parameters**:
- `q` (string, required): Search query
- `type` (string): Filter — `roadmaps|topics|resources|users|journal`
- `limit` (integer): Max results (default: 20, max: 50)

**Response** (200):
```json
{
    "success": true,
    "data": {
        "roadmaps": [
            { "id": 1, "title": "Full Stack Developer Roadmap", "type": "roadmap" }
        ],
        "topics": [
            { "id": 5, "title": "JavaScript Fundamentals", "roadmap_title": "Full Stack Roadmap", "type": "topic" }
        ],
        "resources": [
            { "id": 12, "title": "JavaScript Guide", "type": "resource" }
        ],
        "users": [
            { "username": "johndoe", "full_name": "John Doe", "type": "user" }
        ]
    }
}
```

---

---

## AI Endpoints

> Rate limit: **10 requests/minute** per user. All AI calls are asynchronous (dispatched to queue); real-time progress via Pusher channel `ai.{session_id}`.

```
POST  /api/v1/ai/generate-roadmap          Generate roadmap from goal/JD/URL
POST  /api/v1/ai/generate-flashcards/{id}  Generate flashcards for a topic (topicId)
POST  /api/v1/ai/suggest-resources/{id}    AI resource suggestions for a topic
POST  /api/v1/ai/chat                       AI coach message (streaming)
GET   /api/v1/ai/schedule                  AI-generated weekly schedule
```

**POST /api/v1/ai/generate-roadmap** Request:
```json
{
    "prompt": "I want to learn machine learning to get a job at a tech startup",
    "style": "job_description",
    "weeks_available": 12,
    "hours_per_week": 10
}
```

**Response** (202 Accepted — job queued):
```json
{
    "success": true,
    "message": "Generating your roadmap… this takes 15–30 seconds.",
    "data": { "session_id": "abc123" }
}
```

---

## SRS / Flashcard Endpoints

```
GET    /api/v1/decks                        List user's flashcard decks
POST   /api/v1/decks                        Create deck
GET    /api/v1/decks/{id}                   Deck details
DELETE /api/v1/decks/{id}                   Delete deck
GET    /api/v1/decks/{id}/cards             List cards in deck
POST   /api/v1/decks/{id}/cards             Add card
PUT    /api/v1/cards/{id}                   Update card (front/back/tags)
DELETE /api/v1/cards/{id}                   Delete card
POST   /api/v1/decks/{id}/review            Submit review (rating 1–4 via SM-2)
GET    /api/v1/review/due                   All cards due today (across all decks)
GET    /api/v1/review/stats                 Retention stats, ease distribution
```

**POST /api/v1/decks/{id}/review** Request:
```json
{
    "card_id": 42,
    "rating": 3,
    "response_time_ms": 4200
}
```

**Response** (200):
```json
{
    "success": true,
    "data": {
        "new_interval_days": 6,
        "next_review_at": "2026-03-15",
        "ease_factor": 2.50
    }
}
```

---

## Gamification Endpoints

```
GET   /api/v1/xp/history                    XP transaction history (paginated)
GET   /api/v1/achievements                  All achievements with earned status
GET   /api/v1/badges                        All badges with earned status
GET   /api/v1/leaderboard?period=week       Leaderboard (week|month|all_time)
GET   /api/v1/challenges/today              Today's daily challenges
POST  /api/v1/challenges/{id}/complete      Mark challenge complete
GET   /api/v1/streak                        Current streak + freeze tokens
```

**GET /api/v1/leaderboard?period=week** Response:
```json
{
    "success": true,
    "data": {
        "period": "week",
        "my_rank": 14,
        "entries": [
            { "rank": 1, "username": "toplearner", "xp": 1450, "level": 23, "avatar": "..." }
        ]
    }
}
```

---

## Social Endpoints

```
POST   /api/v1/users/{id}/follow            Follow a user
DELETE /api/v1/users/{id}/follow            Unfollow
GET    /api/v1/feed                         Activity feed (following only)
GET    /api/v1/explore/roadmaps             Public roadmap explorer
POST   /api/v1/roadmaps/{id}/rate           Rate a public roadmap (1–5)
POST   /api/v1/roadmaps/{id}/bookmark       Toggle bookmark
GET    /api/v1/mentors                      Browse mentor directory
POST   /api/v1/mentors/{id}/request         Send mentorship request
GET    /api/v1/users/{username}/profile      Public profile
```

---

## Journal & Mood Endpoints

```
GET    /api/v1/journal                      List entries (paginated)
POST   /api/v1/journal                      Create/update today's entry
GET    /api/v1/journal/{date}               Entry for specific date (YYYY-MM-DD)
DELETE /api/v1/journal/{date}               Delete entry for date
POST   /api/v1/mood                         Log today's mood (score 1–5)
GET    /api/v1/mood/history                 Mood history (30 days)
```

**POST /api/v1/journal** Request:
```json
{
    "what_i_learned": "Learned about binary trees and traversal algorithms.",
    "challenges": "Recursion was tricky.",
    "wins": "Implemented DFS from scratch!",
    "tomorrow_goals": "Practice BFS next.",
    "mood_score": 4,
    "tags": ["algorithms", "data-structures"]
}
```

---

## Productivity Endpoints

```
POST  /api/v1/pomodoro                      Start/complete Pomodoro session
GET   /api/v1/habits                        List user habits
POST  /api/v1/habits                        Create habit
PUT   /api/v1/habits/{id}                   Update habit
DELETE /api/v1/habits/{id}                  Delete habit
POST  /api/v1/habits/{id}/log              Mark habit complete for today
GET   /api/v1/habits/today                  Today's habits with completion status
```

---

## Analytics Endpoints

```
GET   /api/v1/analytics/heatmap             52-week activity heatmap data
GET   /api/v1/analytics/velocity            Learning velocity (topics/week)
GET   /api/v1/analytics/retention           SRS retention and ease stats
GET   /api/v1/analytics/report/weekly       Weekly report card
GET   /api/v1/analytics/time-breakdown      Hours by roadmap/topic
GET   /api/v1/analytics/skill-matrix        Radar chart by skill category
```

**GET /api/v1/analytics/heatmap** Response:
```json
{
    "success": true,
    "data": {
        "start_date": "2025-03-10",
        "end_date": "2026-03-09",
        "max_count": 8,
        "days": [
            { "date": "2026-03-09", "count": 5, "minutes": 120 },
            { "date": "2026-03-08", "count": 3, "minutes": 75 }
        ]
    }
}
```

---

## Integration Endpoints

```
POST  /api/v1/integrations/github/connect   Connect GitHub account
GET   /api/v1/integrations/github/gists     List backup Gists
POST  /api/v1/integrations/github/backup    Push roadmap to GitHub Gist
POST  /api/v1/integrations/notion/import    Import pages from Notion
POST  /api/v1/integrations/calendar/sync    Sync study schedule to Google Calendar
GET   /api/v1/webhooks                      List webhooks
POST  /api/v1/webhooks                      Create webhook
PUT   /api/v1/webhooks/{id}                 Update webhook
DELETE /api/v1/webhooks/{id}               Delete webhook
```

**POST /api/v1/webhooks** Request:
```json
{
    "url": "https://my-app.com/hooks/learnforge",
    "events": ["roadmap.completed", "badge.earned", "certificate.issued"],
    "secret": "my-signing-secret"
}
```

---

## PWA & Push Endpoints

```
POST    /api/v1/push-subscriptions          Register push subscription
DELETE  /api/v1/push-subscriptions/{id}    Unregister subscription
```

---

## Admin Endpoints

> Requires `role=admin`. Only accessible from admin panel.

```
GET    /api/v1/admin/stats                  Platform metrics (users, roadmaps, active today)
GET    /api/v1/admin/users                  User list + search
PATCH  /api/v1/admin/users/{id}/suspend     Suspend user
PATCH  /api/v1/admin/users/{id}/restore     Restore suspended user
GET    /api/v1/admin/reports                Moderation queue
PATCH  /api/v1/admin/reports/{id}/resolve  Resolve report
GET    /api/v1/admin/feature-flags          Feature flag list
PATCH  /api/v1/admin/feature-flags/{key}   Toggle feature flag
```

---

## Public Endpoints

> No authentication required.

```
GET  /api/public/verify/{uuid}              Verify certificate by UUID
GET  /badge/{username}/{roadmap-slug}.svg   Progress badge SVG (for GitHub README)
GET  /u/{username}                          Public user profile page
GET  /api/public/roadmaps/{slug}            Public roadmap viewer
```

**GET /badge/{username}/{roadmap-slug}.svg** — Returns an SVG badge:
```
[LearnForge | Full Stack Dev | 73% ██████████░░░░]  (dynamic, linkable)
```

---

## Webhook Events Reference

Webhook payloads are signed with `X-LearnForge-Signature: sha256=<hmac>` using the user's webhook secret.

| Event | Trigger | Key Payload Fields |
|-------|---------|-------------------|
| `roadmap.completed` | Roadmap hits 100% | `roadmap_id`, `title`, `composite_score`, `completed_at` |
| `topic.completed` | Topic marked complete | `topic_id`, `title`, `roadmap_id`, `hours_spent` |
| `certificate.issued` | Certificate generated | `certificate_number`, `uuid`, `verification_url`, `composite_score` |
| `badge.earned` | Badge awarded to user | `badge_slug`, `badge_name`, `xp_awarded` |
| `streak.updated` | Streak incremented | `current_streak`, `longest_streak`, `date` |

---

## Rate Limiting

### Limits by Endpoint Type

| Endpoint Type | Limit | Window |
|--------------|-------|--------|
| Authenticated (general) | 100 req | 1 minute |
| Unauthenticated | 20 req | 1 minute |
| AI endpoints | 10 req | 1 minute |
| Auth (login/register) | 10 req | 10 minutes |
| Webhook delivery | 5 req | 1 minute |

### Rate Limit Headers

All responses include:
```
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1741526400
```

### Exceeded Limit Response (429)

```json
{
    "success": false,
    "message": "Too many requests. Please try again in 60 seconds.",
    "retry_after": 60
}
```

---

## Conclusion

This API documentation covers all v4.0 endpoints for the LearnForge platform. All endpoints follow RESTful conventions and return consistent JSON responses.

- Full interactive API documentation: `/api/docs` (generated by Laravel Scribe)
- For backend implementation details, refer to [`backend.md`](./backend.md)
- For frontend API consumption patterns, refer to [`frontend.md`](./frontend.md)
- For database schema, refer to [`database.md`](./database.md)

*LearnForge API v4.0 — Windows + VSCode Edition. Total cost of all infrastructure: $0.00/month.*
