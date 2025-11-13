<x-guest-layout>
    <!-- セッションステータス -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Course 選択 / 表示 -->
        <div>
            <x-input-label for="course_id" :value="__('Course')" />

            @if ($selected_course)
                {{-- URLで指定された場合はラベル表示 --}}
                <span class="block mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                    {{ $courses->find($selected_course)->course_name ?? '不明なコース' }}
                </span>
                <input type="hidden" name="course_id" value="{{ $selected_course }}">
            @else
                {{-- URL指定なしならセレクトボックス --}}
                <select id="course_id" name="course_id" required
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">選択してください</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
            @endif

            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
        </div>



        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="login_name" :value="__('Name')" />
            <x-text-input id="login_name" class="block mt-1 w-full" type="text" name="login_name" :value="old('login_name')"
                required autofocus />
            <x-input-error :messages="$errors->get('login_name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
