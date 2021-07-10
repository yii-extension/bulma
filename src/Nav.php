<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma;

use InvalidArgumentException;
use ReflectionException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Span;

use function implode;
use function is_array;

/**
 * Nav renders a nav HTML component.
 *
 * @link https://bulma.io/documentation/components/navbar/#basic-navbar
 */
final class Nav extends Widget
{
    private bool $activateItems = true;
    private bool $activateParents = false;
    private string $currentPath = '';
    private array $items = [];
    private string $hasDropdownCssClass = 'has-dropdown';
    private string $isHoverableCssClass = 'is-hoverable';
    private string $navBarDropdownCssClass = 'navbar-dropdown';
    private string $navBarItemCssClass = 'navbar-item';
    private string $navBarLinkCssClass = 'navbar-link';

    /**
     * @throws ReflectionException
     */
    protected function run(): string
    {
        $new  = clone $this;

        return $new->renderNav($new);
    }

    /**
     * Disable activate items according to whether their currentPath.
     *
     * @return $this
     *
     * {@see isItemActive}
     */
    public function withoutActivateItems(): self
    {
        $new = clone $this;
        $new->activateItems = false;
        return $new;
    }

    /**
     * Whether to activate parent menu items when one of the corresponding child menu items is active.
     *
     * @return $this
     */
    public function activateParents(): self
    {
        $new = clone $this;
        $new->activateParents = true;
        return $new;
    }

    /**
     * Allows you to assign the current path of the url from request controller.
     *
     * @param string $value
     *
     * @return self
     */
    public function currentPath(string $value): self
    {
        $new = clone $this;
        $new->currentPath = $value;
        return $new;
    }

    /**
     * List of items in the nav widget. Each array element represents a single  menu item which can be either a string
     * or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: bool, optional, whether the item should be on active state or not.
     * - dropdownAttributes: array, optional, the HTML options that will passed to the {@see Dropdown} widget.
     * - items: array|string, optional, the configuration array for creating a {@see Dropdown} widget, or a string
     *   representing the dropdown menu.
     * - encode: bool, optional, whether the label will be HTML-encoded. If set, supersedes the $encodeLabels option for
     *   only this item.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     *
     * @param array $value
     *
     * @return self
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * Renders the given items as a dropdown.
     *
     * This method is called to create sub-menus.
     *
     * @param array $items the given items. Please refer to {@see Dropdown::items} for the array structure.
     * @param array $parentItem the parent item information. Please refer to {@see items} for the structure of this
     * array.
     *
     * @throws ReflectionException
     *
     * @return string the rendering result.
     *
     * @link https://bulma.io/documentation/components/navbar/#dropdown-menu
     */
    private function renderDropdown(array $items): string
    {
        return Dropdown::widget()
            ->dividerCssClass('navbar-divider')
            ->dropdownCssClass('navbar-dropdown')
            ->dropdownItemCssClass('navbar-item')
            ->items($items)
            ->unClosedByContainer()
            ->render() . PHP_EOL;
    }

    /**
     * Check to see if a child item is active optionally activating the parent.
     *
     * @param array $items
     * @param bool $active should the parent be active too
     *
     * @return array
     *
     * {@see items}
     */
    private function isChildActive(array $items, bool &$active = false): array
    {
        $new = clone $this;

        /** @var array|string $child */
        foreach ($items as $i => $child) {
            /** @var string */
            $url = $child['url'] ?? '#';

            /** @var bool */
            $active = $child['active'] ?? false;

            if ($active === false && is_array($items[$i])) {
                $items[$i]['active'] = $new->isItemActive($url, $new->currentPath, $new->activateItems);
            }

            if ($new->activateParents) {
                $active = true;
            }

            /** @var array */
            $childItems = $child['items'] ?? [];

            if ($childItems !== [] && is_array($items[$i])) {
                $items[$i]['items'] = $new->isChildActive($childItems);

                if ($active) {
                    $items[$i]['attributes'] = ['active' => true];
                    $active = true;
                }
            }
        }

        return $items;
    }

