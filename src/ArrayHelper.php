<?php

namespace MichaelDrennen\DataHelper;

class ArrayHelper {

    /**
     * Creates a map between the indices of two arrays based on matching values.
     *
     * @param array $leftArray  The primary array to be mapped from.
     * @param array $rightArray The secondary array to be mapped to.
     * @param int   $strictness Determines the mapping type:
     *                          0: One-to-one mapping ($leftArrayIndex => $rightArrayIndex).
     *                          1: One-to-many mapping ($leftArrayIndex => [$possibleRightArrayMatchingIndexes]).
     *                          -1: Reverse one-to-many mapping ($rightArrayIndex => [$possibleLeftArrayMatchingIndexes]).
     *
     * @return array The resulting map.
     * @throws \Exception
     */
    public static function makeMap( array $leftArray, array $rightArray, int $strictness ): array {
        // Handle strictness level 1: Left-to-Right one-to-many mapping.
        if ( 1 === $strictness ):
            return self::buildOneToManyMap( $leftArray, $rightArray );
        endif;

        // Handle strictness level -1: Right-to-Left one-to-many mapping.
        if ( -1 === $strictness ):
            return self::buildOneToManyMap( $rightArray, $leftArray );
        endif;

        // Handle strictness level 0: Left-to-Right one-to-one mapping.
        if ( 0 === $strictness ):
            return self::buildOneToOneMap( $leftArray, $rightArray );
        endif;

        throw new \Exception( 'Invalid strictness level: 0, 1, or -1.' );
    }


    /**
     * Builds a one-to-many map from the first array to the second.
     *
     * @param array $leftArray  The source array.
     * @param array $rightArray The target array.
     *
     * @return array The one-to-many map.
     */
    private static function buildOneToManyMap( array $leftArray, array $rightArray ): array {
        $resultMap = [];

        $rightArrayValueToName = [];
        foreach ( $rightArray as $name => $value ):
            $rightArrayValueToName[ $value ] = $name;
        endforeach;


        // Now, iterate through the source array and build the final map.
        foreach ( $leftArray as $leftName => $leftValue ):

            if ( !isset( $rightArrayValueToName[ $leftValue ] ) ):
                continue;
            endif;

            if ( !isset( $resultMap[ $leftName ] ) ):
                $resultMap[ $leftName ] = [];
            endif;

            $resultMap[ $leftName ][] = $rightArrayValueToName[ $leftValue ];
        endforeach;

        return $resultMap;
    }

    /**
     * Builds a one-to-one map from the first array to the second.
     *
     * @param array $leftArray  The source array.
     * @param array $rightArray The target array.
     *
     * @return array The one-to-one map.
     */
    private static function buildOneToOneMap( array $leftArray, array $rightArray ): array {
        $resultMap = [];

        // To handle potential duplicates in the target array and ensure a unique mapping,
        // we first create a reverse map of value => index.
        $rightArrayValueToName = [];
        foreach ( $rightArray as $name => $value ):
            $rightArrayValueToName[ $value ] = $name;
        endforeach;

        // Now, iterate through the source array and build the one-to-one map.
        foreach ( $leftArray as $leftName => $leftValue ):
            if ( isset( $rightArrayValueToName[ $leftValue ] ) ):
                $resultMap[ $leftName ] = $rightArrayValueToName[ $leftValue ];
            endif;
        endforeach;

        return $resultMap;
    }


    public static function insertAfter(array $array, string $afterKey, array $newElement): array
    {
        $keys = array_keys($array);
        $index = array_search($afterKey, $keys);

        if ($index === false):
            return $array + $newElement;
        endif;

        // Position to insert at
        $index++;

        $start = array_slice($array, 0, $index, true);
        $end = array_slice($array, $index, null, true);

        return $start + $newElement + $end;
    }


}