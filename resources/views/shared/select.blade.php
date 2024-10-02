@php
    $label ??= null;
    $class ??= null;
    $value ??= '';
    $name ??= '';
@endphp
<div @class(['', $class])>
    <label for="{{ $name }}" class="text-sm text-gray-600">{{ $label }}</label>
    <select name="{{ $name }}[]" id="{{ $name }}" multiple
        class="w-full text-gray-700 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
        @foreach ($options as $k => $v)
            <option @selected($value->contains($k)) value="{{ $k }}">{{ $v }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>
