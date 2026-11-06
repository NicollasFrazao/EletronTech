<?php

declare(strict_types=1);

return [
    'title' => 'Unit converter',
    'intro' => 'Converts a value between units of the same quantity. The conversion is exact; the result is rounded to 12 significant digits.',
    'value' => 'Value',
    'from' => 'From',
    'to' => 'To',
    'convert' => 'Convert',
    'result' => 'Result',
    'rounded' => 'rounded',
    'dimensions' => [
        'voltage' => 'Voltage',
        'current' => 'Current',
        'power' => 'Power',
        'apparent_power' => 'Apparent power',
        'resistance' => 'Resistance',
        'conductance' => 'Conductance',
        'capacitance' => 'Capacitance',
        'inductance' => 'Inductance',
        'charge' => 'Charge',
        'frequency' => 'Frequency',
        'length' => 'Length',
        'area' => 'Area',
        'reactive_power' => 'Reactive power',
        'magnetic_flux' => 'Magnetic flux',
        'energy' => 'Energy',
        'duration' => 'Duration',
        'luminous_flux' => 'Luminous flux',
        'illuminance' => 'Illuminance',
    ],
    'errors' => [
        'invalid_number' => 'Type a number, such as 1.5, 1,5 or 4.7e-6, with at most 40 digits.',
        'unknown_unit' => 'Choose a unit from the list.',
        'incompatible_units' => 'Both units must measure the same quantity.',
    ],
];
