<?php

namespace MichaelDrennen\DataHelper;

class NumericDataAnalysis implements InterfaceDataAnalysis {

    public string $minValue;
    public string $maxValue;

    public string $precision;

    public bool $signed;

    public function __construct( string $minValue, string $maxValue, string $precision, bool $signed ) {
        $this->minValue  = $minValue;
        $this->maxValue  = $maxValue;
        $this->precision = $precision;
        $this->signed    = $signed;
    }
}