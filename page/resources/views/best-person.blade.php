@extends('layouts.app')

@section('content')
<div x-data="bestPersonPage()" class="fixed inset-0 overflow-hidden bg-gradient-to-br from-[#6a1e2c] via-[#8b2a3d] to-[#4a1520]">
    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="text-center px-4 max-w-4xl">
            <h1 class="font-display text-5xl md:text-7xl mb-12 text-white drop-shadow-2xl">
                Who is your best person?
            </h1>
            <div class="mt-12">
                <input 
                    type="text"
                    x-model="answer"
                    @keyup.enter="verifyAnswer()"
                    class="px-8 py-4 text-xl md:text-2xl bg-white/10 backdrop-blur-md border-2 border-white/20 rounded-lg text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300"
                    placeholder="Your answer..."
                    autofocus
                >
            </div>
            
            <!-- Playful Message -->
            <div 
                x-show="showPlayful"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="mt-8 text-white text-xl md:text-2xl font-display"
            >
                <p class="mb-4">Haha, nice try! 😊</p>
                <p>But you know what? You're right anyway. Let's go! 💕</p>
            </div>
        </div>
    </div>
</div>

<script>
function bestPersonPage() {
    return {
        answer: '',
        showPlayful: false,
        
        async verifyAnswer() {
            if (!this.answer.trim()) return;
            
            const response = await fetch('/verify-best-person', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ answer: this.answer })
            });
            
            const data = await response.json();
            
            if (data.valid && data.granted) {
                if (data.playful) {
                    this.showPlayful = true;
                    setTimeout(() => {
                        window.location.href = '/presentation';
                    }, 3000);
                } else {
                    window.location.href = '/presentation';
                }
            } else {
                // Fade to dark
                document.body.style.transition = 'background 1s ease-out';
                document.body.style.background = '#000';
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
            }
        }
    }
}
</script>
@endsection
