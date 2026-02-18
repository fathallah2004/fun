<section class="folder-section min-h-screen py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="flex flex-wrap justify-center gap-8">
            @foreach($mediaItems as $media)
                <div class="w-64 h-64 md:w-80 md:h-80 rounded-full overflow-hidden shadow-2xl hover:scale-110 transition-transform duration-500 group">
                    @if($media->type === 'video')
                        <video 
                            class="w-full h-full object-cover"
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
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    @endif
                    @if($media->caption)
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center rounded-full">
                            <p class="text-white font-display text-center px-4">{{ $media->caption }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
