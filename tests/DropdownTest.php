<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Bulma\Dropdown;
use Yii\Extension\Bulma\Tests\TestSupport\TestTrait;

final class DropdownTest extends TestCase
{
    use TestTrait;

    public function testButtonAttributes(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->buttonAttributes(['class' => 'is-active'])
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="fas fa-angle-down"></i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->buttonLabel('Click Me')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
                ['label' => 'Other dropdown item', 'url' => '#'],
                ['label' => 'Active dropdown item', 'url' => '#', 'active' => true],
                ['label' => 'Other dropdown item', 'url' => '#'],
                '-',
                ['label' => 'With a divider', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Click Me</span>
        <span class="icon is-small"><i class="fas fa-angle-down"></i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#">Dropdown item</a>
        <a class="dropdown-item" href="#">Other dropdown item</a>
        <a class="dropdown-item is-active" href="#">Active dropdown item</a>
        <a class="dropdown-item" href="#">Other dropdown item</a>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="#">With a divider</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
