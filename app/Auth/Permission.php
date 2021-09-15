<?php

namespace App\Auth;

class Permission
{
    public const lists = [
        'admin' => [
            'user' => [
                '*',
            ],
            'asset' => [
                '*',
            ],
        ],
        'mis_office_personnel' => [
            'user' => [
                '*' => [
                    'read'
                ],
            ],
            'asset' => [
                'read',
                'show',
            ],
        ],
        'supply_office_personnel' => [
            'user' => [
                '*' => [
                    'read'
                ],
            ],
            'asset' => [
                '*',
            ],
            'job' => [
                '*'
            ],
        ],
        'employee' => [
            'user' => [
                '*' => [
                    'read'
                ],
            ],
            'asset' => [
                'read',
                'show',
            ],
            'job' => [
                '*'
            ],
        ],
    ];
}