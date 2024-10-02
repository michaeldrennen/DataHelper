<?php

namespace MichaelDrennen\DataHelper\Tests;


use MichaelDrennen\DataHelper\DataHelper;
use MichaelDrennen\DataHelper\NumericDataAnalysis;
use PHPUnit\Framework\TestCase;


class DataHelperTest extends TestCase {
    public function setUp(): void {
    }


    public function tearDown(): void {
    }


    /**
     * @test
     * @group numeric
     */
    public function testNumericDataShouldReturnNumericDataAnalysis() {
        $data = [
            199990.12345678901234567890,
            -0.69429657794677,
            0.045506619144603,
            3.83,
            -0.049429657794677,
            -0.049429657794677,
            3.83,
            0.045506619144603,
            0.045506619144603,
            0.045506619144603,
            0.29,
            0.053542703944849,
            0.75281327484265,
            0.29,
            -110.042015577577065,
            0.75281327484265,
            0.053542703944849,
            0,
            0.75281327484265,
            0.053542703944849,
        ];

        $dataHelper   = new DataHelper();
        $dataAnalysis = $dataHelper->recommendDataType( $data );

        print_r($dataAnalysis);

        $this->assertInstanceOf( NumericDataAnalysis::class, $dataAnalysis );
    }

}