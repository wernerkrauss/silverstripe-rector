<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\XmlValToObjForTemplateRector\Fixture;

final class SkipOtherClasses
{
    public function XML_val(string $field): string
    {
        return $field;
    }

    public function test(SkipOtherClasses $other): string
    {
        return $other->XML_val('Title');
    }
}
