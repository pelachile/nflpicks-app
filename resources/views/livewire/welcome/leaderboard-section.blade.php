{{-- resources/views/livewire/welcome/leaderboard-section.blade.php --}}
<section class="bg-gradient-to-r from-primary to-primary/95 py-20 px-6 text-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- LEFT COLUMN -->
            <div class="text-center lg:text-left space-y-6">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 rounded-full text-sm font-semibold backdrop-blur-sm">
                    <span class="mr-2">🏆</span>
                    Season Leaderboard
                </div>
                
                <h2 class="text-4xl lg:text-5xl font-black leading-tight">
                    Think You Can<br/>
                    <span class="text-highlight">
                        Pick 'Em Better?
                    </span>
                </h2>
                
                <p class="text-lg text-white/80 leading-relaxed max-w-lg">
                    Join thousands of players competing in weekly NFL predictions. Start your group and show your friends who really knows football.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 lg:justify-start justify-center">
                    <a href="{{ route('register') }}"
                       wire:navigate
                       class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-primary bg-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <span class="relative z-10">Create Your Group</span>
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    
                    <div class="flex items-center justify-center lg:justify-start space-x-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-white/70">Free to play</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-white/70">Easy setup</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="relative">
                <!-- Decorative Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-white/10 rounded-3xl blur-3xl"></div>
                
                <!-- Leaderboard Card -->
                <div class="relative bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">Top Players</h3>
                        <span class="px-3 py-1 bg-highlight/20 text-highlight rounded-full text-sm font-semibold">
                            Live Rankings
                        </span>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($sampleLeaders as $index => $leader)
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <!-- Rank -->
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $index === 0 ? 'bg-gradient-to-r from-yellow-400 to-orange-500' : 'bg-white/20' }} text-sm font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    <!-- Player -->
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">{{ $leader['emoji'] }}</span>
                                        <div>
                                            <span class="font-semibold text-white">{{ $leader['name'] }}</span>
                                            @if($index === 0)
                                                <div class="text-xs text-yellow-300">👑 League Leader</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Record -->
                                <div class="text-right">
                                    <div class="font-bold text-lg {{ $index === 0 ? 'text-yellow-300' : 'text-white' }}">
                                        {{ $leader['record'] }}
                                    </div>
                                    <div class="text-xs text-white/60">
                                        {{ $index === 0 ? '92%' : (90 - $index * 3) . '%' }} accurate
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- View All Link -->
                    <div class="mt-6 text-center">
                        <a href="{{ route('register') }}" wire:navigate class="text-highlight hover:text-highlight/80 font-semibold text-sm transition-colors">
                            Join to see full leaderboard →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
