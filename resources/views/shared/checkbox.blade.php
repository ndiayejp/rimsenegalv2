@php
    $class ??= '';
    $name ??= '';
    $label ??= '';
    $value ??= '';
@endphp
<div @class(['my-3', $class])>
    <input name="{{ $name }}" value="0" type="hidden">
    <input @checked(old($name, $value)) name="{{ $name }}" value="1" role="switch" type="checkbox"
        class="@error($name)
 border border-red-600 @enderror w-4 h-4  text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
    <label for="{{ $name }}" class="text-sm text-gray-600">{{ $label }}</label>
    @error($name)
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>
