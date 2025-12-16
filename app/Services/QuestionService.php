<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\FileUploadException;

class QuestionService
{
    private const IMAGE_PATH = 'uploads/questions/images';
    private const VIDEO_PATH = 'uploads/questions/videos';
    private const FILE_PATH = 'uploads/questions/files';
    
    private const ALLOWED_IMAGES = ['jpg', 'jpeg', 'png', 'webp'];
    private const ALLOWED_VIDEOS = ['mp4', 'mov', 'webm'];
    private const ALLOWED_FILES = ['pdf', 'doc', 'docx'];
    
    private const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    private const MAX_VIDEO_SIZE = 100 * 1024 * 1024; // 100MB
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    public function __construct(private FileService $fileService)
    {}

    public function createQuestion(array $data, Request $request): Question
    {
        return DB::transaction(function () use ($data, $request) {
            $question = Question::create($data);
            $this->handleQuestionFiles($request, $question);
            return $question;
        });
    }

    public function updateQuestion(Question $question, array $data, Request $request): Question
    {
        return DB::transaction(function () use ($question, $data, $request) {
            $question->update($data);
            $this->handleQuestionFiles($request, $question);
            return $question;
        });
    }

    private function handleQuestionFiles(Request $request, Question $question): void
    {
        $this->handleImage($request, $question);
        $this->handleVideo($request, $question);
        $this->handleFiles($request, $question);
    }

    private function handleImage(Request $request, Question $question): void
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            if (!$this->fileService->validateFile($file, self::ALLOWED_IMAGES, self::MAX_IMAGE_SIZE)) {
                //throw new FileUploadException('Invalid image file');
            }

            if ($question->image) {
                $this->fileService->deleteFile(self::IMAGE_PATH . '/' . $question->image);
            }

            $question->image = $this->fileService->uploadFile($file, self::IMAGE_PATH);
            $question->save();
        }
    }

    private function handleVideo(Request $request, Question $question): void
    {
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            
            if (!$this->fileService->validateFile($file, self::ALLOWED_VIDEOS, self::MAX_VIDEO_SIZE)) {
                //throw new FileUploadException('Invalid video file');
            }

            if ($question->video) {
                $this->fileService->deleteFile(self::VIDEO_PATH . '/' . $question->video);
            }

            $question->video = $this->fileService->uploadFile($file, self::VIDEO_PATH);
            $question->save();
        }
    }

    private function handleFiles(Request $request, Question $question): void
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            
            if (!$this->fileService->validateFile($file, self::ALLOWED_FILES, self::MAX_FILE_SIZE)) {
                //throw new FileUploadException('Invalid files file');
            }

            if ($question->files) {
                $this->fileService->deleteFile(self::FILE_PATH . '/' . $question->files);
            }

            $question->files = $this->fileService->uploadFile($file, self::FILE_PATH);
            $question->save();
        }
    }
}

public function __construct(
    private readonly FileService $fileService
) {}

public function create(array $data, Request $request): Course
{
    $course = Course::create($data);
    $this->handleMedia($request, $course);
    return $course;
}

public function update(Course $course, array $data, Request $request): Course
{
    $course->update($data);
    $this->handleMedia($request, $course);
    return $course;
}

private function handleMedia(Request $request, Course $course): void
{
    foreach (self::MEDIA_CONFIG as $field => $config) {
        if ($request->hasFile($field)) {
            $this->processFile($request->file($field), $course, $field, $config);
        }
    }
}

private function processFile($file, Course $course, string $field, array $config): void
{
    if (!$this->fileService->validateFile($file, $config['types'], $config['max_size'])) {
        return;
    }

    if ($course->{$field}) {
        $this->fileService->deleteFile($config['path'] . '/' . $course->{$field});
    }

    $course->{$field} = $this->fileService->uploadFile($file, $config['path']);
    $course->save();
}