# Software Requirements Specification (SRS)
## LearnForge — Masterclass Learning Progress Tracker Platform

**Version:** 4.0 (Windows + VSCode Edition)
**Document Date:** March 2026
**Project Classification:** Enterprise-Grade SaaS Web Application
**Development Environment:** Windows 10/11 + VSCode + Laragon (No Docker)
**Revision From:** v3.0 (Industry Grade Edition) — Full Windows compatibility update

---

## Table of Contents

1. [Executive Summary](#1-executive-summary)
2. [Project Overview](#2-project-overview)
3. [System Architecture](#3-system-architecture)
4. [Functional Requirements](#4-functional-requirements)
   - 4.1 User Authentication & Identity Management
   - 4.2 Roadmap Management
   - 4.3 Topic Management
   - 4.4 Resource Management
   - 4.5 Progress Tracking & Scoring
   - 4.6 Certificate Generation
   - 4.7 AI-Powered Features
   - 4.8 Spaced Repetition & Flashcard System
   - 4.9 Gamification & Achievement Engine
   - 4.10 Community & Social Features
   - 4.11 Collaboration & Team Workspaces
   - 4.12 Notification & Communication System
   - 4.13 Learning Journal & Reflection System
   - 4.14 Focus & Productivity Tools
   - 4.15 Analytics & Insights Dashboard
   - 4.16 Integrations & Webhooks
   - 4.17 Content Discovery & Marketplace
   - 4.18 Skill Assessment & Competency Matrix
   - 4.19 Admin & Moderation Panel
   - 4.20 PWA & Offline Capabilities
5. [Non-Functional Requirements](#5-non-functional-requirements)
6. [Database Schema](#6-database-schema)
7. [User Interface Design System](#7-user-interface-design-system)
8. [Technology Stack](#8-technology-stack)
   - 8.1 Frontend Technologies
   - 8.2 Backend Technologies
   - 8.3 Infrastructure
   - 8.4 Development & DevOps (Windows + VSCode)
9. [Security Requirements](#9-security-requirements)
10. [API Specification](#10-api-specification)
11. [Feature Breakdown & Prioritization](#11-feature-breakdown--prioritization)
12. [Implementation Roadmap](#12-implementation-roadmap)
13. [Third-Party Integrations](#13-third-party-integrations)
14. [Accessibility Standards](#14-accessibility-standards)
15. [Internationalization & Localization](#15-internationalization--localization)

---

## 1. Executive Summary

**LearnForge** is a next-generation, enterprise-grade Learning Progress Tracker SaaS platform engineered for the modern professional. It transforms unstructured self-directed learning into a systematic, measurable, and deeply engaging discipline — combining the precision of project management tools, the science of cognitive psychology, and the power of artificial intelligence.

Unlike existing solutions that are either too rigid (LMS platforms) or too unstructured (plain note-taking apps), LearnForge occupies a unique position: a personal learning operating system. It gives professionals full authorship over their learning journey while providing the scaffolding, accountability systems, and data-driven insights needed to sustain progress over the long term.

### Key Value Propositions

| Pillar | Description |
|--------|-------------|
| **AI-Augmented Learning** | Gemini-powered roadmap generation (free API tier), smart resource recommendations, quiz synthesis, and adaptive scheduling |
| **Cognitive Science Engine** | Built-in Spaced Repetition System (SRS) using SM-2 algorithm for maximum knowledge retention |
| **Deep Personalization** | Custom views (Kanban, Timeline, Mind Map, Calendar), themes, and adaptive learning paths |
| **Community & Social Learning** | Public profiles, roadmap explorer, peer reviews, mentorship matching, and collaborative roadmaps |
| **Professional Achievement** | Verifiable certificates with UUID-based public verification, skill matrices, LinkedIn share links, and portfolio pages |
| **Enterprise Productivity** | Team workspaces, Pomodoro timer, focus mode, habit tracking, and learning journal |
| **Universal Integration** | Native integrations with GitHub, Notion, Google Calendar, Slack, LinkedIn, and n8n (self-hosted automation) |
| **PWA & Offline-First** | Full offline capabilities, installable app, push notifications, and sync |

### Platform Positioning

LearnForge is designed to be the **Notion + Duolingo + Linear** of personal learning — combining Notion's flexible content architecture, Duolingo's behavioral science-backed engagement loops, and Linear's clean, high-performance interface into a single cohesive platform.

---

## 2. Project Overview

### 2.1 Problem Statement

Modern professionals face a compounding learning crisis:
- **Information overload**: Access to endless resources, but no structured system to organize or retain them
- **Motivation decay**: 73% of self-directed learners abandon their learning goals within 3 weeks without accountability systems
- **Progress invisibility**: No quantifiable way to measure skill acquisition over time
- **Cognitive forgetting**: Without review systems, 70% of newly learned information is lost within 24 hours (Ebbinghaus Forgetting Curve)
- **Isolation**: Self-directed learning is a lonely endeavor without community or peer accountability

### 2.2 Proposed Solution

LearnForge delivers a unified personal learning operating system with five interconnected layers:

1. **Organize**: Flexible roadmap builder with multiple views and templates
2. **Learn**: Rich resource library, block-based notes, embedded media
3. **Retain**: AI-powered flashcard and spaced repetition engine
4. **Measure**: Real-time analytics, heatmaps, and velocity tracking
5. **Achieve**: Certificate generation, skill matrices, and social proof

### 2.3 Target Audience

**Primary Users:**
- Software Engineers & Developers (upskilling, career transitions)
- Data Scientists & ML Engineers
- Product Managers & Business Analysts
- UX/UI Designers
- DevOps & Cloud Engineers

**Secondary Users:**
- Career Changers & Bootcamp Students
- University Students
- Marketing Professionals
- Finance & Operations Professionals

**Enterprise Users:**
- L&D Teams deploying structured learning programs
- Mentors & Coaches managing student cohorts
- Engineering managers tracking team skill development

### 2.4 Success Criteria

| Metric | Target |
|--------|--------|
| Roadmap creation time | < 5 minutes for basic roadmap |
| AI roadmap generation | < 30 seconds |
| Dashboard load time | < 1.5 seconds (LCP) |
| Mobile responsiveness | 100% feature parity on mobile |
| Accessibility | WCAG 2.2 Level AA compliant |
| Uptime | 99.9% (< 8.7 hours downtime/year) |
| SRS retention rate | 85%+ at 1-month interval (target) |
| Weekly active retention | 60%+ of registered users |

### 2.5 Competitive Analysis

| Feature | LearnForge | Notion | Roadmap.sh | Duolingo | Coursera |
|---------|-----------|--------|------------|----------|----------|
| Custom Roadmaps | ✅ | ✅ | ❌ | ❌ | ❌ |
| Spaced Repetition | ✅ | ❌ | ❌ | ✅ | ❌ |
| AI Generation | ✅ | ✅ | ❌ | ✅ | ❌ |
| Certificates | ✅ | ❌ | ❌ | ✅ | ✅ |
| Progress Analytics | ✅ | ❌ | ❌ | ✅ | ✅ |
| Team Collaboration | ✅ | ✅ | ❌ | ❌ | ❌ |
| Free Tier | ✅ | ✅ | ✅ | ✅ | ❌ |

---

## 3. System Architecture

### 3.1 High-Level Architecture

```
┌──────────────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                                   │
│  ┌────────────────┐  ┌────────────────┐  ┌────────────────────────┐ │
│  │  Web Browser   │  │  PWA / Mobile  │  │  Browser Extension     │ │
│  │  (Blade/Alpine)│  │  (Installable) │  │  (Quick Capture)       │ │
│  └───────┬────────┘  └───────┬────────┘  └──────────┬─────────────┘ │
└──────────┼───────────────────┼──────────────────────┼───────────────┘
           │                   │                       │
           └───────────────────┼───────────────────────┘
                               │ HTTPS / WebSockets
┌──────────────────────────────▼───────────────────────────────────────┐
│                     APPLICATION LAYER (Laravel 12.x)                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐               │
│  │  Web Routes  │  │  API Routes  │  │  Livewire /  │               │
│  │  (Blade SSR) │  │  (REST)      │  │  Broadcasting│               │
│  └──────────────┘  └──────────────┘  └──────────────┘               │
│                                                                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐               │
│  │  Controllers │  │  Services    │  │  Jobs/Queues │               │
│  └──────────────┘  └──────────────┘  └──────────────┘               │
│                                                                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐               │
│  │  AI Service  │  │  SRS Engine  │  │  Cert Engine │               │
│  │  (Gemini)    │  │  (SM-2 Algo) │  │  (PDF/Badge) │               │
│  └──────────────┘  └──────────────┘  └──────────────┘               │
└──────────────────────────────────────────────────────────────────────┘
                               │
┌──────────────────────────────▼───────────────────────────────────────┐
│                       STORAGE LAYER                                   │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐               │
│  │  MySQL 8.0+  │  │  Redis Cache │  │  S3/File     │               │
│  │  (Primary DB)│  │  + Sessions  │  │  Storage     │               │
│  └──────────────┘  └──────────────┘  └──────────────┘               │
│  ┌──────────────┐  ┌──────────────┐                                  │
│  │  Meilisearch │  │  Queue DB    │                                  │
│  │  (Full-text) │  │  (Horizon)   │                                  │
│  └──────────────┘  └──────────────┘                                  │
└──────────────────────────────────────────────────────────────────────┘
                               │
┌──────────────────────────────▼───────────────────────────────────────┐
│                    EXTERNAL SERVICES                                  │
│  Google Gemini API (free) │ Brevo SMTP (free) │ Pusher (free tier) │      │
│  GitHub API │ Google OAuth │ n8n (self-hosted) │ Slack │ Google Calendar │
└──────────────────────────────────────────────────────────────────────┘
```

### 3.2 Frontend Architecture Philosophy

**Hybrid Rendering Strategy:**
- **SSR (Server-Side Rendering)**: Blade templates for all primary page content — optimal for SEO and initial load performance
- **Islands Architecture**: Alpine.js for isolated interactive "islands" (modals, progress bars, drag-drop, charts) without hydrating the entire page
- **Progressive Enhancement**: Core functionality works without JavaScript; enhanced experience with it
- **Command Palette (Cmd+K)**: Global quick-action interface for power users

### 3.3 Key Architectural Decisions

| Decision | Choice | Rationale |
|----------|--------|-----------|
| Primary Frontend | Blade + Alpine.js | No SPA overhead, fast initial load, Laravel-native |
| Reactivity | Alpine.js v3 | 15KB vs React's 130KB, sufficient for interactivity needs |
| Real-time | **Pusher free tier** (200 connections, 200k messages/day) | Industry-standard WebSocket service; free tier fully covers development and small-scale production; Laravel Echo native support |
| Search | TNTSearch via Laravel Scout | Pure PHP full-text search driver — zero external service, completely free |
| Queue | Laravel Horizon + Redis | AI jobs, PDF generation, email digests |
| Cache | Redis | Session management, rate limiting, computed data |
| File Storage | Local Filesystem (Laravel `local` disk) | Zero cost; easily swapped to Cloudflare R2 free tier (10 GB/month) when needed |
| AI | Google Gemini 1.5 Flash API | Free tier: 15 RPM, 1 million tokens/day — sufficient for all AI features |
| **Dev Environment** | **Laragon Full + VSCode (Windows)** | All-in-one Windows PHP stack; PHP 8.3, MySQL 8, Redis, Nginx, Node.js — no Docker, no WSL, no virtual machines |

---

## 4. Functional Requirements

### 4.1 User Authentication & Identity Management

#### FR-AUTH-001: Multi-Method Registration
- Email + password registration with strong password policy
- **OAuth 2.0**: One-click sign-in with Google, GitHub, and LinkedIn
- Username must be 3–30 characters (alphanumeric, underscores, hyphens)
- Automatic username suggestion based on display name / email prefix
- Email verification required before accessing protected features
- Welcome email triggered on successful registration

#### FR-AUTH-002: Enhanced Login System
- Login via email/username and password
- OAuth login via Google, GitHub, LinkedIn
- **Two-Factor Authentication (2FA)**:
  - TOTP authenticator app (Google Authenticator, Authy, FreeOTP — all free)
  - Backup recovery codes (8 single-use codes)
  - *(SMS OTP removed — requires paid Twilio/Vonage; TOTP is more secure and free)*
- "Remember Me" with 30-day persistent session cookie
- Failed login throttling: 5 attempts → 15-minute lockout per IP + email
- Login history page showing device, location, timestamp of last 10 sessions
- Suspicious login alert email when login detected from new device/location

#### FR-AUTH-003: Password & Security Management
- Password reset via signed email link (expires in 60 minutes)
- Password change requires current password verification
- **Password strength meter** with real-time visual feedback
- Minimum requirements: 8 characters, 1 uppercase, 1 number, 1 special character
- **Active sessions management**: View and revoke specific sessions
- Account lockout notification with re-enable instructions
- **Security audit log**: View all security-related events

#### FR-AUTH-004: Rich User Profile System
- **Profile Page** with shareable public URL: `/u/{username}`
- Profile fields: full name, profession, headline, bio (500 chars), location, website, GitHub, LinkedIn, Twitter/X
- Profile picture: upload or Gravatar fallback, cropping tool
- **Cover photo / banner image** support
- **Skill tags**: up to 20 self-defined skills displayed on profile
- Privacy controls: public / private / connections-only per profile section
- Account statistics: join date, roadmaps created, topics completed, learning hours, streak record
- **Portfolio section**: Showcase completed roadmaps and certificates
- Account deletion with 30-day grace period and full data export first

#### FR-AUTH-005: User Onboarding Flow
- 5-step interactive onboarding wizard for new users:
  1. Profile setup (name, profession, avatar)
  2. Learning goal selection (career switch, upskilling, hobby, certification)
  3. Available hours per week selector
  4. First roadmap creation (manual or AI-generated)
  5. Feature tour with interactive tooltips
- Onboarding progress bar in header for first 7 days
- Skip anytime with ability to resume later from settings

---

### 4.2 Roadmap Management

#### FR-ROAD-001: Advanced Roadmap Creation
- Multi-step creation wizard with live preview
- Required: Title (max 255 chars)
- Optional: Description (rich text, up to 10,000 chars), category, tags (up to 10), difficulty, target date, cover image
- **Auto-save draft** every 30 seconds with visual indicator
- **Template library**: 50+ curated templates for common professions:
  - Software Development: Frontend, Backend, Full-Stack, Mobile, DevOps, Cloud
  - Data: Data Science, ML Engineer, Data Analyst, AI Engineer
  - Design: UX/UI, Product Design, Graphic Design
  - Business: Product Manager, Business Analyst, Marketing
  - Certifications: AWS, GCP, Azure, PMP, CISSP
- Template preview before importing
- Import roadmap from JSON export or community template

#### FR-ROAD-002: Multi-View Roadmap Interface
The roadmap can be viewed and managed in **five distinct views**:

**a) List View (default)**: Ordered topic list with status badges, progress bars, and collapsible sub-topics
**b) Kanban View**: Topics organized into columns by status (Not Started, In Progress, Completed, Skipped) with drag-and-drop between columns
**c) Timeline / Gantt View**: Visual timeline showing topics scheduled across estimated completion dates, with drag-to-reschedule
**d) Mind Map View**: Interactive radial mind map of roadmap structure using D3.js visualization, topics as nodes with prerequisite edges
**e) Calendar View**: Topics mapped onto calendar dates based on scheduled study sessions

User's preferred view persisted per-roadmap in localStorage and user settings.

#### FR-ROAD-003: Roadmap Editing & Organization
- Inline rename (click title to edit)
- Full edit modal with all creation fields
- **Drag-and-drop reordering** of topics in list view (SortableJS)
- **Bulk operations**: Select multiple topics → Bulk status change, bulk delete, bulk move
- **Sections/Phases**: Group topics into named phases (e.g., "Phase 1: Foundations", "Phase 2: Advanced")
- Phase creation, naming, reordering, and collapse/expand
- **Roadmap settings panel**: Visibility, notifications, scoring weights, time zone
- Version history: see 10 most recent significant changes with rollback

#### FR-ROAD-004: Roadmap Sharing & Discovery
- **Private by default** with toggle to public
- **Share via link**: Unique URL → read-only preview for non-logged-in users
- **Embed code**: Generate iframe embed code for personal websites/portfolios
- **Clone roadmap**: Any public roadmap can be cloned to personal workspace with attribution
- **Export formats**: JSON (re-importable), Markdown, PDF overview, CSV topics list
- Roadmap **visibility modes**: Private → Friends → Public
- **Collaborative roadmaps**: Invite specific users to co-edit (see Section 4.11)

#### FR-ROAD-005: Roadmap Templates & AI Generation
- **Community Templates**: Browse templates submitted by other users, rated and tagged
- **Template submission**: Any user can submit a completed roadmap as a community template
- **AI Roadmap Builder** (see Section 4.7): Generate full roadmap from a job description, skill goal, or URL
- Duplicate any personal roadmap

#### FR-ROAD-006: Smart Roadmap Metadata
- **Estimated completion date**: Auto-calculated from total topic hours ÷ user's available hours/week
- **Pace indicator**: "On track", "Behind pace", "Ahead of schedule" with days to completion
- **Difficulty distribution chart**: Pie chart of beginner/intermediate/advanced topic ratio
- **Category auto-suggestion**: AI suggests category based on title/description
- **Smart tags**: AI suggests relevant tags from content

---

### 4.3 Topic Management

#### FR-TOPIC-001: Rich Topic Creation
- Required: Title (max 255 chars), Estimated learning time (hours, minimum 0.5)
- Optional: Description (block-based editor — see FR-TOPIC-006), priority (P1–P4), difficulty, phase assignment, prerequisites
- **Duplicate topic** within same roadmap or across roadmaps
- **Topic templates**: User-defined topic templates (e.g., "Course template", "Book template")
- Batch-add topics: Enter multiple titles separated by line breaks → create all at once
- **Quick-add mode**: Inline topic creation without leaving the roadmap view

#### FR-TOPIC-002: Topic Status System
- **Status options**: Not Started | In Progress | Completed | On Hold | Skipped
- Status transitions tracked with timestamps in `topic_status_history` table
- Visual status indicators: colored left border, badge, progress ring
- **Completion ceremony**: Check-off animation + confetti burst + XP award on completing topic
- **In Progress indicator**: Shows active topics with pulsing animation in dashboard

#### FR-TOPIC-003: Nested Topic Architecture
- Sub-topics supported up to **3 levels deep**
- Expand/collapse sub-topic trees in list view
- Parent topic progress = aggregate of sub-topic completion percentages
- Move sub-topic to become top-level topic and vice versa
- **Prerequisites system**: 
  - Link any topic as a prerequisite of another within the same roadmap
  - Visual prerequisite graph in Mind Map view
  - Warning indicator when attempting to complete a topic before completing its prerequisites

#### FR-TOPIC-004: Topic Scheduling & Time Tracking
- **Schedule topics**: Assign study sessions to specific calendar dates
- **Estimated vs Actual Hours**: Track planned vs spent time per topic
- **Daily time log**: Log hours worked per topic with optional notes
- **Pomodoro integration** (see Section 4.14): Start Pomodoro timer directly from topic
- Time efficiency score: (Estimated Hours / Actual Hours) × 100%
- **Overdue detection**: Topics past target date flagged visually

#### FR-TOPIC-005: Topic Scoring & Assessment
- Self-assessed **quality rating** (1–5 stars) on completion
- **Confidence level slider** (1–10) for post-completion self-assessment
- **Notes on completion**: Freeform reflection field
- Topic contributes weighted points to roadmap score
- Custom weight assignment per topic (1–10× multiplier)

#### FR-TOPIC-006: Block-Based Rich Text Editor
A Notion-inspired block editor for topic descriptions and notes with support for:
- **Text blocks**: Paragraph, Heading 1/2/3, Quote, Callout (info/warning/tip)
- **List blocks**: Bullet list, Numbered list, Toggle/collapsible, Checklist
- **Code blocks**: Syntax highlighted code with language selector (100+ languages via Prism.js)
- **Media blocks**: Image upload/URL, YouTube/Vimeo embed, File attachment
- **Data blocks**: Table, Divider
- **Inline formatting**: Bold, Italic, Underline, Strikethrough, Code, Link, Highlight (8 colors)
- `/` command palette for inserting blocks
- `@` mention for linking to other topics
- Drag-and-drop block reordering
- Full keyboard shortcut support
- Markdown shortcuts (e.g., `## ` converts to heading, ` ``` ` opens code block)
- Export topic content as Markdown

---

### 4.4 Resource Management

#### FR-RES-001: Multi-Type Resource System
Resources are attached at the **topic level** and support the following types:

| Resource Type | Description | Max Size |
|--------------|-------------|----------|
| **File** | PDF, DOCX, TXT, XLSX, PPT, images | 25MB per file |
| **Link** | URL with auto-fetched title, description, favicon | — |
| **Note** | Block-based rich text note (uses FR-TOPIC-006 editor) | 50,000 chars |
| **Video** | YouTube/Vimeo embed with custom thumbnail | — |
| **Voice Note** | Browser microphone recording (WebRTC) | 10 minutes |
| **Code Snippet** | Dedicated code resource with syntax highlighting | — |
| **Flashcard Deck** | Link resource to SRS flashcard decks | — |

#### FR-RES-002: Resource Organization & Discovery
- **Tags**: Up to 15 tags per resource, auto-suggested from existing user tags
- **Favorites**: Star resources for quick access; accessible from global search
- **Resource Library view**: Dedicated page showing all resources across all roadmaps with filters
- **Filters**: By type, tag, roadmap, date added, favorite status
- **Full-text search** within resource content (notes and code snippets indexed by TNTSearch via Laravel Scout)
- **Recently accessed** section in sidebar
- **Smart collections**: Auto-grouping by tag or type

#### FR-RES-003: Advanced Resource Actions
- **Batch download**: Select multiple files → download as ZIP
- **Move resource**: Move between topics within same roadmap
- **Copy resource**: Duplicate to another topic
- **Link preview cards**: Automatic OG metadata fetching with card preview in feed
- **PDF viewer**: In-browser PDF viewer (via PDF.js) without downloading
- **File versioning**: Replace file while keeping history
- **Resource import**: Browser bookmarks import (HTML bookmark file), Pocket export, Instapaper CSV
- **Archive**: Archive resources without deleting (collapsible section)

#### FR-RES-004: Browser Extension Integration
A lightweight browser extension (Chrome/Firefox) that allows:
- **Quick-save** any URL to a specific topic's resources from any webpage
- Save highlighted text as a note resource
- Save to "Inbox" for later categorization
- **Floating widget** on saved pages showing "This resource is in your LearnForge"
- Inline annotation on web pages linked back to topic notes

---

### 4.5 Progress Tracking & Scoring

#### FR-PROG-001: Multi-Dimensional Progress Calculation
- **Completion Progress**: (Completed Topics / Total Topics) × 100
- **Weighted Progress**: Sum of (topic_weight × completion_status) / Sum of all weights × 100
- **Time Progress**: (Total Actual Hours / Total Estimated Hours) × 100
- **Quality Progress**: Average self-assessed quality ratings across completed topics
- **Composite Score** (out of 100): Weighted average of all four dimensions
- Progress recalculated in real-time on every status change (Alpine.js reactive)

#### FR-PROG-002: Learning Analytics Dashboard
A dedicated `/analytics` page with the following sections:

**Overview Cards:**
- Total roadmaps (active, completed, archived)
- Total learning hours (all-time, this week, today)
- Global completion rate
- Active learning streak (days)
- Total XP earned, current level

**Activity Heatmap:**
- GitHub-style contribution heatmap showing daily learning activity for the past 52 weeks
- Color intensity scales from 0 to 8+ hours per day
- Hover tooltip showing date and hours logged
- Filter by roadmap or show all-roadmaps aggregate

**Progress Charts (Chart.js):**
- Line chart: Progress percentage over time per roadmap (overlappable)
- Bar chart: Hours logged per day over the last 30 days
- Donut chart: Topics by status across all roadmaps
- Radar chart: Skill category coverage (from roadmap categories)
- Area chart: Cumulative learning hours over time

**Velocity Metrics:**
- Topics completed per week (rolling 4-week average)
- Average actual vs estimated hours (efficiency ratio)
- Learning pace trend: accelerating / decelerating / stable
- Projected completion date per roadmap (linear regression on current pace)

**Retention Analytics (SRS):**
- Flashcard retention rate by deck
- Cards due today vs reviewed today
- Memory strength distribution

#### FR-PROG-003: Daily & Weekly Learning Reports
- **Daily summary**: Pushed at day end (configurable time): topics worked, hours logged, XP earned, streak status
- **Weekly digest email**: Sunday summary of week's learning activity, roadmap progress, upcoming due items
- Both reports can be configured (on/off, time, email/push)

#### FR-PROG-004: Milestone & Achievement System
- **Automatic milestones**: Generated at 10%, 25%, 50%, 75%, 90%, 100% completion
- **Custom milestones**: User-created with custom label, target date, and linked topics
- Milestone celebration modal with animation on achievement
- Milestone timeline visible in roadmap sidebar
- **Streak system**:
  - Daily streak increments on any activity (topic status change, time log, SRS review)
  - Streak shield: One missed day forgiven every 7 days (à la Duolingo)
  - Streak record tracked and displayed on profile
  - Streak notifications: reminder before streak reset (via push/email)
  - "Freeze" streak using XP points for missed days

---

### 4.6 Certificate Generation

#### FR-CERT-001: Certificate Eligibility Engine
- Certificate issued when roadmap reaches **100% completion** (all non-skipped topics = Completed)
- **Partial certificate** option: Available at 75%+ with "In Progress" stamp
- Minimum time investment threshold: at least 5 actual learning hours
- Optional: minimum average quality rating (configurable, default off)
- Manual certificate trigger available for completed roadmaps

#### FR-CERT-002: Certificate Content Specification
Each certificate contains:
- User's full name, profile picture, headline
- Roadmap title, description, category
- Completion date and total duration (start to finish)
- Total topics completed and total learning hours
- Topic breakdown list with completion dates and quality ratings
- Unique alphanumeric certificate ID (format: `LF-YYYY-XXXXXXXX`)
- QR code linking to public verification page
- Issuing platform branding (LearnForge logo, tagline)
- **Issued signature**: User's custom digital signature or initials seal

#### FR-CERT-003: Certificate Design System
- **5 professional templates**: Classic, Modern, Minimalist, Dark, Neon
- Each template available in **4 color accent themes**
- Font customization: 3 curated font pairings per template
- Custom border styles (25 options)
- Custom background textures/patterns for Classic/Modern templates
- Preview in real-time before generating
- Hi-res PDF generation (A4 landscape, 300 DPI, print-ready)
- PNG export (2480×1754px) for digital sharing

#### FR-CERT-004: Certificate Distribution & Verification
- **Download**: PDF + PNG formats
- **LinkedIn Share**: Pre-filled LinkedIn share URL opening the "Add Certification" form with certificate name, issuer, and verification URL pre-populated — no API key required, works via URL parameters
- *(Note: Automated direct-post to LinkedIn Credentials requires LinkedIn Partner Program access which is paid. The URL-based share method achieves the same outcome for free.)*
- **Twitter/X Share**: Pre-filled tweet with certificate image and hashtags
- **Copy shareable link**: `/verify/{uuid}` — public, no login required
- **Verification API**: Third parties can query `GET /api/verify/{uuid}` to programmatically validate a certificate
- **SHA-256 certificate fingerprint**: Certificate data hashed and stored — allows integrity verification without any external service or cost
- *(Blockchain anchoring removed — all paid blockchain timestamping services; SHA-256 fingerprinting provides equivalent tamper-evidence for free)*
- Certificate gallery in user profile (public by default, privacy-controllable)
- **Re-generate** certificate with updated template at any time without affecting the certificate ID/UUID

---

### 4.7 AI-Powered Features

#### FR-AI-001: AI Roadmap Generator
A flagship AI feature powered by **Google Gemini 1.5 Flash API** (free tier: 15 requests/minute, 1 million tokens/day):

**Input methods:**
- **Free text goal**: "I want to become a backend engineer specializing in Node.js and microservices"
- **Job description paste**: Paste a JD → AI extracts required skills and generates learning roadmap
- **Job title + level**: Select from common roles and experience level → instant roadmap
- **URL**: Paste a job posting URL → AI fetches and processes the JD (via server-side fetch)

**AI Output:**
- Complete roadmap with title, description, category, difficulty, estimated timeline
- 10–25 structured topics with titles, descriptions, estimated hours, difficulty, and sequence
- Curated resource suggestions per topic (YouTube channels, documentation, books, courses)
- Difficulty-appropriate sub-topics for complex topics

**User controls:**
- **Regenerate** individual topics or the full roadmap
- **Adjust**: modify number of topics, total duration, detail level
- Edit and review before saving to workspace

#### FR-AI-002: AI Topic Assistant
Within the topic block editor, users can invoke AI:
- `/ai summarize` → Summarize content of attached resources
- `/ai quiz` → Generate 5 quiz questions from topic content (see FR-SRS-003)
- `/ai expand` → Elaborate on the current description
- `/ai explain` → Explain a selected text block in simpler terms
- `/ai resources` → Suggest 5 relevant learning resources for this topic
- `/ai timeline` → Estimate realistic time to learn this topic based on difficulty
- All AI completions are editable and non-destructive

#### FR-AI-003: Smart Scheduling Assistant
- Analyzes user's available weekly hours (from profile), roadmap timeline targets, and current pace
- Generates a **weekly learning schedule** showing which topics to focus on each day
- Surfaced in a "Suggested Today" widget on the dashboard
- Reschedule suggestions if user falls behind pace
- "Best time to study" recommendation based on user's historical activity patterns

#### FR-AI-004: Resource Recommendations Engine
- After completing a topic, AI suggests 3–5 next resources based on:
  - Topic content and tags
  - User's existing resources (avoid duplicates)
  - Community-rated popular resources for the same topic type
- Appears as a non-intrusive suggestion card below the completion modal
- User can add to resources with one click or dismiss

#### FR-AI-005: Learning Insights Narrator
- Weekly AI-generated paragraph summarizing the user's learning week:
  - "You've made great progress on your Docker roadmap this week, completing 3 topics. Based on your pace, you're on track to finish by March 15th. Your next focus should be 'Container Orchestration'."
- Displayed on dashboard and included in weekly email digest
- Tone: professional, motivating, factual

#### FR-AI-006: AI Chat Assistant (Learning Coach)
- Global AI chat panel (bottom-right floating button) powered by GPT-4o
- Context-aware: AI has access to user's current roadmaps, topics, and progress
- Use cases: "Explain this concept", "Create a study plan for next week", "What should I learn after completing Python Basics?", "Quiz me on React Hooks"
- Chat history persisted per session
- Ability to pin important AI responses as notes to a topic

---

### 4.8 Spaced Repetition & Flashcard System

The SRS (Spaced Repetition System) is a first-class feature implementing the **SM-2 algorithm** (the same algorithm used by Anki) for scientifically-optimized knowledge retention.

#### FR-SRS-001: Flashcard Deck Management
- Create **flashcard decks** linked to topics or standalone
- Deck types: Manual (user-created), AI-Generated (from topic content), Imported (Anki APKG format)
- Cards have: front (question), back (answer), optional image/code block on either side
- Cards support Markdown formatting and code highlighting
- Deck tags for organization and filtering
- Deck statistics: total cards, mastered, learning, due, average retention

#### FR-SRS-002: SM-2 Algorithm Implementation
- Each card has: `ease_factor`, `interval` (days), `repetitions`, `next_review_date`
- After each review, user rates difficulty: **Again (1) | Hard (2) | Good (3) | Easy (4)**
- SM-2 calculates next interval:
  - Again: reset to 1 day, ease factor −0.2
  - Hard: same interval, ease factor −0.15
  - Good: interval × ease_factor (minimum 1 day)
  - Easy: interval × ease_factor × 1.3, ease_factor +0.15
- Minimum ease factor: 1.3
- **Review session**: Cards due today served in randomized order
- **Learn new cards**: Configurable new cards per day (default 20)
- Cards stay in short-term queue if rated Again/Hard until the session ends

#### FR-SRS-003: AI Flashcard Generation
- From a topic's resources and notes, AI generates a set of flashcards automatically
- Question styles: Definition ("What is X?"), Fill-in-the-blank, Conceptual ("Why does X happen?"), Code completion
- User reviews AI-generated cards before adding to deck (bulk approve/edit)
- **Re-generate individual cards** with different difficulty or question style
- Cards tagged with source topic for traceability

#### FR-SRS-004: Review Session UI
- Dedicated `/review` page with clean, distraction-free interface
- Card flip animation (3D CSS transform)
- Progress bar showing cards remaining in session
- **Session summary** after completing all due cards: cards reviewed, average ease, retention rate
- **Keyboard support**: Spacebar to flip, 1/2/3/4 for difficulty rating
- **Mobile swipe gestures**: Swipe up for Good, swipe down for Again
- Estimated review time shown before starting session ("~8 minutes for 24 cards")
- Option to **abandon and resume** session later

#### FR-SRS-005: SRS Notifications & Scheduling
- Daily notification: "You have 34 cards due for review"
- Notification via: push notification (PWA), email (daily digest), in-app badge
- Configurable review time reminder
- **Vacation mode**: Pause SRS schedule for up to 30 days without accumulating overdue cards

---

### 4.9 Gamification & Achievement Engine

#### FR-GAME-001: XP (Experience Points) System
XP is earned through all platform activities:

| Activity | XP Earned |
|----------|-----------|
| Create a roadmap | +100 XP |
| Add a topic | +10 XP |
| Complete a topic | +50 XP |
| Complete a roadmap | +500 XP |
| Log study time (per hour) | +25 XP |
| Maintain daily streak | +15 XP/day |
| Rate a topic (quality) | +10 XP |
| Review SRS cards (per session) | +20 XP |
| Complete all cards due today | +50 XP |
| Add a resource | +5 XP |
| Add a note | +5 XP |
| Earn a badge | Varies |
| Share a roadmap publicly | +25 XP |
| Receive a clone of your roadmap | +50 XP |
| Complete 7-day streak | +200 XP |
| Complete 30-day streak | +1000 XP |

#### FR-GAME-002: Leveling System
- XP accumulates toward user levels (1–100):
  - Levels 1–10: "Apprentice" (0–5,000 XP)
  - Levels 11–25: "Learner" (5,001–20,000 XP)
  - Levels 26–50: "Scholar" (20,001–75,000 XP)
  - Levels 51–75: "Expert" (75,001–200,000 XP)
  - Levels 76–100: "Master" (200,001+ XP)
- Level badge displayed on profile and dashboard
- Level-up modal with animation + summary of XP earned this level
- Level history graph on profile

#### FR-GAME-003: Badge & Achievement System
**50+ unique badges** across categories:

**Progress Badges:**
- First Step (complete first topic)
- Trailblazer (complete first roadmap)
- Century Club (complete 100 topics)
- Marathon Runner (complete 5 roadmaps)
- Speed Learner (complete a roadmap in under 30 days)

**Streak Badges:**
- Hot Streak (7-day streak)
- On Fire (30-day streak)
- Unstoppable (100-day streak)
- Immortal (365-day streak)

**Quality Badges:**
- Perfectionist (5-star average quality on a roadmap)
- Thorough Learner (all topics rated on a roadmap)

**Social Badges:**
- Helpful (roadmap cloned 10 times)
- Influencer (roadmap cloned 100 times)
- Connected (follow 10 users)
- Mentor (help a mentee complete a roadmap)

**SRS Badges:**
- Memory Master (review 1,000 cards)
- Never Forget (maintain 90%+ retention for 30 days)

**Diversity Badges:**
- Renaissance Learner (active in 5+ different categories)
- All-Rounder (roadmaps in beginner, intermediate, and advanced)

Badge display on profile, shareable as image, viewable in dedicated `/achievements` page.

#### FR-GAME-004: Leaderboards
- **Global leaderboard**: Top 100 users by XP this week/month/all-time
- **Category leaderboard**: Top learners in each roadmap category (opt-in)
- **Friends leaderboard**: Among followed users only
- Opt-in/opt-out control per leaderboard
- Position indicator with rank change arrows
- Anonymous mode: Participate by XP without displaying username

#### FR-GAME-005: Daily Challenges
- 3 daily challenges generated each day (resets at midnight user's local time):
  - "Complete 2 topics today" → +100 XP
  - "Log at least 1 hour of study" → +75 XP
  - "Review all SRS cards due today" → +50 XP
- Challenges visible in dashboard widget
- Weekly "Epic Challenge" with larger reward (+500 XP)
- Monthly "Boss Challenge" based on roadmap completion

---

### 4.10 Community & Social Features

#### FR-SOC-001: Public User Profiles
- Public profile page at `/u/{username}` accessible without login
- Displays: avatar, cover, headline, bio, location, skills, website/social links
- **Public roadmaps** section: shows user's public roadmaps with previews
- **Certificates gallery**: All earned certificates with verification links
- **Stats bar**: Total learning hours, roadmaps completed, badges earned, current streak
- **Activity feed**: Recent public activity (roadmap completions, milestone achievements)
- Follow button (authenticated users only)

#### FR-SOC-002: Roadmap Explorer
- Public page `/explore` for discovering public roadmaps:
  - **Featured**: Curated staff picks
  - **Trending**: Most cloned/viewed this week
  - **New**: Recently published
  - **By Category**: Browse by profession/skill area
  - **Search**: Full-text search across all public roadmaps
- Roadmap cards show: title, author, category, difficulty, topics count, clone count, average rating
- **Rating system**: 1–5 star rating on public roadmaps
- **Save**: Bookmark public roadmaps to personal list without cloning

#### FR-SOC-003: Social Interactions
- **Follow/Following**: Follow other learners, see their public activity in feed
- **Activity Feed**: Chronological feed on dashboard showing followed users' achievements, roadmap completions, new public roadmaps
- **Comments** on public roadmaps: threaded comments with upvote/downvote, reply, report
- **Reactions** on public roadmaps: Like, Insightful, Well-Structured
- **Share**: Share any public roadmap to Twitter/X, LinkedIn, or copy URL

#### FR-SOC-004: Mentorship System
- **Mentor/Mentee matching**: Users can declare themselves a mentor in specific categories
- Mentors set a brief description, available hours/week, and areas of expertise
- Mentees can browse mentor directory and send mentorship requests
- Mentorship relationship: Mentor can **comment on specific topics** in mentee's roadmap
- Mentor can suggest additional topics, resources, and adjustments
- **Mentorship sessions**: Schedule a session (links to Calendly or direct URL)
- Mentorship feed: Mentor sees activity updates from all mentees
- Maximum 5 active mentees per mentor (soft limit, configurable)
- Rating system: Mentee can rate mentor after mentorship period

#### FR-SOC-005: Learning Groups
- Users can create **public or private learning groups**
- Group has: name, description, category, cover image, privacy setting
- Group feed: member activity updates, shared roadmaps, announcements
- **Group roadmaps**: Admins can pin roadmaps as recommended for the group
- Group challenges: Admins set a shared challenge (e.g., "Everyone complete Python Basics this month")
- Members: join, leave, invite others
- Admin tools: remove members, pin posts, manage roadmaps
- Maximum 500 members per group (hard limit for performance)

---

### 4.11 Collaboration & Team Workspaces

#### FR-COLLAB-001: Personal vs. Team Workspace
- All existing features operate in the **Personal workspace** (default)
- **Team workspace**: Created by a team owner (e.g., engineering manager, L&D lead)
- Team workspace has its own namespace, members, and roadmaps

#### FR-COLLAB-002: Collaborative Roadmap Editing
- **Shared roadmaps**: Roadmap owner can invite collaborators with one of three roles:
  - **Viewer**: Read-only access
  - **Commenter**: Can add comments and suggestions but not edit
  - **Editor**: Full edit access (create/edit/delete topics, resources, notes)
- Real-time presence: See avatar icons of currently active collaborators
- Real-time updates: Changes by one editor reflected immediately for all (via Laravel Broadcasting + **Pusher** (free tier: 200 connections, 200k messages/day))
- **Conflict resolution**: Last-write-wins for simple fields; inline diff for block editor conflicts
- Collaborator activity log within the roadmap

#### FR-COLLAB-003: Team Roadmap Assignment
- Team admin can **assign a roadmap to team members**
- Each member gets their own progress tracking copy
- Team admin sees aggregate progress dashboard: all members × roadmap
- **Completion deadline setting**: Admin sets a target date; members see countdown
- **Team leaderboard**: Members ranked by progress within the team roadmap

#### FR-COLLAB-004: Inline Review & Feedback
- Mentors and collaborators can **comment on specific topics** in a roadmap
- Comments appear in a collapsible sidebar panel when viewing the roadmap
- Comments can be: suggestions, questions, approvals, corrections
- Comment threads with @mentions
- Comment resolution: "Mark as resolved" to archive thread
- Comment notifications: in-app + email

---

### 4.12 Notification & Communication System

#### FR-NOTIF-001: Notification Center
- Dedicated `/notifications` page with all notifications, paginated
- **Notification bell icon** in header with unread count badge
- Notification types:
  - Achievement earned (badge, level-up, streak)
  - Daily challenge reminder
  - Weekly digest available
  - SRS review due
  - Collaborator made changes
  - New follower
  - Comment on your roadmap
  - Mentee completed a topic
  - Team roadmap update
  - Certificate generated
  - Roadmap cloned by another user
- Mark all as read, delete individual notifications
- Real-time push delivery via Laravel Echo + **Pusher** (free tier)

#### FR-NOTIF-002: Multi-Channel Notifications
- **In-app**: Dropdown + `/notifications` page
- **Email**: Transactional emails via **Brevo (formerly Sendinblue) free SMTP** (300 emails/day free) + weekly digest; fallback to **Gmail SMTP** in development
- **Push notifications**: PWA push API (requires user opt-in)
- **Per-notification type control**: Each type can be independently toggled per channel in Settings → Notifications
- **Quiet hours**: Set a time window (e.g., 10 PM – 8 AM) where all notifications are suppressed

#### FR-NOTIF-003: Email Digest
- **Weekly Progress Report** (sent Sunday 9AM user timezone):
  - Learning week in review: hours, topics, roadmaps progressed
  - Streak status
  - Top 3 upcoming topics for next week (AI-suggested)
  - Your badges/achievements this week
  - Community activity from followed users
- **Monthly Achievement Summary**: Sent on 1st of each month

---

### 4.13 Learning Journal & Reflection System

#### FR-JOURNAL-001: Daily Journal
- Dedicated `/journal` section with a per-day journal entry
- Entries created using the block-based editor (FR-TOPIC-006)
- **Daily reflection prompts** (optional, toggleable):
  - "What did you learn today?"
  - "What was challenging?"
  - "What will you focus on tomorrow?"
- Journal entries tagged with active roadmaps
- Private by default (no sharing option)
- Calendar-based navigation for past entries
- **Word count tracker** with personal milestone (500, 1000, 5000, 10000 total words)
- Journal XP rewards: +10 XP per day with a journal entry

#### FR-JOURNAL-002: Topic Reflections
- On completing a topic, optional reflection panel appears:
  - What was the most important thing you learned?
  - What would you do differently?
  - What questions do you still have?
- Reflections stored per topic, visible in topic detail view
- Reflections can be used to generate flashcards (AI feature)

#### FR-JOURNAL-003: Mood Tracker
- Daily emotional check-in (1–5 scale with emoji icons: 😫 😔 😐 😊 🤩)
- Optional 1-sentence context note
- Mood data displayed as a line chart in analytics
- Correlation analysis: "You tend to complete more topics on days you rate your mood 4+" (AI insight)

---

### 4.14 Focus & Productivity Tools

#### FR-FOCUS-001: Pomodoro Timer
- Built-in Pomodoro timer accessible from any topic:
  - **Work session**: 25 minutes (customizable 15–90 min)
  - **Short break**: 5 minutes (customizable)
  - **Long break**: 15 minutes after 4 cycles (customizable)
- Session linked to current topic → time automatically logged on session completion
- Visual circular countdown timer with audio notification (optional)
- Session history: view all Pomodoro sessions with timestamps and linked topics
- **Focus Mode** activated automatically during Pomodoro (see FR-FOCUS-002)
- Keyboard shortcut to start/pause: `Ctrl/Cmd + P`

#### FR-FOCUS-002: Focus Mode
- Activated via button in header or automatically with Pomodoro
- **Full-screen, distraction-free view** showing only:
  - Current topic title and description
  - Timer (Pomodoro or elapsed time)
  - Quick access to topic resources
  - Minimal notes area
- Hides: navigation, sidebar, notifications, footer
- Background music player (integrated): Lo-fi / Nature sounds / White noise (user-selectable)
- Exit via Escape key or dedicated exit button
- Time in Focus Mode tracked as study time

#### FR-FOCUS-003: Daily Study Planner
- Widget on dashboard: "Today's Plan"
- Shows AI-suggested or manually scheduled topics for today
- Drag topics into today's plan from any roadmap
- Mark topics as "done for today" without fully completing them
- Estimated time for today's plan shown
- Quick-launch Focus Mode for any item in today's plan

#### FR-FOCUS-004: Habit Tracker
- Users define **learning habits** (e.g., "Read documentation for 30 min", "Do 1 Pomodoro session")
- Habits have: name, target frequency (daily/weekdays/weekly), icon, color
- Habit check-in: mark habit complete for the day
- **Habit streak**: Separate streak per habit
- Habit history: 90-day calendar heatmap per habit
- XP rewards for consistent habit completion
- Integration with daily journal: habit completions shown in journal entry for that day

---

### 4.15 Analytics & Insights Dashboard

#### FR-ANALYTICS-001: Personal Analytics Hub
Full dedicated `/analytics` section (in addition to dashboard widgets):

**Learning Velocity Panel:**
- Average topics completed per day / week / month
- Topics per hour efficiency
- Best performing days of the week
- Study time distribution: morning / afternoon / evening / night

**Roadmap Analytics:**
- Individual roadmap: detailed progress timeline, time per topic, quality distribution
- Cross-roadmap: compare progress curves side by side
- Estimated completion dates with confidence intervals

**Knowledge Retention (SRS) Panel:**
- Cards by retention strength: New / Young / Mature / Suspended
- Daily retention rate trend
- Estimated memory stability per topic
- Heatmap of review activity

**Category Analysis:**
- Radar/spider chart of coverage across categories
- Time invested by category (pie chart)
- Roadmaps per category

#### FR-ANALYTICS-002: Personalized Weekly Report Card
- Auto-generated every Monday morning
- Visible at `/analytics/weekly`
- Includes: Grade (A–F), hours studied, topics completed, streak status, XP earned, SRS performance
- "Areas of strength" and "Focus areas for next week"
- Motivational AI-generated message
- Downloadable as PDF

#### FR-ANALYTICS-003: Exportable Analytics Data
- Export full analytics data as CSV
- Date range selector (custom range, presets: last 7/30/90/365 days)
- Data includes: daily activity log, topic completion log, SRS review log, mood entries
- GDPR-compliant "Download My Data" full account export (JSON zip)

---

### 4.16 Integrations & Webhooks

#### FR-INT-001: GitHub Integration
- Connect GitHub account via OAuth
- **Activity sync**: GitHub commits optionally counted as learning activity (configurable)
- **Repository linking**: Link a GitHub repo as a resource to a topic
- Auto-detect programming languages in linked repos and suggest related roadmaps

#### FR-INT-002: Google Calendar Integration
- OAuth connect to Google Calendar
- **Two-way sync**: Scheduled study sessions appear as Google Calendar events
- Create study sessions from Google Calendar → auto-linked to topic
- Roadmap target dates sync as calendar reminders
- Free/busy time considered by AI scheduling assistant

#### FR-INT-003: Notion Integration
- **Import from Notion**: Import Notion database pages as roadmap topics
- **Export to Notion**: Push completed roadmap as a Notion database
- Authentication via Notion OAuth

#### FR-INT-004: Slack Integration
- Connect workspace via Slack OAuth
- Daily study summary posted to a configured Slack channel
- `/learnforge` Slack command: "Show my progress today"
- Completion milestone notifications posted to Slack channel

#### FR-INT-005: LinkedIn Integration
- OAuth for profile display and profile picture import
- Certificate LinkedIn share via pre-filled URL (free, no API key required)
- "Add to LinkedIn Profile" button on every certificate page

#### FR-INT-006: n8n Windows Automation Integration
- **n8n** is a free, open-source workflow automation tool installable on Windows via npm — no Docker required
- Install with a single command: `npm install -g n8n` then run `n8n start` in any terminal
- Access the n8n UI at `http://localhost:5678` from your browser
- LearnForge exposes outbound webhooks (see FR-INT-007) that n8n receives as triggers
- n8n connects to 400+ apps including Slack, Gmail, Google Sheets, Notion, Discord, Telegram
- Documentation page in LearnForge explains how to set up n8n with LearnForge webhooks
- *(Zapier removed — requires paid plan for multi-step zaps and most app connections)*

#### FR-INT-007: Webhooks
- Users and teams can configure outbound webhooks for any event
- Webhook events: `roadmap.completed`, `topic.completed`, `certificate.issued`, `badge.earned`, `review.completed`
- Payload: JSON with event metadata
- Delivery with HMAC-SHA256 signature header for verification
- Webhook delivery log with retry on failure (3 retries, exponential backoff)
- Webhook testing from settings panel

---

### 4.17 Content Discovery & Marketplace

#### FR-DISC-001: Roadmap Marketplace
- Community-submitted roadmap templates browsable at `/marketplace`
- **Curated collections**: Staff-picked roadmap sets (e.g., "Frontend Developer in 6 months", "Data Science starter pack")
- **Trending roadmaps**: Most cloned, most bookmarked, highest rated this month
- Full-text search + filter by: category, difficulty, topics count, estimated hours, rating
- Roadmap detail page: full topic preview, author info, rating + reviews, clone count

#### FR-DISC-002: Resource Recommendations Feed
- "Discover" tab on dashboard: AI-curated external resources (articles, videos, courses) matching active roadmap topics
- Sources: curated public APIs (Dev.to, YouTube Data API, freeCodeCamp, GitHub Topics)
- User feedback: "Useful" / "Not relevant" to improve recommendations
- **Weekly picks**: 5 hand-curated resources per category

#### FR-DISC-003: Roadmap Review System
- Users can rate (1–5 stars) and write a review (100–500 chars) on any public roadmap they've cloned
- Reviews shown on roadmap marketplace page
- Helpful votes on reviews
- Author can respond to reviews
- Report system for inappropriate reviews

---

### 4.18 Skill Assessment & Competency Matrix

#### FR-SKILL-001: Skill Tags & Self-Assessment
- Users define up to **50 skill tags** on their profile (e.g., "Python", "React", "Product Strategy")
- For each skill: self-assessed proficiency level: Beginner (1) | Developing (2) | Proficient (3) | Advanced (4) | Expert (5)
- Skill linked to active roadmaps and completed topics (auto-populated from roadmap categories)
- Skill proficiency can be manually updated or auto-incremented when relevant roadmaps are completed

#### FR-SKILL-002: Skill Matrix Visualization
- Interactive radar chart on profile and analytics page showing top skills vs. proficiency
- **Gap analysis**: Compare skill matrix against a target role's required skills
- Target roles pre-defined: choose from 30+ common tech/business roles
- Highlighted gap areas become suggested roadmaps
- Exportable as skill matrix PNG for CV/resume

#### FR-SKILL-003: Competency Progression
- Each skill has a **progression history**: "Python: Beginner (Jan 2025) → Proficient (Sep 2025)"
- Timeline view of skill progression across all skills
- Shareable skill progression page on public profile (opt-in)

---

### 4.19 Admin & Moderation Panel

#### FR-ADMIN-001: Admin Dashboard
- Accessible at `/admin` (role-gated: role = `admin`)
- **Platform metrics**: Total users, DAU, WAU, MAU; total roadmaps, topics, certificates; SRS activity
- Real-time graphs: new signups, active sessions, API request volume

#### FR-ADMIN-002: User Management
- Browse all users with search and filter
- View user profile, roadmaps, activity log, subscription status
- Actions: suspend, unsuspend, force password reset, manually verify email, impersonate (sudo mode)
- Bulk actions on filtered user sets

#### FR-ADMIN-003: Content Moderation
- Reported content queue (roadmaps, comments, reviews)
- Moderator review interface: view reported content with reporter's reason
- Actions: approve (dismiss report), remove content, warn user, suspend user
- Moderation log with timestamps and moderator attribution

#### FR-ADMIN-004: Template & Marketplace Management
- Review and approve community template submissions
- Feature/unfeature templates
- Manage marketplace collections and curated picks
- View template performance: clones, ratings, reports

#### FR-ADMIN-005: System Configuration
- Feature flag management (enable/disable features without deployment)
- Email template management
- Platform announcement banner (shown to all users)
- Maintenance mode toggle with custom message

---

### 4.20 PWA & Offline Capabilities

#### FR-PWA-001: Progressive Web App (PWA)
- Service Worker registered on first load
- **Installable**: "Add to Home Screen" prompt on mobile and desktop
- App manifest with icons, theme color, splash screen
- Standalone display mode (no browser chrome when installed)
- Fast launch from home screen (< 1 second from cold start via cache)

#### FR-PWA-002: Offline Mode
- **Offline-accessible pages**:
  - Dashboard (cached data from last sync)
  - All roadmaps + topics list views
  - Topic detail views (with cached resources)
  - Journal entries (create new while offline)
  - SRS review (cached cards due today)
- Offline indicator banner when connection is lost
- **Background sync**: Changes made offline queued locally (IndexedDB) and synced when connection restored
- Conflict resolution: server version wins by default; user prompted for manual merge if divergent

#### FR-PWA-003: Push Notifications
- Web push notifications (via Vapid keys + Service Worker)
- User must explicitly grant permission (browser native prompt triggered by in-app CTA)
- Notification types configurable (same as FR-NOTIF-002)
- Notification click opens the relevant page in the app

---

### 4.21 Real-Time Notification Engine (Pusher)

#### FR-RT-001: Pusher Integration Architecture
LearnForge uses **Pusher Channels** (free tier) as the WebSocket backbone for all real-time features.

**Channel Types:**
- **Private channels** (`private-user.{id}`): Per-user notifications, personal activity updates
- **Presence channels** (`presence-roadmap.{id}`): Show who is currently viewing/editing a roadmap
- **Public channels** (`public-explore`): Live roadmap clone/bookmark counters on explore page

**Events broadcasted in real-time:**
| Event Name | Channel | Trigger |
|-----------|---------|---------|
| `notification.new` | `private-user.{id}` | Any new notification |
| `topic.status_changed` | `private-user.{id}` | Topic status update by collaborator |
| `roadmap.progress_updated` | `private-user.{id}` | Progress % changed |
| `comment.created` | `private-user.{id}` | New comment on your roadmap |
| `badge.earned` | `private-user.{id}` | Achievement unlocked |
| `streak.at_risk` | `private-user.{id}` | Streak about to break (< 2 hours left in day) |
| `srs.due_reminder` | `private-user.{id}` | Cards due for review today |
| `collaborator.joined` | `presence-roadmap.{id}` | Collaborator opens the roadmap |
| `collaborator.left` | `presence-roadmap.{id}` | Collaborator closes the roadmap |
| `collaborator.cursor` | `presence-roadmap.{id}` | Real-time cursor position |
| `roadmap.cloned` | `public-explore` | Live clone counter update |

#### FR-RT-002: Real-Time Notification Bell
- Notification bell icon in header updates count **instantly** via Pusher without page refresh
- New notification slides into the dropdown in real time
- **Unread badge**: animates (pulse ring) when a new notification arrives
- Notification mark-as-read updates immediately for all open tabs
- **Multi-tab synchronization**: Uses `BroadcastChannel` browser API so all open tabs receive the same notification state

#### FR-RT-003: Live Collaboration Presence
- When multiple users view the same shared roadmap, their **avatar stack** appears in the roadmap header
- Presence channel shows: avatar, name, "last seen field" (which topic they're viewing)
- Typing indicator on shared block editor when a collaborator is editing a topic description
- Real-time topic status changes propagate to all viewers instantly
- **Cursor tracking**: In collaborative editing mode, see other editors' cursor positions (colored named cursors)

#### FR-RT-004: Real-Time Dashboard Updates
- Dashboard stat cards (total hours, XP, streak) update in real-time without page refresh
- Progress bars on roadmap cards animate to new values when a topic is marked complete from any device
- Activity feed on dashboard receives new items pushed in real-time
- **Live XP counter**: XP total in header animates upward when XP is earned

---

### 4.22 Advanced Block Editor Features

#### FR-EDITOR-001: Extended Block Types
Beyond the base block types in FR-TOPIC-006, the block editor additionally supports:

**Scientific & Technical Blocks:**
- **Math block** (KaTeX): Render LaTeX math equations — inline `$E=mc^2$` and block `$$\int_0^\infty$$` — powered by **KaTeX.js** (free, MIT license, renders locally with no API)
- **Mermaid diagram block**: Render flowcharts, sequence diagrams, ER diagrams, Gantt charts, mind maps directly in notes — powered by **Mermaid.js** (free, MIT license)
  ```
  Example: flowchart LR
    A[Start] --> B{Decision}
    B -->|Yes| C[Done]
    B -->|No| A
  ```
- **Excalidraw whiteboard block**: Embedded interactive canvas for freehand diagrams, sketches, architecture drawings — powered by **Excalidraw** (free, MIT license, iframe embed)

**Content Enrichment Blocks:**
- **Callout block** with 6 types: Info (ℹ️), Warning (⚠️), Danger (🚨), Tip (💡), Success (✅), Quote (💬) — each with distinct color and icon
- **Equation block** (KaTeX): Multi-line math with numbered equation labels
- **Details/Summary block**: Collapsible spoiler block ("Click to reveal answer")
- **Tabbed content block**: Multiple tab panels within a single block
- **Columns block**: 2 or 3-column layout for side-by-side content

**Reference Blocks:**
- **Footnote**: Inline footnote markers that expand on hover
- **Definition term**: Highlight a term → auto-add to topic's glossary
- **Cross-reference**: Link to another topic, resource, or journal entry with rich preview card on hover

#### FR-EDITOR-002: Editor Quality-of-Life Features
- **Undo/Redo**: Full 50-step history stack (`Ctrl/Cmd+Z` / `Ctrl/Cmd+Shift+Z`)
- **Auto Table of Contents**: Heading blocks (H1/H2/H3) automatically generate a floating TOC sidebar panel in read mode
- **Reading time estimator**: Word count + estimated read time shown in editor status bar ("~4 min read · 820 words")
- **Word count + character count**: Live in editor status bar
- **Focus mode in editor**: Dim all blocks except the one being edited (TypeFocus behavior)
- **Block commenting**: Right-click any block → add a margin comment (like Google Docs)
- **Block duplication**: `Ctrl/Cmd+D` duplicates the selected block below
- **Multi-block selection**: Hold `Shift` + click to select multiple blocks → group actions (delete, move, wrap in callout)
- **Paste intelligence**: Pasting a URL auto-creates a link resource card; pasting code auto-detects language and creates a code block; pasting markdown auto-converts to blocks
- **Image paste**: Paste from clipboard directly into an image block (uploads automatically)

---

### 4.23 SEO, Discoverability & Social Sharing

#### FR-SEO-001: Technical SEO
- **Semantic HTML structure**: Correct heading hierarchy, `<article>`, `<section>`, `<nav>`, `<main>` on all pages
- **Sitemap generation**: Auto-generated `sitemap.xml` including all public roadmaps, user profiles, and static pages — generated via **spatie/laravel-sitemap** (free package), updated nightly via scheduler
- **robots.txt**: Properly configured to allow search engine crawling of public pages, block private pages
- **Canonical URLs**: `<link rel="canonical">` on all pages to prevent duplicate content
- **Structured Data (JSON-LD)**: Schema.org markup injected on:
  - Public roadmap pages → `Course` schema
  - Certificate verification pages → `EducationalOccupationalCredential` schema
  - User profile pages → `Person` schema
  - Blog/changelog pages → `Article` schema
- **Meta tags**: Fully customized title, description, keywords for every page type
- **Hreflang**: Language-alternates when multi-language support is active

#### FR-SEO-002: Open Graph & Social Share Images
- All public pages (roadmaps, profiles, certificates) have full Open Graph meta tags:
  - `og:title`, `og:description`, `og:image`, `og:url`, `og:type`, `og:site_name`
  - Twitter Card meta: `twitter:card`, `twitter:image`, `twitter:title`
- **Dynamic OG image generation**: Server-side generated preview images using **Blade + headless Chromium (Browsershot by Spatie — free)** or a simple **PHP/GD-based canvas renderer** (zero dependency fallback):
  - Roadmap OG image: Title, category, progress%, topic count, author name on branded template
  - Certificate OG image: Certificate design thumbnail with user name and roadmap title
  - Profile OG image: Avatar, name, stats, top skills

#### FR-SEO-003: RSS Feeds
- `/feed/roadmaps.xml`: Public Atom/RSS feed of newly published community roadmaps
- `/feed/users/{username}.xml`: RSS feed of a specific user's public roadmap activity
- Proper `<link rel="alternate">` headers on feed-applicable pages
- Generated via **spatie/laravel-feed** (free package)

#### FR-SEO-004: Shareable Progress Cards (Social Proof)
- **Progress card generator**: Users can generate a shareable image card showing:
  - Current roadmap and progress percentage
  - Learning streak count
  - Total topics completed
  - Platform branding and user avatar
- Generated server-side using PHP/GD library (free, built into PHP) — no canvas API or external service
- Cards available as PNG download and direct share URL
- Share to: Twitter/X, LinkedIn, WhatsApp, copy link
- Accessible from roadmap detail page → "Share Progress" button

---

### 4.24 Import, Export & Data Portability

#### FR-EXPORT-001: Roadmap Export Formats
From any roadmap, users can export to:
- **JSON**: Complete roadmap data including all topics, resources, and metadata — re-importable back into LearnForge
- **Markdown**: Full roadmap as structured Markdown file — compatible with Obsidian, Notion import, GitHub README
- **CSV**: Topics list with columns (title, status, estimated hours, actual hours, quality rating, completed date) — for Excel/Google Sheets analysis
- **PDF Overview**: Formatted roadmap summary with all topics and progress stats — generated via **barryvdh/laravel-dompdf** (free)
- **iCal (.ics)**: Export all scheduled study sessions as a calendar file — importable into Google Calendar, Outlook, Apple Calendar — generated via **spatie/laravel-ical-component** (free)
- **Anki (.apkg)**: Export all flashcard decks for a roadmap as an Anki-compatible deck file — free Anki format, generated from cards table

#### FR-EXPORT-002: Full Account Export (GDPR)
- "Download My Data" at `/settings/export`
- Generates a ZIP containing:
  - `profile.json` — all profile data
  - `roadmaps/` — one JSON file per roadmap with full topic/resource tree
  - `flashcards/` — all decks and cards as JSON + Anki .apkg
  - `journal/` — all journal entries as Markdown files
  - `certificates/` — all certificate PDFs
  - `activity_log.csv` — full activity history
  - `analytics.csv` — all time logs and progress data
- ZIP generated as a background queue job; user emailed a download link (expires 7 days)

#### FR-IMPORT-001: Roadmap Import Formats
- **LearnForge JSON**: Re-import any exported roadmap JSON — fully reconstructs roadmap, topics, and resources
- **CSV bulk topics**: Upload a CSV with columns (title, estimated_hours, difficulty, phase) → bulk-create topics into an existing or new roadmap
- **Markdown**: Import a structured Markdown file (headings as topics, bullet points as sub-topics) — parsed server-side
- **Trello Board JSON**: Import a Trello board export — Trello lists → phases, Trello cards → topics
- **GitHub Gist**: Import a roadmap from a GitHub Gist URL — paste URL → fetched and parsed server-side
- **Anki .apkg**: Import Anki deck file → creates flashcard deck linked to a topic

#### FR-IMPORT-002: Resource Import Tools
- **Browser Bookmarks HTML**: Import browser bookmarks file (Chrome/Firefox HTML export) → each bookmark becomes a Link resource, organized by bookmark folder
- **Pocket Export CSV**: Import saved article list from Pocket
- **GitHub Stars**: Connect GitHub → import starred repositories as link resources
- **YouTube Playlist**: Paste a YouTube playlist URL → each video imported as a Video resource with thumbnail, duration, and auto-title

---

### 4.25 Keyboard Power User System

#### FR-KB-001: Global Command Palette (Cmd/Ctrl+K)
Full-featured command palette with:

**Navigation commands:**
- "Go to Dashboard", "Go to Analytics", "Go to Review Session", "Go to Journal", "Open Explore"
- "Go to [roadmap name]" — fuzzy-searches roadmap titles
- "Go to [topic name]" — searches across all topics
- "Recent pages" — last 10 visited pages

**Action commands:**
- "New Roadmap", "New Topic in [current roadmap]", "New Journal Entry", "Start Pomodoro", "Start Review Session"
- "Toggle Dark Mode", "Toggle Focus Mode"
- "Search Resources", "Search All"

**AI commands:**
- "Generate Roadmap with AI"
- "Generate Flashcards for [current topic]"
- "Ask AI Coach"

**Keyboard palette features:**
- Instant fuzzy search with result ranking
- Category grouping with icons
- Keyboard-only navigation (arrows + Enter)
- Recent commands history
- Implemented with Alpine.js (no external library needed)

#### FR-KB-002: Page-Level Keyboard Shortcuts
| Shortcut | Action |
|----------|--------|
| `?` | Show keyboard shortcuts overlay |
| `Cmd/Ctrl + K` | Open command palette |
| `Cmd/Ctrl + /` | Focus search bar |
| `n` | New item (context-sensitive: new roadmap on dashboard, new topic on roadmap page) |
| `e` | Edit current item |
| `g d` | Go to Dashboard |
| `g e` | Go to Explore |
| `g r` | Go to Review session |
| `g j` | Go to Journal |
| `g a` | Go to Analytics |
| `Escape` | Close modal / exit focus mode |
| `Ctrl/Cmd + Enter` | Save/submit current form |
| `j / k` | Navigate up/down through topic list |
| `Space` | Toggle topic completion when focused |
| `Cmd/Ctrl + D` | Duplicate selected topic |
| `p` | Start Pomodoro for current topic |
| `t` | Log time on current topic |

All shortcuts documented in a `/shortcuts` page and the `?` overlay. Alpine.js `keydown` listeners handle all bindings.

---

### 4.26 Advanced Search & Filtering

#### FR-SEARCH-001: Global Unified Search
- **Command palette search** (`Cmd+K`) for navigation and actions
- **Dedicated search page** (`/search`) for deep content search
- TNTSearch powered full-text search across:
  - Roadmap titles and descriptions
  - Topic titles, descriptions, and block editor content
  - Resource titles, note content, link descriptions
  - Journal entries
  - Community public roadmaps and profiles
- **Search result snippets**: Highlighted matching text excerpt shown per result (TNTSearch snippet support)
- **Result grouping**: Results categorized by type (Roadmaps, Topics, Resources, Journal, Community)
- **Fuzzy matching**: Tolerates typos (e.g., "javscript" finds "javascript")
- **Recent searches**: Last 10 queries saved in localStorage, shown before typing
- **Search analytics**: Top search queries visible in admin panel for content gap identification

#### FR-SEARCH-002: Advanced Filters & Sorting
On roadmap list, topic list, and explore pages:

**Roadmap filters:**
- Status: All / Active / Completed / Archived / Draft
- Category: Multi-select dropdown
- Difficulty: Beginner / Intermediate / Advanced
- Progress range: 0–25% / 25–50% / 50–75% / 75–100% / Completed
- Date range: Created after / Created before
- Has certificate: Yes / No
- Is public: Yes / No

**Topic filters:**
- Status: Multi-select (Not Started / In Progress / Completed / On Hold / Skipped)
- Priority: P1–P4
- Difficulty level
- Phase membership
- Has resources: Yes / No
- Overdue: Yes
- Date range

**Sorting options (per list):**
- Default order (manual drag-drop order)
- Alphabetical (A–Z, Z–A)
- Progress (highest/lowest first)
- Recently updated
- Date created
- Estimated hours
- Priority

**Saved filters:**
- Users can save a filter configuration as a named saved view
- Saved views appear in sidebar for quick access
- Up to 10 saved views per roadmap

---

### 4.27 Roadmap Health & Intelligence

#### FR-HEALTH-001: Roadmap Health Score
Every roadmap automatically computes a **Health Score** (0–100) displayed as a color-coded indicator (🟢 80–100, 🟡 50–79, 🔴 0–49):

Health score factors:
| Factor | Weight | Good Signal |
|--------|--------|------------|
| Has a description | 5 pts | Description > 50 chars |
| Topics have descriptions | 10 pts | > 60% topics have descriptions |
| Resources attached | 15 pts | Average ≥ 2 resources per topic |
| Estimated hours set | 10 pts | All topics have estimated hours |
| Time logs present | 15 pts | Time logged on ≥ 50% of topics |
| Regular activity | 20 pts | Activity within last 14 days |
| On pace | 15 pts | Not behind target date by > 30% |
| Quality ratings | 10 pts | Quality rated on ≥ 50% completed topics |

- Health score shown on roadmap cards and detail page
- Health panel with improvement suggestions: "Add descriptions to 4 more topics to improve your score"
- Health history graph showing improvement over time

#### FR-HEALTH-002: Pace Intelligence
- **Pace indicator widget**: Shown on every roadmap with a target date
  - "✅ On track — estimated completion Mar 28 (3 days ahead)"
  - "⚠️ Behind pace — at current speed, finish by Apr 14 (16 days late)"
  - "🚀 Ahead of pace — finish by Feb 28 (18 days early)"
- **Velocity graph**: Rolling 7-day average of topics completed per day
- **Burn-down chart**: Topics remaining over time vs ideal burn-down line
- **Completion prediction**: Linear regression on last 30 days activity → estimated date with 80% confidence interval shown as a range

#### FR-HEALTH-003: Smart Warnings & Nudges
Non-intrusive inline warning cards on roadmap detail page:
- "⚠️ 3 topics are overdue based on your schedule"
- "💡 You haven't logged time in 5 days — your streak is safe but progress is slowing"
- "🔗 Topic 'Docker Networking' requires completing 'Docker Basics' first"
- "📦 7 topics have no resources attached — add resources to improve retention"
- "🎯 You're 2 topics away from your 75% milestone!"
- Nudges are dismissable and respect `prefers-not-to-be-bothered` quiet hours

---

### 4.28 Learning Path & Recommendations

#### FR-RECMD-001: "People Also Learned" Engine
- After completing a roadmap, show: "Users who completed this roadmap also studied:"
- Data derived from anonymized completion sequences of other users (aggregated, privacy-safe)
- Maximum 5 recommendations, ranked by overlap frequency
- Shown as roadmap cards with a "View / Clone" CTA
- Stored in `roadmap_recommendations` table, pre-computed by a daily scheduled job

#### FR-RECMD-002: Skill Gap Roadmap Suggestions
- Based on user's skill matrix (FR-SKILL-001), identify under-developed skills
- Suggest top 3 public community roadmaps that address those skill gaps
- Shown in a "Suggested For You" section on the Explore page
- Refreshed weekly by a background queue job

#### FR-RECMD-003: Learning Path Builder
- A guided wizard at `/paths` for constructing a multi-roadmap learning curriculum:
  - Choose target role (e.g., "Full-Stack Engineer")
  - System suggests a curated sequence of roadmaps (community + personal)
  - User can reorder, add, or remove roadmaps from the path
  - Path has: name, description, total estimated hours, difficulty progression
  - Tracks overall path completion % (aggregate across linked roadmaps)
- **Share a learning path**: Generate a shareable URL for the full multi-roadmap path
- **Learning path templates**: 10 pre-defined paths included (Frontend Dev Path, Data Science Path, DevOps Path, etc.)

---

### 4.29 Study Buddy & Accountability System

#### FR-BUDDY-001: Study Buddy Pairing
- Users can send a **Study Buddy request** to another user on the same roadmap
- Study buddy relationship features:
  - **Progress visibility**: See each other's topic completion in real-time
  - **Mutual XP boost**: +10% XP for topics completed while buddy is also active that day
  - **Buddy streak**: Separate streak for "days you both logged activity"
  - **Check-in messages**: Daily micro-message (max 140 chars) sent to buddy (delivered via in-app notification + Pusher)
- Maximum 3 active study buddies per user
- Buddy activity card on dashboard: "Your buddy Ahmed completed 2 topics today 🎉"

#### FR-BUDDY-002: Accountability Pods
- Groups of 3–6 users formed around a shared roadmap or topic area
- Weekly accountability check-in: each member answers 3 questions:
  1. What did you complete this week?
  2. What blocked you?
  3. What will you commit to next week?
- Answers visible to pod members in a shared feed
- Pod leader sets a weekly group goal (e.g., "Complete Phase 1 by Sunday")
- Pod completion rate displayed as a group metric
- Pods can be public (discoverable) or private (invite-only)

---

### 4.30 Changelog, Announcements & In-App Updates

#### FR-CHANGE-001: Public Changelog
- Dedicated `/changelog` page documenting platform updates
- Each entry: version number, date, category tags (New, Improved, Fixed, Removed), description with screenshots
- Entries written in Markdown, stored in `changelog_entries` database table
- RSS feed at `/feed/changelog.xml`
- **"What's New" modal**: On first login after a new release, show a modal with the top 3 new features (dismissable, never shown again for that version)

#### FR-CHANGE-002: In-App Announcements Banner
- Admin can publish a site-wide banner from the admin panel
- Banner types: info (blue), warning (amber), maintenance (red)
- Banners are dismissable per-user; dismissed state stored in localStorage
- Scheduled banners: set start and end time for timed announcements (e.g., maintenance window notice)
- Banners pushed in real-time to all active sessions via Pusher

---

### 4.31 QR Codes, Embeds & Sharing Utilities

#### FR-SHARE-001: QR Code Generation
- Every public roadmap, certificate, and user profile has a generated QR code
- QR code links to the public URL of that resource
- Generated server-side via **simplesoftwareio/simple-qrcode** (free Laravel package, no API)
- Available as: inline SVG display, PNG download, `<img>` embed code
- QR codes embedded on:
  - Printed certificate PDFs (bottom-right corner)
  - Roadmap share modal
  - Profile "Share" dropdown

#### FR-SHARE-002: Embeddable Roadmap Widget
- Any public roadmap can be embedded on external sites:
  ```html
  <iframe src="https://learnforge.app/embed/roadmaps/{slug}"
    width="600" height="400" frameborder="0"></iframe>
  ```
- Embed widget shows: roadmap title, category, progress bar (anonymized), topic list (collapsed), "Clone this roadmap" button linking back to LearnForge
- Responsive, works in any `<iframe>` context
- Dedicated embed renderer at `/embed/roadmaps/{slug}` — separate lightweight Blade layout, no nav/sidebar

#### FR-SHARE-003: Deep Link URLs
Every meaningful state in the app has a shareable URL:
- `/roadmaps/{slug}?view=kanban` — opens roadmap in Kanban view
- `/roadmaps/{slug}?topic={id}` — opens roadmap with specific topic expanded/focused
- `/roadmaps/{slug}?filter=in_progress` — opens roadmap with filter applied
- `/explore?category=devops&difficulty=intermediate` — filtered explore page
- `/review?deck={id}` — starts review session for specific deck
- `/journal/{YYYY-MM-DD}` — opens specific journal entry date

---

### 4.32 Accessibility & Inclusive Design Features

#### FR-A11Y-001: Reading & Vision Accommodations
- **Font size controls**: Increase/decrease base font size (3 levels) — persisted in user settings
- **Line height control**: Normal / Relaxed / Wide (helps users with dyslexia)
- **Letter spacing**: Normal / Wide
- **Dyslexia-friendly font**: Toggle to **OpenDyslexic** font (free, open source) — applied globally
- **High contrast mode**: Pure black/white theme beyond the standard dark mode — activated via settings or `prefers-contrast: high` media query
- **Color-blind modes**: Deuteranopia / Protanopia / Tritanopia color palettes — replaces semantic color coding with pattern/shape differentiation

#### FR-A11Y-002: Motion & Cognitive Accommodations
- **Reduced motion mode**: Respect `prefers-reduced-motion` — eliminates all animations (not just slows them)
- **Simplified UI mode**: Collapsible "declutter" toggle that hides: badges, XP, leaderboards, streak counts — for users who find gamification distracting
- **Reading ruler**: Horizontal focus line that follows mouse on content pages — helps track reading position
- **Focus indicator enhancement**: Extra-large 3px focus ring option for keyboard navigation visibility

#### FR-A11Y-003: Screen Reader & AT Optimization
- All interactive elements have descriptive `aria-label` and `title` attributes
- Progress bars include `aria-valuenow`, `aria-valuemin`, `aria-valuemax`, `aria-valuetext` ("65 percent complete")
- Live regions (`aria-live="polite"`) for: progress updates, toast notifications, Pusher-pushed updates
- Charts include `<table>` data alternatives in visually-hidden `<details>` elements
- Drag-and-drop has full keyboard alternative: select item → `Shift+Arrow` to reorder
- Modal focus trapping and return-focus on close implemented correctly

---

### 4.33 Developer Experience & API Utilities

#### FR-DEV-001: Personal API Tokens
- Users can generate **Personal Access Tokens** (via Laravel Sanctum) for programmatic access
- Token management at `/settings/api-tokens`
- Tokens have: name, abilities (scopes), expiry date (optional)
- Available scopes: `read:roadmaps`, `write:roadmaps`, `read:analytics`, `write:progress`, `read:profile`
- Last-used timestamp tracked per token
- Tokens can be revoked individually or all-at-once

#### FR-DEV-002: Embeddable Progress Badge
A GitHub README-style status badge that can be embedded anywhere:
```
![LearnForge Progress](https://learnforge.app/badge/{username}/{roadmap-slug})
```
- Returns a dynamically generated SVG badge showing:
  - Roadmap name (truncated)
  - Progress percentage
  - Color: red (0–25%), orange (26–50%), yellow (51–75%), green (76–100%)
- Cached for 1 hour (Redis)
- Used in GitHub READMEs, personal websites, portfolios
- Optional badge styles: flat / flat-square / plastic / for-the-badge (matching shields.io styles)

#### FR-DEV-003: Public API Documentation
- Auto-generated API docs using **Laravel Scribe** (free, open-source) at `/docs/api`
- Includes: endpoint list, request/response schemas, authentication instructions, example cURL commands
- "Try It" interactive requests directly from the docs page
- OpenAPI 3.0 spec exported at `/docs/openapi.json` — compatible with Postman/Insomnia import

---

### 4.34 Advanced Certificate Features

#### FR-CERT-005: Certificate Comparison & Portfolio
- **Certificate Portfolio page** (`/u/{username}/certificates`): Gallery of all earned certificates, filterable by category and year
- **Certificate comparison mode**: Side-by-side view of two certificates showing skill growth over time
- **Certificate stats**: Show average quality rating, total learning hours, topic count prominently on certificate detail page
- **Certificate expiry system** (optional): Certificates can be set to "refresh recommended" after N months (for fast-changing fields like cloud certifications). Shows a soft reminder — does not revoke the certificate.

#### FR-CERT-006: Certificate Verification API
Public endpoint (no auth required):
```
GET /api/public/verify/{uuid}
Response: {
  valid: true,
  issued_to: "John Doe",
  roadmap: "Full Stack Developer Path",
  issued_at: "2026-03-01",
  topics_completed: 22,
  total_hours: 180,
  sha256_fingerprint: "abc123...",
  verification_url: "https://learnforge.app/verify/{uuid}"
}
```
- Third-party tools (Notion, LinkedIn, HR systems) can call this URL to validate a certificate
- Fingerprint in response allows cross-checking against the certificate PDF's embedded hash
- Rate-limited to 60 requests/minute to prevent enumeration attacks

---

### 4.35 GitHub Gist Auto-Backup

#### FR-BACKUP-001: GitHub Gist Roadmap Backup
- Users can connect GitHub account and enable **automatic Gist backup** for any roadmap
- On every significant change (topic status update, new topic, completed roadmap), a background job updates a private GitHub Gist with the roadmap JSON export
- Gist acts as a version-controlled history of the roadmap — each update is a Gist revision
- Features:
  - View Gist revision history from within LearnForge
  - Restore a roadmap from any previous Gist revision
  - Toggle per-roadmap (not all roadmaps need backup)
  - Gist format: standard LearnForge JSON (importable)
- GitHub API is free for Gist operations (no rate limit issues at this scale)

---

### 4.36 Unsplash Cover Image Picker

#### FR-COVERS-001: Roadmap Cover Images via Unsplash API
- When creating or editing a roadmap, users can pick a cover image from **Unsplash** (free API — 50 requests/hour, no credit card)
- **Search interface**: Type keywords (e.g., "code", "study", "ocean") → grid of high-quality images
- Selected image stored as: Unsplash photo ID + thumbnail URL — no downloading/storing images on server
- Images rendered via Unsplash's `source.unsplash.com` CDN link (properly attributed per Unsplash API terms)
- **Attribution**: Photographer name automatically shown as a small credit on roadmap card
- Fallback: category-based gradient backgrounds (8 options) if user skips image selection
- **Custom upload**: Users can also upload their own cover image (stored on local filesystem)

---

### 4.37 Video Timestamp Notes

#### FR-VIDEO-001: YouTube Video Timestamp Notes
When a Video resource (YouTube) is attached to a topic:
- Embedded YouTube player (YouTube IFrame API — free) inside the topic resource view
- **Timestamp notes**: While watching, press `N` (or click "Add Note") → a note is created with the current video timestamp automatically prepended
  - Example: `[12:34] This is where they explain memoization — really important`
- Timestamp notes appear in a side panel next to the video player
- Clicking a timestamp note in the panel seeks the video to that point
- Timestamp notes stored in `resource_timestamp_notes` table (resource_id, timestamp_seconds, content)
- Exportable as Markdown: `- [12:34] This is where they explain...`

---

### 4.38 IP Geolocation & Security Enhancements

#### FR-SEC-EXT-001: Login Geolocation
- On each login, IP address is resolved to approximate city/country using **ip-api.com** (free: 45 req/min, no API key required, JSON endpoint)
- Login history page shows: device, browser, city/country, IP, timestamp
- **Suspicious login detection**: If a login occurs from a new country not seen in last 30 days → send email alert: "New login from [City, Country]" with session revoke link
- No precise coordinates stored — only city and country for privacy compliance

#### FR-SEC-EXT-002: Device Fingerprinting
- On login, browser fingerprint computed client-side using **FingerprintJS Community Edition** (free, open source)
- Fingerprint stored alongside session; used to detect same device across sessions
- "This session" vs "Other sessions" indicator on active sessions management page
- Fingerprint hash stored — no PII, only a hash used for comparison

#### FR-SEC-EXT-003: Honeypot Fields
- All public forms include an invisible honeypot field (hidden via CSS, not `display:none`)
- Bot submissions that fill the honeypot field are silently rejected with a fake success response
- Zero false positives on legitimate users (screen readers included — field is `aria-hidden="true"`)
- Implemented in `HoneypotMiddleware` — applied to: register, login, contact, comment forms

---

## 5. Non-Functional Requirements


### 5.1 Performance Requirements

**NFR-PERF-001: Core Web Vitals Targets**

| Metric | Target | Description |
|--------|--------|-------------|
| LCP (Largest Contentful Paint) | < 1.5s | Main content visible |
| FID (First Input Delay) | < 50ms | First interaction response |
| CLS (Cumulative Layout Shift) | < 0.05 | Visual stability |
| TTFB (Time to First Byte) | < 200ms | Server response time |
| Total Page Weight | < 500KB | Per page (compressed) |

**NFR-PERF-002: Backend Performance**
- API response time (p95): < 300ms for CRUD operations
- Database queries: < 50ms (simple), < 200ms (complex analytics)
- File uploads: Max 25MB, streamed directly to S3 (not through app server)
- AI API calls: Background queued jobs for > 3s operations; user notified on completion
- Full-text search (TNTSearch via Laravel Scout): < 100ms query response for typical dataset sizes

**NFR-PERF-003: Scalability Targets**
- Support 100,000+ registered users
- Support 10,000 concurrent active users
- Handle 1,000,000+ roadmaps without degradation
- Database: horizontal read scaling via read replicas
- Queue workers: horizontally scalable via Laravel Horizon
- Static assets: served via **Cloudflare free CDN** (unlimited bandwidth on free plan, global PoPs)

**NFR-PERF-004: Optimization Strategies**
- Blade view caching in production
- Eager loading on all Eloquent relationships (N+1 elimination enforced in CI)
- Redis cache for: dashboard stats (TTL 5 min), roadmap progress (TTL 1 min), leaderboards (TTL 10 min)
- Database connection pooling via PgBouncer (if PostgreSQL migration) or HaProxy
- Image optimization pipeline: WebP conversion, multiple sizes, lazy loading
- Code splitting: Alpine.js components loaded on demand
- HTTP/2 Push for critical CSS/JS assets

### 5.2 Security Requirements

**NFR-SEC-001: Authentication Security**
- HTTPS enforced on all routes (HSTS with preload, 1 year max-age)
- CSRF protection on all state-changing routes
- Secure, HTTP-only, SameSite=Strict cookies
- Session lifetime: 120 minutes idle, 30 days with Remember Me
- Session ID rotation on privilege escalation
- OAuth tokens stored encrypted; refresh tokens in database

**NFR-SEC-002: Data Protection**
- Passwords: bcrypt with cost factor 12
- Sensitive fields (API keys, webhook secrets): AES-256 encrypted at rest
- Database backups encrypted at rest
- User-uploaded files: validated by **strict server-side MIME type detection** using PHP's `finfo_file()` (built into PHP, no external service) — rejects mismatched extension/MIME combinations
- Windows Defender (built into Windows Server / Windows 10+) provides real-time file scanning at the OS level on the host machine
- File quarantine: uploaded files stored outside web root; only served via signed download URL
- File type verification by MIME type (not just extension)
- File serving via signed S3 URLs (never direct path exposure)

**NFR-SEC-003: Attack Prevention**
- SQL injection: prevented by Eloquent ORM (parameterized queries enforced)
- XSS: Blade auto-escaping + HTMLPurifier for user-submitted HTML
- SSRF prevention: outbound URL fetches (AI URL input, link preview) go through allowlisted proxy
- Rate limiting:
  - Authentication: 5 attempts / 15 min / IP+email
  - API: 100 req/min authenticated, 20 req/min unauthenticated
  - AI endpoints: 10 req/min (cost control)
  - File upload: 20 uploads/hour per user
- Clickjacking prevention: X-Frame-Options SAMEORIGIN (except `/verify/` and public embeds)
- Content-Security-Policy headers configured and enforced

**NFR-SEC-004: Privacy & Compliance**
- GDPR compliance:
  - Cookie consent banner (essential / functional / analytics)
  - Right to access: `/settings/export` → full account data JSON download
  - Right to erasure: account deletion removes all PII within 30 days
  - Data minimization: only collect fields that serve a functional purpose
- CCPA compliance for California users
- Privacy Policy and Terms of Service pages
- Data retention policy: inactive accounts warned at 24 months, deleted at 30 months

### 5.3 Reliability & Availability

**NFR-REL-001: Uptime**
- Target: 99.9% uptime (< 8.7 hours downtime per year)
- Automated health checks every 60 seconds via **UptimeRobot free tier** (50 monitors, 5-min interval)
- Alerting via **UptimeRobot email alerts** (free) + **Telegram bot** (free) on downtime > 2 minutes
- Maintenance windows: max 30 min/month, pre-announced 72 hours ahead

**NFR-REL-002: Backup & Recovery**
- Database: hourly incremental backups + daily full backup
- File storage: S3 versioning enabled
- Backup retention: 7 days daily, 4 weeks weekly, 12 months monthly
- RTO (Recovery Time Objective): < 1 hour
- RPO (Recovery Point Objective): < 1 hour (max data loss)
- Disaster recovery drill: monthly automated restore test

**NFR-REL-003: Error Handling**
- **Laravel Telescope** in development (free, built-in Laravel package)
- **Flare free tier** in production (free up to 10,000 exceptions/month, Laravel-specific error tracker) — or fall back to Laravel's built-in log channel with daily rotation
- All unhandled exceptions logged with full stack trace + user context
- Error rate alerting: > 1% 5xx rate triggers alert
- Graceful degradation: AI features fail silently with "unavailable" message; core features unaffected

### 5.4 Usability & Accessibility

**NFR-USE-001: Usability Standards**
- 3-click rule: any feature accessible within 3 clicks from dashboard
- **Command Palette (Cmd/Ctrl+K)**: Global search + quick actions overlay
  - Actions: "New Roadmap", "Go to [roadmap name]", "Start Review Session", "Open Timer"
  - Recent pages
  - Fuzzy search across all roadmaps and topics
- Consistent design language across all 40+ pages
- Inline help tooltips on complex UI elements (dismissable, not shown again after dismissed)
- Empty state illustrations with actionable CTAs on all empty views

**NFR-USE-002: Keyboard Navigation**
- All interactive elements reachable via Tab key
- Focus indicators visible and styled (custom ring style)
- Keyboard shortcuts documented in a shortcuts modal (`?` key)
- Modal trapping: focus trapped within open modals
- Skip navigation links for screen reader users

**NFR-USE-003: Responsive Design**
- Mobile-first CSS approach (base styles for mobile, enhancement for desktop)
- Tested and functional on: iPhone SE (375px) through 4K (3840px)
- Bottom navigation bar on mobile for primary actions
- Touch targets: minimum 44×44px
- No horizontal scroll on any breakpoint
- Swipe gestures on mobile for common actions (SRS card review, roadmap switching)

### 5.5 Maintainability & Code Quality

**NFR-MAIN-001: Code Standards**
- PSR-12 compliance enforced via PHP CS Fixer in CI
- PHPStan level 6+ (strict type checking)
- ESLint + Prettier for JavaScript/Alpine.js
- Tailwind CSS linting via Stylelint
- Git commit convention: Conventional Commits (`feat:`, `fix:`, `docs:`, `refactor:`, `test:`)
- PR template with: description, testing checklist, migration notes, UI screenshots

**NFR-MAIN-002: Testing Requirements**
- Unit test coverage: ≥ 80% on service layer
- Feature test coverage: all API endpoints
- Browser testing (Dusk or Playwright): critical user flows
- Performance testing: Lighthouse CI on every PR (enforce LCP < 2.5s gate)
- N+1 query detection: Laravel Clockwork alerts in test suite

---

---

## 6. Database Schema

### 6.1 Overview

| Table | Purpose |
|-------|---------|
| `users` | User accounts and profile data |
| `user_providers` | OAuth provider connections |
| `user_security_logs` | Login/security event history |
| `roadmaps` | Learning roadmaps |
| `roadmap_phases` | Grouping phases within roadmaps |
| `topics` | Individual learning topics |
| `topic_status_history` | Full status change audit log |
| `topic_dependencies` | Prerequisite relationships |
| `resources` | Files, links, notes, videos, voice notes |
| `resource_tags` | Tag associations for resources |
| `topic_time_logs` | Pomodoro/manual study time entries |
| `topic_progress` | Per-topic progress tracking |
| `flashcard_decks` | SRS deck metadata |
| `flashcards` | Individual SRS cards |
| `flashcard_reviews` | SM-2 review records |
| `certificates` | Issued certificates |
| `activity_logs` | All user activity events |
| `xp_transactions` | XP earn/spend history |
| `badges` | Badge definitions |
| `user_badges` | Badge awards per user |
| `achievements` | Milestone / challenge definitions |
| `user_achievements` | Achievement completions |
| `daily_challenges` | Generated daily challenges |
| `user_daily_challenges` | Challenge completion tracking |
| `streaks` | User streak tracking |
| `follows` | User follow relationships |
| `roadmap_ratings` | Community ratings on public roadmaps |
| `roadmap_reviews` | Text reviews on public roadmaps |
| `roadmap_bookmarks` | Bookmarked public roadmaps |
| `roadmap_collaborators` | Collaboration access control |
| `roadmap_comments` | Comments on public roadmaps |
| `groups` | Learning community groups |
| `group_members` | Group membership |
| `group_roadmaps` | Roadmaps pinned to groups |
| `mentorships` | Mentor/mentee relationships |
| `topic_comments` | Mentor inline comments on topics |
| `notifications` | In-app notification records |
| `journal_entries` | Daily journal entries |
| `topic_reflections` | Post-completion reflections |
| `mood_logs` | Daily mood check-ins |
| `habits` | User-defined learning habits |
| `habit_logs` | Daily habit check-ins |
| `webhooks` | User-configured webhook endpoints |
| `webhook_deliveries` | Webhook delivery log |
| `integrations` | OAuth integrations (GitHub, Notion, etc.) |
| `user_skills` | User skill self-assessments |
| `pomodoro_sessions` | Pomodoro timer history |
| `roadmap_milestones` | Custom and auto milestones |
| `resource_timestamp_notes` | YouTube video timestamp notes |
| `roadmap_health_scores` | Cached health score + factor breakdown |
| `api_tokens` | Personal API access tokens (Sanctum) |
| `changelog_entries` | Platform changelog entries |
| `study_buddy_pairs` | Study buddy relationships |
| `accountability_pods` | Accountability pod groups |
| `pod_members` | Pod membership |
| `pod_checkins` | Weekly accountability check-in answers |
| `roadmap_embeds` | Embed configuration per roadmap |
| `gist_backups` | GitHub Gist backup tracking |
| `roadmap_recommendations` | Pre-computed "also learned" suggestions |
| `learning_paths` | Multi-roadmap curated learning paths |
| `learning_path_items` | Roadmaps within a learning path |
| `user_login_history` | Login history with device + geolocation |

**Total: 66 tables**

---

### 6.2 Core Table Structures

#### users
```sql
id                    BIGINT UNSIGNED PK AUTO_INCREMENT
username              VARCHAR(30) UNIQUE NOT NULL
email                 VARCHAR(255) UNIQUE NOT NULL
password              VARCHAR(255) NULL  -- NULL for OAuth-only users
full_name             VARCHAR(100) NULL
headline              VARCHAR(160) NULL  -- Short professional headline
profession            VARCHAR(100) NULL
bio                   TEXT NULL
location              VARCHAR(100) NULL
website               VARCHAR(255) NULL
github_username       VARCHAR(100) NULL
linkedin_url          VARCHAR(255) NULL
twitter_username      VARCHAR(100) NULL
profile_picture       VARCHAR(500) NULL
cover_image           VARCHAR(500) NULL
timezone              VARCHAR(50) DEFAULT 'UTC'
locale                VARCHAR(10) DEFAULT 'en'
theme                 ENUM('system','light','dark') DEFAULT 'system'
accent_color          VARCHAR(7) DEFAULT '#6366F1'  -- Hex color
available_hours_week  DECIMAL(4,1) DEFAULT 10.0
is_mentor             BOOLEAN DEFAULT false
is_public             BOOLEAN DEFAULT true
two_factor_secret     VARCHAR(255) NULL ENCRYPTED
two_factor_confirmed  BOOLEAN DEFAULT false
email_verified_at     TIMESTAMP NULL
remember_token        VARCHAR(100) NULL
onboarding_completed  BOOLEAN DEFAULT false
last_active_at        TIMESTAMP NULL
created_at            TIMESTAMP
updated_at            TIMESTAMP
deleted_at            TIMESTAMP NULL

INDEXES:
  UNIQUE (username), UNIQUE (email)
  INDEX (is_public, last_active_at)
  FULLTEXT (username, full_name, profession, bio)
```

#### user_providers
```sql
id             BIGINT UNSIGNED PK
user_id        BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE
provider       ENUM('google','github','linkedin') NOT NULL
provider_id    VARCHAR(255) NOT NULL
token          TEXT ENCRYPTED NULL
refresh_token  TEXT ENCRYPTED NULL
expires_at     TIMESTAMP NULL
created_at     TIMESTAMP
updated_at     TIMESTAMP
UNIQUE (provider, provider_id)
INDEX (user_id)
```

#### roadmaps
```sql
id                     BIGINT UNSIGNED PK
user_id                BIGINT UNSIGNED FK -> users(id) CASCADE
title                  VARCHAR(255) NOT NULL
slug                   VARCHAR(300) UNIQUE NOT NULL
description            MEDIUMTEXT NULL  -- Block editor JSON
category               VARCHAR(100) NULL
cover_image            VARCHAR(500) NULL
difficulty_level       ENUM('beginner','intermediate','advanced') NULL
tags                   JSON NULL  -- Array of tag strings
target_completion_date DATE NULL
is_public              BOOLEAN DEFAULT false
visibility             ENUM('private','friends','public') DEFAULT 'private'
total_score            DECIMAL(5,2) DEFAULT 0.00
progress_percentage    DECIMAL(5,2) DEFAULT 0.00
weighted_progress      DECIMAL(5,2) DEFAULT 0.00
quality_score          DECIMAL(5,2) DEFAULT 0.00
composite_score        DECIMAL(5,2) DEFAULT 0.00
status                 ENUM('draft','active','completed','archived') DEFAULT 'active'
cloned_from_id         BIGINT UNSIGNED NULL FK -> roadmaps(id) SET NULL
total_clones           INT UNSIGNED DEFAULT 0
total_views            INT UNSIGNED DEFAULT 0
total_bookmarks        INT UNSIGNED DEFAULT 0
average_rating         DECIMAL(3,2) DEFAULT 0.00
ratings_count          INT UNSIGNED DEFAULT 0
created_at             TIMESTAMP
updated_at             TIMESTAMP
deleted_at             TIMESTAMP NULL

INDEXES:
  INDEX (user_id, status, created_at)
  INDEX (is_public, status, average_rating)
  INDEX (category, difficulty_level)
  FULLTEXT (title, description)
```

#### roadmap_phases
```sql
id           BIGINT UNSIGNED PK
roadmap_id   BIGINT UNSIGNED FK -> roadmaps(id) CASCADE
title        VARCHAR(255) NOT NULL
description  TEXT NULL
color        VARCHAR(7) NULL  -- Hex color for visual differentiation
order_index  INT NOT NULL DEFAULT 0
created_at   TIMESTAMP
updated_at   TIMESTAMP
INDEX (roadmap_id, order_index)
```

#### topics
```sql
id                BIGINT UNSIGNED PK
roadmap_id        BIGINT UNSIGNED FK -> roadmaps(id) CASCADE
phase_id          BIGINT UNSIGNED NULL FK -> roadmap_phases(id) SET NULL
parent_topic_id   BIGINT UNSIGNED NULL FK -> topics(id) SET NULL
title             VARCHAR(255) NOT NULL
description       MEDIUMTEXT NULL  -- Block editor JSON
estimated_hours   DECIMAL(6,2) NOT NULL
actual_hours      DECIMAL(6,2) DEFAULT 0.00
difficulty_level  ENUM('beginner','intermediate','advanced') NULL
priority          TINYINT DEFAULT 2  -- 1=P1 (Critical) to 4=P4 (Low)
order_index       INT NOT NULL DEFAULT 0
weight            TINYINT UNSIGNED DEFAULT 1  -- 1-10x scoring multiplier
status            ENUM('not_started','in_progress','completed','on_hold','skipped') DEFAULT 'not_started'
quality_rating    TINYINT NULL  -- 1-5 stars
confidence_level  TINYINT NULL  -- 1-10
started_at        TIMESTAMP NULL
completed_at      TIMESTAMP NULL
scheduled_date    DATE NULL
due_date          DATE NULL
created_at        TIMESTAMP
updated_at        TIMESTAMP

INDEXES:
  INDEX (roadmap_id, order_index)
  INDEX (roadmap_id, status)
  INDEX (parent_topic_id)
  INDEX (phase_id)
  INDEX (scheduled_date)
  FULLTEXT (title, description)
```

#### topic_dependencies
```sql
id              BIGINT UNSIGNED PK
topic_id        BIGINT UNSIGNED FK -> topics(id) CASCADE
depends_on_id   BIGINT UNSIGNED FK -> topics(id) CASCADE
created_at      TIMESTAMP
UNIQUE (topic_id, depends_on_id)
```

#### resources
```sql
id              BIGINT UNSIGNED PK
topic_id        BIGINT UNSIGNED FK -> topics(id) CASCADE
resource_type   ENUM('file','link','note','video','voice','code','flashcard_deck') NOT NULL
title           VARCHAR(255) NOT NULL
description     TEXT NULL
content         MEDIUMTEXT NULL  -- Block JSON for notes; code for snippets
file_path       VARCHAR(500) NULL
file_size       BIGINT NULL
mime_type       VARCHAR(100) NULL
duration_sec    INT NULL  -- For voice notes / videos
url             VARCHAR(2000) NULL
og_title        VARCHAR(255) NULL  -- Open Graph metadata
og_description  TEXT NULL
og_image        VARCHAR(500) NULL
og_domain       VARCHAR(100) NULL
language        VARCHAR(50) NULL  -- For code snippets
is_favorite     BOOLEAN DEFAULT false
order_index     INT DEFAULT 0
created_at      TIMESTAMP
updated_at      TIMESTAMP
INDEX (topic_id, resource_type)
INDEX (topic_id, is_favorite)
FULLTEXT (title, content)
```

#### flashcard_decks
```sql
id              BIGINT UNSIGNED PK
user_id         BIGINT UNSIGNED FK -> users(id) CASCADE
topic_id        BIGINT UNSIGNED NULL FK -> topics(id) SET NULL
title           VARCHAR(255) NOT NULL
description     TEXT NULL
source          ENUM('manual','ai_generated','imported') DEFAULT 'manual'
total_cards     INT DEFAULT 0
new_cards_today INT DEFAULT 0
new_per_day     INT DEFAULT 20  -- Config: new cards per day
is_archived     BOOLEAN DEFAULT false
created_at      TIMESTAMP
updated_at      TIMESTAMP
INDEX (user_id, is_archived)
INDEX (topic_id)
```

#### flashcards
```sql
id              BIGINT UNSIGNED PK
deck_id         BIGINT UNSIGNED FK -> flashcard_decks(id) CASCADE
front           MEDIUMTEXT NOT NULL
back            MEDIUMTEXT NOT NULL
front_image     VARCHAR(500) NULL
back_image      VARCHAR(500) NULL
tags            JSON NULL
ease_factor     DECIMAL(4,2) DEFAULT 2.50
interval_days   INT DEFAULT 0
repetitions     INT DEFAULT 0
next_review_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
status          ENUM('new','learning','review','relearning','suspended') DEFAULT 'new'
created_at      TIMESTAMP
updated_at      TIMESTAMP
INDEX (deck_id, next_review_at, status)
```

#### flashcard_reviews
```sql
id           BIGINT UNSIGNED PK
card_id      BIGINT UNSIGNED FK -> flashcards(id) CASCADE
user_id      BIGINT UNSIGNED FK -> users(id) CASCADE
rating       TINYINT NOT NULL  -- 1=Again, 2=Hard, 3=Good, 4=Easy
prev_interval INT
new_interval  INT
prev_ease    DECIMAL(4,2)
new_ease     DECIMAL(4,2)
response_ms  INT  -- Response time in milliseconds
reviewed_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
INDEX (card_id, reviewed_at)
INDEX (user_id, reviewed_at)
```

#### xp_transactions
```sql
id           BIGINT UNSIGNED PK
user_id      BIGINT UNSIGNED FK -> users(id) CASCADE
amount       INT NOT NULL  -- Positive = earn, Negative = spend
action       VARCHAR(100) NOT NULL  -- e.g., 'topic_completed', 'daily_streak'
reference_id BIGINT UNSIGNED NULL  -- ID of the related object
description  VARCHAR(255) NULL
created_at   TIMESTAMP
INDEX (user_id, created_at)
INDEX (action)
```

#### streaks
```sql
id                    BIGINT UNSIGNED PK
user_id               BIGINT UNSIGNED FK -> users(id) CASCADE UNIQUE
current_streak        INT DEFAULT 0
longest_streak        INT DEFAULT 0
last_activity_date    DATE NULL
shield_available      INT DEFAULT 0  -- Number of streak shields earned
streak_frozen_until   DATE NULL
created_at            TIMESTAMP
updated_at            TIMESTAMP
```

#### certificates
```sql
id                    BIGINT UNSIGNED PK
uuid                  CHAR(36) UNIQUE NOT NULL
user_id               BIGINT UNSIGNED FK -> users(id) CASCADE
roadmap_id            BIGINT UNSIGNED FK -> roadmaps(id) CASCADE
certificate_number    VARCHAR(50) UNIQUE NOT NULL  -- LF-2026-XXXXXXXX
issued_at             TIMESTAMP NOT NULL
total_topics          INT NOT NULL
total_learning_hours  DECIMAL(8,2) NOT NULL
topics_summary        JSON NOT NULL  -- Array of topic summaries
average_quality       DECIMAL(3,2) NULL
template_type         ENUM('classic','modern','minimalist','dark','neon') DEFAULT 'modern'
accent_color          VARCHAR(7) DEFAULT '#6366F1'
blockchain_hash       VARCHAR(64) NULL  -- SHA-256 fingerprint of certificate data for tamper detection (no external service needed)
blockchain_anchored   BOOLEAN DEFAULT false  -- Reserved for future use; always false in free implementation
file_path_pdf         VARCHAR(500) NULL
file_path_png         VARCHAR(500) NULL
linkedin_post_id      VARCHAR(255) NULL
is_revoked            BOOLEAN DEFAULT false
created_at            TIMESTAMP
updated_at            TIMESTAMP
INDEX (user_id, issued_at)
INDEX (roadmap_id)
INDEX (uuid)
```

#### pomodoro_sessions
```sql
id             BIGINT UNSIGNED PK
user_id        BIGINT UNSIGNED FK -> users(id) CASCADE
topic_id       BIGINT UNSIGNED NULL FK -> topics(id) SET NULL
type           ENUM('work','short_break','long_break') DEFAULT 'work'
duration_min   INT NOT NULL  -- Minutes configured for this session
actual_min     INT NULL  -- Actual minutes completed (null = abandoned)
completed      BOOLEAN DEFAULT false
started_at     TIMESTAMP NOT NULL
ended_at       TIMESTAMP NULL
created_at     TIMESTAMP
INDEX (user_id, started_at)
INDEX (topic_id)
```

#### mood_logs
```sql
id          BIGINT UNSIGNED PK
user_id     BIGINT UNSIGNED FK -> users(id) CASCADE
mood_score  TINYINT NOT NULL  -- 1-5
note        VARCHAR(255) NULL
logged_date DATE NOT NULL
created_at  TIMESTAMP
UNIQUE (user_id, logged_date)
INDEX (user_id, logged_date)
```

#### webhooks
```sql
id         BIGINT UNSIGNED PK
user_id    BIGINT UNSIGNED FK -> users(id) CASCADE
name       VARCHAR(100) NOT NULL
url        VARCHAR(2000) NOT NULL
secret     VARCHAR(64) NOT NULL ENCRYPTED
events     JSON NOT NULL  -- Array of event names to trigger
is_active  BOOLEAN DEFAULT true
created_at TIMESTAMP
updated_at TIMESTAMP
INDEX (user_id, is_active)
```

---

### 6.3 Performance Indexes Summary

```sql
-- Compound indexes for most common query patterns

-- Dashboard: User's active roadmaps sorted by updated_at
INDEX idx_roadmaps_user_active (user_id, status, updated_at DESC)

-- SRS: Cards due for review today for a user
INDEX idx_flashcards_review (deck_id, status, next_review_at)

-- Activity heatmap: Daily activity per user
INDEX idx_time_logs_user_date (user_id, logged_date)

-- Explore: Public roadmaps sorted by rating + recency
INDEX idx_roadmaps_explore (is_public, status, average_rating DESC, created_at DESC)

-- Notifications: Unread notifications for a user
INDEX idx_notifications_unread (user_id, is_read, created_at DESC)

-- Analytics: XP by time range
INDEX idx_xp_user_time (user_id, created_at DESC)

-- Topic ordering within roadmap
INDEX idx_topics_order (roadmap_id, phase_id, order_index)
```

---

## 7. User Interface Design System

### 7.1 Design Philosophy

LearnForge follows a **"Calm Technology"** design philosophy: surfaces information when needed, recedes when not. The UI is optimized for **long work sessions** — it must be comfortable, clear, and never overwhelming.

Design influences:
- **Linear**: Micro-animations, keyboard-first, density-efficient layout
- **Notion**: Block editor flexibility, clean typography
- **Vercel Dashboard**: Professional dark mode, stat cards
- **Duolingo**: Celebration moments, streak visibility, friendly progress

---

### 7.2 Color System

#### Light Mode Palette
```
-- Primary Brand
--color-primary:       #6366F1  (Indigo 500)
--color-primary-hover: #4F46E5  (Indigo 600)
--color-primary-light: #EEF2FF  (Indigo 50)
--color-primary-ring:  #C7D2FE  (Indigo 200)

-- Semantic Colors
--color-success:   #10B981  (Emerald 500)
--color-warning:   #F59E0B  (Amber 500)
--color-error:     #EF4444  (Red 500)
--color-info:      #3B82F6  (Blue 500)

-- Surface Colors
--color-bg:        #F8FAFC  (Slate 50)
--color-surface:   #FFFFFF
--color-surface-2: #F1F5F9  (Slate 100)
--color-border:    #E2E8F0  (Slate 200)
--color-border-hover: #CBD5E1 (Slate 300)

-- Text Colors
--color-text-primary:   #0F172A  (Slate 900)
--color-text-secondary: #475569  (Slate 600)
--color-text-muted:     #94A3B8  (Slate 400)
--color-text-disabled:  #CBD5E1  (Slate 300)
```

#### Dark Mode Palette
```
--color-bg:        #0A0A0F  (Near Black)
--color-surface:   #13131A
--color-surface-2: #1C1C27
--color-border:    #2A2A3C
--color-border-hover: #3A3A52

--color-text-primary:   #F1F5F9  (Slate 100)
--color-text-secondary: #94A3B8  (Slate 400)
--color-text-muted:     #475569  (Slate 600)

-- Primary adjusted for dark:
--color-primary:       #818CF8  (Indigo 400)
--color-primary-hover: #6366F1  (Indigo 500)
```

#### Accent Color System
User-customizable accent color (stored in `users.accent_color`):
- 8 preset options: Indigo, Violet, Emerald, Sky, Rose, Amber, Teal, Orange
- Applied as CSS custom property `--color-accent` globally

---

### 7.3 Typography

```css
/* Primary: Inter (Google Fonts) */
font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

/* Monospace: JetBrains Mono (code blocks) */
font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;

/* Type Scale */
--text-xs:   0.75rem / 1rem     (12px / 16px)
--text-sm:   0.875rem / 1.25rem (14px / 20px)
--text-base: 1rem / 1.5rem      (16px / 24px)
--text-lg:   1.125rem / 1.75rem (18px / 28px)
--text-xl:   1.25rem / 1.75rem  (20px / 28px)
--text-2xl:  1.5rem / 2rem      (24px / 32px)
--text-3xl:  1.875rem / 2.25rem (30px / 36px)
--text-4xl:  2.25rem / 2.5rem   (36px / 40px)
--text-5xl:  3rem / 1           (48px)
```

---

### 7.4 Component Library

#### 7.4.1 Navigation
**Left Sidebar (Desktop):**
- Logo + Product name
- Navigation items: Dashboard, Explore, Analytics, Journal, Review (SRS), Community
- Roadmaps section: list of active roadmaps with progress rings
- Command palette trigger
- Bottom: User avatar, settings, theme toggle

**Top Header (Desktop):**
- Breadcrumb navigation
- Search bar (triggers command palette)
- Notification bell + badge
- User avatar with dropdown menu

**Bottom Navigation (Mobile):**
- 5 tabs: Home, Explore, Review, Journal, Profile
- Active state: filled icon + label
- Badge indicators for unread notifications and due SRS cards

#### 7.4.2 Cards

**Roadmap Card:**
```
┌─────────────────────────────────────────────┐
│ [Cover Image / Category Color Banner]        │
├─────────────────────────────────────────────┤
│ 🏷 Category                    [Difficulty] │
│ Roadmap Title                               │
│ Short description (2 lines max)             │
│                                             │
│ Progress Bar ████████░░░ 73%               │
│                                             │
│ 12 topics · 47h estimated · Due Mar 15     │
│ ─────────────────────────────────────────  │
│ [Continue →]          [⋯ More options]    │
└─────────────────────────────────────────────┘
```

**Topic Card (List View):**
```
┌─────────────────────────────────────────────┐
│ ◉ [Status Icon] Topic Title    [P1] [Inter] │
│   Est: 8h · Actual: 6.5h                   │
│   ████████░░ 80%    ★★★★☆               │
│   [3 Resources] [1 Flashcard Deck]          │
└─────────────────────────────────────────────┘
```

#### 7.4.3 Progress Visualization Components
- **Circular Progress Ring**: SVG-based, animated, used on roadmap cards and profile stats
- **Horizontal Progress Bar**: Gradient fill, animated on update, with % label
- **Multi-segment Bar**: Shows breakdown (completed / in-progress / not-started)
- **Stat Cards**: Large number, label, trend indicator (↑ / ↓), comparison period
- **Activity Heatmap**: 52-week grid, CSS grid-based, hover tooltips
- **Sparkline Charts**: Inline micro-charts in tables/cards using Chart.js

#### 7.4.4 Interaction Patterns
**Drag & Drop (SortableJS):**
- Topics reordering: dashed drop target preview while dragging
- Kanban column dragging: ghost item + column highlight
- Visual handle icon on hover

**Modals:**
- Slide-up on mobile, center-pop on desktop
- Backdrop blur + fade overlay
- Focus trap, Escape to close
- Sizes: sm (400px) / md (600px) / lg (800px) / full-screen

**Toast Notifications:**
- Top-right on desktop, top-center on mobile
- 4 types: success (green), error (red), warning (amber), info (blue)
- Auto-dismiss after 4 seconds, pause on hover
- Action button option (e.g., "Undo")
- Stack up to 3 toasts; queued thereafter

**Skeleton Screens:**
- All loading states use skeleton screens (not spinners)
- Shimmer animation on skeleton elements
- Matches exact layout of loaded content

---

### 7.5 Animation System

```css
/* Duration tokens */
--duration-instant:  50ms
--duration-fast:     150ms
--duration-normal:   250ms
--duration-slow:     400ms
--duration-enter:    300ms
--duration-exit:     200ms

/* Easing tokens */
--ease-spring:    cubic-bezier(0.34, 1.56, 0.64, 1)   /* Overshoot bounce */
--ease-smooth:    cubic-bezier(0.4, 0, 0.2, 1)         /* Standard material */
--ease-out:       cubic-bezier(0, 0, 0.2, 1)           /* Deceleration */
--ease-in:        cubic-bezier(0.4, 0, 1, 1)           /* Acceleration */

/* Signature animations */
.topic-complete-celebration {
  /* Checkmark draw + ring expand + confetti burst */
  /* Using canvas-confetti library */
}

.card-enter {
  /* Fade + 8px translate-up over 300ms */
}

.progress-bar-fill {
  /* Width transition: 600ms ease-out, triggered on page load */
}

.streak-flame {
  /* CSS keyframe: flicker animation, scale 0.95–1.05 */
}

.xp-burst {
  /* +XP text that floats up and fades: +50 XP ✨ */
}
```

**Respect for Accessibility:**
All animations respect `prefers-reduced-motion`:
```css
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

### 7.6 Page Layout Catalog

#### Dashboard (`/dashboard`)
```
┌─────────────────────────────────────────────────────────────────┐
│ SIDEBAR │  Welcome back, Minhaz! 🔥 Day 47 streak              │
│         │  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐               │
│  Nav    │  │Total │ │Hours │ │XP    │ │Level │  Stat Cards     │
│  Items  │  │Roads │ │Today │ │Week  │ │ 23   │               │
│         │  └──────┘ └──────┘ └──────┘ └──────┘               │
│         │                                                        │
│         │  [Today's Plan]    [AI Insight of the Day]           │
│         │                                                        │
│         │  ── Active Roadmaps ─────────────────────────────── │
│         │  [Card] [Card] [Card] [+ New Roadmap]               │
│         │                                                        │
│         │  ── Due for Review ──────── ── Activity ────────── │
│         │  SRS: 24 cards due          Heatmap (52 weeks)      │
│         │  [Start Review]                                       │
│         │                                                        │
│         │  ── Community Feed ──────────────────────────────── │
│         │  [Activity from followed users]                       │
└─────────────────────────────────────────────────────────────────┘
```

#### Roadmap Detail (`/roadmaps/{slug}`)
```
┌─────────────────────────────────────────────────────────────────┐
│ SIDEBAR │ [Roadmap Title]                                        │
│         │ [Description] [Tags] [Category] [Difficulty]          │
│  Nav    │ ─────────────────────────────────────────────────    │
│  Items  │ [View: List | Kanban | Timeline | MindMap | Calendar] │
│         │                                                        │
│  Road-  │ ──── Progress Panel (Sidebar) ─── Topic List ─────── │
│  map    │ [75% ring]       [Status: Active]  [Phase 1 header]  │
│  List   │ [Score: 82/100]                    [■ Topic 1  ✓]   │
│         │ [Milestones]                        [■ Topic 2  ●]   │
│         │ [Schedule]                          [■ Topic 3  ○]   │
│         │                                     [+ Add Topic]    │
│         │                                                        │
└─────────────────────────────────────────────────────────────────┘
```

---

## 8. Technology Stack

### 8.1 Frontend

| Technology | Version | Purpose |
|-----------|---------|---------|
| Laravel Blade | 12.x | Server-side HTML rendering, layouts, components |
| Alpine.js | 3.x | Client-side reactivity, interactive components, command palette |
| Tailwind CSS | 4.x | Utility-first CSS framework |
| Chart.js | 4.x | Progress charts, analytics graphs, burn-down charts |
| D3.js | 7.x | Mind map visualization (custom SVG rendering) |
| SortableJS | 1.x | Drag-and-drop reordering |
| FilePond | 4.x | Rich file upload with preview and progress |
| Tippy.js | 6.x | Tooltips, popovers |
| Day.js | 1.x | Date formatting and manipulation |
| Prism.js | 1.x | Syntax highlighting in code blocks (100+ languages) |
| KaTeX | 0.x | LaTeX math rendering in block editor (free, MIT) |
| Mermaid.js | 10.x | Diagram rendering (flowchart, ER, sequence, Gantt) in notes |
| Excalidraw | — | Embedded whiteboard/sketch blocks (free, MIT, iframe) |
| canvas-confetti | 1.x | Celebration animations on topic/roadmap completion |
| PDF.js | 3.x | In-browser PDF viewer for file resources |
| Tone.js | — | Focus mode background audio (lo-fi, white noise) |
| YouTube IFrame API | — | Embedded video player with timestamp control (free) |
| FingerprintJS CE | — | Device fingerprinting for security (Community Edition, free) |
| BroadcastChannel API | native | Multi-tab notification sync (browser native, no library) |
| Pusher JS | 8.x | WebSocket client for real-time notifications |
| Laravel Echo | — | WebSocket event listener wrapper |
| Vite | 5.x | Build tool, HMR in development |
| PostCSS + Autoprefixer | — | CSS processing |

### 8.2 Backend

| Technology | Version | Purpose |
|-----------|---------|---------|
| PHP | 8.3+ | Runtime |
| Laravel | 12.x | Application framework |
| Laravel Sanctum | — | Session + API token authentication |
| Laravel Breeze | — | Auth scaffolding |
| Laravel Horizon | — | Queue worker dashboard |
| Laravel Echo | — | WebSocket broadcasting |
| Laravel Scout | — | Full-text search integration |
| Laravel Telescope | — | Debug toolbar (dev only) |
| Laravel Socialite | — | OAuth (Google, GitHub, LinkedIn) |
| Spatie Laravel Permission | — | Role-based access control |
| Spatie Laravel Backup | — | Automated backups |
| Spatie Laravel MediaLibrary | — | File management with conversions |
| Spatie Laravel Sluggable | — | Auto-slug generation |
| Spatie Laravel ActivityLog | — | Activity logging |
| Spatie Laravel Sitemap | — | Auto sitemap.xml generation (free) |
| Spatie Laravel Feed | — | RSS/Atom feed generation (free) |
| Spatie Laravel IcalComponent | — | iCal (.ics) study schedule export (free) |
| Spatie Browsershot | — | OG image generation via headless Chrome (free) |
| Spatie Laravel CSP | — | Content-Security-Policy headers (free) |
| Barryvdh DomPDF | — | Certificate + roadmap PDF generation (free) |
| Intervention Image | 3.x | Image manipulation, OG card generation, avatar crop |
| Google Gemini PHP / Guzzle HTTP | — | Google Gemini 1.5 Flash API integration (free tier) |
| Pusher PHP SDK | 7.x | WebSocket broadcasting (free tier: 200 conns, 200k msg/day) |
| teamtnt/laravel-scout-tntsearch-driver | — | TNTSearch full-text search (free, pure PHP) |
| SimpleSoftwareIO/simple-qrcode | — | QR code generation server-side (free, no API) |
| pragmarx/google2fa-laravel | — | TOTP 2FA — Google Authenticator compatible (free) |
| tightenco/scribe | — | API documentation auto-generation (free, open source) |
| rap2hpoutre/laravel-log-viewer | — | Web-based log viewer in admin panel (free) |

### 8.3 Infrastructure

| Technology | Purpose |
|-----------|---------|
| MySQL 8.0+ | Primary relational database |
| Redis 7.x | Cache, sessions, queues, rate limiting |
| TNTSearch (via Laravel Scout) | Full-text search — pure PHP, no external service, runs locally |
| Local Filesystem | File storage (Laravel `local` disk driver); upgrade path to Cloudflare R2 free tier (10 GB/mo) |
| Cloudflare Free CDN | Static asset delivery (unlimited bandwidth, global, free) — proxy via Cloudflare |
| Pusher (free tier) | WebSocket server (200 connections, 200k messages/day — free forever) |
| Brevo (formerly Sendinblue) | Transactional email — free SMTP: 300 emails/day, no credit card required |

### 8.4 Development & DevOps

| Tool | Purpose |
|------|---------|
| Git for Windows + GitHub | Version control (download: git-scm.com) |
| GitHub Actions | CI/CD pipeline (cloud-based, no local setup needed) |
| **Laragon Full** | All-in-one Windows dev environment — PHP 8.3, MySQL 8, Redis, Nginx, Node.js bundled (free, no Docker) |
| **VSCode** | Primary IDE with recommended extensions (see Section D.5) |
| PHP CS Fixer | PHP code formatting (run via Composer, `vendor/bin/php-cs-fixer`) |
| PHPStan level 6 | Static analysis (`vendor/bin/phpstan analyse`) |
| Pest PHP | Modern testing framework (`php artisan test`) |
| Laravel Dusk | Browser testing via ChromeDriver (Windows compatible) |
| Playwright | Cross-browser E2E testing (Windows native via npm) |
| Lighthouse CI | Performance regression testing (npm package, Windows compatible) |
| Flare (free tier) | Error tracking in production |
| UptimeRobot (free tier) | Uptime monitoring (50 monitors free) |
| Laravel Forge | Deployment management (optional) |

---

## 9. Security Requirements

### 9.1 Authentication Security (Enhanced)

```php
// 2FA TOTP Verification
class TwoFactorAuthService {
    public function verify(User $user, string $code): bool {
        return $this->totp->verify($user->two_factor_secret, $code)
            || $this->validateRecoveryCode($user, $code);
    }
}

// Session security
Session::regenerate();           // On every login
Session::put('ip_at_login', $request->ip());  // Detect session hijack

// OAuth token storage: encrypted in user_providers
$token = Crypt::encrypt($token);
```

### 9.2 Content Security Policy
```
Content-Security-Policy:
  default-src 'self';
  script-src 'self' cdn.jsdelivr.net cdnjs.cloudflare.com 'nonce-{CSP_NONCE}';
  style-src 'self' fonts.googleapis.com 'nonce-{CSP_NONCE}';
  font-src 'self' fonts.gstatic.com;
  img-src 'self' data: *.amazonaws.com *.cloudfront.net;
  connect-src 'self' api.openai.com *.pusher.com;
  frame-src 'self' www.youtube.com player.vimeo.com;
  object-src 'none';
  base-uri 'self';
```

### 9.3 File Security
```php
// Secure file upload pipeline
class FileUploadService {
    public function upload(UploadedFile $file, User $user): Resource {
        // 1. Validate MIME type (not just extension)
        $this->validateMimeType($file);
        
        // 2. Validate MIME type server-side using PHP finfo (built-in, no external service)
        // Windows Defender on host provides OS-level real-time protection
        
        // 3. Generate random filename (never use original)
        $filename = Str::random(40) . '.' . $file->extension();
        
        // 4. Store outside public web root
        $path = Storage::disk('s3-private')->put("users/{$user->id}/{$filename}", $file);
        
        // 5. Record original filename for display
        return Resource::create(['file_path' => $path, 'title' => $file->getClientOriginalName()]);
    }
}
```

---

## 10. API Specification

### 10.1 API Versioning
Base URL: `/api/v1/`
All endpoints require authenticated session (CSRF token) or Bearer token (Sanctum API token for webhook/external access).

### 10.2 New Endpoints vs. v1.0

In addition to all v1.0 endpoints, v2.0 adds:

```
-- AI Endpoints
POST  /api/v1/ai/generate-roadmap          Generate roadmap from goal/JD/URL
POST  /api/v1/ai/generate-flashcards/{id}  Generate flashcards for a topic
POST  /api/v1/ai/suggest-resources/{id}    Get AI resource suggestions
POST  /api/v1/ai/chat                       AI coach chat message
GET   /api/v1/ai/schedule                  Get AI-generated weekly schedule

-- SRS Endpoints
GET   /api/v1/decks                         List flashcard decks
POST  /api/v1/decks                         Create deck
GET   /api/v1/decks/{id}/cards              List cards in deck
POST  /api/v1/decks/{id}/cards              Add card to deck
POST  /api/v1/decks/{id}/review             Submit review rating
GET   /api/v1/review/due                    Get cards due today (all decks)
GET   /api/v1/review/stats                  SRS statistics

-- Gamification Endpoints
GET   /api/v1/xp/history                    XP transaction history
GET   /api/v1/achievements                  All achievements with earned status
GET   /api/v1/badges                        All badges with earned status
GET   /api/v1/leaderboard?period=week       Leaderboard data
GET   /api/v1/challenges/today              Today's daily challenges
POST  /api/v1/challenges/{id}/complete      Mark challenge complete

-- Social Endpoints
POST  /api/v1/users/{id}/follow             Follow a user
DELETE /api/v1/users/{id}/follow            Unfollow
GET   /api/v1/feed                          Activity feed (following)
GET   /api/v1/explore/roadmaps             Public roadmap explorer
POST  /api/v1/roadmaps/{id}/rate            Rate a public roadmap
POST  /api/v1/roadmaps/{id}/bookmark        Bookmark a public roadmap
GET   /api/v1/mentors                       Browse mentor directory
POST  /api/v1/mentors/{id}/request          Send mentorship request

-- Journal Endpoints
GET   /api/v1/journal                       List journal entries
POST  /api/v1/journal                       Create/update today's entry
GET   /api/v1/journal/{date}                Get entry for a date
POST  /api/v1/mood                          Log today's mood

-- Productivity Endpoints
POST  /api/v1/pomodoro                      Start/complete Pomodoro session
GET   /api/v1/habits                        List user habits
POST  /api/v1/habits                        Create habit
POST  /api/v1/habits/{id}/log              Mark habit complete for today

-- Analytics Endpoints
GET   /api/v1/analytics/heatmap             52-week activity heatmap data
GET   /api/v1/analytics/velocity            Learning velocity metrics
GET   /api/v1/analytics/retention           SRS retention analytics
GET   /api/v1/analytics/report/weekly       Weekly report card data

-- Integration Endpoints
POST  /api/v1/integrations/github/connect   Connect GitHub account
POST  /api/v1/integrations/notion/import    Import from Notion
POST  /api/v1/integrations/calendar/sync    Sync to Google Calendar
GET   /api/v1/webhooks                      List webhooks
POST  /api/v1/webhooks                      Create webhook
DELETE /api/v1/webhooks/{id}                Delete webhook

-- PWA Endpoints
POST  /api/v1/push-subscriptions            Register push subscription
DELETE /api/v1/push-subscriptions/{id}      Unregister push subscription

-- Admin Endpoints (role=admin)
GET   /api/v1/admin/stats                   Platform metrics
GET   /api/v1/admin/users                   User management list
PATCH /api/v1/admin/users/{id}/suspend      Suspend user
GET   /api/v1/admin/reports                 Moderation queue
PATCH /api/v1/admin/reports/{id}/resolve    Resolve report
```

---

## 11. Feature Breakdown & Prioritization

### 11.1 Priority Tiers

**Tier 1 — Core MVP (Must Have):**
Authentication (Email + OAuth), Roadmap CRUD, Topic Management, Block Editor, Resource Library, Progress Tracking, Certificate Generation, Basic Analytics Dashboard, Notification System

**Tier 2 — Engagement Features (High Priority):**
Gamification (XP/Badges/Streaks), SRS/Flashcards, AI Roadmap Generator, Dark Mode, PWA/Offline, Activity Heatmap, Community Profiles, Public Roadmap Explorer, Multi-view Roadmap (Kanban, Timeline)

**Tier 3 — Differentiation Features (Medium Priority):**
AI Chat Coach, Pomodoro Timer + Focus Mode, Journal & Mood Tracking, Habit Tracker, Team Workspaces, Mentorship System, Learning Groups, Google Calendar Integration

**Tier 4 — Enterprise & Power Features (Lower Priority):**
Browser Extension, n8n Automation Integration, Notion Integration, Learning Groups Advanced Features, Admin Panel, Skill Matrix & Gap Analysis, Leaderboards

### 11.2 Implementation Phases

| Phase | Duration | Focus |
|-------|----------|-------|
| **Phase 1: Foundation** | Weeks 1–6 | Auth, roadmaps, topics, block editor, resources, progress, certificates |
| **Phase 2: Engagement** | Weeks 7–12 | Gamification, SRS, AI generator, dark mode, PWA, heatmap, analytics |
| **Phase 3: Community** | Weeks 13–18 | Public profiles, explore, social, mentorship, groups |
| **Phase 4: Productivity** | Weeks 19–22 | Pomodoro, focus mode, journal, mood, habits |
| **Phase 5: Integrations** | Weeks 23–26 | GitHub, Calendar, Notion, n8n webhooks |
| **Phase 6: Enterprise** | Weeks 27–32 | Team workspaces, admin, skill matrix, advanced analytics |

---

## 12. Implementation Roadmap

### 12.1 Revised 3-Day Sprint Focus (MVP)

> **Windows Setup Prerequisite (30 min, one-time):**
> Before Day 1 — install Laragon Full, VSCode, and Git for Windows.
> Full setup guide is in Appendix D.3. Once Laragon is running, all three days
> use only `php artisan`, `npm`, and `composer` commands in the VSCode terminal.

**Day 1: Core Foundation (8–10 hours)**
- Laragon already running → `composer create-project laravel/laravel learnforge` in `C:\laragon\www`
- Laravel 12.x + MySQL + Redis configured (Laragon bundles all three — zero extra setup)
- TNTSearch configured via Laravel Scout — no additional service needed
- Authentication: email/password + Google/GitHub OAuth
- Base UI system: Tailwind v4, Alpine.js, dark mode support, design tokens
- Navigation layout (sidebar + top bar + mobile bottom nav)
- Keep 3 VSCode terminals open: `php artisan serve` | `npm run dev` | `php artisan queue:work`

**Day 2: Backend Engine (10–12 hours)**
- All 50 table migrations (focus on Tier 1 tables first)
- Models + Eloquent relationships + service layer
- Roadmap + Topic + Resource CRUD with form validation
- Block-based editor backend (JSON storage)
- Progress calculation engine
- Certificate generation service

**Day 3: Frontend & Integration (10–12 hours)**
- Dashboard UI with stat cards, heatmap stub, roadmap cards
- Roadmap detail: list view + Kanban view
- Topic management UI with block editor
- Resource library UI (file upload, link preview, notes)
- Progress visualization (charts, progress bars, milestone tracking)
- Certificate preview + PDF download
- Mobile responsive polish
- Comprehensive feature testing

### 12.2 Extended Roadmap (Full Platform, 32 Weeks)

```
Weeks 1–6:   Foundation (Day 1-3 sprint) + UI polish + Testing
Weeks 7–8:   Gamification layer (XP, badges, streaks, daily challenges)
Weeks 9–10:  SRS/Flashcard system + SM-2 engine
Weeks 11–12: AI features (roadmap generator, AI assistant, recommendations)
Weeks 13–14: PWA + Service Worker + Push notifications
Weeks 15–16: Advanced analytics + activity heatmap + weekly reports
Weeks 17–18: Social: public profiles, explorer, follow system, comments
Weeks 19–20: Mentorship system + learning groups
Weeks 21–22: Pomodoro + Focus mode + Journal + Mood + Habits
Weeks 23–24: Google OAuth integration, Calendar sync, GitHub integration
Weeks 25–26: Notion + Slack + n8n webhook documentation + outbound webhooks
Weeks 27–28: Team workspaces + collaborative editing (Pusher broadcast)
Weeks 29–30: Admin panel + moderation + feature flags
Weeks 31–32: Skill matrix + gap analysis + performance audit + security audit
```

---

## 13. Third-Party Integrations

| Service | Type | Purpose | Cost | Auth Method |
|---------|------|---------|------|-------------|
| **Google Gemini 1.5 Flash** | AI API | Roadmap generation, AI coach, quiz synthesis | **Free** (15 RPM, 1M tokens/day) | API Key (server-side) |
| **Google OAuth** | Identity | Login with Google | **Free** | OAuth 2.0 |
| **GitHub OAuth** | Identity | Login with GitHub, repo linking, Gist backup | **Free** | OAuth 2.0 |
| **LinkedIn OAuth** | Identity | Login with LinkedIn | **Free** | OAuth 2.0 |
| **Pusher Channels** | WebSockets | Real-time notifications, presence, collaboration | **Free** (200 conns, 200k msg/day) | App Key |
| **Brevo SMTP** | Email | Transactional + digest emails | **Free** (300/day, no card) | SMTP credentials |
| **Local Filesystem** | Storage | File and image storage | **Free** (server disk) | Laravel driver |
| **Cloudflare** | CDN | Static assets, DDoS, minification | **Free** plan | DNS proxy |
| **TNTSearch** | Search | Full-text search (local, no service) | **Free** (pure PHP) | Composer package |
| **ip-api.com** | Geolocation | Login location for security alerts | **Free** (45 req/min) | HTTP JSON (no key) |
| **Unsplash API** | Images | Roadmap cover image picker | **Free** (50 req/hr) | Demo API Key |
| **YouTube IFrame API** | Video | Embedded player + timestamp notes | **Free** | No key for embed |
| **GitHub Gist API** | Backup | Auto-backup roadmaps as private Gists | **Free** | OAuth token |
| **Google Calendar API** | Calendar | Study session sync | **Free** (quota-based) | OAuth 2.0 |
| **Notion API** | Notes | Import/export | **Free** (public integration) | OAuth 2.0 |
| **Slack Incoming Webhooks** | Messaging | Progress notifications to Slack | **Free** | Webhook URL |
| **n8n** (Windows, npm) | Automation | No-code workflow automation | **Free** (open source, npm install) | Webhook |
| **PHP finfo + Windows Defender** | Security | File upload MIME validation + OS-level AV | **Free** (built-in PHP + Windows) | No setup |
| **FingerprintJS CE** | Security | Device fingerprinting | **Free** (Community Edition) | JS library |
| **Soketi** (optional, npm) | WebSockets | Pusher-compatible local dev server (Windows) | **Free** (npm install -g @soketi/soketi) | Pusher protocol |
| **UptimeRobot** | Monitoring | Uptime monitoring, alerts | **Free** (50 monitors) | Dashboard |
| **Flare** | Error Tracking | Laravel-native error tracking | **Free** (10k errors/month) | DSN Key |
| **Laravel Telescope** | Debug | Dev-time request/query debugger | **Free** (Laravel package) | Built-in |

**Total cost of all services: $0.00/month**

---

## 14. Accessibility Standards

### 14.1 WCAG 2.2 Level AA Compliance

| Criterion | Implementation |
|-----------|----------------|
| 1.1.1 Non-text Content | All images have descriptive `alt` text; decorative images use `alt=""` |
| 1.3.1 Info and Relationships | Semantic HTML throughout: `<nav>`, `<main>`, `<article>`, `<section>`, proper heading hierarchy |
| 1.4.3 Contrast Minimum | All text achieves 4.5:1 contrast ratio; UI components 3:1 minimum |
| 1.4.10 Reflow | Content reflows without horizontal scroll at 320px width |
| 1.4.11 Non-text Contrast | Interactive elements (buttons, inputs) have 3:1 contrast against background |
| 2.1.1 Keyboard | All features operable via keyboard; no keyboard traps except intentional modals |
| 2.4.3 Focus Order | Focus order follows logical reading order |
| 2.4.7 Focus Visible | Custom visible focus ring on all focusable elements |
| 2.5.3 Label in Name | Button/link text matches accessible name |
| 3.1.1 Language of Page | `<html lang="en">` (or user's locale) |
| 3.3.1 Error Identification | Form errors identify the field and describe the issue |
| 4.1.2 Name, Role, Value | All UI components have appropriate ARIA roles and states |
| 4.1.3 Status Messages | Status messages (toasts, alerts) use `role="status"` or `role="alert"` |

### 14.2 Additional Accessibility Features
- Skip navigation link at page start: "Skip to main content"
- Drag-and-drop has keyboard-accessible alternative (arrow keys to move items)
- All charts have data table alternatives
- SRS card review supports keyboard-only operation (no mouse required)
- Screen reader announcements for: progress updates, completions, XP gains, toast messages

---

## 15. Internationalization & Localization

### 15.1 i18n Architecture

- Laravel's native localization (`lang/` directory) for all user-facing strings
- Language files: `en.php` (default), with structure for translation files
- User locale stored in `users.locale` (defaults to browser `Accept-Language`)
- Locale selector in profile settings
- Number formatting via PHP `NumberFormatter` (dates, hours, XP values)
- Date/time: always stored as UTC in database; displayed in `users.timezone`
- Pluralization rules handled via Laravel's `trans_choice()`

### 15.2 Initial Language Support
- Phase 1: English (en) only
- Phase 2 (post-launch): Bangla (bn), Arabic (ar, RTL), Spanish (es), French (fr), Hindi (hi), Portuguese (pt), German (de)
- RTL layout support via Tailwind's `rtl:` modifier and `dir="rtl"` on `<html>`

---

## Appendix A: Glossary

| Term | Definition |
|------|-----------|
| **Roadmap** | A structured, user-defined learning plan containing phases, topics, and resources |
| **Topic** | An individual learning unit within a roadmap representing a specific skill or concept |
| **Phase** | A named grouping of topics within a roadmap (e.g., "Phase 1: Fundamentals") |
| **Resource** | Supporting material (file, link, note, video, voice note, code) attached to a topic |
| **Flashcard Deck** | A collection of spaced repetition cards linked to a topic for knowledge retention |
| **SM-2** | SuperMemo 2 algorithm — the scientific algorithm used to schedule flashcard reviews |
| **XP** | Experience Points — the gamification currency earned through learning activity |
| **Composite Score** | Weighted combination of completion %, time efficiency, and quality ratings (0–100) |
| **Streak** | Consecutive days of learning activity tracked for motivation and habit formation |
| **SRS** | Spaced Repetition System — a learning technique using increasing review intervals |
| **Pomodoro** | 25-minute focused work session followed by a 5-minute break |
| **PWA** | Progressive Web App — web app installable on devices with offline capability |
| **Mentorship** | A formal relationship where an experienced user guides a learner through their roadmap |
| **Certificate** | An achievement document generated on roadmap completion, verifiable via UUID |
| **Leaderboard** | A ranking of users by XP, opt-in, for social motivation |
| **Skill Matrix** | Visual radar chart of a user's skills by proficiency level |
| **Activity Heatmap** | GitHub-style visualization of daily learning activity over 52 weeks |
| **Focus Mode** | A distraction-free full-screen interface for deep work on a single topic |
| **Block Editor** | A Notion-style content editor where content is composed of modular blocks |
| **WCAG** | Web Content Accessibility Guidelines — international accessibility standard |

---

## Appendix B: Design Inspiration References

| Platform | Borrowed Elements |
|---------|-------------------|
| **Linear** | Command palette (Cmd+K), keyboard shortcuts, performance-first mindset |
| **Notion** | Block editor architecture, flexible page organization |
| **GitHub** | Activity heatmap, profile stats, code blocks |
| **Duolingo** | Streak mechanics, daily challenges, celebration animations, progress nudges |
| **Vercel Dashboard** | Stat cards, dark theme aesthetic, clean data presentation |
| **Anki** | SM-2 SRS algorithm, card review UI concepts |
| **Obsidian** | Bi-directional linking concept (topic @mentions), knowledge graph |
| **Todoist** | Karma system inspiration for XP design |

---

## Appendix C: Technology Documentation References

- Laravel 12.x: https://laravel.com/docs/12.x
- Alpine.js 3.x: https://alpinejs.dev
- Tailwind CSS v4: https://tailwindcss.com/docs
- Chart.js 4.x: https://www.chartjs.org/docs/
- D3.js 7.x: https://d3js.org
- SM-2 Algorithm: https://www.supermemo.com/en/blog/application-of-a-computer-to-improve-the-results-obtained-in-working-with-the-supermemo-method
- TNTSearch Laravel Scout Driver: https://github.com/teamtnt/laravel-scout-tntsearch-driver
- Laravel Horizon: https://laravel.com/docs/12.x/horizon
- WCAG 2.2: https://www.w3.org/TR/WCAG22/
- Google Gemini API (free tier): https://ai.google.dev/gemini-api/docs
- Pusher Free Tier: https://pusher.com/channels (free plan, no credit card)
- Laravel Echo + Pusher: https://laravel.com/docs/broadcasting
- Brevo Free SMTP: https://www.brevo.com/free-smtp-server/
- n8n Self-Hosted Automation: https://docs.n8n.io
- Flare Error Tracking (free): https://flareapp.io
- UptimeRobot Free Monitoring: https://uptimerobot.com

---

## Document History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | Dec 11, 2024 | Initial | Complete SRS document created |
| 2.0 | Mar 2026 | Masterclass Revision | Complete overhaul: 17 new feature modules, 50-table schema, design system, 32-week roadmap |
| 2.1 | Mar 2026 | Free Stack Edition | All paid services replaced with free equivalents; Pusher free tier for WebSockets |
| 3.0 | Mar 2026 | Industry Grade Expansion | +18 new feature sections (real-time Pusher engine, extended block editor, SEO/OG/RSS, import/export, keyboard shortcuts, advanced search, roadmap health, AI learning paths, study buddies, QR codes, embeds, accessibility, API tokens, dev badges, Scribe docs, certificate portfolio, GitHub Gist backup, Unsplash, YouTube timestamps, IP geolocation, fingerprinting, honeypot). 66 DB tables. $0/month. |
| 4.0 | Mar 2026 | Windows + VSCode Edition | Replaced all Docker/Linux-specific tooling: Laravel Sail→Laragon Full, ClamAV→PHP finfo+Windows Defender, Docker Soketi→npm Soketi, Docker n8n→npm n8n, added complete Windows setup guide (Laragon, VSCode extensions, Mailpit.exe, 3-terminal workflow, PowerShell commands), updated all shell commands to Windows-compatible. No Docker, no WSL, no virtual machines. Primary IDE: VSCode. |

---

## Appendix D: Free Technology Stack — Complete Reference

This appendix documents every service used in LearnForge and confirms it requires **zero paid subscription or credit card**.

### D.1 Free Stack Summary Table

| Category | Service Chosen | Free Limits | Paid Alternative (Avoided) |
|----------|---------------|-------------|---------------------------|
| **AI API** | Google Gemini 1.5 Flash | 15 RPM, 1M tokens/day, no credit card | OpenAI GPT-4o ($0.005/1K tokens) |
| **WebSockets** | Pusher free tier | 200 connections, 200k messages/day | Pusher paid ($49+/mo) |
| **Email (SMTP)** | Brevo free tier | 300 emails/day, no credit card | Mailgun ($35/mo), SES ($0.10/1K) |
| **File Storage** | Laravel Local Disk | Server disk space only | AWS S3 ($0.023/GB/mo) |
| **CDN** | Cloudflare free plan | Unlimited bandwidth | CloudFront (~$0.0085/GB), Bunny CDN |
| **Full-text Search** | TNTSearch (PHP library) | Unlimited (local, in-process) | Meilisearch Cloud ($30+/mo) |
| **Error Tracking** | Flare free tier | 10,000 exceptions/month | Sentry ($26/mo) |
| **Uptime Monitor** | UptimeRobot free | 50 monitors, 5-min intervals | PagerDuty ($21+/mo/user) |
| **Automation** | n8n (Windows, npm install) | Unlimited workflows | Zapier ($20+/mo) |
| **2FA** | TOTP only (authenticator app) | Unlimited | Twilio/Vonage SMS (~$0.05/SMS) |
| **Payments** | None (no premium tier) | N/A | Stripe (2.9% + 30¢/transaction) |
| **Blockchain** | SHA-256 fingerprint (local) | Free (no service needed) | Chainpoint, OpenTimestamps paid tiers |
| **LinkedIn Post** | URL-based share | Free (URL parameter API) | LinkedIn Partner Program (invite-only) |
| **Virus Scan** | PHP finfo + Windows Defender (built-in) | Unlimited (OS-level) | Paid AV APIs |
| **Auth (Social)** | Google + GitHub + LinkedIn OAuth | Free (OAuth 2.0 standard) | — |
| **Geolocation** | ip-api.com | 45 req/min, no API key | MaxMind GeoIP2 ($24+/mo) |
| **Cover Images** | Unsplash API | 50 req/hr demo key | Getty Images, Shutterstock |
| **Video Player** | YouTube IFrame API | Unlimited (Google free) | Vimeo Pro ($20+/mo) |
| **QR Codes** | simple-qrcode (PHP) | Unlimited (local generation) | QR API services ($5+/mo) |
| **Device Security** | FingerprintJS CE | Unlimited (open source) | FingerprintJS Pro ($99+/mo) |
| **API Docs** | Scribe (open source) | Unlimited | ReadMe, Stoplight ($99+/mo) |
| **OG Images** | PHP/GD + Browsershot | Free (server CPU) | Cloudinary, imgix ($99+/mo) |
| **Gist Backup** | GitHub Gist API | Unlimited (free GitHub) | Paid backup services |
| **Sitemap/RSS** | spatie/laravel-sitemap | Unlimited (local generation) | Yoast ($99+/yr) |
| **iCal Export** | spatie/ical-component | Unlimited (local generation) | Calendar API services |
| **Honeypot** | Custom middleware | Unlimited (no service) | reCAPTCHA Enterprise ($) |

**Total monthly cost of all third-party services: $0.00**

---

### D.2 Setup Instructions for Free Services

#### Google Gemini API (Free AI)
```
1. Go to: https://aistudio.google.com/app/apikey
2. Sign in with Google account (no credit card required)
3. Click "Create API Key" → copy the key
4. Add to .env: GEMINI_API_KEY=your_key_here
5. Free quota: 15 requests/minute, 1,500 requests/day, 1M tokens/day
```

#### Brevo Free SMTP (Email)
```
1. Register at: https://www.brevo.com (free, no credit card)
2. Go to SMTP & API → SMTP tab
3. Copy: Host, Port (587), Login, Password
4. Add to .env:
   MAIL_MAILER=smtp
   MAIL_HOST=smtp-relay.brevo.com
   MAIL_PORT=587
   MAIL_USERNAME=your_brevo_login
   MAIL_PASSWORD=your_brevo_smtp_password
   MAIL_ENCRYPTION=tls
5. Free quota: 300 emails/day, 9,000/month
```

#### Pusher Free Tier (WebSockets / Real-time)
```
1. Register at: https://pusher.com (free, no credit card required)
2. Create a new "Channels" app → choose free plan
   - Free tier: 200 concurrent connections, 200,000 messages/day
3. Copy: App ID, App Key, App Secret, Cluster
4. Add to .env:
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your_app_id
   PUSHER_APP_KEY=your_app_key
   PUSHER_APP_SECRET=your_app_secret
   PUSHER_APP_CLUSTER=ap2   (choose cluster closest to your region)

5. Install Pusher PHP SDK:
   composer require pusher/pusher-php-server

6. Install Laravel Echo + Pusher JS:
   npm install --save-dev laravel-echo pusher-js

7. In app.js / bootstrap.js:
   import Echo from 'laravel-echo';
   import Pusher from 'pusher-js';
   window.Echo = new Echo({
     broadcaster: 'pusher',
     key: import.meta.env.VITE_PUSHER_APP_KEY,
     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
   });
```

#### TNTSearch (Full-Text Search)
```bash
# Install via Composer
composer require teamtnt/laravel-scout-tntsearch-driver

# Add to .env:
SCOUT_DRIVER=tntsearch

# Models to add: use Laravel\Scout\Searchable trait
# Indexing happens automatically in the local database — no external service needed
php artisan scout:import "App\Models\Roadmap"
php artisan scout:import "App\Models\Topic"
php artisan scout:import "App\Models\Resource"
```

#### Cloudflare Free CDN (Static Assets)
```
1. Add your domain to Cloudflare (free account at cloudflare.com)
2. Update nameservers at your registrar to Cloudflare's
3. Enable "Proxy" (orange cloud) on your A/CNAME records
4. All static assets (CSS, JS, images) are automatically CDN-served
5. Enable: Auto Minify, Brotli compression, HTTP/2 — all free
```

#### Flare (Error Tracking)
```
1. Register at: https://flareapp.io (free: 10,000 errors/month)
2. Create a project → copy the DSN key
3. Install: composer require facade/flare-client-php
4. Add to .env: FLARE_KEY=your_flare_key
5. Errors are automatically reported from Laravel's exception handler
```

#### UptimeRobot (Uptime Monitoring)
```
1. Register at: https://uptimerobot.com (free: 50 monitors)
2. Add new monitor: HTTP(S) monitor → your domain URL
3. Set check interval: 5 minutes (free tier)
4. Set alert contacts: your email (free)
5. Get status page URL to share (free public status page included)
```

#### n8n on Windows (Automation)
```powershell
# Install n8n globally via npm (no Docker required)
npm install -g n8n

# Start n8n (run in any terminal - PowerShell, CMD, or VSCode terminal)
n8n start

# Access UI at: http://localhost:5678
# To run n8n as a background Windows service, use pm2:
npm install -g pm2
pm2 start n8n
pm2 save
pm2 startup   # Auto-start on Windows boot

# Configure LearnForge webhook URL in n8n as the trigger
# Connect to any of n8n's 400+ free integrations
```

---

### D.3 Windows Local Development Stack (100% Free, No Docker)

**Primary tool: Laragon Full** — the best all-in-one Windows development environment for PHP/Laravel.
It bundles PHP 8.3, MySQL 8, Redis, Nginx, Node.js, and Git in a single portable installer with zero configuration required.

#### Step 1: Install Laragon Full
```
1. Download Laragon Full from: https://laragon.org/download/
   → Choose "laragon-full.exe" (includes PHP, MySQL, Node.js, Redis, Git, Nginx — ~180MB)
2. Run installer → install to C:\laragon  (avoid spaces in path)
3. Launch Laragon → click "Start All"
4. Laragon auto-creates a virtual host for every folder in C:\laragon\www\
   → Access your app at: http://learnforge.test  (auto HTTPS with local cert)
```

#### Step 2: Install Required Software (Windows native)
```
Software          | Download From                       | Notes
──────────────────────────────────────────────────────────────────
PHP 8.3           | Bundled in Laragon                  | No separate install
MySQL 8.0         | Bundled in Laragon                  | HeidiSQL included as GUI
Redis 7           | Bundled in Laragon                  | Auto-starts with Laragon
Node.js 20 LTS    | https://nodejs.org/en/download      | Install MSI, adds npm globally
Composer 2        | https://getcomposer.org/download    | Windows .exe installer
Git for Windows   | https://git-scm.com/download/win    | Includes Git Bash
VSCode            | https://code.visualstudio.com       | Primary IDE
```

#### Step 3: Create the Laravel Project
```powershell
# Open VSCode terminal (Ctrl + `) or PowerShell
# Navigate to Laragon www folder
cd C:\laragon\www

# Create Laravel 12 project
composer create-project laravel/laravel learnforge

# Laragon auto-detects the new folder — access at http://learnforge.test

# Enter project directory
cd learnforge

# Install npm dependencies
npm install

# Copy environment file
copy .env.example .env
php artisan key:generate
```

#### Step 4: Configure .env for Laragon
```env
APP_NAME=LearnForge
APP_URL=http://learnforge.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learnforge
DB_USERNAME=root
DB_PASSWORD=          # Laragon default: empty password

REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null   # Laragon Redis: no password

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=ap2

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025       # Mailpit (see Step 6)
MAIL_USERNAME=null
MAIL_PASSWORD=null

QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
SCOUT_DRIVER=tntsearch
```

#### Step 5: Run Migrations and Start Services
```powershell
# Run database migrations
php artisan migrate --seed

# Start Vite dev server (asset compilation + hot reload)
npm run dev

# Start Laravel queue worker (for background jobs: AI, PDF, emails)
# Open a second VSCode terminal (Ctrl+Shift+`) and run:
php artisan queue:work redis --tries=3

# Start Laravel scheduler (for daily reports, SRS reminders, sitemap)
# Open a third VSCode terminal and run:
php artisan schedule:work

# Access your app at: http://learnforge.test
```

#### Step 6: Email Testing with Mailpit (Windows)
```
Mailpit is a lightweight email catcher for local development (no external service).

1. Download Mailpit for Windows from: https://github.com/axllent/mailpit/releases
   → Download: mailpit-windows-amd64.zip
2. Extract mailpit.exe to C:\laragon\bin\mailpit\
3. Run: mailpit.exe  (or add to Windows startup)
4. Web UI available at: http://localhost:8025
   → All emails sent by Laravel are captured here instantly
5. .env is already configured above (port 1025)
```

#### Step 7: VSCode Extensions (Recommended)
Install these free VSCode extensions for the best Laravel + PHP development experience:

```
Extension Name                    | Publisher       | Purpose
──────────────────────────────────────────────────────────────────────
PHP Intelephense                  | Ben Mewburn     | PHP intellisense, auto-complete
Laravel Extension Pack            | Winnie Lin      | Blade, routes, Eloquent helpers
Tailwind CSS IntelliSense         | Tailwind Labs   | Class autocomplete + hover preview
Alpine.js IntelliSense            | Adrian Wilczyński| Alpine.js directives autocomplete
ESLint                            | Microsoft       | JavaScript linting
Prettier - Code formatter         | Prettier        | Auto-format JS/CSS/JSON
GitLens                           | GitKraken       | Enhanced Git integration
Thunder Client                    | Thunder Client  | API testing (like Postman, built-in)
MySQL (for Laragon DB)            | cweijan         | Database GUI inside VSCode
DotENV                            | mikestead       | .env file syntax highlighting
PHP CS Fixer                      | junstyle        | Auto-format PHP on save
Error Lens                        | Alexander       | Inline error display
TODO Highlight                    | Wayou Liu       | Highlight TODO/FIXME comments
Auto Rename Tag                   | Jun Han         | Sync rename HTML/Blade tags
Bracket Pair Colorizer 2          | CoenraadS       | Colored bracket matching
```

**VSCode settings.json additions for this project:**
```json
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode",
  "[php]": {
    "editor.defaultFormatter": "junstyle.php-cs-fixer"
  },
  "php-cs-fixer.executablePath": "${workspaceFolder}/vendor/bin/php-cs-fixer",
  "intelephense.environment.phpVersion": "8.3.0",
  "tailwindCSS.includeLanguages": {
    "blade": "html"
  },
  "emmet.includeLanguages": {
    "blade": "html"
  },
  "files.associations": {
    "*.blade.php": "blade"
  },
  "terminal.integrated.defaultProfile.windows": "PowerShell"
}
```

#### Step 8: Running Tests
```powershell
# Run all tests
php artisan test

# Run with coverage (requires Xdebug — bundled in Laragon)
php artisan test --coverage

# Run specific test file
php artisan test --filter=RoadmapTest

# Run Pest tests
./vendor/bin/pest

# Run Laravel Dusk (browser tests) — requires ChromeDriver
php artisan dusk
```

#### Step 9: Common Windows-Specific Artisan Commands
```powershell
# Clear all caches
php artisan optimize:clear

# Rebuild search index (TNTSearch)
php artisan scout:import "App\Models\Roadmap"
php artisan scout:import "App\Models\Topic"

# Generate sitemap
php artisan sitemap:generate

# Generate SSL cert for learnforge.test (Laragon built-in)
# Right-click Laragon tray icon → SSL → Generate

# Open Tinker REPL
php artisan tinker
```

#### Step 10: Soketi (Optional — Offline Pusher Development)
If you need WebSockets to work **100% offline** without using your Pusher free quota during dev:
```powershell
# Install Soketi globally via npm (Windows native, no Docker)
npm install -g @soketi/soketi

# Start Soketi (Pusher-compatible server on port 6001)
soketi start

# Update .env for local Soketi:
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http

# Switch back to real Pusher for production by reverting .env
```

---

### D.3.1 Windows Terminal Workflow (3-Terminal Setup)

For active development, keep **3 VSCode terminal tabs** open simultaneously:

| Terminal Tab | Command | Purpose |
|-------------|---------|---------|
| **Tab 1: Dev Server** | `php artisan serve` (or use Laragon) | HTTP server at localhost:8000 |
| **Tab 2: Assets** | `npm run dev` | Vite HMR, Tailwind JIT, Alpine.js |
| **Tab 3: Queue** | `php artisan queue:work` | Background jobs (AI, PDFs, emails) |

Optional 4th tab for scheduler during development:
```powershell
# Tab 4 (optional): Scheduler
php artisan schedule:work
```

**Laragon tray icon services running in background:**
- MySQL 8.0 (port 3306)
- Redis (port 6379)
- Nginx (port 80/443)
- (Mailpit runs separately as mailpit.exe)



---

### D.4 Upgrade Path (When You Grow)

If the platform outgrows free tier limits, here is the natural upgrade path — all still low-cost:

| If You Hit | Upgrade To | Cost |
|-----------|-----------|------|
| Brevo 300 emails/day limit | Brevo paid (20,000/mo) or Resend | ~$9–15/mo |
| Local disk storage full | Cloudflare R2 | $0.015/GB (first 10GB free) |
| Gemini rate limits (15 RPM) | Gemini paid tier | $0.075 per 1M tokens |
| TNTSearch performance at scale | Self-hosted Meilisearch (VPS) | ~$5–10/mo VPS |
| Pusher free tier (200 connections) | Pusher Starter ($49/mo) or Soketi via npm (`npm install -g @soketi/soketi`) | $0 with Soketi |

---



**End of Document — LearnForge SRS v4.0 Windows + VSCode Edition**

*Built to be the world's most complete personal learning operating system.*
*Developed entirely on Windows + VSCode + Laragon. Zero Docker. Zero paid services.*
