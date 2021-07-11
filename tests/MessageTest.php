<?php

declare(strict_types=1);

namespace Yii\Extension\Bulma\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Bulma\Message;
use Yii\Extension\Bulma\Tests\TestSupport\TestTrait;

final class MessageTest extends TestCase
{
    use TestTrait;

    public function testAttributes(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->attributes(['class' => 'has-text-justified'])
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->headerMessage('Very important')
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="has-text-justified message is-dark">
        <div class="message-header">
        <p>Very important</p>
        <button type="button" class="delete"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBodyAttributes(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->bodyAttributes(['class' => 'has-text-justified'])
            ->headerMessage('Very important')
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark">
        <div class="message-header">
        <p>Very important</p>
        <button type="button" class="delete"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="has-text-justified message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCloseButtonAttributes(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->closeButtonAttributes(['class' => 'btn'])
            ->headerMessage('Very important')
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark">
        <div class="message-header">
        <p>Very important</p>
        <button type="button" class="btn delete"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHeaderAttributes(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->headerAttributes(['class' => 'has-text-justified'])
            ->headerMessage('Very important')
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark">
        <div class="has-text-justified message-header">
        <p>Very important</p>
        <button type="button" class="delete"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHeaderColor(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->headerMessage('Very important')
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->headerColor(Message::COLOR_SUCCESS)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-success">
        <div class="message-header">
        <p>Very important</p>
        <button type="button" class="delete"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHeaderColorException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid color. Valid values are: "is-primary"is-link"is-info"is-success"is-warning"is-danger".'
        );
        Message::widget()->headerColor('is-non-existent')->render();
    }

    public function testRender(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->headerMessage('Very important')
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark">
        <div class="message-header">
        <p>Very important</p>
        <button type="button" class="delete"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testSize(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->headerMessage('Very important')
            ->size(Message::SIZE_LARGE)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark is-large">
        <div class="message-header">
        <p>Very important</p>
        <button type="button" class="delete is-large"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithoutCloseButton(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->headerMessage('Very important')
            ->unclosedButton()
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark">
        <div class="message-header">Very important</div>
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithoutHeader(): void
    {
        Message::counter(0);

        $html = Message::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->headerMessage('Very important')
            ->withoutHeader()
            ->render();
        $expected = <<<'HTML'
        <div id="w0-message" class="message is-dark">
        <div class="message-body">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
