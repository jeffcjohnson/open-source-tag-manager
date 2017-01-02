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

namespace SevenTag\Api\ContainerBundle\Tests\ContainerLibrary\Template\Handler;

use Prophecy\Argument;
use SevenTag\Api\ContainerBundle\ContainerLibrary\Template\Handler\TagTreeHandler;

/**
 * Class TagTreeHandlerTest
 * @package SevenTag\Api\ContainerBundle\Tests\ContainerLibrary\Template\Handler
 */
class TagTreeHandlerTest extends \PHPUnit_Framework_TestCase
{
    const RAW_CONTENT = ' ##tagTree## ';

    /**
     * @test
     */
    public function itShouldReplaceTagTreePlaceholder()
    {
        $handler = new TagTreeHandler($this->getTagTreeBuilderMock());
        $handler->handle($this->getContextMock());
    }

    /**
     * @return TagTreeBuilderInterface
     */
    private function getTagTreeBuilderMock()
    {
        $tagTree = ['a' => 1, 'b' => 2, 'c' => 3];
        $tagTreeBuilder = $this->prophesize('SevenTag\Api\ContainerBundle\TagTree\Builder\TagTreeBuilderInterface');
        $tagTreeBuilder
            ->buildTree(Argument::any())
            ->willReturn($tagTree)
            ->shouldBeCalled();

        return $tagTreeBuilder->reveal();
    }

    /**
     * @return Context
     */
    private function getContextMock()
    {
        $context = $this->prophesize('SevenTag\Api\ContainerBundle\ContainerLibrary\Template\Context');
        $context->getContainer()->willReturn($this->getContainerMock());
        $context->getContent()->willReturn(self::RAW_CONTENT);
        $expectedContent = ' {"a":1,"b":2,"c":3} ';
        $context->setContent($expectedContent)->shouldBeCalled();

        return $context->reveal();
    }

    /**
     * @return ContainerInterface
     */
    private function getContainerMock()
    {
        $container = $this->prophesize('SevenTag\Component\Container\Model\ContainerInterface');
        return $container->reveal();
    }
}
