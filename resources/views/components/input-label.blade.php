@props([
    'name' => '',
    'value' => old($name),
    'type' => match ($name) {
        'email' => 'email',
        'password', 'password_confirmation', 'new_password' => 'password',
        'phone_number' => 'tel',
        default => 'text',
    },
])

<label for="{{ $name }}">
    @if($slot->isEmpty())
        {{__(ucfirst(str_replace('_', ' ', $name)))}}
    @else
        {{ $slot }}
    @endif
</label>
<input type="{{ $type }}"
       id="{{ $name }}"
       value="{{ $value }}"
       name="{{ $name }}"
       {!! $attributes->merge(['class' => 'form-control mb-2']) !!}/>
