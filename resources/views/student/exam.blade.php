@extends('layouts.app')

@section('title', 'Exam - ' . $package->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" x-data="examEngine()">
    <!-- Header CBT -->
    <div class="bg-blue-800 text-white rounded-t-xl p-4 flex justify-between items-center shadow-md">
        <div>
            <h2 class="text-xl font-bold">{{ $package->name }}</h2>
            <p class="text-blue-200 text-sm" x-text="sections[currentSectionIndex] + ' Section'"></p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-blue-900 px-4 py-2 rounded-lg border border-blue-700">
                <span class="text-sm uppercase tracking-wider text-blue-300 mr-2">Time Left</span>
                <span class="text-xl font-mono font-bold" x-text="formattedTime"></span>
            </div>
            <button @click="submitSection()" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-medium transition-colors">
                Finish Section
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white border-x border-b border-slate-200 rounded-b-xl shadow-md min-h-[60vh] p-6 flex flex-col md:flex-row gap-6">
        
        <!-- Question Area -->
        <div class="flex-1">
            <!-- Simulated Question Display -->
            <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-6">
                <p class="font-medium text-slate-800 text-lg mb-4">
                    Question <span x-text="currentQuestionNumber"></span>
                </p>
                <div class="text-slate-700 space-y-4 text-lg">
                    <p>This is a placeholder for the CBT question content. Alpine.js will render the actual question from the package JSON structure here.</p>
                </div>
            </div>
            
            <!-- Choices -->
            <div class="space-y-3">
                <template x-for="(choice, index) in ['A. Choice 1', 'B. Choice 2', 'C. Choice 3', 'D. Choice 4']">
                    <label class="flex items-center p-4 border border-slate-200 rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <input type="radio" :name="'q' + currentQuestionNumber" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                        <span class="ml-3 text-slate-700" x-text="choice"></span>
                    </label>
                </template>
            </div>
        </div>

        <!-- Right Panel: Navigator -->
        <div class="w-full md:w-64 shrink-0">
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Question Navigator</h3>
                <div class="grid grid-cols-5 gap-2">
                    <template x-for="i in 15">
                        <button class="w-10 h-10 rounded text-sm font-medium transition-colors"
                            :class="i === currentQuestionNumber ? 'bg-blue-600 text-white' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-100'"
                            @click="currentQuestionNumber = i"
                            x-text="i"></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('examEngine', () => ({
            sections: ['Listening Comprehension', 'Structure & Written Expression', 'Reading Comprehension'],
            currentSectionIndex: 1, // Example: starting at Structure
            currentQuestionNumber: 1,
            timeLeft: 1500, // 25 minutes
            
            get formattedTime() {
                const m = Math.floor(this.timeLeft / 60).toString().padStart(2, '0');
                const s = (this.timeLeft % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            init() {
                setInterval(() => {
                    if (this.timeLeft > 0) this.timeLeft--;
                }, 1000);
            },

            submitSection() {
                if (confirm('Are you sure you want to submit this section?')) {
                    // Logic to post answers via AJAX to submitExam endpoint
                    alert('Answers submitted!');
                    window.location.href = '/dashboard';
                }
            }
        }));
    });
</script>
@endpush
@endsection
