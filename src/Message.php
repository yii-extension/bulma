<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Span;

/**
 * Message renders Bulma message component.
 *
 * For example,
 *
 * ```php
 * <?= Message::widget()->headerColor('success')->header('System info')->body('Say hello...') ?>
 * ```
 *
 * @link https://bulma.io/documentation/components/message/
 */
final class Message extends Widget
{
    private string $body = '';
    private array $bodyAttributes = [];
    private array $buttonSpanAttributes = [];
    private string $buttonSpanAriaHidden = 'true';
    private string $buttonCssClass = 'delete';
    private array $closeButtonAttributes = [];
    private array $headerAttributes = [];
    private string $headerColor = 'is-dark';
    private string $headerMessage = '';
    private string $messageBodyCssClass = 'message-body';
    private string $messageCssClass = 'message';
    private string $messageHeaderMessageCssClass = 'message-header';
    private bool $unclosedButton = false;
    private bool $withoutHeader = true;

    protected function run(): string
    {
        $new = clone $this;

        return $new->renderMessage($new);
    }

    /**
     * The body content in the message component. Message widget will also be treated as the body content, and will be
     * rendered before this.
     *
     * @param string $value
     *
     * @return self
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;
        return $new;
    }

    /**
     * The HTML attributes for the widget body tag.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function bodyAttributes(array $value): self
    {
        $new = clone $this;
        $new->bodyAttributes = $value;
        return $new;
    }

    /**
     * The attributes for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If {@see unclosedButton} is false, no close button will be rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function closeButtonAttributes(array $value): self
    {
        $new = clone $this;
        $new->closeButtonAttributes = $value;
        return $new;
    }

    /**
     * Set color header message.
     *
     * @param string $value setting default 'is-dark', 'is-primary', 'is-link', 'is-info', 'is-success', 'is-warning',
     * 'is-danger'.
     *
     * @return self
     */
    public function headerColor(string $value): self
    {
        if (!in_array($value, self::COLOR_ALL)) {
            $values = implode('"', self::COLOR_ALL);
            throw new InvalidArgumentException("Invalid color. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->headerColor = $value;
        return $new;
    }

    /**
     * The header message in the message component. Message widget will also be treated as the header content, and will
     * be rendered before body.
     *
     * @param string $value
     *
     * @return self
     */
    public function headerMessage(string $value): self
    {
        $new = clone $this;
        $new->headerMessage = $value;
        return $new;
    }

    /**
     * The HTML attributes for the widget header tag.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function headerAttributes(array $value): self
    {
        $new = clone $this;
        $new->headerAttributes = $value;
        return $new;
    }

    /**
     * Allows you to disable close button message widget.
     *
     * @return self
     */
    public function unclosedButton(): self
    {
        $new = clone $this;
        $new->unclosedButton = true;
        return $new;
    }

    /**
     * Allows you to disable header widget.
     *
     * @return self
     */
    public function withoutHeader(): self
    {
        $new = clone $this;
        $new->withoutHeader = false;
        return $new;
    }

    private function renderCloseButton(self $new): string
    {
        $html = '';

        if ($new->unclosedButton === true) {
            return $html;
        }

        $new->buttonSpanAttributes['aria-hidden'] = $new->buttonSpanAriaHidden;

        Html::addCssClass($new->closeButtonAttributes, $new->buttonCssClass);

        unset($new->closeButtonAttributes['label']);

        $label = Span::tag()->attributes($new->buttonSpanAttributes)->content('&times;')->encode(false)->render() ;

        $new->closeButtonAttributes['type'] = 'button';

        $size = $new->getSize();

        if ($size !== '') {
            Html::addCssClass($new->closeButtonAttributes, $size);
        }

        return Button::tag()
            ->attributes($new->closeButtonAttributes)
            ->content($label)
            ->encode(false)
            ->render() . PHP_EOL;
    }

    private function renderHeader(self $new): string
    {
        $html = '';

        Html::addCssClass($new->headerAttributes, $new->messageHeaderMessageCssClass);

        $renderCloseButton = $new->renderCloseButton($new);

        if ($renderCloseButton !== '') {
            $new->headerMessage = PHP_EOL . '<p>' . $new->headerMessage . '</p>' . PHP_EOL . $renderCloseButton;
        }

        if ($new->withoutHeader) {
            $html = Div::tag()
                ->attributes($new->headerAttributes)
                ->content($new->headerMessage)
                ->encode(false)
                ->render() . PHP_EOL;
        }


        return $html;
    }

    private function renderMessage(self $new): string
    {
        $attributes = $new->getAttributes();
        $id = '';
        $size = $new->getSize();

        if (!isset($attributes['id'])) {
            $id = "{$new->getId()}-message";
        }

        Html::addCssClass($attributes, $new->messageCssClass);
        Html::addCssClass($attributes, $new->headerColor);

        if ($size !== '') {
            Html::addCssClass($attributes, $size);
        }

        $divBody = $new->renderMessageBody($new);

        return Div::tag()
            ->attributes($attributes)
            ->content(PHP_EOL . $new->renderHeader($new) . $divBody)
            ->encode(false)
            ->id($id)
            ->render();
    }

    private function renderMessageBody(self $new): string
    {
        Html::addCssClass($new->bodyAttributes, $new->messageBodyCssClass);

        if ($new->body !== '') {
            $new->body = PHP_EOL . $new->body . PHP_EOL;
        }

        return Div::tag()->attributes($new->bodyAttributes)->content($new->body)->encode(false)->render() . PHP_EOL;
    }
}
