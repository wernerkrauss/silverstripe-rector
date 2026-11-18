<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\XmlValToObjForTemplateRector\Fixture;

use SilverStripe\View\ViewableData;

final class XmlVal extends ViewableData
{
    public function test(ViewableData $data): string
    {
        $title = $data->XML_val('Title');
        $summary = $this->XML_val('Summary', [20], true);

        return $title . $summary;
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Misc\XmlValToObjForTemplateRector\Fixture;

use SilverStripe\View\ViewableData;

final class XmlVal extends ViewableData
{
    public function test(ViewableData $data): string
    {
        $title = $data->obj('Title')->forTemplate();
        $summary = $this->obj('Summary', [20], true)->forTemplate();

        return $title . $summary;
    }
}

