<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'product_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'product_tag_create',
            ],
            [
                'id'    => 24,
                'title' => 'product_tag_edit',
            ],
            [
                'id'    => 25,
                'title' => 'product_tag_show',
            ],
            [
                'id'    => 26,
                'title' => 'product_tag_delete',
            ],
            [
                'id'    => 27,
                'title' => 'product_tag_access',
            ],
            [
                'id'    => 28,
                'title' => 'product_create',
            ],
            [
                'id'    => 29,
                'title' => 'product_edit',
            ],
            [
                'id'    => 30,
                'title' => 'product_show',
            ],
            [
                'id'    => 31,
                'title' => 'product_delete',
            ],
            [
                'id'    => 32,
                'title' => 'product_access',
            ],
            [
                'id'    => 33,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 34,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 35,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 36,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 37,
                'title' => 'content_management_access',
            ],
            [
                'id'    => 38,
                'title' => 'content_category_create',
            ],
            [
                'id'    => 39,
                'title' => 'content_category_edit',
            ],
            [
                'id'    => 40,
                'title' => 'content_category_show',
            ],
            [
                'id'    => 41,
                'title' => 'content_category_delete',
            ],
            [
                'id'    => 42,
                'title' => 'content_category_access',
            ],
            [
                'id'    => 43,
                'title' => 'content_tag_create',
            ],
            [
                'id'    => 44,
                'title' => 'content_tag_edit',
            ],
            [
                'id'    => 45,
                'title' => 'content_tag_show',
            ],
            [
                'id'    => 46,
                'title' => 'content_tag_delete',
            ],
            [
                'id'    => 47,
                'title' => 'content_tag_access',
            ],
            [
                'id'    => 48,
                'title' => 'content_page_create',
            ],
            [
                'id'    => 49,
                'title' => 'content_page_edit',
            ],
            [
                'id'    => 50,
                'title' => 'content_page_show',
            ],
            [
                'id'    => 51,
                'title' => 'content_page_delete',
            ],
            [
                'id'    => 52,
                'title' => 'content_page_access',
            ],
            [
                'id'    => 53,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 54,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 55,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 56,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 57,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 58,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 59,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 60,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 61,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 62,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 63,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 64,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 65,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 66,
                'title' => 'order_management_access',
            ],
            [
                'id'    => 67,
                'title' => 'order_create',
            ],
            [
                'id'    => 68,
                'title' => 'order_edit',
            ],
            [
                'id'    => 69,
                'title' => 'order_show',
            ],
            [
                'id'    => 70,
                'title' => 'order_delete',
            ],
            [
                'id'    => 71,
                'title' => 'order_access',
            ],
            [
                'id'    => 72,
                'title' => 'cart_create',
            ],
            [
                'id'    => 73,
                'title' => 'cart_edit',
            ],
            [
                'id'    => 74,
                'title' => 'cart_show',
            ],
            [
                'id'    => 75,
                'title' => 'cart_delete',
            ],
            [
                'id'    => 76,
                'title' => 'cart_access',
            ],
            [
                'id'    => 77,
                'title' => 'vendor_create',
            ],
            [
                'id'    => 78,
                'title' => 'vendor_edit',
            ],
            [
                'id'    => 79,
                'title' => 'vendor_show',
            ],
            [
                'id'    => 80,
                'title' => 'vendor_delete',
            ],
            [
                'id'    => 81,
                'title' => 'vendor_access',
            ],
            [
                'id'    => 82,
                'title' => 'franchisee_create',
            ],
            [
                'id'    => 83,
                'title' => 'franchisee_edit',
            ],
            [
                'id'    => 84,
                'title' => 'franchisee_show',
            ],
            [
                'id'    => 85,
                'title' => 'franchisee_delete',
            ],
            [
                'id'    => 86,
                'title' => 'franchisee_access',
            ],
            [
                'id'    => 87,
                'title' => 'area_management_access',
            ],
            [
                'id'    => 88,
                'title' => 'pincode_create',
            ],
            [
                'id'    => 89,
                'title' => 'pincode_edit',
            ],
            [
                'id'    => 90,
                'title' => 'pincode_show',
            ],
            [
                'id'    => 91,
                'title' => 'pincode_delete',
            ],
            [
                'id'    => 92,
                'title' => 'pincode_access',
            ],
            [
                'id'    => 93,
                'title' => 'state_create',
            ],
            [
                'id'    => 94,
                'title' => 'state_edit',
            ],
            [
                'id'    => 95,
                'title' => 'state_show',
            ],
            [
                'id'    => 96,
                'title' => 'state_delete',
            ],
            [
                'id'    => 97,
                'title' => 'state_access',
            ],
            [
                'id'    => 98,
                'title' => 'district_create',
            ],
            [
                'id'    => 99,
                'title' => 'district_edit',
            ],
            [
                'id'    => 100,
                'title' => 'district_show',
            ],
            [
                'id'    => 101,
                'title' => 'district_delete',
            ],
            [
                'id'    => 102,
                'title' => 'district_access',
            ],
            [
                'id'    => 103,
                'title' => 'block_create',
            ],
            [
                'id'    => 104,
                'title' => 'block_edit',
            ],
            [
                'id'    => 105,
                'title' => 'block_show',
            ],
            [
                'id'    => 106,
                'title' => 'block_delete',
            ],
            [
                'id'    => 107,
                'title' => 'block_access',
            ],
            [
                'id'    => 108,
                'title' => 'area_create',
            ],
            [
                'id'    => 109,
                'title' => 'area_edit',
            ],
            [
                'id'    => 110,
                'title' => 'area_show',
            ],
            [
                'id'    => 111,
                'title' => 'area_delete',
            ],
            [
                'id'    => 112,
                'title' => 'area_access',
            ],
            [
                'id'    => 113,
                'title' => 'brand_create',
            ],
            [
                'id'    => 114,
                'title' => 'brand_edit',
            ],
            [
                'id'    => 115,
                'title' => 'brand_show',
            ],
            [
                'id'    => 116,
                'title' => 'brand_delete',
            ],
            [
                'id'    => 117,
                'title' => 'brand_access',
            ],
            [
                'id'    => 118,
                'title' => 'logistics_managment_access',
            ],
            [
                'id'    => 119,
                'title' => 'forum_management_access',
            ],
            [
                'id'    => 120,
                'title' => 'article_create',
            ],
            [
                'id'    => 121,
                'title' => 'article_edit',
            ],
            [
                'id'    => 122,
                'title' => 'article_show',
            ],
            [
                'id'    => 123,
                'title' => 'article_delete',
            ],
            [
                'id'    => 124,
                'title' => 'article_access',
            ],
            [
                'id'    => 125,
                'title' => 'article_tag_create',
            ],
            [
                'id'    => 126,
                'title' => 'article_tag_edit',
            ],
            [
                'id'    => 127,
                'title' => 'article_tag_show',
            ],
            [
                'id'    => 128,
                'title' => 'article_tag_delete',
            ],
            [
                'id'    => 129,
                'title' => 'article_tag_access',
            ],
            [
                'id'    => 130,
                'title' => 'article_comment_create',
            ],
            [
                'id'    => 131,
                'title' => 'article_comment_edit',
            ],
            [
                'id'    => 132,
                'title' => 'article_comment_show',
            ],
            [
                'id'    => 133,
                'title' => 'article_comment_delete',
            ],
            [
                'id'    => 134,
                'title' => 'article_comment_access',
            ],
            [
                'id'    => 135,
                'title' => 'follower_create',
            ],
            [
                'id'    => 136,
                'title' => 'follower_edit',
            ],
            [
                'id'    => 137,
                'title' => 'follower_show',
            ],
            [
                'id'    => 138,
                'title' => 'follower_delete',
            ],
            [
                'id'    => 139,
                'title' => 'follower_access',
            ],
            [
                'id'    => 140,
                'title' => 'article_like_create',
            ],
            [
                'id'    => 141,
                'title' => 'article_like_edit',
            ],
            [
                'id'    => 142,
                'title' => 'article_like_show',
            ],
            [
                'id'    => 143,
                'title' => 'article_like_delete',
            ],
            [
                'id'    => 144,
                'title' => 'article_like_access',
            ],
            [
                'id'    => 145,
                'title' => 'logistic_create',
            ],
            [
                'id'    => 146,
                'title' => 'logistic_edit',
            ],
            [
                'id'    => 147,
                'title' => 'logistic_show',
            ],
            [
                'id'    => 148,
                'title' => 'logistic_delete',
            ],
            [
                'id'    => 149,
                'title' => 'logistic_access',
            ],
            [
                'id'    => 150,
                'title' => 'transaction_management_access',
            ],
            [
                'id'    => 151,
                'title' => 'transaction_create',
            ],
            [
                'id'    => 152,
                'title' => 'transaction_edit',
            ],
            [
                'id'    => 153,
                'title' => 'transaction_show',
            ],
            [
                'id'    => 154,
                'title' => 'transaction_delete',
            ],
            [
                'id'    => 155,
                'title' => 'transaction_access',
            ],
            [
                'id'    => 156,
                'title' => 'user_address_create',
            ],
            [
                'id'    => 157,
                'title' => 'user_address_edit',
            ],
            [
                'id'    => 158,
                'title' => 'user_address_show',
            ],
            [
                'id'    => 159,
                'title' => 'user_address_delete',
            ],
            [
                'id'    => 160,
                'title' => 'user_address_access',
            ],
            [
                'id'    => 161,
                'title' => 'setting_create',
            ],
            [
                'id'    => 162,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 163,
                'title' => 'setting_show',
            ],
            [
                'id'    => 164,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 165,
                'title' => 'setting_access',
            ],
            [
                'id'    => 166,
                'title' => 'admin_management_access',
            ],
            [
                'id'    => 167,
                'title' => 'admin_create',
            ],
            [
                'id'    => 168,
                'title' => 'admin_edit',
            ],
            [
                'id'    => 169,
                'title' => 'admin_show',
            ],
            [
                'id'    => 170,
                'title' => 'admin_delete',
            ],
            [
                'id'    => 171,
                'title' => 'admin_access',
            ],
            [
                'id'    => 172,
                'title' => 'city_create',
            ],
            [
                'id'    => 173,
                'title' => 'city_edit',
            ],
            [
                'id'    => 174,
                'title' => 'city_show',
            ],
            [
                'id'    => 175,
                'title' => 'city_delete',
            ],
            [
                'id'    => 176,
                'title' => 'city_access',
            ],
            [
                'id'    => 177,
                'title' => 'organisation_access',
            ],
            [
                'id'    => 178,
                'title' => 'help_center_create',
            ],
            [
                'id'    => 179,
                'title' => 'help_center_edit',
            ],
            [
                'id'    => 180,
                'title' => 'help_center_show',
            ],
            [
                'id'    => 181,
                'title' => 'help_center_delete',
            ],
            [
                'id'    => 182,
                'title' => 'help_center_access',
            ],
            [
                'id'    => 183,
                'title' => 'help_center_profile_create',
            ],
            [
                'id'    => 184,
                'title' => 'help_center_profile_edit',
            ],
            [
                'id'    => 185,
                'title' => 'help_center_profile_show',
            ],
            [
                'id'    => 186,
                'title' => 'help_center_profile_delete',
            ],
            [
                'id'    => 187,
                'title' => 'help_center_profile_access',
            ],
            [
                'id'    => 188,
                'title' => 'user_profile_create',
            ],
            [
                'id'    => 189,
                'title' => 'user_profile_edit',
            ],
            [
                'id'    => 190,
                'title' => 'user_profile_show',
            ],
            [
                'id'    => 191,
                'title' => 'user_profile_delete',
            ],
            [
                'id'    => 192,
                'title' => 'user_profile_access',
            ],
            [
                'id'    => 193,
                'title' => 'information_center_access',
            ],
            [
                'id'    => 194,
                'title' => 'crop_create',
            ],
            [
                'id'    => 195,
                'title' => 'crop_edit',
            ],
            [
                'id'    => 196,
                'title' => 'crop_show',
            ],
            [
                'id'    => 197,
                'title' => 'crop_delete',
            ],
            [
                'id'    => 198,
                'title' => 'crop_access',
            ],
            [
                'id'    => 199,
                'title' => 'franchisee_profile_create',
            ],
            [
                'id'    => 200,
                'title' => 'franchisee_profile_edit',
            ],
            [
                'id'    => 201,
                'title' => 'franchisee_profile_show',
            ],
            [
                'id'    => 202,
                'title' => 'franchisee_profile_delete',
            ],
            [
                'id'    => 203,
                'title' => 'franchisee_profile_access',
            ],
            [
                'id'    => 204,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
