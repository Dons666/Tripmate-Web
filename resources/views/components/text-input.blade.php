<input @class([
    'block w-full rounded-xl border-gray-200 text-sm shadow-sm transition duration-150 ease-in-out py-3 px-4',
    'focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500',
    'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' => $errors->has($attributes->get('name')),
]) {{ $attributes }} />