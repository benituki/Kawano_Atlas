<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '仮田',
                'under_name' => '一郎',
                'over_name_kana' => 'カリタ',
                'under_name_kana' => 'イチロウ',
                'mail_address' => 'test@test.com',
                'sex' => '1',
                'birth_day' => '1999-01-25',
                'role' => '1',
                'password' => Hash::make('test1234')
            ],
            [
                'over_name' => '本田',
                'under_name' => '次郎',
                'over_name_kana' => 'ホンダ',
                'under_name_kana' => 'ジロウ',
                'mail_address' => 'test2@test.com',
                'sex' => '1',
                'birth_day' => '1999-01-25',
                'role' => '2',
                'password' => Hash::make('test1234')
            ]
        ]);

        DB::table('subject_users')->insert([
            [
                'user_id' => '1',
                'subject_id' => '1'
            ],
            [
                'user_id' => '2',
                'subject_id' => '2'
            ]
        ]);
    }
}

// php artisan migrate;
// リセット（1から）php artisan 