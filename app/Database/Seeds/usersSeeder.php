<?php

namespace App\Database\Seeds;

use Myth\Auth\Password;
use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class usersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'               => 1,
                'email'            => 'admin@admin.com',
                'username'         => 'admin',
                'full_name'         => 'Administrator',
                'user_image'       => 'users.png',
                'password_hash'    => Password::hash('password'),
                'reset_hash'       => null,
                'reset_at'         => null,
                'reset_expires'    => null,
                'activate_hash'    => null,
                'status'           => null,
                'status_message'   => null,
                'active'           => 1,
                'force_pass_reset' => 0,
                'created_at'       => date('Y-m-d'),
                'updated_at'       => date('Y-m-d'),
                'deleted_at'       => null,
            ],
            [
                'id'               => 2,
                'email'            => 'user@user.com',
                'username'         => 'user',
                'full_name'         => 'User',
                'user_image'       => 'users.png',
                'password_hash'    => Password::hash('password'),
                'reset_hash'       => null,
                'reset_at'         => null,
                'reset_expires'    => null,
                'activate_hash'    => null,
                'status'           => null,
                'status_message'   => null,
                'active'           => 1,
                'force_pass_reset' => 0,
                'created_at'       => date('Y-m-d'),
                'updated_at'       => date('Y-m-d'),
                'deleted_at'       => null,
            ]
        ];


        $this->db->table('users')->insertBatch($data);

        $data = [
            [
                'id' => 1,
                'name'     => 'SuperAdmin',
                'description' => 'Administrator',
            ],
            [
                'id' => 2,
                'name'     => 'Admin',
                'description' => 'Administrator',
            ],
            [
                'id' => 3,
                'name'     => 'User',
                'description' => 'User',
            ]
        ];

        $this->db->table('auth_groups')->insertBatch($data);

        $data = [
            [
                'user_id'          => 1,
                'group_id'         => 1,
            ],
            [
                'user_id'          => 2,
                'group_id'         => 3,
            ]
        ];
        $this->db->table('auth_groups_users')->insertBatch($data);
    }
}
