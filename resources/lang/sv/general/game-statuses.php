<?php

use App\Constants\GameStatusConstants;

return [

    GameStatusConstants::NOT_STARTED => 'Ej påbörjad',
    GameStatusConstants::ONGOING => 'Pågående',
    GameStatusConstants::COMPLETED => 'Avslutad',
    GameStatusConstants::CANCELED => 'Inställd',
    GameStatusConstants::DEFERRED => 'Uppskjuten',
    GameStatusConstants::INTERRUPTED => 'Avbruten',
    GameStatusConstants::PUSHED_FORWARD => 'Framskjuten',
    GameStatusConstants::WALK_OVER => 'Går över',
    GameStatusConstants::NOT_DECIDED => 'Inte bestämt',

];
