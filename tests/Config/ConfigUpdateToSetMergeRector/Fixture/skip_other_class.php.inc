<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Config\ConfigUpdateToSetMergeRector\Fixture;

class SkipOtherConfig
{
    public function update($class, $name, $value)
    {
    }
}

class SkipOtherClass
{
    public function configure(SkipOtherConfig $config)
    {
        $config->update('MyClass', 'my_list', ['a' => 'b']);
    }
}

?>
