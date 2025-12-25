<div class="doctor-card bg-white p-8 rounded-2xl shadow-lg text-center hover-lift hover-glow scale-in delay-{{ ($index + 1) * 100 }}">
    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-{{ $doctor->color }}-400 to-{{ $doctor->color }}-600 rounded-full flex items-center justify-center floating-animation">
        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
    </div>
    <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ $doctor->name }}</h4>
    <p class="text-{{ $doctor->color }}-600 font-semibold mb-4">{{ $doctor->specialty }}</p>
    <p class="text-gray-600 mb-6">{{ $doctor->description ?: "Berpengalaman {$doctor->experience_years} tahun dalam bidang {$doctor->specialty}." }}</p>
    <div class="flex justify-center flex-wrap gap-2">
        @foreach($doctor->skills as $index => $skill)
            @if($index < 2)
                <span class="bg-{{ $doctor->color }}-100 text-{{ $doctor->color }}-800 px-3 py-1 rounded-full text-sm hover:bg-{{ $doctor->color }}-200 transition-colors">{{ $skill }}</span>
            @endif
        @endforeach
    </div>
</div>