<section class="folder-section min-h-screen relative overflow-hidden">
    @if($mediaItems->where('type', 'video')->first())
        @php $video = $mediaItems->where('type', 'video')->first(); @endphp
        <video 
            class="absolute inset-0 w-full h-full object-cover"
            autoplay 
            muted 
            loop
            playsinline
        >
            <source src="{{ Storage::url($video->path) }}" type="video/mp4">
        </video>
    @endif
    
    <div class="absolute inset-0 bg-black/40"></div>
    
    <div class="relative z-10 h-full flex items-center justify-center px-4">
        <div class="text-center text-white">
            <h2 class="font-display text-5xl md:text-8xl mb-6 drop-shadow-2xl">{{ $folder->title }}</h2>
            @if($folder->description)
                <p class="text-xl md:text-3xl max-w-3xl mx-auto drop-shadow-lg">{{ $folder->description }}</p>
            @endif
        </div>
    </div>
</section>
