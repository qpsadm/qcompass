@extends('layouts.f_layout')

@section('title', '講座情報')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
<div class="container">
    <x-f_page_title :search="false" title="講座情報" />

    <div class="page-content">
        <table>
            <tr>
                <td class="table-title"><p>講座名</p></td>
                <td><h3>{{ $course->course_name }}</h3></td>
            </tr>
            <tr>
                <td class="table-title"><p>概要</p></td>
                <td><p>{{ $course->description }}</p></td>
            </tr>
            <tr>
                <td class="table-title"><p>開始日</p></td>
                <td><p>{{ $course->start_date ?? '---' }}</p></td>
            </tr>
            <tr>
                <td class="table-title"><p>終了日</p></td>
                <td><p>{{ $course->end_date ?? '---' }}</p></td>
            </tr>
            <tr>
                <td class="table-title"><p>日別計画表</p></td>
                <td><a href="{{ $course->plan_path }}">日別計画表を開く</a>
            </tr>
            <tr>
                <td class="table-title"><p>パンフレット</p></td>
                <td><a href="{{ $course->flier_path }}">パンフレットを開く</a></td>
            </tr>
        </table>
    </div>

                    <x-f_btn_list :prevBtn="false" :listBtn="true" :nextBtn="false" listUrl="{{ url('/') }}"
            listLabel="トップへもどる"/>

        <x-f_bread_crumbs />
</div>
@endsection
