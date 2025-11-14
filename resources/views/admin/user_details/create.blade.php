@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">UserDetail作成</h1>
        <form action="{{ route('admin.user_details.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">user_id</label>
                <input type="text" name="user_id" value="{{ old('user_id', $UserDetail->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">birthday</label>
                <input type="text" name="birthday" value="{{ old('birthday', $UserDetail->birthday ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">gender</label>
                <input type="text" name="gender" value="{{ old('gender', $UserDetail->gender ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">phone1</label>
                <input type="text" name="phone1" value="{{ old('phone1', $UserDetail->phone1 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">phone2</label>
                <input type="text" name="phone2" value="{{ old('phone2', $UserDetail->phone2 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">postal_code</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $UserDetail->postal_code ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">address1</label>
                <input type="text" name="address1" value="{{ old('address1', $UserDetail->address1 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">address2</label>
                <input type="text" name="address2" value="{{ old('address2', $UserDetail->address2 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">emergency_contact</label>
                <input type="text" name="emergency_contact"
                    value="{{ old('emergency_contact', $UserDetail->emergency_contact ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">avatar_path</label>
                <input type="text" name="avatar_path" value="{{ old('avatar_path', $UserDetail->avatar_path ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">theme_color</label>
                <input type="text" name="theme_color" value="{{ old('theme_color', $UserDetail->theme_color ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">status</label>
                <input type="text" name="status" value="{{ old('status', $UserDetail->status ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">is_show</label>
                <input type="text" name="is_show" value="{{ old('is_show', $UserDetail->is_show ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">divisions_id</label>
                <input type="text" name="divisions_id"
                    value="{{ old('divisions_id', $UserDetail->divisions_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">bio</label>
                <input type="text" name="bio" value="{{ old('bio', $UserDetail->bio ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">memo1</label>
                <input type="text" name="memo1" value="{{ old('memo1', $UserDetail->memo1 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">memo2</label>
                <input type="text" name="memo2" value="{{ old('memo2', $UserDetail->memo2 ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">joining_date</label>
                <input type="text" name="joining_date"
                    value="{{ old('joining_date', $UserDetail->joining_date ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">leaving_date</label>
                <input type="text" name="leaving_date"
                    value="{{ old('leaving_date', $UserDetail->leaving_date ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">leaving_reason</label>
                <input type="text" name="leaving_reason"
                    value="{{ old('leaving_reason', $UserDetail->leaving_reason ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">created_user_id</label>
                <input type="text" name="created_user_id"
                    value="{{ old('created_user_id', $UserDetail->created_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">updated_user_id</label>
                <input type="text" name="updated_user_id"
                    value="{{ old('updated_user_id', $UserDetail->updated_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">deleted_at</label>
                <input type="text" name="deleted_at" value="{{ old('deleted_at', $UserDetail->deleted_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">deleted_user_id</label>
                <input type="text" name="deleted_user_id"
                    value="{{ old('deleted_user_id', $UserDetail->deleted_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
        </form>
    </div>
@endsection
