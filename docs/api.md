# API Documentation
## Learning Progress Tracker - RESTful API Reference

**Version:** 1.0  
**Last Updated:** December 11, 2025  
**Framework:** Laravel 12.x  
**API Type:** RESTful API  
**Base URL:** `/api/v1` (future API version) or direct routes  
**Authentication:** Laravel Sanctum (Session-based for web)

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

---

## API Overview

### Base Information

- **Protocol**: HTTPS (enforced in production)
- **Authentication**: Session-based (CSRF token required)
- **Content-Type**: `application/json`
- **Rate Limiting**: 100 requests per minute per user
- **Pagination**: 20 items per page (default)

### HTTP Methods

- `GET`: Retrieve resources
- `POST`: Create new resources
- `PUT/PATCH`: Update existing resources
- `DELETE`: Delete resources

---

## Authentication

### CSRF Token

All POST, PUT, PATCH, DELETE requests require CSRF token:

```javascript
// Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Include in request headers
fetch('/api/roadmaps', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(data)
});
```

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

**Status Values**: `not_started`, `in_progress`, `completed`, `skipped`

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

**Template Types**: `modern`, `classic`, `minimal`

**Response** (201):
```json
{
    "success": true,
    "data": {
        "id": 1,
        "uuid": "550e8400-e29b-41d4-a716-446655440000",
        "certificate_number": "CERT-ABC1234567",
        "issued_at": "2025-12-11T10:00:00Z",
        "verification_url": "https://app.com/verify/550e8400-e29b-41d4-a716-446655440000",
        "download_url": "https://app.com/certificates/550e8400-e29b-41d4-a716-446655440000/download"
    },
    "message": "Certificate generated successfully"
}
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

**GET** `/verify/{uuid}`

**Response** (200):
```json
{
    "success": true,
    "data": {
        "certificate_number": "CERT-ABC1234567",
        "issued_to": "John Doe",
        "roadmap_title": "Full Stack Developer Roadmap",
        "issued_at": "2025-12-11T10:00:00Z",
        "total_topics": 20,
        "total_learning_hours": 200,
        "is_valid": true
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

### Global Search

**GET** `/search`

**Query Parameters**:
- `q` (string, required): Search query
- `type` (string): Filter by type (roadmaps|topics|resources)
- `limit` (integer): Max results (default: 20)

**Response** (200):
```json
{
    "success": true,
    "data": {
        "roadmaps": [
            {
                "id": 1,
                "title": "Full Stack Developer Roadmap",
                "type": "roadmap"
            }
        ],
        "topics": [
            {
                "id": 5,
                "title": "JavaScript Fundamentals",
                "roadmap_title": "Full Stack Developer Roadmap",
                "type": "topic"
            }
        ],
        "resources": [
            {
                "id": 12,
                "title": "JavaScript Guide",
                "type": "resource"
            }
        ]
    }
}
```

---

## Rate Limiting

### Headers

All responses include rate limit headers:

```
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1702291200
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

This API documentation provides comprehensive coverage of all endpoints for the Learning Progress Tracker platform. All endpoints follow RESTful conventions and return consistent JSON responses. For implementation details, refer to `backend.md` and `frontend.md`.
