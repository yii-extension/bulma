<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Span;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the {@see begin()} and {@see end()} calls of NavBar is treated as the content of the
 * navbar. You may use widgets such as {@see Nav} to build up such content. For example,
 *
 * @link https://bulma.io/documentation/components/navbar/
 */
final class NavBar extends Widget
{
    private array $brandAttributes = [];
    private string $brandImage = '';
    private array $brandImageAttributes = [];
    private string $brandText = '';
    private array $brandTextAttributes = [];
    private string $brandUrl = '/';
    private string $buttonLinkAriaExpanded = "false";
    private string $buttonLinkAriaLabelText = 'menu';
    private string $buttonLinkContent = '';
    private string $buttonLinkRole = "button";
    private string $navBarAriaLabel = 'main navigation';
    private string $navBarBrandCssClass = 'navbar-brand';
    private array $navBarBurgerAttributes = [];
    private string $navBarBurgerCssClass = 'navbar-burger';
    private string $navBarCssClass = 'navbar';
    private string $navBarItemCssClass = 'navbar-item';
    private string $navBarRole = 'navigation';

    public function begin(): string
    {
        parent::begin();

        $new = clone $this;

        return $new->renderNavBar($new);
    }

    protected function run(): string
    {
        return Html::closeTag('nav');
    }

    /**
     * The HTML attributes of the brand.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function brandAttributes(array $value): self
    {
        $new = clone $this;
        $new->brandAttributes = $value;
        return $new;
    }

    /**
     * Src of the brand image or empty if it's not used. Note that this param will override `$this->brandText` param.
     *
     * @param string $value
     *
     * @return static
     */
    public function brandImage(string $value): self
    {
        $new = clone $this;
        $new->brandImage = $value;
        return $new;
    }

    /**
     * The HTML attributes of the brand image.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function brandImageAttributes(array $value): self
    {
        $new = clone $this;
        $new->brandImageAttributes = $value;
        return $new;
    }

    /**
     * The text of the brand or empty if it's not used. Note that this is not HTML-encoded.
     *
     * @param string $value
     *
     * @return static
     */
    public function brandText(string $value): self
    {
        $new = clone $this;
        $new->brandText = $value;
        return $new;
    }

    /**
     * The HTML attributes of the brand text.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function brandTextAttributes(array $value): self
    {
        $new = clone $this;
        $new->brandTextAttributes = $value;
        return $new;
    }

    /**
     * The URL for the brand's hyperlink tag and will be used for the "href" attribute of the brand link. Default value
     * is "/". You may set it to empty string if you want no link at all.
     *
     * @param string $value
     *
     * @return static
     */
    public function brandUrl(string $value): self
    {
        $new = clone $this;
        $new->brandUrl = $value;
        return $new;
    }

    public function buttonLinkAriaExpanded(string $value): self
    {
        $new = clone $this;
        $new->buttonLinkAriaExpanded = $value;
        return $new;
    }

    public function buttonLinkAriaLabelText(string $value): self
    {
        $new = clone $this;
        $new->buttonLinkAriaLabelText = $value;
        return $new;
    }

    public function buttonLinkContent(string $value): self
    {
        $new = clone $this;
        $new->buttonLinkContent = $value;
        return $new;
    }

    public function buttonLinkRole(string $value): self
    {
        $new = clone $this;
        $new->buttonLinkRole = $value;
        return $new;
    }

    public function navBarAriaLabel(string $value): self
    {
        $new = clone $this;
        $new->navBarAriaLabel = $value;
        return $new;
    }

    public function navBarBrandCssClass(string $value): self
    {
        $new = clone $this;
        $new->navBarBrandCssClass = $value;
        return $new;
    }

    public function navBarBurgerAttributes(array $value): self
    {
        $new = clone $this;
        $new->navBarBurgerAttributes = $value;
        return $new;
    }

    public function navBarBurgerCssClass(string $value): self
    {
        $new = clone $this;
        $new->navBarBurgerCssClass = $value;
        return $new;
    }

    public function navBarCssClass(string $value): self
    {
        $new = clone $this;
        $new->navBarCssClass = $value;
        return $new;
    }

    public function navBarItemCssClass(string $value): self
    {
        $new = clone $this;
        $new->navBarItemCssClass = $value;
        return $new;
    }

    public function navBarRole(string $value): self
    {
        $new = clone $this;
        $new->navBarRole = $value;
        return $new;
    }

    private function renderNavBar(self $new): string
    {
        Html::addCssClass($new->attributes, $new->navBarCssClass);

        if (!isset($new->attributes['id'])) {
            $new->attributes['id'] = "{$new->getId()}-navbar";
        }

        $new->attributes['aria-label'] = $new->navBarAriaLabel;
        $new->attributes['role'] = $new->navBarRole;

        return Html::openTag('nav', $new->attributes) . PHP_EOL . $new->renderNavBarBrand() . PHP_EOL;
    }

    private function renderNavBarBrand(): string
    {
        $new = clone $this;

        $brand = '';
        $brandImage = '';

        if ($new->brandImage !== '') {
            $brandImage = Img::tag()->attributes($new->brandImageAttributes)->url($new->brandImage)->render();
            $brand = PHP_EOL . A::tag()
                ->class($new->navBarItemCssClass)
                ->content($brandImage)
                ->encode(false)
                ->url($new->brandUrl)
                ->render();
        }

        if ($new->brandText !== '') {
            $brandText = $new->brandText;

            if ($brandImage !== '') {
                $brandText = $brandImage . $new->brandText;
            }

            if (empty($new->brandUrl)) {
                $brand = PHP_EOL . Span::tag()
                    ->attributes($new->brandTextAttributes)
                    ->class($new->navBarItemCssClass)
                    ->content($brandText)
                    ->render();
            } else {
                $brand = PHP_EOL . A::tag()
                    ->class($new->navBarItemCssClass)
                    ->content($brandText)
                    ->encode(false)
                    ->url($new->brandUrl)
                    ->render();
            }
        }

        $brand .= $new->renderNavBarBurguer($new);

        return Div::tag()
            ->attributes($new->brandAttributes)
            ->class($new->navBarBrandCssClass)
            ->content($brand)
            ->encode(false)
            ->render();
    }

    /**
     * Renders collapsible toggle button.
     *
     * @return string the rendering navbar burguer link button.
     *
     * @link https://bulma.io/documentation/components/navbar/#navbar-burger
     */
    private function renderNavBarBurguer(self $new): string
    {
        if ($new->buttonLinkContent === '') {
            $new->buttonLinkContent = PHP_EOL .
                Span::tag()->attributes(['aria-hidden' => "true"])->render() . PHP_EOL .
                Span::tag()->attributes(['aria-hidden' => "true"])->render() . PHP_EOL .
                Span::tag()->attributes(['aria-hidden' => "true"])->render() . PHP_EOL;
        }

        $new->navBarBurgerAttributes['aria-expanded'] = $new->buttonLinkAriaExpanded;
        $new->navBarBurgerAttributes['aria-label'] = $new->buttonLinkAriaLabelText;
        $new->navBarBurgerAttributes['role'] = $new->buttonLinkRole;

        return PHP_EOL . A::tag()
            ->attributes($new->navBarBurgerAttributes)
            ->class($new->navBarBurgerCssClass)
            ->content($new->buttonLinkContent)
            ->encode(false)
            ->render() . PHP_EOL;
    }
}
