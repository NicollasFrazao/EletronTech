{{-- The unit converter. A minimal form until the interface is designed in E9 (#12). --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('unit-converter.title') }} · {{ config('app.name') }}</title>
    <style>
        body { margin: 0; font-family: system-ui, sans-serif; background: #0f172a; color: #e2e8f0; }
        main { max-width: 40rem; margin: 0 auto; padding: 4rem 1rem; }
        label { display: block; margin-top: 1rem; }
        input, select, button { font: inherit; padding: 0.4rem; margin-top: 0.25rem; }
        .error { color: #fca5a5; }
        output { display: block; margin-top: 2rem; font-size: 1.5rem; }
    </style>
</head>
<body>
<main>
    <h1>{{ __('unit-converter.title') }}</h1>
    <p>{{ __('unit-converter.intro') }}</p>

    <form method="post" action="{{ route('tools.unit-converter.convert') }}">
        @csrf
        <label for="value">{{ __('unit-converter.value') }}</label>
        <input id="value" name="value" inputmode="decimal" required value="{{ old('value', $result?->from->value) }}">
        @error('value') <p class="error">{{ $message }}</p> @enderror

        @foreach (['from' => $result?->from->unit->id, 'to' => $result?->to->unit->id] as $field => $selected)
            <label for="{{ $field }}">{{ __('unit-converter.'.$field) }}</label>
            <select id="{{ $field }}" name="{{ $field }}" required>
                @foreach ($groups as $group)
                    <optgroup label="{{ __('unit-converter.dimensions.'.$group->dimension) }}">
                        @foreach ($group->units as $unit)
                            <option value="{{ $unit->id }}" @selected(old($field, $selected) === $unit->id)>{{ $unit->name }} ({{ $unit->symbol }})</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error($field) <p class="error">{{ $message }}</p> @enderror
        @endforeach

        <p><button type="submit">{{ __('unit-converter.convert') }}</button></p>
    </form>

    @isset($result)
        <output aria-label="{{ __('unit-converter.result') }}">
            {{ $result->from->value }} {{ $result->from->unit->symbol }} {{ $result->isExact ? '=' : '≈' }} {{ $result->to->value }} {{ $result->to->unit->symbol }}
        </output>
        @unless ($result->isExact)
            <p>({{ __('unit-converter.rounded') }})</p>
        @endunless
    @endisset
</main>
</body>
</html>
