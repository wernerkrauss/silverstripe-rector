<?php

namespace App\Model;

class BaseUser {}
class User extends BaseUser
{
    public string $name;
}

class Other
{
    public function printName(User $user): void
    {
        echo $user->name;
    }
}

?>
-----
<?php

namespace App\Model;

class BaseUser {}
class User extends BaseUser
{
    public string $name;
}

class Other
{
    public function printName(User $user): void
    {
        echo $user->getName();
    }
}

?>
