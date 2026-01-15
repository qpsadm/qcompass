<x-guest-layout>
    <!-- セッションステータス -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Course 選択 / 表示 -->
        @if ($showCourse)
        <div class="login-item">
            <div class="item-box">
                <label for="course_id">講座名</label>

                @if ($selected_course)
                @php
                $course = $courses->find($selected_course);
                $days = $course?->loginRemainingDays;
                $endDate = $course?->end_date
                ? \Carbon\Carbon::parse($course->end_date)->format('Y/m/d')
                : null;

                $color =
                !$course?->isLoginable() ? 'text-gray-400'
                : ($days !== null && $days <= 7 ? 'text-red-600'
                    : ($days !==null && $days <=14 ? 'text-yellow-600'
                    : 'text-gray-700' ));
                    @endphp

                    <span class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                    {{ $course->course_name ?? '不明なコース' }}

                    <span class="ml-2 text-sm {{ $color }}"
                        @if ($endDate)
                        title="終了日：{{ $endDate }}"
                        @endif>
                        @if (!$course?->isLoginable())
                        🔒 不可
                        @elseif ($days === null)
                        🔓 利用可
                        @else
                        🔓 {{ $days }}日
                        @endif
                    </span>
                    </span>

                    <input type="hidden" name="course_id" value="{{ $selected_course }}">
                    @else
                    <select id="course_id" name="course_id" required
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm
       focus:ring-indigo-500 focus:border-indigo-500">

                        <option value="">選択してください</option>

                        @foreach ($courses as $course)
                        @php
                        $days = $course->loginRemainingDays;

                        // ログイン不可なら赤文字、期間が短い場合は黄色
                        $color =
                        !$course->isLoginable() ? 'text-red-600'
                        : ($days !== null && $days <= 7 ? 'text-red-600'
                            : ($days !==null && $days <=14 ? 'text-yellow-600'
                            : 'text-gray-700' ));
                            @endphp

                            <option value="{{ $course->id }}"
                            class="{{ $color }}"
                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                            @if (!$course->isLoginable())
                            🔒 不可
                            @elseif ($days === null)
                            🔓 利用可
                            @else
                            🔓 {{ $days }}日
                            @endif
                            </option>
                            @endforeach
                    </select>

                    @endif
            </div>

            <x-input-error :messages="$errors->get('course_id')" class="error-msg" />
        </div>
        @endif


        <!-- Email -->
        <div class="login-item">
            <div class="item-box">
                <label for="email">E-mail</label>
                <x-text-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="example@example.com"
                    required
                    autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="error-msg" />
        </div>

        <!-- Password -->
        <div class="login-item">
            <div class="item-box password">
                <label for="password">パスワード</label>
                <x-text-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    placeholder="パスワードを入力してください"
                    required
                    autocomplete="current-password" />
                <button class="eye-btn" type="button" onclick="togglePass()">
                    <img class="eye-open" src="{{ asset('assets/images/icon/f_icon_eye_open.svg') }}" alt="">
                    <img class="eye-close" src="{{ asset('assets/images/icon/f_icon_eye_close.svg') }}" alt="">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="error-msg" />
        </div>

        <p class="considerations">
            ※パスワード等をお忘れの場合は、管理者までお問い合わせください。
        </p>

        <div class="login-btn-container">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
