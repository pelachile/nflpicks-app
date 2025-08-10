{{-- resources/views/livewire/welcome/how-it-works-section.blade.php --}}
<section class="bg-gradient-to-br from-soft via-card to-soft py-20 px-6 text-center">
    <div class="max-w-6xl mx-auto">
        <!-- Section Header -->
        <div class="mb-16">
            <h2 class="text-4xl md:text-5xl font-black text-primary mb-4">
                How It Works
            </h2>
            <p class="text-lg text-primary/70 max-w-2xl mx-auto">
                Get started in three simple steps and start dominating your friends' predictions
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 items-stretch">
            <!-- Step 1 -->
            <div class="group relative flex">
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-primary/5 hover:border-primary/20 transform hover:-translate-y-2 flex-1 flex flex-col">
                    <!-- Step Number -->
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="w-8 h-8 bg-gradient-to-r from-highlight to-accent rounded-full flex items-center justify-center text-white font-bold text-sm">
                            1
                        </div>
                    </div>
                    
                    <div class="text-6xl mb-6">👥</div>
                    <h3 class="text-2xl font-bold text-primary mb-4">
                        Invite Your Friends
                    </h3>
                    <p class="text-primary/70 leading-relaxed flex-1">
                        Create a group of up to 10 friends and challenge them to weekly picks. The more friends, the more fun!
                    </p>
                </div>
                
                <!-- Connector Line -->
                <div class="hidden md:block absolute top-1/2 -right-6 w-12 h-0.5 bg-gradient-to-r from-primary/20 to-primary/5 transform -translate-y-1/2"></div>
            </div>

            <!-- Step 2 -->
            <div class="group relative flex">
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-primary/5 hover:border-primary/20 transform hover:-translate-y-2 flex-1 flex flex-col">
                    <!-- Step Number -->
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="w-8 h-8 bg-gradient-to-r from-highlight to-accent rounded-full flex items-center justify-center text-white font-bold text-sm">
                            2
                        </div>
                    </div>
                    
                    <div class="text-6xl mb-6">📱</div>
                    <h3 class="text-2xl font-bold text-primary mb-4">
                        Make Your Picks
                    </h3>
                    <p class="text-primary/70 leading-relaxed flex-1">
                        Each week, pick the winners of every NFL game before kickoff. Lock in your predictions and see who knows football best.
                    </p>
                </div>
                
                <!-- Connector Line -->
                <div class="hidden md:block absolute top-1/2 -right-6 w-12 h-0.5 bg-gradient-to-r from-primary/20 to-primary/5 transform -translate-y-1/2"></div>
            </div>

            <!-- Step 3 -->
            <div class="group relative flex">
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-primary/5 hover:border-primary/20 transform hover:-translate-y-2 flex-1 flex flex-col">
                    <!-- Step Number -->
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="w-8 h-8 bg-gradient-to-r from-highlight to-accent rounded-full flex items-center justify-center text-white font-bold text-sm">
                            3
                        </div>
                    </div>
                    
                    <div class="text-6xl mb-6">🏆</div>
                    <h3 class="text-2xl font-bold text-primary mb-4">
                        Track the Leaderboard
                    </h3>
                    <p class="text-primary/70 leading-relaxed flex-1">
                        See who has the best record each week and for the whole season. Climb the rankings and claim your bragging rights.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-16">
            <a href="{{ route('register') }}"
               wire:navigate
               class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-primary to-primary/90 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                Get Started Now
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>
