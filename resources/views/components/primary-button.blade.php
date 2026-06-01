<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full justify-center inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:from-indigo-700 hover:to-purple-700 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-indigo-600/20 transition-all duration-200 shadow-md shadow-indigo-600/10 hover:shadow-lg hover:shadow-indigo-600/20 cursor-pointer']) }}>
    {{ $slot }}
</button>
