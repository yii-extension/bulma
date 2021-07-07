<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests\TestSupport;

use Yii\Extension\Bulma\Widget;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        return '<run-' . $this->getId() . '>';
    }
}
