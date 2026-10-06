<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe53\Fixture;

use DNADesign\Elemental\Models\BaseElement;

class MyElement extends BaseElement
{
    public function getDescription()
    {
        return 'My description';
    }

    public function otherMethod()
    {
        $desc = $this->getDescription();
    }
}
-----
<?php

namespace Netwerkstatt\SilverstripeRector\Tests\Set\Silverstripe53\Fixture;

use DNADesign\Elemental\Models\BaseElement;

class MyElement extends BaseElement
{
    /**
     * @deprecated BaseElement::getDescription() has been deprecated. To update or get the CMS description of elemental blocks, use the description configuration property and the localisation API.
     * See: https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes
     */
    public function getDescription()
    {
        return 'My description';
    }

    public function otherMethod()
    {
        /**
         * @deprecated BaseElement::getDescription() has been deprecated. To update or get the CMS description of elemental blocks, use the description configuration property and the localisation API.
         * See: https://docs.silverstripe.org/en/5/changelogs/5.3.0/#api-changes
         */
        $desc = $this->getDescription();
    }
}
