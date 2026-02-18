@extends('layouts.app')

@section('content')
<div x-data="landingPage()" class="fixed inset-0 overflow-hidden">
    <!-- Background Video -->
    <video 
        x-ref="backgroundVideo"
        class="absolute inset-0 w-full h-full object-cover"
        autoplay 
        muted 
        loop
        playsinline
    >
        <source src="{{ asset('1/WAIT A MINUTE  MEME NO COPYRIGHT.mp4') }}" type="video/mp4">
    </video>
    
    <!-- Dark Overlay -->
    <div 
        class="absolute inset-0 bg-black transition-opacity duration-700"
        :class="overlayClass"
    ></div>
    
    <!-- Content -->
    <div class="relative z-10 h-full flex items-center justify-center">
        <!-- Main Landing -->
        <div 
            x-show="!showEmail && !showRejection"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 blur-sm"
            x-transition:enter-end="opacity-100 blur-0"
            class="text-center px-4"
        >
            <h1 class="font-display text-6xl md:text-8xl lg:text-9xl mb-8 text-white drop-shadow-2xl">
                Who are you?
            </h1>
            <div class="mt-12">
                <input 
                    type="text"
                    x-model="name"
                    @keyup.enter="verifyName()"
                    :class="inputClass"
                    class="glass-input px-8 py-4 text-2xl md:text-3xl bg-white/10 backdrop-blur-md border-2 border-white/20 rounded-lg text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300"
                    placeholder="Enter your name..."
                    autofocus
                >
            </div>
        </div>
        
        <!-- Email Verification -->
        <div 
            x-show="showEmail"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 blur-sm scale-95"
            x-transition:enter-end="opacity-100 blur-0 scale-100"
            class="text-center px-4"
        >
            <h1 class="font-display text-5xl md:text-7xl mb-8 text-white drop-shadow-2xl">
                Verify your email
            </h1>
            <div class="mt-12">
                <input 
                    type="email"
                    x-model="email"
                    @keyup.enter="verifyEmail()"
                    class="glass-input px-8 py-4 text-xl md:text-2xl bg-white/10 backdrop-blur-md border-2 border-white/20 rounded-lg text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300"
                    placeholder="Enter your email..."
                    autofocus
                >
            </div>
        </div>
        
        <!-- Rejection Message -->
        <div 
            x-show="showRejection"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="text-center px-4"
        >
            <div 
                x-show="rejectionText.length > 0"
                class="font-display text-4xl md:text-6xl text-white drop-shadow-2xl"
                x-text="rejectionText"
            ></div>
        </div>
    </div>
</div>

<script>
function landingPage() {
    return {
        name: '',
        email: '',
        showEmail: false,
        showRejection: false,
        rejectionText: '',
        overlayClass: 'opacity-60',
        inputClass: '',
        
        async verifyName() {
            if (!this.name.trim()) return;
            
            const response = await fetch('/verify-name', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ name: this.name })
            });
            
            const data = await response.json();
            
            if (data.valid) {
                this.overlayClass = 'opacity-70';
                setTimeout(() => {
                    this.showEmail = true;
                }, 300);
            } else {
                this.showRejection = true;
                this.overlayClass = 'opacity-80';
                this.inputClass = 'animate-shake';
                
                // Change video source to darker video
                this.$refs.backgroundVideo.src = "{{ asset('1/WAIT A MINUTE  MEME NO COPYRIGHT.mp4') }}";
                
                // Typewriter effect
                const message = "No… I'm looking for Yasmine, not you.";
                this.rejectionText = '';
                for (let i = 0; i < message.length; i++) {
                    await new Promise(resolve => setTimeout(resolve, 50));
                    this.rejectionText += message[i];
                }
            }
        },
        
        async verifyEmail() {
            if (!this.email.trim()) return;
            
            const response = await fetch('/verify-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: this.email })
            });
            
            const data = await response.json();
            
            if (data.valid) {
                if (data.needs_best_person) {
                    window.location.href = '/best-person';
                } else {
                    window.location.href = '/dashboard';
                }
            } else {
                this.inputClass = 'animate-shake';
                setTimeout(() => {
                    this.inputClass = '';
                }, 500);
            }
        }
    }
}
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}
.animate-shake {
    animation: shake 0.5s ease-in-out;
}
</style>
@endsection
