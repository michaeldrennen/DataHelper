<?php

namespace MichaelDrennen\DataHelper;

class NumericDataAnalysis implements InterfaceDataAnalysis {

    public ?float $minValue;

    public ?float $maxValue;

    public ?int $numWholeDigits = NULL;

    public ?int $precision = NULL;

    public ?bool $signed;


    /**
     * @param string|NULL $minValue
     * @param string|NULL $maxValue
     * @param int|NULL    $numWholeDigits
     * @param string|NULL $precision
     * @param bool|NULL   $signed
     */
    public function __construct( string $minValue = NULL,
                                 string $maxValue = NULL,
                                 int    $numWholeDigits = NULL,
                                 string $precision = NULL,
                                 bool   $signed = NULL ) {
        $this->minValue       = $minValue;
        $this->maxValue       = $maxValue;
        $this->numWholeDigits = $numWholeDigits;
        $this->precision      = $precision;
        $this->signed         = $signed;
    }
}