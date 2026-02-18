<section class="folder-section min-h-screen py-20 px-4 md:px-8 relative">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="relative" style="min-height: 600px;">
            @foreach($mediaItems as $index => $media)
                <div 
                    class="absolute transform hover:z-50 hover:scale-110 transition-all duration-500"
                    style="
                        top: {{ $index * 40 }}px;
                        left: {{ $index * 30 }}px;
                        z-index: {{ $index }};
                        transform: rotate({{ ($index % 3 - 1) * 5 }}deg);
                    "
                >
                    @if($media->type === 'video')
                        <video 
                            class="w-64 md:w-80 h-auto rounded-lg shadow-2xl"
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
                            class="w-64 md:w-80 h-auto rounded-lg shadow-2xl"
                            loading="lazy"
                        >
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
