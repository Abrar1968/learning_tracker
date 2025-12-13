@props(['session' => null, 'topic' => null, 'resource' => null])

<div x-data="pomodoroTimer(@json($session), @json($topic?->id), @json($resource?->id))"
     x-init="init()"
     class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl overflow-hidden">

    <!-- Timer Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Focus Timer
            </h3>
            <div class="flex items-center space-x-2">
                <span class="text-white/80 text-sm" x-text="sessionType"></span>
                <span x-show="isBreak" class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Break</span>
            </div>
        </div>
    </div>

    <!-- Timer Display -->
    <div class="p-8 text-center">
        <!-- Circular Progress -->
        <div class="relative w-64 h-64 mx-auto mb-6">
            <svg class="w-full h-full transform -rotate-90">
                <circle cx="128" cy="128" r="120" stroke-width="8" fill="none"
                        class="stroke-gray-200 dark:stroke-dark-700"/>
                <circle cx="128" cy="128" r="120" stroke-width="8" fill="none"
                        class="transition-all duration-1000"
                        :class="isBreak ? 'stroke-green-500' : 'stroke-indigo-600'"
                        :stroke-dasharray="circumference"
                        :stroke-dashoffset="progressOffset"
                        stroke-linecap="round"/>
            </svg>

            <!-- Time Display -->
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-5xl font-mono font-bold text-gray-900 dark:text-white" x-text="formattedTime"></span>
                <span class="text-sm text-gray-500 dark:text-gray-400 mt-2" x-text="sessionLabel"></span>
            </div>
        </div>

        <!-- Session Counter -->
        <div class="flex justify-center space-x-2 mb-6">
            <template x-for="i in 4">
                <div class="w-3 h-3 rounded-full transition-colors"
                     :class="i <= completedSessions ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-dark-600'"></div>
            </template>
        </div>

        <!-- Controls -->
        <div class="flex justify-center space-x-4">
            <button @click="toggleTimer()"
                    class="px-8 py-3 rounded-xl font-bold text-white transition-all transform hover:scale-105 shadow-lg"
                    :class="isRunning ? 'bg-orange-500 hover:bg-orange-600' : 'bg-indigo-600 hover:bg-indigo-700'">
                <span x-show="!isRunning" class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    Start
                </span>
                <span x-show="isRunning" class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Pause
                </span>
            </button>

            <button @click="resetTimer()"
                    class="px-6 py-3 bg-gray-200 dark:bg-dark-700 hover:bg-gray-300 dark:hover:bg-dark-600 text-gray-700 dark:text-gray-300 rounded-xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>

            <button x-show="isBreak" @click="skipBreak()"
                    class="px-6 py-3 bg-gray-200 dark:bg-dark-700 hover:bg-gray-300 dark:hover:bg-dark-600 text-gray-700 dark:text-gray-300 rounded-xl font-bold transition-all">
                Skip Break
            </button>
        </div>
    </div>

    <!-- Session Type Selector -->
    <div class="px-6 pb-6">
        <div class="flex justify-center space-x-2">
            <button @click="setSessionType('pomodoro')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-all"
                    :class="currentType === 'pomodoro' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-dark-700 text-gray-600 dark:text-gray-400'">
                Pomodoro (25m)
            </button>
            <button @click="setSessionType('short_break')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-all"
                    :class="currentType === 'short_break' ? 'bg-green-500 text-white' : 'bg-gray-100 dark:bg-dark-700 text-gray-600 dark:text-gray-400'">
                Short Break (5m)
            </button>
            <button @click="setSessionType('long_break')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-all"
                    :class="currentType === 'long_break' ? 'bg-green-600 text-white' : 'bg-gray-100 dark:bg-dark-700 text-gray-600 dark:text-gray-400'">
                Long Break (15m)
            </button>
        </div>
    </div>

    <!-- Today's Stats -->
    <div class="bg-gray-50 dark:bg-dark-700/50 px-6 py-4 border-t border-gray-200 dark:border-dark-600">
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-2xl font-bold text-indigo-600" x-text="todayMinutes"></div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Today's Focus</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600" x-text="completedSessions"></div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Sessions</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-purple-600" x-text="streak"></div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Day Streak</div>
            </div>
        </div>
    </div>
</div>

