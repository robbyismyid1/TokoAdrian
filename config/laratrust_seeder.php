<?php

return [
    'role_structure' => [
        'super_admin' => [
            'kategori' => 'c,r,u,d',
            'produk' => 'c,r,u,d',
            'penjualan' => 'c,r,u,d',
            'pembelian' => 'c,r,u,d',
            'pemasok' => 'c,r,u,d',
            'klien' => 'c,r,u,d',
            'pengeluaran' => 'c,r,u,d',
            'kotakuang' => 'c,r,u,d',
            'users' => 'c,r,u,d',
            'pengaturan' => 'c,r,u,d',
        ],
        'employer' => []
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
