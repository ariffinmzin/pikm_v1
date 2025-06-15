<x-layouts.app>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Add New Guard') }}
        </h1>
        <a href="{{ route('guard.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <form action="{{ route('guard.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <div>
                        <x-forms.input label="NRIC Number" name="nric" required autofocus
                            placeholder="Enter NRIC number" :value="old('nric')" class="font-mono" maxlength="14"
                            pattern="\d{6}-\d{2}-\d{4}" title="Format: 123456-12-1234 (with hyphens)"
                            oninput="
                                let val = this.value.replace(/[^0-9]/g, '');
                                if (val.length > 6) {
                                    val = val.substr(0,6) + '-' + val.substr(6);
                                }
                                if (val.length > 9) {
                                    val = val.substr(0,9) + '-' + val.substr(9);
                                }
                                if (val.length > 14) {
                                    val = val.substr(0,14);
                                }
                                this.value = val;
                            " />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Format: 123456-12-1234 (with hyphens)
                        </p>
                    </div>

                    <div>
                        <x-forms.input label="Full Name" name="full_name" required
                            placeholder="Enter full name as per NRIC" :value="old('full_name')" />
                    </div>

                    <div>
                        <x-forms.input label="Date of Birth" name="dob" type="date" :value="old('dob')" />
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Gender
                        </label>
                        <select name="gender" id="gender"
                            class="w-full px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Gender</option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="blood_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Blood Type
                        </label>
                        <select name="blood_type" id="blood_type"
                            class="w-full px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Blood Type</option>
                            @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                                <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_type')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Contact and Additional Information -->
                <div class="space-y-6">
                    <div>
                        <x-forms.input label="Contact Number" name="contact_no" placeholder="Enter contact number"
                            :value="old('contact_no')" />
                    </div>

                    <div>
                        <x-forms.input label="Email Address" name="email" type="email"
                            placeholder="Enter email address" :value="old('email')" />
                    </div>

                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Photo
                        </label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="photo" id="photo" accept="image/*"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                dark:file:bg-blue-900 dark:file:text-blue-200
                                hover:file:bg-blue-100 dark:hover:file:bg-blue-800" />
                        </div>
                        @error('photo')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Upload a clear photo. Maximum size 2MB.
                        </p>
                    </div>

                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Remarks
                        </label>
                        <textarea name="remarks" id="remarks" rows="3"
                            class="w-full px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter any additional remarks">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Create Guard') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
