<?php

return [
    'permissions' => [
        'Master User' => [
            'create user',
            'edit user',
            'delete user',
            'create role',
            'edit role',
            'delete role'
        ],
        'Master Bank' => [
            'create bank',
            'edit bank',
            'delete bank',
        ],
        'Master Currency' => [
            'create currency',
            'edit currency',
            'hapus currency',
        ],
        'Master Member' => [
            'create member',
            'edit member',
            'hapus member',
        ],
        'Topup' => [
            'create topup',
            'edit topup',
            'hapus topup',
        ],
        'Kurs Rate' => [
            'create kurs rate',
            'edit kurs rate',
            'delete kurs rate'
        ],
    ],
    'company_name' => 'KURS',
    'forgot_password_lifetime' => '3', // in days
];