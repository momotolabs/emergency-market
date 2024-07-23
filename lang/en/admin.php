<?php

return [

    'fields' => [
        'name' => 'Name',
        'email' => 'E-mail',
        'pass' => 'Password',
        'pass_confirm' => 'Password Confirmation',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'status' => 'Active user',
        'type' => 'Type user',
        'phone' => 'Phone number',
    ],

    'validations' => [
        'user_type' => 'You do not have sufficient permissions to access ✋ !!!',
    ],

];
