<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseService
{
    private const IMAGE_PATH = 'courses/images';
    private const VIDEO_PATH = 'courses/videos';
    private const FILE_PATH = 'courses/files';
    
    private const ALLOWED_IMAGES = ['jpg', 'jpeg', 'png'];
    private const ALLOWED_VIDEOS = ['mp4', 'mov'];
    private const ALLOWED_FILES = ['pdf', 'doc', 'docx'];
    
    private const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    private const MAX_VIDEO_SIZE = 100 * 1024 * 1024; // 100MB
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    public function __construct(
        private FileService $fileService
    ) {}

    public function create(array $data, Request $request): Course
    {
        $course = Course::create($data);
        $this->handleFiles($request, $course);
        return $course;
    }

    public function update(Course $course, array $data, Request $request): Course
    {
        $course->update($data);
        $this->handleFiles($request, $course);
        return $course;
    }

    private function handleFiles(Request $request, Course $course): void
    {
        // Handle Image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($this->fileService->validateFile($file, self::ALLOWED_IMAGES, self::MAX_IMAGE_SIZE)) {
                if ($course->image) {
                    $this->fileService->deleteFile(self::IMAGE_PATH . '/' . $course->image);
                }
                $course->image = $this->fileService->uploadFile($file, self::IMAGE_PATH);
            }
        }

        // Handle Video
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            if ($this->fileService->validateFile($file, self::ALLOWED_VIDEOS, self::MAX_VIDEO_SIZE)) {
                if ($course->video) {
                    $this->fileService->deleteFile(self::VIDEO_PATH . '/' . $course->video);
                }
                $course->video = $this->fileService->uploadFile($file, self::VIDEO_PATH);
            }
        }

        // Handle File
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($this->fileService->validateFile($file, self::ALLOWED_FILES, self::MAX_FILE_SIZE)) {
                if ($course->file) {
                    $this->fileService->deleteFile(self::FILE_PATH . '/' . $course->file);
                }
                $course->file = $this->fileService->uploadFile($file, self::FILE_PATH);
            }
        }

        $course->save();
    }
}