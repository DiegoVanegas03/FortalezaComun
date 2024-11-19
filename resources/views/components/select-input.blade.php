<select {!! $attributes->except(['options', 'selected', 'requerido'])->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    @if(!$requerido)
        <option value="">Seleccionar valor</option>
    @endif
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
