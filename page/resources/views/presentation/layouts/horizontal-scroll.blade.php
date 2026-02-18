<section class="folder-section min-h-screen py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex gap-6 pb-6" style="scroll-snap-type: x mandatory;">
                @foreach($mediaItems as $media)
                    <div class="flex-shrink-0 w-80 md:w-96" style="scroll-snap-align: start;">
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
                            <p class="mt-4 text-center font-display text-[#6a1e2c]">{{ $media->caption }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>
