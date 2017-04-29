<?php
/**
 * UserEvents.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Event;


class UserEvents
{
    const USER_ACTIVATE_DONE = 'user.activate.success';
    const USER_REGISTER_DONE = 'user.register.success';
    const USER_RESET         = 'user.reset';
    const USER_RESET_DONE    = 'user.reset.done';
}