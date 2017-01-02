<?php
/**
 * Copyright (C) 2015 Digimedia Sp. z o.o. d/b/a Clearcode
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace SevenTag\Plugin\SalesManagoCustomTemplateBundle\Tests\Template;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use SevenTag\Api\TagBundle\Entity\Tag;
use SevenTag\Plugin\SalesManagoCustomTemplateBundle\Form\SalesManagoFormType;
use SevenTag\Plugin\SalesManagoCustomTemplateBundle\Template\SalesManagoProvider;

/**
 * Class SalesManagoProviderTest
 * @package SevenTag\Plugin\SalesManagoCustomTemplateBundle\Template
 */
class SalesManagoProviderTest extends WebTestCase
{
    /**
     * @var SalesManagoProvider
     */
    private $provider;

    /**
     * @before
     */
    public function beforeEach()
    {
        $this->provider = new SalesManagoProvider();
        $this->provider->setContainer($this->getContainer());
    }

    /**
     * @test
     */
    public function itReturnsProviderKey()
    {
        $this->assertEquals($this->provider->getKey(), SalesManagoProvider::KEY);
    }

    /**
     * @test
     */
    public function itReturnsFormType()
    {
        $formType = new SalesManagoFormType();
        $this->assertEquals($formType->getName(), $this->provider->getFormType());
    }

    /**
     * @test
     */
    public function itIsAbleToPrePersistTag()
    {
        $smid = 123;
        $tag = new Tag();
        $tag->setTemplateOptions([
            'smid' => $smid
        ]);
        $tag = $this->provider->prePersist($tag);
        $code = $tag->getCode();
        $this->assertRegExp(sprintf('/%s/i', preg_quote($smid)), $code);
        $this->assertFalse($tag->getDocumentWrite());
    }
}
