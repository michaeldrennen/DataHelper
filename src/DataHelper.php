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

        $signed = FALSE;

        foreach ( $data as $datum ):
            $floatNumber = (float)$datum;

            if ( 0 > $floatNumber ):
                $signed = TRUE;
            endif;

            if ( !isset( $maxValue ) ):
                $maxValue = $floatNumber;
            elseif ( $floatNumber > $maxValue ):
                $maxValue = $floatNumber;
            endif;


            if ( !isset( $minValue ) ):
                $minValue = $floatNumber;
            elseif ( $floatNumber < $minValue ):
                $minValue = $floatNumber;
            endif;

            $stringNumber = (string)$datum;
            $numberParts  = explode( '.', $stringNumber );

            //print_r( $numberParts );

            $tempWhole   = $numberParts[ 0 ];
            $tempDecimal = $numberParts[ 1 ] ?? NULL;

            $unsignedTempWhole = str_replace('-','',$tempWhole);

            //var_dump($tempWhole);
            //var_dump($tempDecimal);
            $tempWholeDigits = strlen( $tempWhole );
            if ( !isset( $tempWholeDigits ) ):
                $numWholeDigits = $tempWholeDigits;
            elseif ( $tempWholeDigits > $numWholeDigits ):
                var_dump($tempWhole);
                var_dump($tempWholeDigits);
                $numWholeDigits = $tempWholeDigits;
            endif;

            $tempNumDecimals = @strlen( $tempDecimal );
            if ( !isset( $precision ) ):
                $precision = $tempNumDecimals;
            elseif ( $tempNumDecimals > $precision ):
                $precision = $tempNumDecimals;
            endif;
        endforeach;

        return new NumericDataAnalysis( $minValue,
                                        $maxValue,
                                        $numWholeDigits,
                                        $precision,
                                        $signed );
    }

}