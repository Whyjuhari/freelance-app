@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'pl-10 pr-3 py-3 border border-gray-200 dark:border-gray-600 rounded-md leading-5 bg-gray-50 dark:bg-slate-800 text-text-main-light dark:text-text-main-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm transition duration-300 ease-in-out']) }}>
