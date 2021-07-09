<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Bulma\NavBar;
use Yii\Extension\Bulma\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Tag\Div;

final class NavBarTest extends TestCase
{
    use TestTrait;

    public function testBrandAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandAttributes(['class' => 'text-danger'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="text-danger navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandImageAndUrl(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandImage('https://bulma.io/images/bulma-logo.png')
            ->brandImageAttributes(['style' => ['width' => '112', 'height' => '28']])
            ->brandUrl('https://bulma.io')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io"><img src="https://bulma.io/images/bulma-logo.png" style="width: 112; height: 28;"></a>
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('My Project')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-item" href="/">My Project</a>
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandImageUrlText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandImage('https://bulma.io/images/bulma-logo.png')
            ->brandImageAttributes(['title' => 'bulma', 'style' => ['width' => '112', 'height' => '28']])
            ->brandText('My Project')
            ->brandUrl('https://bulma.io')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io"><img src="https://bulma.io/images/bulma-logo.png" title="bulma" style="width: 112; height: 28;">My Project</a>
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandUrlEmptyText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandText('My Project')
            ->brandTextAttributes(['class' => 'has-text-primary'])
            ->brandUrl('')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <span class="has-text-primary navbar-item">My Project</span>
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonLinkAriaExpanded(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->buttonLinkAriaExpanded('true')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="true" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonLinkAriaLabelText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->buttonLinkAriaLabelText('menu-text')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu-text" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonLinkContent(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->buttonLinkContent('<span class="icon"><i class="mdi mdi-menu mdi-24px"></i></span>')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button"><span class="icon"><i class="mdi mdi-menu mdi-24px"></i></span></a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonLinkRole(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->buttonLinkRole('button-text')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button-text">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarAriaLabel(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarAriaLabel('main')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarBrandCssClass(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarBrandCssClass('has-text-center navbar-brand')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="has-text-center navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarBurgerAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarBurgerAttributes(['class' => 'has-text-center'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="has-text-center navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarBurgerCssClass(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarBurgerCssClass('has-text-center navbar-burguer')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="has-text-center navbar-burguer" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarCssClass(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarCssClass('has-text-danger navbar')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="has-text-danger navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarItemCssClass(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarItemCssClass('has-text-center navbar-item')->brandText('link-text')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="has-text-center navbar-item" href="/">link-text</a>
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavBarRole(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->navBarRole('navigation-text')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation-text">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar" aria-label="main navigation" role="navigation">
        <div class="navbar-brand">
        <a class="navbar-burger" aria-expanded="false" aria-label="menu" role="button">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
