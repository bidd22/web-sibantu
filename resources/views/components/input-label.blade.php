@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-[11px] uppercase tracking-wider text-slate-500 mb-1']) }}>
    {{ $value ?? $slot }}
</label>
