<?php


namespace AmpedWeb\GlideInABox\Tests\Feature;


use AmpedWeb\GlideInABox\Exceptions\InvalidFlipException;
use AmpedWeb\GlideInABox\Tests\TestCase;
use AmpedWeb\GlideInABox\Traits\Flip;
use AmpedWeb\GlideInABox\Util\GlideUrl;

class FlipTest extends TestCase
{
    /** @var GlideUrl */
    protected $glideUrl;

    public function setUp(): void
    {
        parent::setUp();

        $this->glideUrl = glide_url('cat.png');
    }

    public function testFlipRejectsInvalidInput()
    {
        $invalidInput = 'foo';

        $this->expectException(InvalidFlipException::class);
        $this->glideUrl->flip($invalidInput);
    }

    public function testFlipSetsCorrectValueV()
    {
        $this->glideUrl->flip(Flip::$FLIP_V);
        $this->assertEquals('v', $this->glideUrl->getParams()['flip']);
    }

    public function testFlipSetsCorrectValueH()
    {
        $this->glideUrl->flip(Flip::$FLIP_H);
        $this->assertEquals('h', $this->glideUrl->getParams()['flip']);
    }

    public function testFlipSetsCorrectValueBoth()
    {
        $this->glideUrl->flip(Flip::$FLIP_BOTH);
        $this->assertEquals('both', $this->glideUrl->getParams()['flip']);
    }
}