<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma;

use InvalidArgumentException;
use ReflectionException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Span;

use function array_merge;
use function implode;

/**
 * The dropdown component is a container for a dropdown button and a dropdown menu.
 *
 * @link https://bulma.io/documentation/components/dropdown/
 */
final class Dropdown extends Widget
{
    private array $buttonAttributes = [];
    private array $buttonIconAttributes = ['class' => 'icon is-small'];
    private string $buttonIconCssClass = '';
    private string $buttonIconText = '&#8595;';
    private string $buttonLabel = 'Clic Me';
    private array $buttonLabelAttributes = [];
    private string $dividerCssClass = 'dropdown-divider';
    private string $dropdownContentCssClass = 'dropdown-content';
    private string $dropdownMenuCssClass = 'dropdown-menu';
    private string $dropdownTriggerCssClass = 'dropdown-trigger';
    private bool $encloseByContainer = true;
    private array $items = [];
    private array $submenuAttributes = [];
    private array $triggerAttributes = [];

    protected function run(): string
    {
        $new = clone $this;
        return $new->renderDropdown($new);
    }

    /**
     * The HTML attributes for the dropdown button. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function buttonAttributes(array $value): self
    {
        $new = clone $this;
        $new->buttonAttributes = $value;
        return $new;
    }

    /**
     * Set icon css class for the dropdown button.
     *
     * @param string $value
     *
     * @return self
     */
    public function buttonIconCssClass(string $value): self
    {
        $new = clone $this;
        $new->buttonIconCssClass = $value;
        return $new;
    }

    /**
     * Set icon text for the dropdown button.
     *
     * @param string $value
     *
     * @return self
     */
    public function buttonIconText(string $value): self
    {
        $new = clone $this;
        $new->buttonIconText = $value;
        return $new;
    }

    /**
     * Set label for the dropdown button.
     *
     * @param string $value
     *
     * @return self
     */
    public function buttonLabel(string $value): self
    {
        $new = clone $this;
        $new->buttonLabel = $value;
        return $new;
    }

    /**
     * The HTML attributes for the dropdown button label. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function buttonLabelAttributes(array $value): self
    {
        $new = clone $this;
        $new->buttonLabelAttributes = $value;
        return $new;
    }

    /**
     * A horizontal line to separate dropdown items.
     *
     * @return static
     */
    public function dividerCssClass(string $value): self
    {
        $new = clone $this;
        $new->dividerCssClass = $value;
        return $new;
    }

    /**
     * The dropdown box, with a white background and a shadow.
     *
     * @return static
     *
     * @link https://bulma.io/documentation/components/dropdown/#dropdown-content
     */
    public function dropdownContentCssClass(string $value): self
    {
        $new = clone $this;
        $new->dropdownContentCssClass = $value;
        return $new;
    }

    /**
     * The toggable menu, hidden by default.
     *
     * @return static
     */
    public function dropdownMenuCssClass(string $value): self
    {
        $new = clone $this;
        $new->dropdownMenuCssClass = $value;
        return $new;
    }

    /**
     * The toggable menu, hidden by default.
     *
     * @return static
     */
    public function dropdownTriggerCssClass(string $value): self
    {
        $new = clone $this;
        $new->dropdownTriggerCssClass = $value;
        return $new;
    }

    /**
     * List of menu items in the dropdown. Each array element can be either an HTML string, or an array representing a
     * single menu with the following structure:
     *
     * - label: string, required, the label of the item link.
     * - encode: bool, optional, whether to HTML-encode item label.
     * - url: string|array, optional, the URL of the item link. This will be processed by {@see currentPath}.
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - urlAttributes: array, optional, the HTML attributes of the item link.
     * - attributes: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - submenuOptions: array, optional, the HTML attributes for sub-menu container tag. If specified it will be
     *   merged with {@see submenuOptions}.
     *
     * To insert divider use `-`.
     *
     * @param array $value
     *
     * @return static
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The HTML attributes for sub-menu container tags.
     *
     * @param array $value
     *
     * @return static
     */
    public function submenuAttributes(array $value): self
    {
        $new = clone $this;
        $new->submenuAttributes = $value;
        return $new;
    }

    /**
     * If the widget should be unclosed by container.
     *
     * @return static
     */
    public function unClosedByContainer(): self
    {
        $new = clone $this;
        $new->encloseByContainer = false;
        return $new;
    }

    /**
     * @throws ReflectionException
     */
    private function renderDropdown(self $new): string
    {
        /** @var string */
        $id = $new->attributes['id'] ?? "{$this->getId()}-dropdown";

        unset($new->attributes['id']);

        if ($new->encloseByContainer) {
            Html::addCssClass($new->attributes, 'dropdown');
            $html = Div::tag()->attributes($new->attributes)->content(
                PHP_EOL . $new->renderDropdownTrigger($new, $id) . PHP_EOL
            )->encode(false)->render();
        } else {
            $html = $new->renderItems($new);
        }

        return $html;
    }

