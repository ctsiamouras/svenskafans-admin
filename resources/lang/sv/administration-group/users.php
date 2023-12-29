<?php

use App\Constants\UserRoleConstants;

return [

    'singular_label' => 'Användare',
    'plural_label' => 'Användare',

    'first_name' => 'Förnamn',
    'last_name' => 'Efternamn',
    'nickname' => 'Författarnamn (Byline)',
    'username' => 'Användarnamn',
    'password' => 'Lösenord',
    'phone' => 'Telefon',
    'email' => 'Email',
    'twitter_name' => 'Twitternamn',
    'user_role' => 'Användarroll',
    'teams' => 'Lag',

    'user_roles' => [
        UserRoleConstants::SUPER_ADMIN => 'Super admin',
        UserRoleConstants::LEAGUE_EDITOR => 'Ligaredaktör',
        UserRoleConstants::TEAM_EDITOR => 'Lagredaktör',
        UserRoleConstants::FORUM_EDITOR => 'Forumredaktör',
    ],

];
