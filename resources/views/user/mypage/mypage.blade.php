@extends('layouts.f_layout')

@section('title', 'マイページ')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_mypage.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- プロフィールモーダル -->
        <div class="modal-profile">
            <div class="profile-data">
                <h4>{{ $user->name }}</h4>
                <p class="mail">{{ $user->email ?? '未登録' }}</p>
                <p class="tel">{{ $user_details?->phone1 ?? '未登録' }}</p>
                <p class="birthday">{{ $user_details?->birthday ? $user_details->birthday->format('Y/m/d') : '未登録' }}</p>

                <div class="btn-area">
                    <button class="close-btn">とじる</button>
                </div>
            </div>
        </div>

        <!-- カスタマイズモーダル -->
        <div class="modal-customize">
            <form id="customize-form" action="{{ route('user.settings.update') }}" method="POST">
                @csrf

                @php
                    $initialTheme = $user->detail->theme_id ?? 1;
                    $fontSize = $user_details->fontsize ?? 2;
                    $avatarType = $user_details->avatar_type ?? 1;
                @endphp

                <div class="form-container">

                    <!-- テーマカラー選択 -->
                    <div class="theme-color-select">
                        <p>テーマカラー</p>
                        <div class="radio-container">
                            @foreach ($themes as $theme)
                                <input type="radio" id="theme-{{ $theme->id }}" name="theme_id"
                                    value="{{ $theme->id }}" {{ $initialTheme == $theme->id ? 'checked' : '' }}>
                                <label for="theme-{{ $theme->id }}">{{ $theme->name }}</label>
                            @endforeach
                        </div>
                    </div>

                    <!-- フォントサイズ選択 -->
                    <div class="font-size-select">
                        <label for="">フォントサイズ</label>
                        <div class="radio-container">
                            <input type="radio" id="small" name="fontsize" value="1"
                                {{ $fontSize == 1 ? 'checked' : '' }}>
                            <label for="small">標準</label>

                            <input type="radio" id="medium" name="fontsize" value="2"
                                {{ $fontSize == 2 ? 'checked' : '' }}>
                            <label for="medium">中</label>

                            <input type="radio" id="large" name="fontsize" value="3"
                                {{ $fontSize == 3 ? 'checked' : '' }}>
                            <label for="large">大</label>
                        </div>
                        <p class="note">※フォントサイズの変更は、各ページの詳細画面および日報作成フォーム内にのみ適用されます。</p>
                    </div>
                </div>

                <div class="btn-area">
                    <button type="submit" class="change-btn">変更する</button>
                </div>
            </form>
            <div class="btn-area">
                <button class="close-btn">とじる</button>
            </div>
        </div>

        <!-- アバターモーダル -->
        <div class="modal-avatar">
            <form id="avatar-form" action="{{ route('user.settings.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @php
                    $avatarType = $user_details->avatar_type ?? 1;
                    $userAvatarPath = $user_details?->user_avatar_path ?? null;
                @endphp

                <div class="form-container">
                    <div class="avatar">
                        <label>アバター画像</label>
                        <div class="img-container">

                            {{-- デフォルト 1〜15 --}}
                            @for ($i = 1; $i <= 15; $i++)
                                <input type="radio" id="avatar{{ $i }}" name="avatar_type"
                                    value="{{ $i }}" {{ $avatarType == $i ? 'checked' : '' }}>
                                <label for="avatar{{ $i }}">
                                    <img src="{{ asset("assets/images/profile/f_profile_image{$i}.svg") }}"
                                        class="avatar-img">
                                </label>
                            @endfor

                            {{-- カスタム 99 --}}
                            <input type="radio" id="avatar99" name="avatar_type" value="99"
                                {{ $avatarType == 99 ? 'checked' : '' }}>
                            <label for="avatar99" id="customPreviewLabel"
                                class="{{ $avatarType == 99 && $userAvatarPath ? 'selected' : 'is-hidden' }}">
                                <img id="preview99" class="preview avatar-img"
                                    src="{{ $userAvatarPath ? asset('storage/' . $userAvatarPath) : '' }}"
                                    style="{{ $userAvatarPath ? 'visibility: visible;' : 'visibility: hidden;' }}">
                            </label>

                            {{-- ファイル選択ボタン --}}
                            <label id="btnSelectFile">
                                <img src="{{ asset('assets/images/profile/f_profile_imageadd.svg') }}" class="avatar-img">
                            </label>
                            <input type="file" id="fileInput" name="avatar_file" accept="image/*" hidden>
                        </div>
                    </div>
                </div>

                <div class="btn-area">
                    <button type="submit" class="change-btn">変更する</button>
                </div>
            </form>
            <div class="btn-area">
                <button class="close-btn">とじる</button>
            </div>
        </div>


        <!-- オーバーレイ -->
        <div class="overlay"></div>

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="マイページ" />

        <!-- プロフィール -->
        <div class="section-flex">
            <div class="section-box profile">
                <div class="box-title">
                    <h3>プロフィール</h3>
                </div>
                <div class="box-content">
                    <div class="profile-icon">
                        <img src="{{ $user_details->avatar_type_image ?? asset('assets/images/f_profile_image1.svg') }}"
                            alt="プロフィール画像">
                    </div>
                    <div class="profile-data">
                        <div>
                            <h4>{{ $user->name }}</h4>
                            <p class="mail">{{ $user->email ?? '未登録' }}</p>

                            <p class="course">
                                {{ session('current_course_name') ?? '未設定' }}
                            </p>

                            <p class="division">{{ $divisions->name ?? '未設定' }}</p>
                            <p class="division-tel">（{{ $divisions->tel ?? '未設定' }}）</p>
                        </div>
                        <div class="btn-area">
                            <button class="open-btn-profile">プロフィールをみる</button>
                            <button class="open-btn-avatar">アイコン変更</button>
                            <button class="open-btn-customize">カスタマイズ</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- カレンダー -->
            <div class="section-box calendar">
                <div class="box-title">
                    <h3>日報カレンダー</h3>
                </div>
                <div class="box-content">
                    <div id="calendar"></div>
                    <p>※日報を提出した日はチェックマークが表示されます。<br>　提出し忘れていないかチェックしましょう。</p>
                </div>
            </div>
        </div>

        <!-- 各種スケジュール -->
        <div class="section-box">
            <div class="box-title">
                <h3>各種スケジュール</h3>
            </div>
            <div class="box-content">
                <x-f_content_list :items="$scheduledAnnouncements" />
            </div>
        </div>

        <!-- メモ -->
        <div class="section-box memo">
            <div class="box-title">
                <h3>簡易メモエディター</h3>
            </div>

            <div class="box-content">
                <form id="memo-form" class="memo-form" method="POST" action="{{ route('user.memo.save') }}">
                    @csrf
                    <textarea name="memo" id="memo-textarea" rows="6">{{ $user_details->memo ?? '' }}</textarea>
                    <button type="submit">保存</button>
                </form>
                <div id="memo-success">
                    <p>メモを保存しました</p>
                </div>
            </div>
            <div style="margin-top: 15px; padding: 10px; border-left: 4px solid #ffc107; border-radius: 4px;">
                <p style="margin: 0; font-size: 14px; color: #664d03;">
                    講習や就職支援や日報などの簡易メモとしてご利用ください。<br>
                    <span style="color: #dc3545; font-weight: bold;">※プログラムのソースコードは記録しないようお願いいたします。</span>
                </p>
            </div>
        </div>

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection

