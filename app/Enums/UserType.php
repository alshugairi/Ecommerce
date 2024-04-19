<?php

namespace App\Enums;


use App\Packages\Emerald\Enum\Options;

enum UserType:int
{
    use Options;
    case Admin = 1;
    case Captain = 2;
    case Client = 3;
    case FleetManager = 4;
}
