<?php

use App\Constants\UserRoleConstants;

return [

    'singular_label' => 'User',
    'plural_label' => 'Users',

    'first_name' => 'First name',
    'last_name' => 'Last name',
    'nickname' => 'Nickname (Byline)',
    'username' => 'Username',
    'password' => 'Password',
    'phone' => 'Phone',
    'email' => 'Email',
    'twitter_name' => 'Twitter name',
    'user_role' => 'User role',
    'teams' => 'Teams',

    'user_roles' => [
        UserRoleConstants::SUPER_ADMIN => 'Super admin',
        UserRoleConstants::LEAGUE_EDITOR => 'League editor',
        UserRoleConstants::TEAM_EDITOR => 'Team editor',
        UserRoleConstants::FORUM_EDITOR => 'Forum editor',
    ],

];
