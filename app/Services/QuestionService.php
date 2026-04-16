<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            // Extract answers from data before creating question
            $answers = $data['answers'] ?? [];
            unset($data['answers']); // Remove answers from question data
            
            $question = Question::create($data);
            $this->handleQuestionFiles($request, $question);
            
            // Create answers if provided
            if (!empty($answers)) {
                $this->createAnswers($question, $answers);
            }
            
            return $question;
        });
    }

    /**
     * Create answers for a question
     */
    public function createAnswers(Question $question, array $answers): void
    {
        $answersData = [];
        foreach ($answers as $answerData) {
            $answersData[] = [
                'question_id' => $question->id,
                'answer' => $answerData['answer'],
                'correct' => !empty($answerData['correct']) ? 1 : 0,
                'user_id' => Auth::id(),
                'exam_id' => $question->exam_id,
                'course_id' => $question->course_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Answer::insert($answersData);
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
            
            // Validate file before upload
            if (!$this->fileService->validateFile($file, self::ALLOWED_IMAGES, self::MAX_IMAGE_SIZE)) {
                throw new \RuntimeException('Invalid image file. Allowed types: ' . implode(', ', self::ALLOWED_IMAGES) . '. Max size: ' . (self::MAX_IMAGE_SIZE / 1024 / 1024) . 'MB');
            }

            // Delete old image if exists
            if ($question->image) {
                $this->fileService->deleteFile($question->image, self::IMAGE_PATH);
            }

            // Upload new image
            $question->image = $this->fileService->uploadFile($file, self::IMAGE_PATH);
            $question->save();
        }
    }

    private function handleVideo(Request $request, Question $question): void
    {
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            
            // Validate file before upload
            if (!$this->fileService->validateFile($file, self::ALLOWED_VIDEOS, self::MAX_VIDEO_SIZE)) {
                throw new \RuntimeException('Invalid video file. Allowed types: ' . implode(', ', self::ALLOWED_VIDEOS) . '. Max size: ' . (self::MAX_VIDEO_SIZE / 1024 / 1024) . 'MB');
            }

            // Delete old video if exists
            if ($question->video) {
                $this->fileService->deleteFile($question->video, self::VIDEO_PATH);
            }

            // Upload new video
            $question->video = $this->fileService->uploadFile($file, self::VIDEO_PATH);
            $question->save();
        }
    }

    private function handleFiles(Request $request, Question $question): void
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            
            // Validate file before upload
            if (!$this->fileService->validateFile($file, self::ALLOWED_FILES, self::MAX_FILE_SIZE)) {
                throw new \RuntimeException('Invalid file. Allowed types: ' . implode(', ', self::ALLOWED_FILES) . '. Max size: ' . (self::MAX_FILE_SIZE / 1024 / 1024) . 'MB');
            }

            // Delete old file if exists
            if ($question->files) {
                $this->fileService->deleteFile($question->files, self::FILE_PATH);
            }

            // Upload new file
            $question->files = $this->fileService->uploadFile($file, self::FILE_PATH);
            $question->save();
        }
    }

    /**
     * Get media URL for question image
     */
    public function getImageUrl(?string $fileName): ?string
    {
        return $this->fileService->getFileUrl($fileName, self::IMAGE_PATH);
    }

    /**
     * Get media URL for question video
     */
    public function getVideoUrl(?string $fileName): ?string
    {
        return $this->fileService->getFileUrl($fileName, self::VIDEO_PATH);
    }
}