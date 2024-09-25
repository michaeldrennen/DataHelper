<?php

namespace MichaelDrennen\DataHelper;

class NumericDataAnalysis implements InterfaceDataAnalysis {

    public ?string $minValue;
    public ?string $maxValue;

    public ?string $precision;

    public ?bool $signed;

    public function __construct( string $minValue = null, string $maxValue = null, string $precision = null, bool $signed = null ) {
        $this->minValue  = $minValue;
        $this->maxValue  = $maxValue;
        $this->precision = $precision;
        $this->signed    = $signed;
    }
}