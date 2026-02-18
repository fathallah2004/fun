@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdf6ec]">
    @if($user === 'amine')
    <div x-data="dashboard()" class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center space-y-8">
            <h1 class="font-display text-5xl md:text-7xl text-[#6a1e2c] mb-12">
                Welcome, Amine
            </h1>
            <div class="flex flex-col md:flex-row gap-6 justify-center">
                <button 
                    @click="showModal = true"
                    class="glass-button px-12 py-6 text-2xl font-display bg-white/20 backdrop-blur-md border-2 border-[#6a1e2c]/30 rounded-lg text-[#6a1e2c] hover:bg-white/30 hover:scale-105 transition-all duration-300 shadow-lg"
                >
                    Send Notification
                </button>
                <a 
                    href="{{ route('presentation') }}"
                    class="glass-button px-12 py-6 text-2xl font-display bg-white/20 backdrop-blur-md border-2 border-[#6a1e2c]/30 rounded-lg text-[#6a1e2c] hover:bg-white/30 hover:scale-105 transition-all duration-300 shadow-lg"
                >
                    See Content
                </a>
            </div>
        </div>
        
        <!-- Notification Modal -->
        <div 
            x-show="showModal"
            @click.away="showModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center px-4"
            style="display: none;"
        >
            <div 
                @click.stop
                class="bg-white rounded-lg p-8 max-w-2xl w-full"
            >
                <h2 class="font-display text-3xl text-[#6a1e2c] mb-6">Send Notification to Yasmine</h2>
                <form @submit.prevent="sendNotification()">
                    <div class="space-y-4">
                        <input 
                            type="text"
                            x-model="subject"
                            placeholder="Subject"
                            class="w-full px-4 py-3 border-2 border-[#6a1e2c]/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6a1e2c]/50"
                            required
                        >
                        <textarea 
                            x-model="message"
                            placeholder="Message"
                            rows="6"
                            class="w-full px-4 py-3 border-2 border-[#6a1e2c]/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6a1e2c]/50"
                            required
                        ></textarea>
                        <div class="flex gap-4">
                            <button 
                                type="submit"
                                class="px-6 py-3 bg-[#6a1e2c] text-white rounded-lg hover:bg-[#8b2a3d] transition-colors"
                            >
                                Send
                            </button>
                            <button 
                                type="button"
                                @click="showModal = false"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <script>
        window.location.href = '{{ route("presentation") }}';
    </script>
    @endif
</div>

<script>
function dashboard() {
    return {
        showModal: false,
        subject: '',
        message: '',
        
        async sendNotification() {
            const response = await fetch('/send-notification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    subject: this.subject,
                    message: this.message
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('Notification sent!');
                this.showModal = false;
                this.subject = '';
                this.message = '';
            } else {
                alert('Failed to send notification. Please try again.');
            }
        }
    }
}
</script>
@endsection
