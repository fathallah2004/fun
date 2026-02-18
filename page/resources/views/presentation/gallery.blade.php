@extends('layouts.app')

@section('content')
<div x-data="galleryPage()" class="min-h-screen bg-[#fdf6ec] py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-display text-5xl md:text-7xl text-[#6a1e2c] mb-12 text-center">Full Gallery</h1>
        
        <!-- Folder Filters -->
        <div class="flex flex-wrap gap-4 justify-center mb-12">
            <button 
                @click="selectedFolder = null"
                :class="selectedFolder === null ? 'bg-[#6a1e2c] text-white' : 'bg-white/20 text-[#6a1e2c]'"
                class="px-6 py-3 rounded-lg font-display transition-colors"
            >
                All
            </button>
            @foreach($folders as $folder)
                <button 
                    @click="selectedFolder = {{ $folder->id }}"
                    :class="selectedFolder === {{ $folder->id }} ? 'bg-[#6a1e2c] text-white' : 'bg-white/20 text-[#6a1e2c]'"
                    class="px-6 py-3 rounded-lg font-display transition-colors"
                >
                    {{ $folder->title }}
                </button>
            @endforeach
        </div>
        
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($folders as $folder)
                @foreach($folder->media as $media)
                    <div 
                        x-show="selectedFolder === null || selectedFolder === {{ $folder->id }}"
                        class="group relative overflow-hidden rounded-lg shadow-xl hover:shadow-2xl transition-all duration-500 cursor-pointer"
                        @click="openModal({{ $media->id }})"
                    >
                        @if($media->type === 'video')
                            <video 
                                class="w-full h-64 object-cover"
                                muted
                                loop
                                @mouseenter="$el.play()"
                                @mouseleave="$el.pause()"
                            >
                                <source src="{{ Storage::url($media->path) }}" type="video/mp4">
                            </video>
                        @else
                            <img 
                                src="{{ Storage::url($media->path) }}" 
                                alt="{{ $media->caption }}"
                                class="w-full h-64 object-cover grayscale hover:grayscale-0 transition-all duration-500"
                                loading="lazy"
                            >
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            @if($media->caption)
                                <p class="text-white font-display">{{ $media->caption }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
    
    <!-- Modal -->
    <div 
        x-show="showModal"
        @click.away="showModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <button 
            @click="showModal = false"
            class="absolute top-4 right-4 text-white text-4xl hover:text-[#c6a75e] transition-colors"
        >
            ×
        </button>
        <div class="max-w-5xl w-full">
            <img 
                :src="modalImage"
                alt=""
                class="w-full h-auto rounded-lg"
            >
        </div>
    </div>
</div>

<script>
function galleryPage() {
    return {
        selectedFolder: null,
        showModal: false,
        modalImage: '',
        
        openModal(mediaId) {
            // Get media path from server or use asset path
            this.modalImage = `/media/${mediaId}/signed`;
            this.showModal = true;
        }
    }
}
</script>
@endsection
