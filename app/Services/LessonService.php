<?php

namespace App\Services;

use App\Services\FileService;
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
        'videos' => [
            'path' => 'lessons/videos',
            'types' => ['mp4', 'mov'],
            'max_size' => 104857600 // 100MB
        ],
        'files' => [
            'path' => 'lessons/files',
            'types' => ['pdf', 'doc', 'docx'],
            'max_size' => 10485760 // 10MB
        ]
    ];

    public function __construct(
        private readonly FileService $fileService
    ) {}

    public function create(array $data, Request $request): Lesson
    {
        $Lesson = Lesson::create($data);
        $this->handleMedia($request, $Lesson);
        return $Lesson;
    } 

    public function update(Lesson $lesson, array $data, Request $request): Lesson
    {
        //delete old image or file or video when updating
        if($lesson->image){
            $this->fileService->deleteFile(self::MEDIA_CONFIG['image']['path']. '/' . $lesson->image);
        }
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

   // public function delete(Lesson $lesson): void
    //{
      //  DB::transaction(function () use ($lesson) {
      //      if ($lesson->image) {
//$this->fileService->deleteFile(self::MEDIA_CONFIG['image']['path']. '/' . $lesson->image);
          //  }
          //  $lesson->delete();
       // });
   // }


   private function processFile($file, Lesson $lesson, string $field, array $config): void
   {
       if (!$this->fileService->validateFile($file, $config['types'], $config['max_size'])) {
           return;
       }
       
       // Store full path in database
       $lesson->$field = $this->fileService->uploadFile($file, $config['path']);
       $lesson->save();
   }

   public function getMediaPath(string $type): ?string
   {
       return self::MEDIA_CONFIG[$type]['path'] ?? null;
   }
}