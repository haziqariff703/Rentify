<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Http\Message\UploadedFileInterface;

/**
 * Image Upload Service
 *
 * Centralized service for handling image uploads across the application.
 * Supports user avatars and car images with configurable options.
 */
class ImageUploadService
{
    /**
     * Default allowed MIME types for image uploads
     */
    private const DEFAULT_ALLOWED_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * Default max file size (5MB)
     */
    private const DEFAULT_MAX_SIZE = 5 * 1024 * 1024;

    /**
     * Upload an image file
     *
     * @param UploadedFileInterface $file The uploaded file
     * @param string $targetDir Target directory relative to webroot/img/ (e.g., 'avatars', 'cars')
     * @param string $filenamePrefix Prefix for the generated filename (e.g., 'avatar_123')
     * @param array $options Optional settings: 'allowedTypes', 'maxSize', 'deleteOld' (path to old file)
     * @return array ['success' => bool, 'filename' => string|null, 'error' => string|null]
     */
    public function upload(
        UploadedFileInterface $file,
        string $targetDir,
        string $filenamePrefix,
        array $options = []
    ): array {
        // Check if file was actually uploaded
        if ($file->getError() === UPLOAD_ERR_NO_FILE) {
            return ['success' => false, 'filename' => null, 'error' => null]; // No file is not an error
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            return ['success' => false, 'filename' => null, 'error' => 'File upload failed with error code: ' . $file->getError()];
        }

        // Get options with defaults
        $allowedTypes = $options['allowedTypes'] ?? self::DEFAULT_ALLOWED_TYPES;
        $maxSize = $options['maxSize'] ?? self::DEFAULT_MAX_SIZE;
        $deleteOld = $options['deleteOld'] ?? null;

        // Validate MIME type
        if (!in_array($file->getClientMediaType(), $allowedTypes, true)) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Invalid file type. Allowed: ' . implode(', ', array_map(fn($t) => str_replace('image/', '', $t), $allowedTypes))
            ];
        }

        // Validate file size
        if ($file->getSize() > $maxSize) {
            $maxMB = $maxSize / 1024 / 1024;
            return [
                'success' => false,
                'filename' => null,
                'error' => "File is too large. Maximum size is {$maxMB}MB."
            ];
        }

        // Create target directory if it doesn't exist
        $uploadDir = WWW_ROOT . 'img' . DS . $targetDir;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $safePrefix = preg_replace('/[^a-zA-Z0-9_-]/', '-', $filenamePrefix);
        $newFilename = $safePrefix . '_' . time() . '.' . strtolower($extension);
        $targetPath = $uploadDir . DS . $newFilename;

        // Move uploaded file
        try {
            $file->moveTo($targetPath);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'filename' => null,
                'error' => 'Failed to move uploaded file: ' . $e->getMessage()
            ];
        }

        // Delete old file if requested
        if ($deleteOld && !empty($deleteOld)) {
            $oldPath = WWW_ROOT . 'img' . DS . $deleteOld;
            if (file_exists($oldPath) && is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        // Return the relative path from webroot/img/ (use forward slash for web URLs)
        $relativePath = $targetDir . '/' . $newFilename;

        return [
            'success' => true,
            'filename' => $relativePath,
            'error' => null
        ];
    }

    /**
     * Convenience method for uploading user avatars
     *
     * @param UploadedFileInterface $file The uploaded file
     * @param int|string $userId User ID for filename prefix
     * @param string|null $oldAvatar Path to the old avatar to delete
     * @return array ['success' => bool, 'filename' => string|null, 'error' => string|null]
     */
    public function uploadAvatar(UploadedFileInterface $file, $userId, ?string $oldAvatar = null): array
    {
        return $this->upload($file, 'avatars', 'avatar_' . $userId, [
            'maxSize' => 2 * 1024 * 1024, // 2MB for avatars
            'deleteOld' => $oldAvatar,
        ]);
    }

    /**
     * Convenience method for uploading car images
     *
     * @param UploadedFileInterface $file The uploaded file
     * @param string $brand Car brand
     * @param string $model Car model
     * @param string|null $oldImage Path to the old image to delete
     * @return array ['success' => bool, 'filename' => string|null, 'error' => string|null]
     */
    public function uploadCarImage(UploadedFileInterface $file, string $brand, string $model, ?string $oldImage = null): array
    {
        $prefix = strtolower(str_replace(' ', '-', $brand . '-' . $model));

        return $this->upload($file, 'cars', $prefix, [
            'maxSize' => 5 * 1024 * 1024, // 5MB for car images
            'deleteOld' => $oldImage,
        ]);
    }
}
