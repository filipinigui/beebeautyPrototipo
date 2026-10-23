<?php
/** Dados de exemplo usados enquanto o banco MySQL não existe. */
return [
    'services' => [
        ['id' => 1,  'category' => 'Hair',  'name' => 'Haircut',            'price' => 'from $80',  'featured' => 1],
        ['id' => 2,  'category' => 'Hair',  'name' => 'Tint',               'price' => 'from $120', 'featured' => 0],
        ['id' => 3,  'category' => 'Hair',  'name' => 'Highlights',         'price' => 'from $220', 'featured' => 0],
        ['id' => 4,  'category' => 'Hair',  'name' => 'Balayage',           'price' => 'from $300', 'featured' => 0],
        ['id' => 5,  'category' => 'Hair',  'name' => 'Brazilian Keratin',  'price' => 'from $250', 'featured' => 0],
        ['id' => 6,  'category' => 'Hair',  'name' => 'Botox Capilar',      'price' => 'from $180', 'featured' => 0],
        ['id' => 7,  'category' => 'Brows', 'name' => 'Brow Design',        'price' => 'from $45',  'featured' => 1],
        ['id' => 8,  'category' => 'Brows', 'name' => 'Brow Lamination',    'price' => 'from $85',  'featured' => 0],
        ['id' => 9,  'category' => 'Brows', 'name' => 'Microblading',       'price' => 'from $450', 'featured' => 0],
        ['id' => 10, 'category' => 'Lashes & Makeup', 'name' => 'Lash Lift', 'price' => 'from $95', 'featured' => 0],
        ['id' => 11, 'category' => 'Lashes & Makeup', 'name' => 'Makeup',    'price' => 'from $110', 'featured' => 0],
    ],
    'team' => [
        ['id' => 1, 'name' => 'Team member 1', 'role' => 'Hair colour specialist', 'photo' => ''],
        ['id' => 2, 'name' => 'Team member 2', 'role' => 'Brow and lash artist',   'photo' => ''],
        ['id' => 3, 'name' => 'Team member 3', 'role' => 'Stylist',                'photo' => ''],
    ],
    'gallery' => [
        ['id' => 1, 'title' => 'Balayage',       'before' => '', 'after' => ''],
        ['id' => 2, 'title' => 'Brow lamination', 'before' => '', 'after' => ''],
        ['id' => 3, 'title' => 'Haircut',        'before' => '', 'after' => ''],
    ],
    'reviews' => [
        ['id' => 1, 'author' => 'Client name', 'text' => 'Texto de avaliação 5 estrelas do Google/Instagram.', 'stars' => 5],
        ['id' => 2, 'author' => 'Client name', 'text' => 'Texto de avaliação 5 estrelas do Google/Instagram.', 'stars' => 5],
        ['id' => 3, 'author' => 'Client name', 'text' => 'Texto de avaliação 5 estrelas do Google/Instagram.', 'stars' => 5],
    ],
    'bookings' => [
        ['id' => 1, 'name' => 'Maria Silva',  'service' => 'Balayage',      'date' => '2026-10-23 10:00', 'phone' => '0400 111 222', 'status' => 'pending'],
        ['id' => 2, 'name' => 'Jane Smith',   'service' => 'Brow Design',   'date' => '2026-10-23 14:30', 'phone' => '0400 333 444', 'status' => 'confirmed'],
        ['id' => 3, 'name' => 'Ana Costa',    'service' => 'Haircut',       'date' => '2026-10-24 09:00', 'phone' => '0400 555 666', 'status' => 'pending'],
    ],
];
