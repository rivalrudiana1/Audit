@if (session('success'))
    <div class="mb-5 flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
        <div class="flex items-center gap-3">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    </div>
@endif