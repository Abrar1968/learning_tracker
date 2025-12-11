<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    /**
     * Allowed file types and extensions
     */
    const ALLOWED_TYPES = [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'documents' => ['pdf', 'doc', 'docx', 'txt', 'md', 'rtf'],
        'spreadsheets' => ['xls', 'xlsx', 'csv'],
        'presentations' => ['ppt', 'pptx'],
        'archives' => ['zip', 'rar', '7z'],
    ];

    const MAX_FILE_SIZE = 10240; // 10MB in KB

    /**
     * Upload and attach file to a model
     */
    public function attachFile(Model $model, UploadedFile $file, int $uploadedBy): Attachment
    {
        // Validate file
        $this->validateFile($file);

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;

        // Store file
        $path = $file->storeAs(
            'attachments/' . class_basename($model) . '/' . $model->id,
            $fileName,
            'public'
        );

        // Create attachment record
        return $model->attachments()->create([
            'file_name' => $fileName,
            'file_path' => $path,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'original_name' => $file->getClientOriginalName(),
            'uploaded_by' => $uploadedBy,
        ]);
    }

    /**
     * Upload multiple files
     */
    public function attachFiles(Model $model, array $files, int $uploadedBy): array
    {
        $attachments = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $attachments[] = $this->attachFile($model, $file, $uploadedBy);
            }
        }

        return $attachments;
    }

    /**
     * Delete attachment and file
     */
    public function deleteAttachment(Attachment $attachment): bool
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // Delete database record
        return $attachment->delete();
    }

    /**
     * Validate uploaded file
     */
    protected function validateFile(UploadedFile $file): void
    {
        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE * 1024) {
            throw new \InvalidArgumentException('File size exceeds maximum allowed size of ' . self::MAX_FILE_SIZE . 'KB');
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        $allExtensions = array_merge(...array_values(self::ALLOWED_TYPES));

        if (!in_array($extension, $allExtensions)) {
            throw new \InvalidArgumentException('File type not allowed. Allowed types: ' . implode(', ', $allExtensions));
        }
    }

    /**
     * Get file category based on extension
     */
    public function getFileCategory(string $extension): string
    {
        $extension = strtolower($extension);

        foreach (self::ALLOWED_TYPES as $category => $extensions) {
            if (in_array($extension, $extensions)) {
                return $category;
            }
        }

        return 'other';
    }

    /**
     * Format file size for display
     */
    public function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Check if file is an image
     */
    public function isImage(string $mimeType): bool
    {
        return str_starts_with($mimeType, 'image/');
    }
}