    /**
     * Checks whether a menu item is active.
     *
     * This is done by checking if {@see currentPath} match that specified in the `url` option of the menu item. When
     * the `url` option of a menu item is specified in terms of an array, its first element is treated as the
     * currentPath for the item and the rest of the elements are the associated parameters. Only when its currentPath
     * and parameters match {@see currentPath}, respectively, will a menu item be considered active.
     *
     * @param string $url
     * @param string $currentPath
     * @param bool $activateItems
     *
     * @return bool whether the menu item is active
     */
    private function isItemActive(string $url, string $currentPath, bool $activateItems): bool
    {
        return ($currentPath !== '/') && ($url === $currentPath) && $activateItems;
    }

    private function renderLabelItem(
        string $label,
        string $iconText,
        string $iconCssClass,
        array $iconAttributes = []
    ): string {
        $html = '';

        if ($iconText !== '' || $iconCssClass !== '') {
            $html = Span::tag()
                ->attributes($iconAttributes)
                ->content(CustomTag::name('i')->class($iconCssClass)->content($iconText)->encode(false)->render())
                ->encode(false)
                ->render();
        }

        if ($label !== '') {
            $html .= $label;
        }

        return $html;
    }

    /**
     * Renders a widget's item.
     *
     * @param array $item the item to render.
     *
     * @throws ReflectionException
     *
     * @return string the rendering result.
     */
    private function renderItem(array $item): string
    {
        $new = clone $this;

        $html = '';

        if (!isset($item['label'])) {
            throw new InvalidArgumentException('The "label" option is required.');
        }

        /** @var string */
        $itemLabel = $item['label'] ?? '';

        if (isset($item['encode']) && $item['encode'] === true) {
            $itemLabel = Html::encode($itemLabel);
        }

        /** @var array */
        $items = $item['items'] ?? [];

        /** @var string */
        $url = $item['url'] ?? '#';

        /** @var array */
        $urlAttributes = $item['urlAttributes'] ?? [];

        /** @var array */
        $dropdownAttributes = isset($item['dropdownAttributes']) ? $item['dropdownAttributes'] : [];

        /** @var string */
        $iconText = $item['iconText'] ?? '';

        /** @var string */
        $iconCssClass = $item['iconCssClass'] ?? '';

        /** @var array */
        $iconAttributes = $item['iconAttributes'] ?? [];

        /** @var bool */
        $active = $item['active'] ?? $new->isItemActive($url, $new->currentPath, $new->activateItems);

        /** @var bool */
        $disabled = $item['disabled'] ?? false;

        $itemLabel = $new->renderLabelItem($itemLabel, $iconText, $iconCssClass, $iconAttributes);

        if ($disabled) {
            Html::addCssStyle($urlAttributes, 'opacity:.65; pointer-events:none;');
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($urlAttributes, ['active' => 'is-active']);
        }

        if ($items !== []) {
            Html::addCssClass(
                $new->attributes,
                [$new->navBarItemCssClass, $new->hasDropdownCssClass, $new->isHoverableCssClass]
            );
            Html::addCssClass($urlAttributes, $new->navBarLinkCssClass);
            Html::addCssClass($dropdownAttributes, $new->navBarDropdownCssClass);

            $items = $new->isChildActive($items, $active);
            $dropdown = PHP_EOL . $new->renderDropdown($items);
            $a = A::tag()->attributes($urlAttributes)->content($itemLabel)->encode(false)->url($url)->render();
            $div = Div::tag()->attributes($dropdownAttributes)->content($dropdown)->encode(false)->render();

            $html = Div::tag()
                ->attributes($new->attributes)
                ->content(PHP_EOL . $a . PHP_EOL . $div . PHP_EOL)
                ->encode(false)
                ->render();
        }

        if ($html === '') {
            Html::addCssClass($urlAttributes, 'navbar-item');
            $html = A::tag()->attributes($urlAttributes)->content($itemLabel)->url($url)->encode(false)->render();
        }

        return $html;
    }

    /**
     * @throws ReflectionException
     */
    private function renderNav(self $new): string
    {
        $items = [];

        /** @var array|string $item */
        foreach ($new->items as $item) {
            $visible = !isset($item['visible']) || $item['visible'];

            if ($visible) {
                $items[] = is_string($item) ? $item : $new->renderItem($item);
            }
        }

        return implode("\n", $items);
    }
}
