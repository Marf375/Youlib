@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#9370db]   dark:text-black focus:border-[#e3fc3d] dark:focus:border-[#e3fc3d] dark:focus:ring-0 dark:active:border-[#e3fc3d]  rounded-md shadow-sm']) }}>