@section('code-page-js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.19/locales/ja.global.min.js"></script>

    <script src="{{ asset('assets/js/f_mypage.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ja', // 💡ロケールファイルを読み込んだことで、これが効くようになります
                buttonText: {
                    today: '本日' // 💡これで月を変えても「本日」に固定されます
                }
            });

            calendar.render();
        });
    </script>

    <!-- PHP データを JS に渡す -->
    @php
        $pendingJs = collect($pending_diaries)->map(function ($d) {
            return [
                'title' => '',
                'start' => $d->date,
                'allDay' => true,
                'backgroundColor' => 'transparent',
                'borderColor' => 'transparent',
                'extendedProps' => [
                    'isPending' => true,
                    'url' => $d->url,
                ],
            ];
        });

        $submittedJs = collect($submitted_reports)->map(function ($r) {
            return [
                'title' => '',
                'start' => \Carbon\Carbon::parse($r->date)->format('Y-m-d'),
                'allDay' => true,
                'backgroundColor' => 'transparent',
                'borderColor' => 'transparent',
                'extendedProps' => [
                    'isPending' => false,
                    'url' => route('user.reports.info', ['report' => $r->id]),
                ],
            ];
        });
    @endphp

    <script>
        window.pendingEvents = @json($pendingJs);
        window.submittedEvents = @json($submittedJs);
        window.APP_URL = "{{ url('/') }}";
    </script>


@endsection
