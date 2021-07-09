<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Bulma\Nav;
use Yii\Extension\Bulma\Tests\TestSupport\TestTrait;

final class NavTest extends TestCase
{
    use TestTrait;

    public function testDropdown(): void
    {
        Nav::counter(0);

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
        <a class="navbar-item navbar-link" href="#">Docs</a>
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

    public function testRender(): void
    {
        $this->assertSame(
            '<a class="navbar-item" href="#">Page1</a>',
            Nav::widget()->items([['label' => 'Page1', 'url' => '#']])->render(),
        );
    }

    public function testRenderItemsEmpty(): void
    {
        $this->assertEmpty(Nav::widget()->items([])->render());
    }
}
