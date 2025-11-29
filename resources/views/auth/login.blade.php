<x-guest-layout>
    <!-- セッションステータス -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="login-item">
            <label for="name">会社名</label>
            <p>株式会社 QLIP</p>
        </div>

        <!-- Course 選択 / 表示 -->
        <div class="login-item">

            {{-- <x-input-label for="course_id" :value="__('Course')" /> --}}
            <label for="name">講座名</label>

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
        <div class="login-item">
            {{-- <x-input-label for="login_name" :value="__('Name')" /> --}}
            <label for="name">お名前</label>
            <x-text-input id="login_name" class="block mt-1 w-full" type="text" name="login_name" :value="old('login_name')" placeholder="yamada_taro" required autofocus />
            <x-input-error :messages="$errors->get('login_name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="login-item">
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            <label for="name">パスワード</label>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="パスワードを入力してください" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <p class="considerations">※パスワード等をお忘れの場合は、管理者までお問い合わせください。</p>

        <!-- Remember Me -->
        <div class="remember-me">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="login-btn-container">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
