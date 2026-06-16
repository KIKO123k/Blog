<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case AUTHOR = 'author';
    case ADMIN = 'admin';

    /**
     * Get all values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the label for display.
     */
    public function label(): string
    {
        return match ($this) {
            self::USER => 'Utilisateur',
            self::AUTHOR => 'Auteur',
            self::ADMIN => 'Administrateur',
        };
    }

    /**
     * Check if this role has all permissions of another role.
     */
    public function includes(UserRole $role): bool
    {
        return match ($this) {
            self::ADMIN => true,
            self::AUTHOR => in_array($role, [self::USER, self::AUTHOR]),
            self::USER => $role === self::USER,
        };
    }
}