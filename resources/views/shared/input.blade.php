@php
    $label ??= null;
    $type ??= null;
    $class ??= null;
    $value ??= '';
    $name ??= '';
    $id ??= '';
    $placeholder ??= '';
    $dataId ??= null;
    $dataType ??= null;
    $dataUrl ??= null;
    $multiple ??= null;
@endphp

<div>
    <label for="{{ $name }}" class="text-sm text-gray-600">{{ $label }}</label>
    @if ($type == 'textarea')
        <textarea id="editor" name="{{ $name }}" wire:model.defer="{{ $name }}" id="{{ $name }}"
            data-id={{ $dataId }} data-type="{{ $dataType }}" data-url="{{ $dataUrl }}"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary">{{ old($name, $value) }}</textarea>
    @elseif ($type == 'select')
        <select name="{{ $name }}" id="{{ $name }}"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary {{ $class }}">
            <option value="">Sélectionnez une option</option>
            @foreach ($options as $k => $v)
                <option value="{{ $k }}" @selected($value === $k)>{{ $v }}</option>
            @endforeach
        </select>
    @else
        <input type="{{ $type }}" placeholder="{{ $placeholder }}" name="{{ $name }}"
            id="{{ $id }}" value="{{ old($name, $value) }}" multiple="{{ $multiple }}"
            wire:model.defer='{{ $name }}'
            class="@error($name)
         border-red-600 @enderror bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary focus:border-primary block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary {{ $class }}">
    @endif
    @error($name)
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>
