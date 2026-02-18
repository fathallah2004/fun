<section class="folder-section min-h-screen py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
            @foreach($mediaItems as $media)
                <div class="break-inside-avoid mb-6 group">
                    @if($media->type === 'video')
                        <video 
                            class="w-full h-auto rounded-lg shadow-xl hover:shadow-2xl transition-all duration-500"
                            autoplay 
                            muted 
                            loop
                            playsinline
                        >
                            <source src="{{ Storage::url($media->path) }}" type="video/mp4">
                        </video>
                    @else
                        <img 
                            src="{{ Storage::url($media->path) }}" 
                            alt="{{ $media->caption }}"
                            class="w-full h-auto rounded-lg shadow-xl hover:shadow-2xl transition-all duration-500 grayscale hover:grayscale-0"
                            loading="lazy"
                        >
                    @endif
                    @if($media->caption)
                        <p class="mt-2 text-sm text-[#222222]/60 font-display">{{ $media->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
