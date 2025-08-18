<?php

namespace App\Enums;

enum UserRoleEnum : string
{
    case SUPERADMIN = "super-admin";
    case ADMIN = 'admin';
    case USER = 'user';
    case LECTURER = 'lecturer';




    public function label(): string {
        return match($this) {
            UserRoleEnum::SUPERADMIN => "super-admin",
            UserRoleEnum::ADMIN => 'admin',
            UserRoleEnum::USER => 'user',
            UserRoleEnum::LECTURER => 'lecturer',
        };
    }

    public static function getValues(): array {  
        return array_column(self::cases(), 'value');  
    } 

}
