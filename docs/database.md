# Database Schema Documentation
## Learning Progress Tracker - Complete Database Design

**Version:** 1.0  
**Last Updated:** December 11, 2025  
**Framework:** Laravel 12.x  
**Database:** MySQL 8.0+  
**ORM:** Eloquent

---

## Table of Contents

1. [Database Overview](#database-overview)
2. [Entity Relationship Diagram](#entity-relationship-diagram)
3. [Complete Table Specifications](#complete-table-specifications)
4. [Relationships](#relationships)
5. [Indexes & Performance](#indexes--performance)
6. [Migration Files](#migration-files)
7. [Seeders](#seeders)
8. [Queries & Examples](#queries--examples)

---

## Database Overview

The Learning Progress Tracker uses **MySQL 8.0+** with the following characteristics:

- **8 Primary Tables**: users, roadmaps, topics, resources, resource_tags, topic_progress, certificates, activity_logs
- **Total Estimated Size**: ~500MB for 10,000 users with average data
- **Character Set**: utf8mb4_unicode_ci (full Unicode support including emojis)
- **Engine**: InnoDB (ACID compliance, foreign key support)
- **Collation**: utf8mb4_unicode_ci

---

## Entity Relationship Diagram

```
┌─────────────────────┐
│       users         │
│  (PK: id)           │
└──────────┬──────────┘
           │
           │ 1:M
           ▼
┌─────────────────────┐
│      roadmaps       │
│  (PK: id)           │
│  (FK: user_id)      │
└──────────┬──────────┘
           │
           │ 1:M
           ▼
┌─────────────────────┐       ┌─────────────────────┐
│       topics        │───────│   topic_progress    │
│  (PK: id)           │  M:M  │  (FK: topic_id,     │
│  (FK: roadmap_id)   │       │       user_id)      │
│  (FK: parent_id)    │       └─────────────────────┘
└──────────┬──────────┘
           │
           │ 1:M
           ▼
┌─────────────────────┐       ┌─────────────────────┐
│     resources       │───────│   resource_tags     │
│  (PK: id)           │  1:M  │  (FK: resource_id)  │
│  (FK: topic_id)     │       └─────────────────────┘
└─────────────────────┘

┌─────────────────────┐
│    certificates     │
│  (PK: id)           │
│  (FK: user_id)      │
│  (FK: roadmap_id)   │
└─────────────────────┘

┌─────────────────────┐
│   activity_logs     │
│  (PK: id)           │
│  (FK: user_id)      │
└─────────────────────┘
```

---

## Complete Table Specifications

### 1. users

**Purpose**: Store user account information and profile data

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| username | VARCHAR(30) | UNIQUE, NOT NULL | Unique username (3-30 chars) |
| email | VARCHAR(255) | UNIQUE, NOT NULL | User email address |
| password | VARCHAR(255) | NOT NULL | Bcrypt hashed password |
| full_name | VARCHAR(100) | NULL | User's full name |
| profession | VARCHAR(100) | NULL | User's profession |
| bio | TEXT | NULL | User biography |
| profile_picture | VARCHAR(255) | NULL | Path to profile image |
| remember_token | VARCHAR(100) | NULL | Laravel "remember me" token |
| email_verified_at | TIMESTAMP | NULL | Email verification timestamp |
| created_at | TIMESTAMP | NOT NULL | Account creation time |
| updated_at | TIMESTAMP | NOT NULL | Last update time |
| deleted_at | TIMESTAMP | NULL | Soft delete timestamp |

**Indexes**:
```sql
PRIMARY KEY (id)
UNIQUE KEY users_username_unique (username)
UNIQUE KEY users_email_unique (email)
INDEX users_deleted_at_index (deleted_at)
```

---

### 2. roadmaps

**Purpose**: Store learning roadmap information and progress

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | References users(id) |
| title | VARCHAR(255) | NOT NULL | Roadmap title |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL-friendly slug |
| description | TEXT | NULL | Detailed description |
| category | VARCHAR(100) | NULL | Category/profession |
| difficulty_level | ENUM | NULL | beginner/intermediate/advanced |
| target_completion_date | DATE | NULL | Target completion date |
| is_public | BOOLEAN | DEFAULT FALSE | Public visibility |
| total_score | DECIMAL(5,2) | DEFAULT 0.00 | Overall score (0-100) |
| progress_percentage | DECIMAL(5,2) | DEFAULT 0.00 | Completion percentage |
| status | ENUM | DEFAULT 'active' | draft/active/completed/archived |
| created_at | TIMESTAMP | NOT NULL | Creation time |
| updated_at | TIMESTAMP | NOT NULL | Last update time |
| deleted_at | TIMESTAMP | NULL | Soft delete timestamp |

**Indexes**:
```sql
PRIMARY KEY (id)
UNIQUE KEY roadmaps_slug_unique (slug)
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
INDEX roadmaps_user_id_index (user_id)
INDEX roadmaps_status_index (status)
INDEX roadmaps_is_public_index (is_public)
INDEX roadmaps_user_status_created (user_id, status, created_at)
```

---

### 3. topics

**Purpose**: Store individual learning topics within roadmaps

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| roadmap_id | BIGINT UNSIGNED | FK, NOT NULL | References roadmaps(id) |
| parent_topic_id | BIGINT UNSIGNED | FK, NULL | Self-referencing for sub-topics |
| title | VARCHAR(255) | NOT NULL | Topic title |
| description | TEXT | NULL | Topic description |
| estimated_hours | DECIMAL(6,2) | NOT NULL | Estimated learning time |
| difficulty_level | ENUM | NULL | beginner/intermediate/advanced |
| order_index | INTEGER | DEFAULT 0 | Display order |
| weight | INTEGER | DEFAULT 1 | Weight for scoring |
| status | ENUM | DEFAULT 'not_started' | not_started/in_progress/completed/skipped |
| completed_at | TIMESTAMP | NULL | Completion timestamp |
| created_at | TIMESTAMP | NOT NULL | Creation time |
| updated_at | TIMESTAMP | NOT NULL | Last update time |

**Indexes**:
```sql
PRIMARY KEY (id)
FOREIGN KEY (roadmap_id) REFERENCES roadmaps(id) ON DELETE CASCADE
FOREIGN KEY (parent_topic_id) REFERENCES topics(id) ON DELETE CASCADE
INDEX topics_roadmap_id_index (roadmap_id)
INDEX topics_parent_topic_id_index (parent_topic_id)
INDEX topics_status_index (status)
INDEX topics_roadmap_order (roadmap_id, order_index)
```

---

### 4. resources

**Purpose**: Store learning resources attached to topics

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| topic_id | BIGINT UNSIGNED | FK, NOT NULL | References topics(id) |
| resource_type | ENUM | NOT NULL | file/link/note/video |
| title | VARCHAR(255) | NOT NULL | Resource title |
| description | TEXT | NULL | Resource description |
| content | TEXT | NULL | Content for notes |
| file_path | VARCHAR(500) | NULL | Storage path for files |
| file_size | BIGINT | NULL | File size in bytes |
| url | VARCHAR(500) | NULL | URL for links/videos |
| is_favorite | BOOLEAN | DEFAULT FALSE | Favorite flag |
| order_index | INTEGER | DEFAULT 0 | Display order |
| created_at | TIMESTAMP | NOT NULL | Creation time |
| updated_at | TIMESTAMP | NOT NULL | Last update time |

**Indexes**:
```sql
PRIMARY KEY (id)
FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
INDEX resources_topic_id_index (topic_id)
INDEX resources_resource_type_index (resource_type)
INDEX resources_is_favorite_index (is_favorite)
```

---

### 5. resource_tags

**Purpose**: Tag system for organizing resources

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| resource_id | BIGINT UNSIGNED | FK, NOT NULL | References resources(id) |
| tag | VARCHAR(50) | NOT NULL | Tag name |
| created_at | TIMESTAMP | NOT NULL | Creation time |

**Indexes**:
```sql
PRIMARY KEY (id)
FOREIGN KEY (resource_id) REFERENCES resources(id) ON DELETE CASCADE
INDEX resource_tags_resource_id_index (resource_id)
INDEX resource_tags_tag_index (tag)
```

---

### 6. topic_progress

**Purpose**: Track detailed progress and time spent on topics

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| topic_id | BIGINT UNSIGNED | FK, NOT NULL | References topics(id) |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | References users(id) |
| actual_hours | DECIMAL(6,2) | DEFAULT 0.00 | Actual time spent |
| quality_rating | TINYINT | NULL | Quality rating (1-5 stars) |
| notes | TEXT | NULL | Progress notes |
| started_at | TIMESTAMP | NULL | Start timestamp |
| completed_at | TIMESTAMP | NULL | Completion timestamp |
| created_at | TIMESTAMP | NOT NULL | Creation time |
| updated_at | TIMESTAMP | NOT NULL | Last update time |

**Indexes**:
```sql
PRIMARY KEY (id)
FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
UNIQUE KEY topic_progress_unique (topic_id, user_id)
INDEX topic_progress_user_id_index (user_id)
```

---

### 7. certificates

**Purpose**: Store generated certificates for completed roadmaps

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| uuid | CHAR(36) | UNIQUE, NOT NULL | UUID for verification |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | References users(id) |
| roadmap_id | BIGINT UNSIGNED | FK, NOT NULL | References roadmaps(id) |
| certificate_number | VARCHAR(50) | UNIQUE, NOT NULL | Certificate number |
| issued_at | TIMESTAMP | NOT NULL | Issue date |
| total_topics | INTEGER | NOT NULL | Number of topics completed |
| total_learning_hours | DECIMAL(8,2) | NOT NULL | Total hours invested |
| topics_summary | JSON | NOT NULL | JSON array of topics |
| template_type | VARCHAR(50) | DEFAULT 'modern' | Certificate template |
| file_path | VARCHAR(500) | NULL | PDF file path |
| verification_url | VARCHAR(500) | NOT NULL | Verification URL |
| created_at | TIMESTAMP | NOT NULL | Creation time |
| updated_at | TIMESTAMP | NOT NULL | Last update time |

**Indexes**:
```sql
PRIMARY KEY (id)
UNIQUE KEY certificates_uuid_unique (uuid)
UNIQUE KEY certificates_certificate_number_unique (certificate_number)
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
FOREIGN KEY (roadmap_id) REFERENCES roadmaps(id) ON DELETE CASCADE
INDEX certificates_user_id_index (user_id)
INDEX certificates_roadmap_id_index (roadmap_id)
```

---

### 8. activity_logs

**Purpose**: Track user actions for analytics and auditing

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | References users(id) |
| action_type | VARCHAR(50) | NOT NULL | Action identifier |
| description | TEXT | NULL | Human-readable description |
| metadata | JSON | NULL | Additional data |
| ip_address | VARCHAR(45) | NULL | User IP address |
| user_agent | VARCHAR(500) | NULL | Browser user agent |
| created_at | TIMESTAMP | NOT NULL | Action timestamp |

**Indexes**:
```sql
PRIMARY KEY (id)
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
INDEX activity_logs_user_id_index (user_id)
INDEX activity_logs_action_type_index (action_type)
INDEX activity_logs_user_date (user_id, created_at)
```

---

## Migration Files

### Migration Order

1. `2024_01_01_000000_create_users_table.php`
2. `2024_01_01_000001_create_password_reset_tokens_table.php`
3. `2024_01_01_000002_create_sessions_table.php`
4. `2024_01_02_000000_create_roadmaps_table.php`
5. `2024_01_03_000000_create_topics_table.php`
6. `2024_01_04_000000_create_resources_table.php`
7. `2024_01_05_000000_create_resource_tags_table.php`
8. `2024_01_06_000000_create_topic_progress_table.php`
9. `2024_01_07_000000_create_certificates_table.php`
10. `2024_01_08_000000_create_activity_logs_table.php`

### Example Migration: Create Roadmaps Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])
                  ->nullable();
            $table->date('target_completion_date')->nullable();
            $table->boolean('is_public')->default(false);
            $table->decimal('total_score', 5, 2)->default(0.00);
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->enum('status', ['draft', 'active', 'completed', 'archived'])
                  ->default('active');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['user_id', 'status', 'created_at']);
            $table->index('is_public');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
```

---

## Seeders

### Database Seeder

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoadmapSeeder::class,
            TopicSeeder::class,
            ResourceSeeder::class,
        ]);
    }
}
```

### User Seeder

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'full_name' => 'Test User',
            'profession' => 'Software Developer',
            'bio' => 'Learning and growing every day',
        ]);

        // Create additional random users
        User::factory(50)->create();
    }
}
```

---

## Queries & Examples

### Common Queries

#### 1. Get User's Active Roadmaps with Progress

```sql
SELECT 
    r.id,
    r.title,
    r.progress_percentage,
    r.total_score,
    COUNT(t.id) as total_topics,
    SUM(CASE WHEN t.status = 'completed' THEN 1 ELSE 0 END) as completed_topics
FROM roadmaps r
LEFT JOIN topics t ON r.id = t.roadmap_id
WHERE r.user_id = ? 
  AND r.status = 'active'
  AND r.deleted_at IS NULL
GROUP BY r.id
ORDER BY r.updated_at DESC;
```

#### 2. Get Roadmap Details with Topics and Resources

```sql
SELECT 
    r.*,
    t.id as topic_id,
    t.title as topic_title,
    t.status as topic_status,
    t.estimated_hours,
    COUNT(res.id) as resource_count
FROM roadmaps r
INNER JOIN topics t ON r.id = t.roadmap_id
LEFT JOIN resources res ON t.id = res.topic_id
WHERE r.id = ?
GROUP BY t.id
ORDER BY t.order_index;
```

#### 3. Calculate Roadmap Progress

```sql
UPDATE roadmaps r
SET 
    progress_percentage = (
        SELECT 
            (COUNT(CASE WHEN status = 'completed' THEN 1 END) * 100.0 / COUNT(*))
        FROM topics
        WHERE roadmap_id = r.id
    ),
    total_score = (
        SELECT 
            (SUM(CASE WHEN status = 'completed' THEN weight ELSE 0 END) * 100.0 / SUM(weight))
        FROM topics
        WHERE roadmap_id = r.id
    )
WHERE r.id = ?;
```

#### 4. Get User's Learning Statistics

```sql
SELECT 
    COUNT(DISTINCT r.id) as total_roadmaps,
    COUNT(DISTINCT CASE WHEN r.status = 'completed' THEN r.id END) as completed_roadmaps,
    COUNT(DISTINCT t.id) as total_topics,
    COUNT(DISTINCT CASE WHEN t.status = 'completed' THEN t.id END) as completed_topics,
    COALESCE(SUM(tp.actual_hours), 0) as total_learning_hours,
    COUNT(DISTINCT c.id) as total_certificates
FROM users u
LEFT JOIN roadmaps r ON u.id = r.user_id AND r.deleted_at IS NULL
LEFT JOIN topics t ON r.id = t.roadmap_id
LEFT JOIN topic_progress tp ON t.id = tp.topic_id AND tp.user_id = u.id
LEFT JOIN certificates c ON u.id = c.user_id
WHERE u.id = ?
GROUP BY u.id;
```

#### 5. Search Roadmaps

```sql
SELECT 
    r.*,
    u.username,
    COUNT(t.id) as topic_count
FROM roadmaps r
INNER JOIN users u ON r.user_id = u.id
LEFT JOIN topics t ON r.id = t.roadmap_id
WHERE 
    r.is_public = true
    AND r.deleted_at IS NULL
    AND (
        r.title LIKE CONCAT('%', ?, '%')
        OR r.description LIKE CONCAT('%', ?, '%')
        OR r.category LIKE CONCAT('%', ?, '%')
    )
GROUP BY r.id
ORDER BY r.created_at DESC
LIMIT 20;
```

---

## Performance Optimization Tips

### 1. Index Usage

- **Always index foreign keys**: Essential for JOIN operations
- **Composite indexes**: For commonly used WHERE clauses with multiple columns
- **Covering indexes**: Include frequently selected columns in index

### 2. Query Optimization

```sql
-- Bad: N+1 Query Problem
SELECT * FROM roadmaps WHERE user_id = ?;
-- Then for each roadmap:
SELECT * FROM topics WHERE roadmap_id = ?;

-- Good: Eager Loading
SELECT 
    r.*,
    t.id as topic_id,
    t.title as topic_title
FROM roadmaps r
LEFT JOIN topics t ON r.id = t.roadmap_id
WHERE r.user_id = ?;
```

### 3. Caching Strategy

```php
// Cache expensive queries
$stats = Cache::remember("user.{$userId}.stats", 3600, function () use ($userId) {
    return DB::table('users')
        ->where('id', $userId)
        ->select(/* complex aggregation */)
        ->first();
});
```

### 4. Pagination

```php
// Always paginate large result sets
$roadmaps = Roadmap::where('is_public', true)
    ->with('topics')
    ->paginate(20);
```

---

## Backup & Maintenance

### Daily Backup Script

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/learning_tracker"
DB_NAME="learning_tracker"
DB_USER="root"
DB_PASS="password"

# Create backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > "$BACKUP_DIR/backup_$DATE.sql.gz"

# Keep only last 30 days
find $BACKUP_DIR -type f -name "backup_*.sql.gz" -mtime +30 -delete
```

### Maintenance Queries

```sql
-- Analyze tables
ANALYZE TABLE users, roadmaps, topics, resources;

-- Optimize tables
OPTIMIZE TABLE users, roadmaps, topics, resources;

-- Check table health
CHECK TABLE users, roadmaps, topics;
```

---

## Conclusion

This database schema provides a robust foundation for the Learning Progress Tracker platform. The design prioritizes:

- **Normalization**: Reducing data redundancy
- **Integrity**: Foreign key constraints ensure data consistency
- **Performance**: Strategic indexing for common queries
- **Scalability**: Efficient structure for growth
- **Flexibility**: JSON fields for extensibility

For implementation details, refer to `backend.md` and the migration files in the `steps/` directory.
