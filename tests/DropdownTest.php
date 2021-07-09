<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use InvalidArgumentException;
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
            ->buttonAttributes(['class' => 'is-link'])
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="is-link button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
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

    public function testButtonIconCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->buttonIconCssClass('fas fa-angle-down')
            ->buttonIconText('')
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

    public function testButtonIconTextAndAttributes(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->buttonIconAttributes(['class' => 'icon is-link'])
            ->buttonIconText('&#8593;')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-link"><i class="">&#8593;</i></span>
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

    public function testButtonLabel(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->buttonLabel('Dropdown Label')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Dropdown Label</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
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

    public function testButtonLabelAttributes(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->buttonLabelAttributes(['class' => 'text-danger'])
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span class="text-danger">Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
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

    public function testDividerCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dividerCssClass('dropdown-divider-test')
            ->items([
                "-",
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <hr class="dropdown-divider-test">
        <a class="dropdown-item" href="#">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownContentCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownContentCssClass('dropdown-content-test')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content-test">
        <a class="dropdown-item" href="#">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownItemActiveCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownItemActiveCssClass('active')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#', 'active' => true],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item active" href="#">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownItemCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownItemCssClass('dropdown-item-test')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item-test" href="#">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownItemDisabledStyleCss(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownItemDisabledStyleCss('opacity:.65;')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#', 'disable' => true],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#" style="opacity:.65;">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownItemHeaderCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownItemHeaderCssClass('dropdown-header is-link')
            ->items([
                ['label' => 'Dropdown header'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <h6 class="dropdown-header is-link">Dropdown header</h6>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownMenuCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownMenuCssClass('dropdown-menu-test')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu-test">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#">Dropdown item</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownTriggerCssClass(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->dropdownTriggerCssClass('dropdown-trigger-test')
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger-test">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
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

    public function testMissingLabel(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Dropdown::widget()->items([['url' => '#test']])->render();
    }

    public function testRender(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
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
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
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

    public function testRenderItemsEncodeLabels(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Encode & Labels',
                    'url' => '#',
                    'encode' => true,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#">Encode &amp; Labels</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderIconText(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Icon',
                    'url' => "#",
                    'iconText' => '&#8962; ',
                    'iconAttribute' => 'icon',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#"><span><i class="">&#8962; </i></span>Icon</a>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderSubmenu(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Disable',
                    'url' => '#',
                    'disable' => true,
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        ['label' => 'Options:'],
                        ['label' => '-'],
                        ['label' => 'Option 2', 'url' => "/page2"],
                        ['label' => '<hr class="dropdown-divider">', 'enclose' => false]
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w0-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w0-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <a class="dropdown-item" href="#" style="opacity:.65;pointer-events:none;">Disable</a>
        <div class="dropdown">
        <div class="dropdown-trigger">
        <button class="button" aria-haspopup="true" aria-controls="w1-dropdown">
        <span>Clic Me</span>
        <span class="icon is-small"><i class="">&#8595;</i></span>
        </button>
        </div>
        <div id="w1-dropdown" class="dropdown-menu">
        <div class="dropdown-content">
        <h6 class="dropdown-header">Options:</h6>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="/page2">Option 2</a>
        <hr class="dropdown-divider">
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testUnClosedByContainer(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                ['label' => 'Dropdown item', 'url' => '#'],
            ])
            ->unClosedByContainer()
            ->render();
        $this->assertSame('<a class="dropdown-item" href="#">Dropdown item</a>', $html);
    }
}
