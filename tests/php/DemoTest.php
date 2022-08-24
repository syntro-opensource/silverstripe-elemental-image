<?php

namespace Syntro\SEO\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\CMS\Model\SiteTree;
use Syntro\SEO\DOM;

/**
 * Demonstartion test
 *
 * @author Matthias Leutenegger <hello@syntro.ch>
 */
class MetaTest extends FunctionalTest
{
    /**
     * Defines the fixture file to use for this test class
     * @var string
     */
    protected static $fixture_file = './EmptyFixture.yml';

    /**
     * testDemo
     *
     * @return void
     */
    public function testDemo()
    {
        $this->assertEquals(2, 1+1);
    }

}
