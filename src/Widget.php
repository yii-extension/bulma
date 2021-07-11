<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma;

use InvalidArgumentException;
use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\NoEncodeStringableInterface;

abstract class Widget extends AbstractWidget implements NoEncodeStringableInterface
{
    public const COLOR_PRIMARY = 'is-primary';
    public const COLOR_LINK = 'is-link';
    public const COLOR_INFO = 'is-info';
    public const COLOR_SUCCESS = 'is-success';
    public const COLOR_WARNING = 'is-warning';
    public const COLOR_DANGER = 'is-danger';
    public const COLOR_ALL = [
        self::COLOR_PRIMARY,
        self::COLOR_LINK,
        self::COLOR_INFO,
        self::COLOR_SUCCESS,
        self::COLOR_WARNING,
        self::COLOR_DANGER,
    ];
    public const SIZE_SMALL = 'is-small';
    public const SIZE_MEDIUM = 'is-medium';
    public const SIZE_LARGE = 'is-large';
    public const SIZE_ALL = [
        self::SIZE_SMALL,
        self::SIZE_MEDIUM,
        self::SIZE_LARGE,
    ];

    private array $attributes = [];
    private string $id = '';
    private string $autoIdPrefix = 'w';
    private bool $autoGenerate = true;
    private static int $counter = 0;
    private string $size = '';

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
     * Set size config widgets.
     *
     * @param string $value size class.
     *
     * @return self
     */
    public function size(string $value): self
    {
        if (!in_array($value, self::SIZE_ALL)) {
            $values = implode('"', self::SIZE_ALL);
            throw new InvalidArgumentException("Invalid size. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->size = $value;
        return $new;
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

    protected function getAttributes(): array
    {
        return $this->attributes;
    }

    protected function getSize(): string
    {
        return $this->size;
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
