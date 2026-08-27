<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Seating Layout Designer Draggable Objects
    |--------------------------------------------------------------------------
    |
    | Here you can configure the items that appear in the "Object List" sidebar
    | of the Seating Layout Designer. These can be dragged and dropped
    | onto the seating map canvas to create entry points, exits, structures, etc.
    |
    */
    'objects' => [
        [
            'type' => 'entry',
            'label' => 'Entry Gate',
            'icon' => 'fa-solid fa-door-open',
            'color' => '#10b981',
            'category' => 'Gates & Openings'
        ],
        [
            'type' => 'exit',
            'label' => 'Exit Gate',
            'icon' => 'fa-solid fa-door-closed',
            'color' => '#ef4444',
            'category' => 'Gates & Openings'
        ],
        [
            'type' => 'emergency_exit',
            'label' => 'Emergency Exit',
            'icon' => 'fa-solid fa-person-running',
            'color' => '#dc2626',
            'category' => 'Gates & Openings'
        ],
        [
            'type' => 'stage',
            'label' => 'Stage Area',
            'icon' => 'fa-solid fa-chalkboard',
            'color' => '#1e293b',
            'category' => 'Structures'
        ],
        [
            'type' => 'bar',
            'label' => 'Bar / Concession',
            'icon' => 'fa-solid fa-glass-martini-alt',
            'color' => '#f59e0b',
            'category' => 'Facilities'
        ],
        [
            'type' => 'restroom',
            'label' => 'Restroom',
            'icon' => 'fa-solid fa-restroom',
            'color' => '#3b82f6',
            'category' => 'Facilities'
        ],
        [
            'type' => 'info',
            'label' => 'Info Desk',
            'icon' => 'fa-solid fa-circle-info',
            'color' => '#06b6d4',
            'category' => 'Facilities'
        ]
    ]
];
