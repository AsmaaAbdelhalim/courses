<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseService
{
    private const IMAGE_PATH = 'uploads/courses/images';
    private const VIDEO_PATH = 'uploads/courses/videos';
    private const FILE_PATH = 'uploads/courses/files';
    
    private const ALLOWED_IMAGES = ['jpg', 'jpeg', 'png', 'webp'];
    private const ALLOWED_VIDEOS = ['mp4', 'mov', 'webm'];
    private const ALLOWED_FILES = ['pdf', 'doc', 'docx'];
    
    private const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    private const MAX_VIDEO_SIZE = 100 * 1024 * 1024; // 100MB
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    public function __construct(private FileService $fileService)
    {}

    public function createCourse(array $data, Request $request): Course
    {
        return DB::transaction(function () use ($data, $request) {
            $course = Course::create($data);
            $this->handleCourseFiles($request, $course);
            return $course;
        });
    }

    public function updateCourse(Course $course, array $data, Request $request): Course
    {
        return DB::transaction(function () use ($course, $data, $request) {
            $course->update($data);
            $this->handleCourseFiles($request, $course);
            return $course;
        });
    }

    private function handleCourseFiles(Request $request, Course $course): void
    {
        $this->handleImage($request, $course);
        $this->handleVideo($request, $course);
        $this->handleFiles($request, $course);
    }

    private function handleImage(Request $request, Course $course): void
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            if (!$this->fileService->validateFile($file, self::ALLOWED_IMAGES, self::MAX_IMAGE_SIZE)) {
                //throw new FileUploadException('Invalid image file');
            }

            if ($course->image) {
                $this->fileService->deleteFile(self::IMAGE_PATH . '/' . $course->image);
            }

            $course->image = $this->fileService->uploadFile($file, self::IMAGE_PATH);
            $course->save();
        }
    }

    private function handleVideo(Request $request, Course $course): void
    {
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            
            if (!$this->fileService->validateFile($file, self::ALLOWED_VIDEOS, self::MAX_VIDEO_SIZE)) {
                //throw new FileUploadException('Invalid video file');
            }

            if ($course->video) {
                $this->fileService->deleteFile(self::VIDEO_PATH . '/' . $course->video);
            }

            $course->video = $this->fileService->uploadFile($file, self::VIDEO_PATH);
            $course->save();
        }
    }

    private function handleFiles(Request $request, Course $course): void
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            
            if (!$this->fileService->validateFile($file, self::ALLOWED_FILES, self::MAX_FILE_SIZE)) {
                //throw new FileUploadException('Invalid files file');
            }

            if ($course->files) {
                $this->fileService->deleteFile(self::FILE_PATH . '/' . $course->files);
            }

            $course->files = $this->fileService->uploadFile($file, self::FILE_PATH);
            $course->save();
        }
    }
}