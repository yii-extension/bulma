<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma;

use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\NoEncodeStringableInterface;

abstract class Widget extends AbstractWidget implements NoEncodeStringableInterface
{
    protected array $attributes = [];
    private string $id = '';
    private string $autoIdPrefix = 'w';
    private bool $autoGenerate = true;
    private static int $counter = 0;

    /**
     * The HTML attributes for the widgets. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @param string $value
     *
     * @return static
     *
     * {@see getId()}
     */
    public function autoIdPrefix(string $value): self
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * Counter used to generate {@see id} for widgets.
     *
     * @param int $value
     */
    public static function counter(int $value): void
    {
        self::$counter = $value;
    }

    /**
     * Disable auto generate id.
     *
     * @return static
     */
    public function withoutAutoGenerateId(): self
    {
        $new = clone $this;
        $new->autoGenerate = false;
        return $new;
    }

    /**
     * Returns the Id of the widget.
     *
     * @return string Id of the widget.
     */
    protected function getId(): string
    {
        $new = clone $this;

        if ($new->autoGenerate) {
            $new->id = $new->autoIdPrefix . static::$counter++;
        }

        return $new->id;
    }
}
