<?php

namespace App\Enums;


class UserRoleEnums extends BasicEnum
{
    // TODO delete
//    const CLIENT_PERSON = 'client-person';
//    const CLIENT_COMPANY = 'client-company';
//    const FREELANCE = 'logistic-person';
//    const LOGIST = 'logistic-company';

    const LOGISTIC = 'logistic';
    const CLIENT = 'client';
    const DRIVER = 'driver';

    const LOGIST = 'logist';
    const MANAGER = 'manager';
    const CARGO_LOADER = 'cargo_loader';
    const CARGO_RECEIVER = 'cargo_receiver';

    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_COMPANY = 'company';
}