<?php

namespace MichaelDrennen\DataHelper;

class DataHelper {

    public static array $mysqlDataTypes = [
        'TINYINT',
        'SMALLINT',
        'MEDIUMINT',
        'INT',
        'BIGINT',
        'DECIMAL',
        'VARCHAR',
    ];

    public function recommendDataType( array $data ): InterfaceDataAnalysis {
        $isNumericData = TRUE;
        foreach ( $data as $i => $datum ):
            if ( is_numeric( $datum ) ):

            else:
                $isNumericData = FALSE;
            endif;
        endforeach;

        if ( $isNumericData ):
            return $this->calculateNumericDataType( $data );
        endif;
    }


    /**
     * @param array $data
     *
     * @return \MichaelDrennen\DataHelper\NumericDataAnalysis
     */
    public function calculateNumericDataType( array $data ): NumericDataAnalysis {
        $minValue = NULL;
        $maxValue = NULL;

        $numWholeDigits = NULL;
        $precision      = NULL;

        foreach ( $data as $datum ):
            $floatNumber = (float)$datum;

            if ( $floatNumber > $maxValue ):
                $maxValue = $floatNumber;
            endif;

            if ( $floatNumber < $minValue ):
                $minValue = $floatNumber;
            endif;

            $stringNumber = (string)$datum;
            $numberParts  = explode( '.', $stringNumber );

            $tempWhole   = $numberParts[ 0 ];
            $tempDecimal = $numberParts[ 1 ] ?? NULL;

            $tempWholeDigits = strlen( $tempWhole );
            if ( $tempWholeDigits > $numWholeDigits ):
                $numWholeDigits = $tempWholeDigits;
            endif;

            $tempNumDecimals = strlen( $tempDecimal );
            if ( $tempNumDecimals > $precision ):
                $precision = $tempNumDecimals;
            endif;
        endforeach;

        return new NumericDataAnalysis( $minValue,
                                        $maxValue,
                                        $numWholeDigits,
                                        $precision );
    }

}