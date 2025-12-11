<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(
        protected CertificateService $certificateService
    ) {
        $this->middleware('auth')->except(['verify']);
    }

    /**
     * Display a listing of certificates.
     */
    public function index(Request $request)
    {
        $certificates = $request->user()
            ->certificates()
            ->with('roadmap')
            ->latest()
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Generate a certificate for a completed roadmap.
     */
    public function generate(Roadmap $roadmap, Request $request)
    {
        if (!$roadmap->isCompleted()) {
            return redirect()
                ->back()
                ->with('error', 'Roadmap must be completed before generating certificate.');
        }

        $certificate = $this->certificateService->generateCertificate(
            $roadmap,
            $request->user()
        );

        return redirect()
            ->route('certificates.show', $certificate)
            ->with('success', 'Certificate generated successfully!');
    }

    /**
     * Display the specified certificate.
     */
    public function show($certificate)
    {
        $certificate = auth()->user()
            ->certificates()
            ->with('roadmap')
            ->findOrFail($certificate);

        return view('certificates.show', compact('certificate'));
    }

    /**
     * Verify a certificate using verification code.
     */
    public function verify($verificationCode)
    {
        $certificate = $this->certificateService->verifyCertificate($verificationCode);

        if (!$certificate) {
            return view('certificates.verify', ['certificate' => null]);
        }

        return view('certificates.verify', compact('certificate'));
    }
}
