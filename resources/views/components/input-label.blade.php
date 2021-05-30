@props(['disabled' => false, 'name' => '', 'value' => '', 'type' => 'text'])

<label for="{{ $name }}">{{ $slot }}</label>
<input type="{{ $type }}"
       id="{{ $name }}"
       value="{{ $value }}"
       name="{{ $name }}"
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['class' => 'form-control mb-2']) !!}/>
