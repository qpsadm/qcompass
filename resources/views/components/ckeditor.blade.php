{{-- resources/views/components/ckeditor.blade.php --}}
<textarea {{ $attributes->merge(['class' => 'ckeditor']) }}>{{ $slot }}</textarea>
