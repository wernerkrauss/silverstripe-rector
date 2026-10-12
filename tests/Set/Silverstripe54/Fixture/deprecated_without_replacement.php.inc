<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\View\ViewableData;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBInt;

final class DeprecatedWithoutReplacement
{
    public function test(DBInt $field, ViewableData $data): void
    {
        DBInt::Times();
        Controller::has_curr();
        $data->XML_val('Title');
        $data->getXMLValues();
    }
}

-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe54\Fixture;

use SilverStripe\Model\ModelData;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBInt;

final class DeprecatedWithoutReplacement
{
    public function test(DBInt $field, ModelData $data): void
    {
        /**
         * @deprecated DBInt::Times() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        DBInt::Times();
        /**
         * @deprecated Controller::has_curr() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        Controller::has_curr();
        /**
         * @deprecated ViewableData::XML_val() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $data->XML_val('Title');
        /**
         * @deprecated ViewableData::getXMLValues() has been deprecated. It will be removed without equivalent functionality to replace it.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.4.0/#deprecated-api
         */
        $data->getXMLValues();
    }
}
