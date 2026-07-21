<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full flex justify-center items-center gap-2 bg-sky-500 text-white font-bold py-3 px-4 rounded-xl shadow-sm hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>