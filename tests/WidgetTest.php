<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Yii\Extension\Bulma\Tests\TestSupport\StubWidget;

final class WidgetTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testAutoIdPrefix(): void
    {
        StubWidget::counter(0);
        $id = StubWidget::widget()->autoIdPrefix('t')->render();
        $this->assertSame('<run-t0>', $id);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetId(): void
    {
        StubWidget::counter(0);
        $id = StubWidget::widget()->render();
        $this->assertSame('<run-w0>', $id);
    }

    /**
     * @throws ReflectionException
     */
    public function testId(): void
    {
        StubWidget::counter(0);
        $id = StubWidget::widget()->id('test-2')->withoutAutoGenerateId()->render();
        $this->assertSame('<run-test-2>', $id);
    }

    public function testSize(): void
    {
        StubWidget::counter(0);
        $this->assertSame(
            '<run-w1 class="is-large">',
            StubWidget::widget()->size(StubWidget::SIZE_LARGE)->render(),
        );
    }

    public function testHeaderSizeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid size. Valid values are: "is-small"is-medium"is-large".');
        StubWidget::widget()->size('is-non-existent')->render();
    }
}
