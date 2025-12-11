<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttachmentController extends Controller
{
    public function __construct(
        protected AttachmentService $attachmentService
    ) {
    }

    /**
     * Remove the specified attachment
     */
    public function destroy(Attachment $attachment)
    {
        // Authorize - user must own the parent resource
        Gate::authorize('delete', $attachment->attachable);

        $this->attachmentService->deleteAttachment($attachment);

        return back()->with('success', 'File deleted successfully!');
    }
}
