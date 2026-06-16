<?php

namespace App\Enums;

enum Permission: string
{
    // Post permissions
    case POST_CREATE = 'post.create';
    case POST_UPDATE = 'post.update';
    case POST_DELETE = 'post.delete';
    case POST_PUBLISH = 'post.publish';

    // Major permissions
    case MAJOR_CREATE = 'major.create';
    case MAJOR_UPDATE = 'major.update';
    case MAJOR_DELETE = 'major.delete';

    // Category permissions
    case CATEGORY_CREATE = 'category.create';
    case CATEGORY_UPDATE = 'category.update';
    case CATEGORY_DELETE = 'category.delete';

    // Club permissions
    case CLUB_CREATE = 'club.create';
    case CLUB_UPDATE = 'club.update';
    case CLUB_DELETE = 'club.delete';

    // User management
    case USER_VIEW = 'user.view';
    case USER_UPDATE = 'user.update';
    case USER_DELETE = 'user.delete';
    case USER_ROLE_ASSIGN = 'user.assign-role';

    // Comment permissions
    case COMMENT_DELETE_ANY = 'comment.delete-any';

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
            self::POST_CREATE => 'Créer des articles',
            self::POST_UPDATE => 'Modifier ses articles',
            self::POST_DELETE => 'Supprimer ses articles',
            self::POST_PUBLISH => 'Publier des articles',
            self::MAJOR_CREATE => 'Créer des majeures',
            self::MAJOR_UPDATE => 'Modifier des majeures',
            self::MAJOR_DELETE => 'Supprimer des majeures',
            self::CATEGORY_CREATE => 'Créer des catégories',
            self::CATEGORY_UPDATE => 'Modifier des catégories',
            self::CATEGORY_DELETE => 'Supprimer des catégories',
            self::CLUB_CREATE => 'Créer des clubs',
            self::CLUB_UPDATE => 'Modifier des clubs',
            self::CLUB_DELETE => 'Supprimer des clubs',
            self::USER_VIEW => 'Voir les profils utilisateurs',
            self::USER_UPDATE => 'Modifier les utilisateurs',
            self::USER_DELETE => 'Supprimer les utilisateurs',
            self::USER_ROLE_ASSIGN => 'Assigner des rôles',
            self::COMMENT_DELETE_ANY => 'Supprimer n\'importe quel commentaire',
        };
    }

    /**
     * Get the default role that has this permission.
     */
    public function defaultRole(): UserRole
    {
        return match ($this) {
            self::POST_CREATE => UserRole::AUTHOR,
            self::POST_UPDATE => UserRole::AUTHOR,
            self::POST_DELETE => UserRole::AUTHOR,
            self::POST_PUBLISH => UserRole::AUTHOR,
            self::MAJOR_CREATE => UserRole::ADMIN,
            self::MAJOR_UPDATE => UserRole::ADMIN,
            self::MAJOR_DELETE => UserRole::ADMIN,
            self::CATEGORY_CREATE => UserRole::ADMIN,
            self::CATEGORY_UPDATE => UserRole::ADMIN,
            self::CATEGORY_DELETE => UserRole::ADMIN,
            self::CLUB_CREATE => UserRole::ADMIN,
            self::CLUB_UPDATE => UserRole::ADMIN,
            self::CLUB_DELETE => UserRole::ADMIN,
            self::USER_VIEW => UserRole::USER,
            self::USER_UPDATE => UserRole::ADMIN,
            self::USER_DELETE => UserRole::ADMIN,
            self::USER_ROLE_ASSIGN => UserRole::ADMIN,
            self::COMMENT_DELETE_ANY => UserRole::ADMIN,
        };
    }
}