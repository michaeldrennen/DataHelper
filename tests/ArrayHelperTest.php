<?php

namespace MichaelDrennen\DataHelper\Tests;


use MichaelDrennen\DataHelper\ArrayHelper;
use MichaelDrennen\DataHelper\DataHelper;
use MichaelDrennen\DataHelper\NumericDataAnalysis;
use PHPUnit\Framework\TestCase;


class ArrayHelperTest extends TestCase {


    protected array $leftArray = [
        'height' => 73,
        'weight' => 275,
        'age' => 46,
    ];

    protected array $rightArray = [
        'a' => 46,
        'h' => 73,
        'w' => 275,
    ];

    public function setUp(): void {
    }


    public function tearDown(): void {
    }


    /**
     * @test
     * @group array
     */
    public function testLeftToRightExactMatchShouldReturnMatches() {
        $matches = ArrayHelper::makeMap($this->leftArray, $this->rightArray, 0);
        $this->assertEquals(3, count($matches));
    }

}