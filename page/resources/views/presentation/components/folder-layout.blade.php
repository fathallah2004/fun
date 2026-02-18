@php
    $layoutType = $folder->layout_type ?? 'hero-split';
    $mediaItems = $folder->media;
@endphp

@if($layoutType === 'hero-split')
    @include('presentation.layouts.hero-split', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'masonry')
    @include('presentation.layouts.masonry', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'fullscreen-video')
    @include('presentation.layouts.fullscreen-video', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'polaroid')
    @include('presentation.layouts.polaroid', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'circular')
    @include('presentation.layouts.circular', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'diagonal')
    @include('presentation.layouts.diagonal', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'horizontal-scroll')
    @include('presentation.layouts.horizontal-scroll', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'timeline')
    @include('presentation.layouts.timeline', ['folder' => $folder, 'mediaItems' => $mediaItems])
@elseif($layoutType === 'overlapping')
    @include('presentation.layouts.overlapping', ['folder' => $folder, 'mediaItems' => $mediaItems])
@else
    @include('presentation.layouts.hero-split', ['folder' => $folder, 'mediaItems' => $mediaItems])
@endif
