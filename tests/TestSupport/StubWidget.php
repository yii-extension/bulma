<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests\TestSupport;

use Yii\Extension\Bulma\Widget;
use Yiisoft\Html\Html;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        $new = clone $this;

        $attributes = $new->getAttributes();
        $size = $new->getSize();
        $html = $new->getId();

        if ($size !== '') {
            Html::addCssClass($attributes, $size);

            $attributes = Html::renderTagAttributes($attributes);

            $html = $this->getId() . $attributes;
        }

        return '<run-' . $html . '>';
    }
}
