<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-blue-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 rounded-lg font-semibold transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl']) }}>
    {{ $slot }}
</button>
