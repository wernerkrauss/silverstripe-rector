<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe50\Fixture;

use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Versioned\Versioned;

class Ss50Deprecations extends Versioned
{
    public function doStuff(FieldList $fields, $myField)
    {
        $this->publish('Stage', 'Live');
        $this->doPublish();
        Config::inst()->update('MyClass', 'my_prop', 'value');
        Config::inst()->update('MyClass', 'my_list', ['a' => 'b']);
        $fields->insertAfter($myField, 'Title');
    }
}
?>
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe50\Fixture;

use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Versioned\Versioned;

class Ss50Deprecations extends Versioned
{
    public function doStuff(FieldList $fields, $myField)
    {
        $this->copyVersionToStage('Stage', 'Live');
        $this->publishRecursive();
        \SilverStripe\Core\Config\Config::modify()->set('MyClass', 'my_prop', 'value');
        \SilverStripe\Core\Config\Config::modify()->merge('MyClass', 'my_list', ['a' => 'b']);
        $fields->insertAfter('Title', $myField);
    }
}
?>
