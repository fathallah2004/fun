@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdf6ec]">
    <!-- Full Gallery Button -->
    <div class="fixed top-8 right-8 z-50">
        <a 
            href="{{ route('gallery') }}"
            class="px-6 py-3 bg-white/20 backdrop-blur-md border-2 border-[#6a1e2c]/30 rounded-lg text-[#6a1e2c] hover:bg-white/30 transition-all duration-300 shadow-lg font-display"
        >
            Open Full Gallery
        </a>
    </div>

    <!-- Folders -->
    <div class="space-y-0">
        @foreach($folders as $folder)
            @include('presentation.components.folder-layout', ['folder' => $folder])
        @endforeach
    </div>
</div>

<script>
// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.folder-section').forEach(section => {
        observer.observe(section);
    });

    // Video autoplay control
    document.querySelectorAll('video').forEach(video => {
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    video.play();
                } else {
                    video.pause();
                }
            });
        }, { threshold: 0.5 });

        videoObserver.observe(video);
    });
});
</script>

<style>
.folder-section {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.folder-section.animate-in {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endsection
