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


    /**
     * @test
     * @group array
     */
    public function testLeftToRightLooseMatchesShouldReturnMatches() {
        $matches = ArrayHelper::makeMap($this->leftArray, $this->rightArray, -1);
        $this->assertEquals(3, count($matches));
    }



    /**
     * @test
     * @group array
     */
    public function testRightToLeftLooseMatchesShouldReturnMatches() {
        $matches = ArrayHelper::makeMap($this->leftArray, $this->rightArray, 1);
        $this->assertEquals(3, count($matches));
    }


    /**
     * @test
     * @group array
     * @group insert
     */
    public function testInsertAfterShouldPlaceElementAtCorrectSpot() {
        $array = [
            'a',
            'b',
            'c',
            'd',
            'e',
        ];
        $array = ArrayHelper::insertAfter($array, 'b', 'x');
        $this->assertEquals('x', $array[1]);
    }

}