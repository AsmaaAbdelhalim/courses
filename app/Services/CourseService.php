<?php

namespace App\Services;

use App\Services\FileService;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseService
{
    
    private const MEDIA_CONFIG = [
        'image' => [
            'path' => 'courses/images',
            'types' => ['jpg', 'jpeg', 'png'],
            'max_size' => 5242880 // 5MB
        ],
        'videos' => [
            'path' => 'courses/videos',
            'types' => ['mp4', 'mov'],
            'max_size' => 104857600 // 100MB
        ],
        'files' => [
            'path' => 'courses/files',
            'types' => ['pdf', 'doc', 'docx'],
            'max_size' => 10485760 // 10MB
        ]
    ];

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
        //delete old image or file or video when updating
        if($course->image){
            $this->fileService->deleteFile(self::MEDIA_CONFIG['image']['path']. '/' . $course->image);
        }
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

   // public function delete(Course $course): void
    //{
      //  DB::transaction(function () use ($course) {
      //      if ($course->image) {
//$this->fileService->deleteFile(self::MEDIA_CONFIG['image']['path']. '/' . $course->image);
          //  }
          //  $course->delete();
       // });
   // }


   private function processFile($file, Course $course, string $field, array $config): void
   {
       if (!$this->fileService->validateFile($file, $config['types'], $config['max_size'])) {
           return;
       }
       
       // Store full path in database
       $course->$field = $this->fileService->uploadFile($file, $config['path']);
       $course->save();
   }

   public function getMediaPath(string $type): ?string
   {
       return self::MEDIA_CONFIG[$type]['path'] ?? null;
   }
}