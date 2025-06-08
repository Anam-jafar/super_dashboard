<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class S3FileController extends Controller
{
    public function downloadAttachment($filepath)
    {
        try {
            // Decode the filepath
            $decodedPath = base64_decode($filepath);

            // Security validation
            if (!$this->isValidFilePath($decodedPath)) {
                abort(403, 'Unauthorized file access');
            }

            // Check if file exists in S3
            if (!Storage::disk('s3')->exists($decodedPath)) {
                Log::warning('S3 file not found', ['path' => $decodedPath]);
                abort(404, 'File not found');
            }

            // Get file content from S3 (KMS decryption happens automatically)
            $fileContent = Storage::disk('s3')->get($decodedPath);

            if (!$fileContent) {
                Log::error('Failed to retrieve S3 file content', ['path' => $decodedPath]);
                abort(500, 'Error retrieving file content');
            }

            // Get file metadata
            $fileSize = Storage::disk('s3')->size($decodedPath);
            $filename = basename($decodedPath);

            // Determine MIME type
            $mimeType = $this->getMimeType($filename);

            Log::info('S3 file download successful', [
                'path' => $decodedPath,
                'size' => $fileSize,
                'filename' => $filename
            ]);

            // Return file response
            return response($fileContent, 200, [
                'Content-Type' => $mimeType,
                'Content-Length' => $fileSize,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ]);

        } catch (\Exception $e) {
            Log::error('S3 file download error', [
                'filepath' => $filepath,
                'decoded_path' => $decodedPath ?? 'failed to decode',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            abort(500, 'Error retrieving file: ' . $e->getMessage());
        }
    }

    /**
     * Validate file path for security
     */
    private function isValidFilePath($path)
    {
        // Only allow files from fin_statement_attachments directory
        if (!str_starts_with($path, 'fin_statement_attachments/')) {
            return false;
        }

        // Prevent directory traversal attacks
        if (str_contains($path, '..') || str_contains($path, '//')) {
            return false;
        }

        // Only allow PDF files
        if (!str_ends_with(strtolower($path), '.pdf')) {
            return false;
        }

        return true;
    }

    /**
     * Get MIME type based on file extension
     */
    private function getMimeType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
