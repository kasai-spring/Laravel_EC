<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")
            ->insert([[
                "email" => "admin@admin.com",
                "password" => Hash::make("password"),
                "user_name" => "admin",
                "created_at" => now(),
                "updated_at" => now(),
                "last_logined_at" => now(),
            ],[
               "email" => "test@test.com",
               "password" => Hash::make("password"),
               "user_name" => "test",
               "created_at" => now(),
               "updated_at" => now(),
               "last_logined_at" => now(),
            ]]);
        DB::table("user_roles")
            ->insert([
                "role_id" => 1,
                "user_id" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        DB::table("addresses")
            ->insert([[
                "user_id" => "1",
                "postcode" => strval(Crypt::encrypt("7550047")),
                "prefecture" => strval(Crypt::encrypt("山口県")),
                "city_street" => strval(Crypt::encrypt("宇部市島4-12-13")),
                "addressee" => strval(Crypt::encrypt("梅本永二")),
                "building" => strval(Crypt::encrypt("")),
                "created_at" => now(),
                "updated_at" => now(),
            ],[
                "user_id" => "2",
                "postcode" => strval(Crypt::encrypt("8694203")),
                "prefecture" => strval(Crypt::encrypt("熊本県")),
                "city_street" => strval(Crypt::encrypt("八代市鏡町鏡2-20-15")),
                "addressee" => strval(Crypt::encrypt("大矢琴")),
                "building" => strval(Crypt::encrypt("パレス敷戸西町203")),
                "created_at" => now(),
                "updated_at" => now(),
            ],
//                [
//                "user_id" => "1",
//                "postcode" => Crypt::encrypt("8694203"),
//                "prefecture" => Crypt::encrypt("熊本県"),
//                "city_street" => Crypt::encrypt("八代市鏡町鏡2-20-15"),
//                "addressee" => Crypt::encrypt("大矢琴"),
//                "created_at" => now(),
//                "updated_at" => now(),
//            ],[
//                "user_id" => "1",
//                "postcode" => Crypt::encrypt("8701103"),
//                "prefecture" => Crypt::encrypt("大分県"),
//                "city_street" => Crypt::encrypt("大分市敷戸西町3-4-13"),
//                "building" => Crypt::encrypt("パレス敷戸西町203"),
//                "addressee" => Crypt::encrypt("野口空"),
//                "created_at" => now(),
//                "updated_at" => now(),
//            ],[
//                "user_id" => "1",
//                "postcode" => Crypt::encrypt("4000022"),
//                "prefecture" => Crypt::encrypt("山梨県"),
//                "city_street" => Crypt::encrypt("甲府市元紺屋町1-9-7"),
//                "addressee" => Crypt::encrypt("中谷喜三郎"),
//                "created_at" => now(),
//                "updated_at" => now(),
//            ],[
//                "user_id" => "1",
//                "postcode" => Crypt::encrypt("4260028"),
//                "prefecture" => Crypt::encrypt("静岡県"),
//                "city_street" => Crypt::encrypt("藤枝市益津下4-1-8"),
//                "addressee" => Crypt::encrypt("竹内陽子"),
//                "created_at" => now(),
//                "updated_at" => now(),
//            ]
            ]);
        DB::table("goods_categories")
            ->insert([
                [
                    "category_name" => "DVD",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],[
                    "category_name" => "野菜",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],[
                    "category_name" => "果物",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],[
                    "category_name" => "GAME",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],[
                    "category_name" => "家電",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
            ]);


    }
}
