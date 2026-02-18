<section class="folder-section min-h-screen py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="grid md:grid-cols-2 gap-8">
            @if($mediaItems->count() > 0)
                <div class="space-y-4">
                    @if($mediaItems[0]->type === 'video')
                        <video 
                            class="w-full h-auto rounded-lg shadow-2xl hover:scale-105 transition-transform duration-500"
                            autoplay 
                            muted 
                            loop
                            playsinline
                        >
                            <source src="{{ Storage::url($mediaItems[0]->path) }}" type="video/mp4">
                        </video>
                    @else
                        <img 
                            src="{{ Storage::url($mediaItems[0]->path) }}" 
                            alt="{{ $mediaItems[0]->caption }}"
                            class="w-full h-auto rounded-lg shadow-2xl hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                    @endif
                </div>
                <div class="space-y-4">
                    @foreach($mediaItems->skip(1) as $media)
                        <div class="relative group">
                            @if($media->type === 'video')
                                <video 
                                    class="w-full h-auto rounded-lg shadow-xl hover:scale-105 transition-transform duration-500"
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
                                    class="w-full h-auto rounded-lg shadow-xl hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                >
                            @endif
                            @if($media->caption)
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-end p-4">
                                    <p class="text-white font-display text-lg">{{ $media->caption }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