    /**
     * Render dropdown button.
     *
     * @return string the rendering toggle button.
     *
     * @link https://bulma.io/documentation/components/dropdown/#hoverable-or-toggable
     */
    private function renderDropdownButton(self $new, string $id): string
    {
        Html::addCssClass($new->triggerAttributes, 'button');

        $new->triggerAttributes['aria-haspopup'] = "true";
        $new->triggerAttributes['aria-controls'] = $id;

        return Button::tag()
            ->attributes($new->triggerAttributes)
            ->content(
                $new->renderLabelButton(
                    $new->buttonLabel,
                    $new->buttonLabelAttributes,
                    $new->buttonIconText,
                    $new->buttonIconCssClass,
                    $new->buttonIconAttributes,
                )
            )
            ->encode(false)
            ->render() . PHP_EOL;
    }

    /**
     * @throws ReflectionException
     */
    private function renderDropdownContent(self $new): string
    {
        return Div::tag()
            ->class($new->dropdownContentCssClass)
            ->content(PHP_EOL . $new->renderItems($new) . PHP_EOL)
            ->encode(false)
            ->render();
    }

    private function renderDropdownMenu(self $new, string $id): string
    {
        return Div::tag()
            ->class($new->dropdownMenuCssClass)
            ->content(PHP_EOL . $new->renderDropdownContent($new) . PHP_EOL)
            ->encode(false)
            ->id($id)
            ->render();
    }

    private function renderDropdownTrigger(self $new, string $id): string
    {
        return Div::tag()
            ->class($new->dropdownTriggerCssClass)
            ->content(PHP_EOL . $new->renderDropdownButton($new, $id))
            ->encode(false)
            ->render() . PHP_EOL . $new->renderDropdownMenu($new, $id);
    }

    /**
     * Renders menu items.
     *
     * @throws InvalidArgumentException|ReflectionException if the label option is not specified in one of the items.
     *
     * @return string the rendering result.
     */
    private function renderItems(self $new): string
    {
        $lines = [];

        /** @var array|string $item */
        foreach ($new->items as $item) {
            if ($item === '-') {
                $lines[] = CustomTag::name('hr')->class($new->dividerCssClass)->render();
            } else {
                if (!isset($item['label']) && $item !== '-') {
                    throw new InvalidArgumentException('The "label" option is required.');
                }

                /** @var string */
                $itemLabel = $item['label'] ?? '';

                if (isset($item['encode']) && $item['encode'] === true) {
                    $itemLabel = Html::encode($itemLabel);
                }

                /** @var array */
                $items = $item['items'] ?? [];

                /** @var array */
                $urlAttributes = $item['urlAttributes'] ?? [];

                /** @var string */
                $iconText = $item['iconText'] ?? '';

                /** @var string */
                $iconCssClass = $item['iconCssClass'] ?? '';

                /** @var array */
                $iconAttributes = $item['iconAttributes'] ?? [];

                /** @var string */
                $url = $item['url'] ?? '';

                /** @var bool */
                $active = $item['active'] ?? false;

                /** @var bool */
                $disabled = $item['disable'] ?? false;

                /** @var bool */
                $enclose = $item['enclose'] ?? true;

                $itemLabel = $new->renderLabelItem($itemLabel, $iconText, $iconCssClass, $iconAttributes);

                Html::addCssClass($urlAttributes, 'dropdown-item');

                if ($disabled) {
                    Html::addCssStyle($urlAttributes, 'opacity:.65; pointer-events:none;');
                } elseif ($active) {
                    Html::addCssClass($urlAttributes, 'is-active');
                }

                if ($items === []) {
                    if ($itemLabel === '-') {
                        $content = CustomTag::name('hr')->class($new->dividerCssClass)->render();
                    } elseif ($enclose === false) {
                        $content = $itemLabel;
                    } elseif ($url === '') {
                        $content = CustomTag::name('h6')
                            ->class('dropdown-header')
                            ->content($itemLabel)
                            ->encode(null)
                            ->render();
                    } else {
                        $content = A::tag()
                            ->attributes($urlAttributes)
                            ->content($itemLabel)
                            ->encode(false)
                            ->url($url)
                            ->render();
                    }

                    $lines[] = $content;
                } else {
                    /** @var array */
                    $submenuAttributes = $item['submenuAttributes'] ?? [];
                    $new->submenuAttributes = array_merge($new->submenuAttributes, $submenuAttributes);

                    $lines[] = self::widget()
                        ->attributes($new->submenuAttributes)
                        ->items($items)
                        ->submenuAttributes($new->submenuAttributes)
                        ->render();
                }
            }
        }

        return implode(PHP_EOL, $lines);
    }

    private function renderLabelButton(
        string $label,
        array $labelAttributes,
        string $iconText,
        string $iconCssClass,
        array $iconAttributes = []
    ): string {
        $html = '';

        if ($label !== '') {
            $html =  PHP_EOL . Span::tag()
                ->attributes($labelAttributes)
                ->content($label)
                ->encode(false)
                ->render();
        }

        if ($iconText !== '' || $iconCssClass !== '') {
            $html .= PHP_EOL .
                Span::tag()
                    ->attributes($iconAttributes)
                    ->content(CustomTag::name('i')->class($iconCssClass)->content($iconText)->encode(false)->render())
                    ->encode(false)
                    ->render();
        }

        return $html . PHP_EOL;
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
}
