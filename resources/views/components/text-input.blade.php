@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 rounded-xl shadow-sm px-4 py-2.5 transition duration-200 bg-slate-50/40 focus:bg-white text-slate-800 placeholder-slate-400']) !!}>
