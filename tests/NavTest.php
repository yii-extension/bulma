<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Bulma\Nav;
use Yii\Extension\Bulma\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Tag\Img;

final class NavTest extends TestCase
{
    use TestTrait;

    public function testDeepActivateParents(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->activateParents()
            ->items([
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Sub Dropdown',
                            'items' => [
                                ['label' => 'Page', 'url' => '#', 'active' => true],
                            ],
                            'submenu' => true,
                        ],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">Dropdown</a>
        <div class="navbar-dropdown">
        <div class="dropdown">
        <div class="dropdown-trigger">
        <a class="navbar-item">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </a>
        </div>
        <div id="w1-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="navbar-item is-active" href="#">Page</a>
        </div>
        </div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdown(): void
    {
        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Docs',
                    'items' => [
                        ['label' => 'Overview', 'url' => '#'],
                        ['label' => 'Elements', 'url' => '#'],
                        '-',
                        ['label' => 'Components', 'url' => '#'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">Docs</a>
        <div class="navbar-dropdown">
        <a class="navbar-item" href="#">Overview</a>
        <a class="navbar-item" href="#">Elements</a>
        <hr class="navbar-divider">
        <a class="navbar-item" href="#">Components</a>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownWithDropdownAttributes(): void
    {
        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'url' => '#',
                ],
                [
                    'label' => 'Dropdown1',
                    'dropdownAttributes' => ['class' => 'is-link', 'data-id' => 't1', 'id' => 'test1'],
                    'items' => [
                        ['label' => 'Page2', 'url' => '#'],
                        ['label' => 'Page3', 'url' => '#'],
                    ],
                    'visible' => true,
                ],
                [
                    'label' => 'Dropdown2',
                    'items' => [
                        ['label' => 'Page4', 'url' => '#'],
                        ['label' => 'Page5', 'url' => '#'],
                    ],
                    'visible' => false,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <a class="navbar-item" href="#">Page1</a>
        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">Dropdown1</a>
        <div id="test1" class="is-link navbar-dropdown" data-id="t1">
        <a class="navbar-item" href="#">Page2</a>
        <a class="navbar-item" href="#">Page3</a>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        $this->assertSame(
            '<a class="navbar-item" href="#">a &amp; b</a>',
            Nav::widget()->items([['label' => 'a & b', 'encode' => true]])->render(),
        );
    }

    public function testExplicitActive(): void
    {
        $html = Nav::widget()
            ->withoutActivateItems()
            ->items([['label' => 'Item1', 'active' => true], ['label' => 'Item2', 'url' => '/site/index']])
            ->render();
        $expected = <<<'HTML'
        <a class="navbar-item" href="#">Item1</a>
        <a class="navbar-item" href="/site/index">Item2</a>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testExplicitActiveSubItems(): void
    {
        $html = Nav::widget()
            ->currentPath('/site/index')
            ->items([
                [
                    'label' => 'Item1',
                ],
                [
                    'label' => 'Item2',
                    'items' => [
                        ['label' => 'Page2', 'url' => '#', 'url' => 'site/index'],
                        ['label' => 'Page3', 'url' => '#', 'active' => true],
                    ],
                ],
            ])
            ->withoutActivateItems()
            ->render();
        $expected = <<<'HTML'
        <a class="navbar-item" href="#">Item1</a>
        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">Item2</a>
        <div class="navbar-dropdown">
        <a class="navbar-item" href="site/index">Page2</a>
        <a class="navbar-item is-active" href="#">Page3</a>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testIcon(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Setting Account',
                    'url' => '/setting/account',
                    'iconCssClass' => 'fas fa-user-cog',
                    'iconAttributes' => ['class' => 'icon'],
                ],
                [
                    'label' => 'Profile',
                    'url' => '/profile',
                    'iconCssClass' => 'fas fa-users',
                    'iconAttributes' => ['class' => 'icon'],
                ],
                [
                    'label' => 'Admin' . Img::tag()
                        ->attributes(['class' => 'img-rounded', 'aria-expanded' => 'false'])
                        ->url('../../docs/images/icon-avatar.png'),
                    'items' => [
                        ['label' => 'Logout', 'url' => '/auth/logout'],
                    ],
                    'encode' => false,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <a class="navbar-item" href="/setting/account"><span class="icon"><i class="fas fa-user-cog"></i></span>Setting Account</a>
        <a class="navbar-item" href="/profile"><span class="icon"><i class="fas fa-users"></i></span>Profile</a>
        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">Admin<img class="img-rounded" src="../../docs/images/icon-avatar.png" aria-expanded="false"></a>
        <div class="navbar-dropdown">
        <a class="navbar-item" href="/auth/logout">Logout</a>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testImplicitActive(): void
    {
        $html = Nav::widget()
            ->currentPath('/site/index')
            ->items([['label' => 'Item1', 'active' => true], ['label' => 'Item2', 'url' => '/site/index']])
            ->render();
        $expected = <<<'HTML'
        <a class="is-active navbar-item" href="#">Item1</a>
        <a class="is-active navbar-item" href="/site/index">Item2</a>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testImplicitActiveSubItems(): void
    {
        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Item1',
                ],
                [
                    'label' => 'Item2',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => '/site/page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'url' => '/site/page3', 'active' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <a class="navbar-item" href="#">Item1</a>
        <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">Item2</a>
        <div class="navbar-dropdown">
        <a class="navbar-item" href="/site/page2">Page2</a>
        <a class="navbar-item is-active" href="/site/page3">Page3</a>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Nav::widget()->items([['content' => 'Page1']])->render();
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<a class="navbar-item" href="#">Page1</a>',
            Nav::widget()->items([['label' => 'Page1', 'url' => '#']])->render(),
        );
    }

    public function testRenderItemsDisabled(): void
    {
        $this->assertSame(
            '<a class="navbar-item" href="#" style="opacity:.65; pointer-events:none;">a & b</a>',
            Nav::widget()->items([['label' => 'a & b', 'disabled' => true]])->render(),
        );
    }

    public function testRenderItemsEmpty(): void
    {
        $html = Nav::widget()
            ->items([['label' => 'Page1', 'items' => null], ['label' => 'Page4', 'items' => []]])
            ->render();
        $expected = <<<'HTML'
        <a class="navbar-item" href="#">Page1</a>
        <a class="navbar-item" href="#">Page4</a>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
        $this->assertEmpty(Nav::widget()->items([])->render());
    }

    public function testRenderItemsWithoutUrl(): void
    {
        $this->assertEqualsWithoutLE(
            '<a class="navbar-item" href="#">Page1</a>',
            Nav::widget()->items([['label' => 'Page1']])->render()
        );
    }
}
