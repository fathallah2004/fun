<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;
use App\Models\Media;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $layoutTypes = [
            'hero-split',
            'masonry',
            'fullscreen-video',
            'polaroid',
            'circular',
            'diagonal',
            'horizontal-scroll',
            'timeline',
            'overlapping',
        ];

        // Create folders from existing directories
        $folders = [
            ['title' => 'First Memories', 'slug' => 'first-memories', 'layout_type' => 'hero-split'],
            ['title' => 'Adventures Together', 'slug' => 'adventures', 'layout_type' => 'masonry'],
            ['title' => 'Special Moments', 'slug' => 'special-moments', 'layout_type' => 'polaroid'],
            ['title' => 'Our Journey', 'slug' => 'journey', 'layout_type' => 'timeline'],
            ['title' => 'Beautiful Times', 'slug' => 'beautiful-times', 'layout_type' => 'circular'],
            ['title' => 'Laughs & Smiles', 'slug' => 'laughs-smiles', 'layout_type' => 'diagonal'],
            ['title' => 'Memories Collection', 'slug' => 'memories-collection', 'layout_type' => 'horizontal-scroll'],
            ['title' => 'Treasured Moments', 'slug' => 'treasured-moments', 'layout_type' => 'overlapping'],
            ['title' => 'Love Story', 'slug' => 'love-story', 'layout_type' => 'fullscreen-video'],
            ['title' => 'Forever Yours', 'slug' => 'forever-yours', 'layout_type' => 'hero-split'],
        ];

        foreach ($folders as $index => $folderData) {
            $folder = Folder::create([
                'title' => $folderData['title'],
                'description' => 'A collection of beautiful memories',
                'slug' => $folderData['slug'],
                'layout_type' => $folderData['layout_type'],
                'order' => $index + 1,
            ]);

            // Map folder numbers to folder IDs (assuming folders 1-21 exist in root)
            $folderNumber = $index + 1;
            $folderPath = base_path($folderNumber);
            
            if (is_dir($folderPath)) {
                $files = glob($folderPath . '/*');
                $mediaOrder = 0;
                
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $type = in_array($extension, ['mp4', 'mov', 'avi']) ? 'video' : 'image';
                        
                        // Copy file to storage
                        $storagePath = 'media/' . $folderNumber . '/' . basename($file);
                        $fullStoragePath = storage_path('app/public/' . $storagePath);
                        $dir = dirname($fullStoragePath);
                        if (!is_dir($dir)) {
                            mkdir($dir, 0755, true);
                        }
                        copy($file, $fullStoragePath);
                        
                        Media::create([
                            'folder_id' => $folder->id,
                            'type' => $type,
                            'path' => $storagePath,
                            'caption' => pathinfo($file, PATHINFO_FILENAME),
                            'order' => $mediaOrder++,
                        ]);
                    }
                }
            }
        }
    }
}
