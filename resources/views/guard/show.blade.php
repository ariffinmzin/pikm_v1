<x-layouts.app>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            Guard Details
        </h1>
        <a href="{{ route('guard.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Photo Section -->
                <div class="md:col-span-1">
                    @if ($guard->photo_path)
                        <img src="{{ Storage::url($guard->photo_path) }}" alt="{{ $guard->full_name }}'s photo"
                            class="w-full rounded-lg shadow-md">
                    @else
                        <div
                            class="w-full aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 dark:text-gray-500">No photo available</span>
                        </div>
                    @endif
                </div>

                <!-- Details Section -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $guard->full_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NRIC (Last 4)</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    XXXXXX-XX-{{ $guard->nric_last4 }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guard->dob ? date('d M Y', strtotime($guard->dob)) : 'Not provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guard->gender ? ($guard->gender === 'M' ? 'Male' : 'Female') : 'Not provided' }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guard->email ?? 'Not provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guard->contact_no ?? 'Not provided' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Medical Information -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Medical Information</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Blood Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $guard->blood_type ?? 'Not provided' }}</dd>
                            </div>
                        </dl>
                    </div>

                    @if ($guard->remarks)
                        <!-- Remarks -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Remarks</h3>
                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">
                                {{ $guard->remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
