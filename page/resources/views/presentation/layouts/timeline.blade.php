<section class="folder-section min-h-screen py-20 px-4 md:px-8">
    <div class="max-w-4xl mx-auto">
        <h2 class="font-display text-4xl md:text-6xl text-[#6a1e2c] mb-8 text-center">{{ $folder->title }}</h2>
        @if($folder->description)
            <p class="text-center text-lg md:text-xl text-[#222222]/70 mb-12 max-w-3xl mx-auto">{{ $folder->description }}</p>
        @endif
        
        <div class="relative">
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-[#6a1e2c]/20"></div>
            
            @foreach($mediaItems as $index => $media)
                <div class="relative mb-12 {{ $index % 2 === 0 ? 'pr-1/2' : 'pl-1/2 ml-auto' }}" style="width: 48%;">
                    <div class="absolute top-0 {{ $index % 2 === 0 ? 'right-0' : 'left-0' }} w-4 h-4 bg-[#6a1e2c] rounded-full transform translate-x-1/2 -translate-x-1/2"></div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        @if($media->type === 'video')
                            <video 
                                class="w-full h-auto rounded-lg mb-4"
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
                                class="w-full h-auto rounded-lg mb-4"
                                loading="lazy"
                            >
                        @endif
                        @if($media->caption)
                            <p class="font-display text-[#6a1e2c]">{{ $media->caption }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
