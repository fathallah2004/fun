<section class="folder-section min-h-screen py-20 px-4 md:px-8 bg-[#fdf6ec]">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($mediaItems as $index => $media)
                <div 
                    class="bg-white p-4 shadow-2xl transform hover:scale-105 transition-transform duration-500"
                    style="transform: rotate({{ ($index % 3 - 1) * 3 }}deg);"
                >
                    @if($media->type === 'video')
                        <video 
                            class="w-full h-auto"
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
                            class="w-full h-auto"
                            loading="lazy"
                        >
                    @endif
                    @if($media->caption)
                        <p class="mt-4 text-center font-display text-[#6a1e2c]">{{ $media->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
