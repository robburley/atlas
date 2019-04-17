<?php

use Illuminate\Database\Seeder;

class PermissionUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permission_user')->delete();

        \DB::table('permission_user')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 2,
                'permission_id' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => 2,
                'permission_id' => 2,
            ),
            2 =>
            array (
                'id' => 3,
                'user_id' => 2,
                'permission_id' => 3,
            ),
            3 =>
            array (
                'id' => 4,
                'user_id' => 2,
                'permission_id' => 4,
            ),
            4 =>
            array (
                'id' => 5,
                'user_id' => 2,
                'permission_id' => 5,
            ),
            5 =>
            array (
                'id' => 6,
                'user_id' => 2,
                'permission_id' => 7,
            ),
            6 =>
            array (
                'id' => 7,
                'user_id' => 2,
                'permission_id' => 9,
            ),
            7 =>
            array (
                'id' => 8,
                'user_id' => 2,
                'permission_id' => 12,
            ),
            8 =>
            array (
                'id' => 9,
                'user_id' => 2,
                'permission_id' => 13,
            ),
            9 =>
            array (
                'id' => 10,
                'user_id' => 2,
                'permission_id' => 14,
            ),
            10 =>
            array (
                'id' => 11,
                'user_id' => 2,
                'permission_id' => 15,
            ),
            11 =>
            array (
                'id' => 12,
                'user_id' => 2,
                'permission_id' => 16,
            ),
            12 =>
            array (
                'id' => 13,
                'user_id' => 2,
                'permission_id' => 17,
            ),
            13 =>
            array (
                'id' => 14,
                'user_id' => 2,
                'permission_id' => 18,
            ),
            14 =>
            array (
                'id' => 15,
                'user_id' => 2,
                'permission_id' => 19,
            ),
            15 =>
            array (
                'id' => 16,
                'user_id' => 3,
                'permission_id' => 1,
            ),
            16 =>
            array (
                'id' => 17,
                'user_id' => 3,
                'permission_id' => 2,
            ),
            17 =>
            array (
                'id' => 18,
                'user_id' => 3,
                'permission_id' => 3,
            ),
            18 =>
            array (
                'id' => 19,
                'user_id' => 3,
                'permission_id' => 4,
            ),
            19 =>
            array (
                'id' => 20,
                'user_id' => 3,
                'permission_id' => 5,
            ),
            20 =>
            array (
                'id' => 21,
                'user_id' => 3,
                'permission_id' => 9,
            ),
            21 =>
            array (
                'id' => 22,
                'user_id' => 4,
                'permission_id' => 1,
            ),
            22 =>
            array (
                'id' => 23,
                'user_id' => 4,
                'permission_id' => 2,
            ),
            23 =>
            array (
                'id' => 24,
                'user_id' => 4,
                'permission_id' => 3,
            ),
            24 =>
            array (
                'id' => 25,
                'user_id' => 4,
                'permission_id' => 4,
            ),
            25 =>
            array (
                'id' => 26,
                'user_id' => 4,
                'permission_id' => 5,
            ),
            26 =>
            array (
                'id' => 27,
                'user_id' => 4,
                'permission_id' => 6,
            ),
            27 =>
            array (
                'id' => 28,
                'user_id' => 4,
                'permission_id' => 8,
            ),
            28 =>
            array (
                'id' => 29,
                'user_id' => 4,
                'permission_id' => 9,
            ),
            29 =>
            array (
                'id' => 30,
                'user_id' => 4,
                'permission_id' => 10,
            ),
            30 =>
            array (
                'id' => 31,
                'user_id' => 4,
                'permission_id' => 11,
            ),
            31 =>
            array (
                'id' => 32,
                'user_id' => 4,
                'permission_id' => 12,
            ),
            32 =>
            array (
                'id' => 33,
                'user_id' => 4,
                'permission_id' => 13,
            ),
            33 =>
            array (
                'id' => 34,
                'user_id' => 4,
                'permission_id' => 14,
            ),
            34 =>
            array (
                'id' => 35,
                'user_id' => 4,
                'permission_id' => 15,
            ),
            35 =>
            array (
                'id' => 36,
                'user_id' => 4,
                'permission_id' => 16,
            ),
            36 =>
            array (
                'id' => 37,
                'user_id' => 4,
                'permission_id' => 17,
            ),
            37 =>
            array (
                'id' => 38,
                'user_id' => 4,
                'permission_id' => 18,
            ),
            38 =>
            array (
                'id' => 39,
                'user_id' => 4,
                'permission_id' => 19,
            ),
            39 =>
                array (
                    'id' => 40,
                    'user_id' => 4,
                    'permission_id' => 20,
                ),
            40 =>
                array (
                    'id' => 41,
                    'user_id' => 4,
                    'permission_id' => 21,
                ),
            42 =>
                array (
                    'id' => 43,
                    'user_id' => 2,
                    'permission_id' => 20,
                ),
        ));


    }
}