<script>
function pomodoroTimer(existingSession, topicId, resourceId) {
    return {
        // Session state
        isRunning: false,
        isBreak: false,
        currentType: 'pomodoro',
        timeRemaining: 25 * 60, // seconds
        totalTime: 25 * 60,
        completedSessions: 0,
        sessionId: existingSession?.id || null,
        topicId: topicId,
        resourceId: resourceId,

        // Stats
        todayMinutes: 0,
        streak: 0,

        // Timer
        timer: null,

        // Circle progress
        circumference: 2 * Math.PI * 120,

        // Durations (in minutes)
        durations: {
            pomodoro: 25,
            short_break: 5,
            long_break: 15
        },

        init() {
            // Load preferences
            const prefs = JSON.parse(localStorage.getItem('pomodoro_prefs') || '{}');
            this.durations.pomodoro = prefs.pomodoro || 25;
            this.durations.short_break = prefs.short_break || 5;
            this.durations.long_break = prefs.long_break || 15;

            // Resume existing session
            if (existingSession && !existingSession.ended_at) {
                this.resumeSession(existingSession);
            } else {
                this.setSessionType('pomodoro');
            }

            // Load stats
            this.loadStats();

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

                if (e.code === 'Space') {
                    e.preventDefault();
                    this.toggleTimer();
                } else if (e.key === 'r') {
                    this.resetTimer();
                } else if (e.key === 's' && this.isBreak) {
                    this.skipBreak();
                }
            });
        },

        get formattedTime() {
            const mins = Math.floor(this.timeRemaining / 60);
            const secs = this.timeRemaining % 60;
            return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        },

        get progressOffset() {
            const progress = this.timeRemaining / this.totalTime;
            return this.circumference * (1 - progress);
        },

        get sessionType() {
            return this.currentType === 'pomodoro' ? 'Focus' : 'Break';
        },

        get sessionLabel() {
            if (!this.isRunning && this.timeRemaining === this.totalTime) {
                return 'Ready to focus';
            }
            return this.isRunning ? 'Stay focused!' : 'Paused';
        },

        setSessionType(type) {
            if (this.isRunning) return;

            this.currentType = type;
            this.isBreak = type !== 'pomodoro';
            this.totalTime = this.durations[type] * 60;
            this.timeRemaining = this.totalTime;
        },

        toggleTimer() {
            if (this.isRunning) {
                this.pauseTimer();
            } else {
                this.startTimer();
            }
        },

        async startTimer() {
            this.isRunning = true;

            // Start session on server if it's a focus session
            if (!this.isBreak && !this.sessionId) {
                try {
                    const payload = {
                        type: 'pomodoro',
                        duration: this.durations.pomodoro
                    };
                    // Only include topic_id and resource_id if they have values
                    if (this.topicId) payload.topic_id = this.topicId;
                    if (this.resourceId) payload.resource_id = this.resourceId;

                    const response = await fetch('/focus/start', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(payload)
                    });
                    const data = await response.json();
                    this.sessionId = data.session?.id;
                } catch (e) {
                    console.error('Failed to start session:', e);
                }
            }

            this.timer = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                } else {
                    this.timerComplete();
                }
            }, 1000);
        },

        pauseTimer() {
            this.isRunning = false;
            clearInterval(this.timer);
        },

        resetTimer() {
            this.pauseTimer();
            this.timeRemaining = this.totalTime;
        },

        async timerComplete() {
            this.pauseTimer();
            this.playSound();

            if (!this.isBreak) {
                // Complete focus session
                this.completedSessions++;
                this.todayMinutes += this.durations.pomodoro;

                if (this.sessionId) {
                    await this.endSession(false);
                }

                // Switch to break
                if (this.completedSessions % 4 === 0) {
                    this.setSessionType('long_break');
                } else {
                    this.setSessionType('short_break');
                }

                this.showNotification('Focus session complete! Take a break.');
            } else {
                // Break complete
                this.setSessionType('pomodoro');
                this.showNotification('Break over! Ready to focus?');
            }
        },

        skipBreak() {
            if (!this.isBreak) return;
            this.pauseTimer();
            this.setSessionType('pomodoro');
        },

        async endSession(interrupted) {
            if (!this.sessionId) return;

            try {
                await fetch(`/focus/${this.sessionId}/end`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ interrupted })
                });
                this.sessionId = null;
            } catch (e) {
                console.error('Failed to end session:', e);
            }
        },

        resumeSession(session) {
            const elapsed = Math.floor((Date.now() - new Date(session.started_at).getTime()) / 1000);
            const remaining = (session.planned_duration * 60) - elapsed;

            if (remaining > 0) {
                this.sessionId = session.id;
                this.timeRemaining = remaining;
                this.totalTime = session.planned_duration * 60;
                this.startTimer();
            }
        },

        loadStats() {
            // This would normally come from the server
            this.todayMinutes = {{ $session?->duration_minutes ?? 0 }};
            this.streak = {{ auth()->user()->current_streak ?? 0 }};
        },

        playSound() {
            const audio = new Audio('/sounds/bell.mp3');
            audio.play().catch(() => {});
        },

        showNotification(message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification('Pomodoro Timer', { body: message, icon: '/favicon.ico' });
            }
        }
    };
}
</script>
