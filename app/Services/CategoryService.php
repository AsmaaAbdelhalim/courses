<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
    
    private const MEDIA_CONFIG = [
        'image' => [
            'path' => 'categories/images',
            'types' => ['jpg', 'jpeg', 'png'],
            'max_size' => 5242880 // 5MB
        ],
        'video' => [
            'path' => 'categories/videos',
            'types' => ['mp4', 'mov'],
            'max_size' => 104857600 // 100MB
        ],
        'file' => [
            'path' => 'categories/files',
            'types' => ['pdf', 'doc', 'docx'],
            'max_size' => 10485760 // 10MB
        ]
    ];

    public function __construct(
        private readonly FileService $fileService
    ) {}

    public function create(array $data, Request $request): Category
    {
        $category = Category::create($data);
        $this->handleMedia($request, $category);
        return $category;
    }

    public function update(Category $category, array $data, Request $request): Category
    {
        //delete old image or file or video when updating
        if($category->image){
            $this->fileService->deleteFile(self::MEDIA_CONFIG['image']['path']. '/' . $category->image);
        }
        $category->update($data);
        $this->handleMedia($request, $category);

        return $category;
    }

    

    private function handleMedia(Request $request, Category $category): void
    {
        foreach (self::MEDIA_CONFIG as $field => $config) {
            if ($request->hasFile($field)) {
                $this->processFile($request->file($field), $category, $field, $config);
            }
        }
    }

    private function processFile($file, Category $category, string $field, array $config): void
    {
        if (!$this->fileService->validateFile($file, $config['types'], $config['max_size'])) {
            return;
        }

        if ($category->{$field}) {
            $this->fileService->deleteFile($config['path'] . '/' . $category->{$field});
        }

        $category->{$field} = $this->fileService->uploadFile($file, $config['path']);
        $category->save();
    }



   // public function delete(Category $category): void
    //{
      //  DB::transaction(function () use ($category) {
      //      if ($category->image) {
//$this->fileService->deleteFile(self::MEDIA_CONFIG['image']['path']. '/' . $category->image);
          //  }
          //  $category->delete();
       // });
   // }
}