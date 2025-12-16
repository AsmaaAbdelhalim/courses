<?php

namespace App\Services;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonService
{
    private const MEDIA_CONFIG = [
        'image' => [
            'path' => 'lessons/images',
            'types' => ['jpg', 'jpeg', 'png'],
            'max_size' => 5242880 // 5MB
        ],
        'video' => [
            'path' => 'lessons/videos',
            'types' => ['mp4', 'mov'],
            'max_size' => 104857600 // 100MB
        ],
        'file' => [
            'path' => 'lessons/files',
            'types' => ['pdf', 'doc', 'docx'],
            'max_size' => 10485760 // 10MB
        ]
    ];

    public function __construct(private FileService $fileService)
    {}

    public function create(array $data, Request $request): Lesson
    {
        $lesson = Lesson::create($data);
        $this->handleMedia($request, $lesson);
        return $lesson;
    }

    public function update(Lesson $lesson, array $data, Request $request): Lesson
    {
        $lesson->update($data);
        $this->handleMedia($request, $lesson);
        return $lesson;
    }
    
    private function handleMedia(Request $request, Lesson $lesson): void
    {
        foreach (self::MEDIA_CONFIG as $field => $config) {
            if ($request->hasFile($field)) {
                $this->processFile($request->file($field), $lesson, $field, $config);
            }
        }
    }
    
    private function processFile($file, Lesson $lesson, string $field, array $config): void
    {
        if (!$this->fileService->validateFile($file, $config['types'], $config['max_size'])) {
            return;
        }
    
        if ($lesson->{$field}) {
            $this->fileService->deleteFile($config['path'] . '/' . $lesson->{$field});
        }
    
        $lesson->{$field} = $this->fileService->uploadFile($file, $config['path']);
        $lesson->save();
    }
}