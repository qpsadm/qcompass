<!DOCTYPE html>
<html lang="ja">
    {{-- <head>内の情報を呼び出す --}}
    @include('includes.head')
<body>
    {{-- <header>内の情報を呼び出す --}}
    @include('includes.header')

    {{-- <main>内の情報を呼び出す --}}
    @include('includes.main')

    {{-- <footer>内の情報を呼び出す --}}
    @include('includes.footer')

    {{-- JavaScript --}}
    @yield('myjs')
</body>
</html>
