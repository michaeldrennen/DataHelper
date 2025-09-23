<?php

namespace MichaelDrennen\DataHelper;

class ArrayHelper {

    /**
     * Creates a map between the indices of two arrays based on matching values.
     *
     * @param array $leftArray The primary array to be mapped from.
     * @param array $rightArray The secondary array to be mapped to.
     * @param int $strictness Determines the mapping type:
     * 0: One-to-one mapping ($leftArrayIndex => $rightArrayIndex).
     * 1: One-to-many mapping ($leftArrayIndex => [$possibleRightArrayMatchingIndexes]).
     * -1: Reverse one-to-many mapping ($rightArrayIndex => [$possibleLeftArrayMatchingIndexes]).
     * @return array The resulting map.
     */
    public static function makeMap(array $leftArray, array $rightArray, int $strictness): array {
        // Handle strictness level 1: Left-to-Right one-to-many mapping.
        if ($strictness === 1) {
            return self::buildOneToManyMap($leftArray, $rightArray);
        }

        // Handle strictness level -1: Right-to-Left one-to-many mapping.
        if ($strictness === -1) {
            // By swapping the arrays and reversing the output, we can reuse the same logic.
            $reversedMap = self::buildOneToManyMap($rightArray, $leftArray);
            return self::reverseMap($reversedMap);
        }

        // Handle strictness level 0: Left-to-Right one-to-one mapping.
        if ($strictness === 0) {
            return self::buildOneToOneMap($leftArray, $rightArray);
        }

        // Return an empty array for any other strictness value.
        return [];
    }

    /**
     * Builds a one-to-many map from the first array to the second.
     *
     * @param array $sourceArray The source array.
     * @param array $targetArray The target array.
     * @return array The one-to-many map.
     */
    private static function buildOneToManyMap(array $sourceArray, array $targetArray): array {
        $resultMap = [];

        // Build a temporary map of values to all their corresponding indices in the target array.
        $targetValueToIndexMap = [];
        foreach ($targetArray as $index => $value) {
            // Normalize values for comparison by converting objects to a hash,
            // or just use the value directly for primitives.
            $key = is_object($value) ? spl_object_hash($value) : $value;
            if (!isset($targetValueToIndexMap[$key])) {
                $targetValueToIndexMap[$key] = [];
            }
            $targetValueToIndexMap[$key][] = $index;
        }

        // Now, iterate through the source array and build the final map.
        foreach ($sourceArray as $sourceIndex => $sourceValue) {
            $sourceKey = is_object($sourceValue) ? spl_object_hash($sourceValue) : $sourceValue;
            if (isset($targetValueToIndexMap[$sourceKey])) {
                $resultMap[$sourceIndex] = $targetValueToIndexMap[$sourceKey];
            }
        }

        return $resultMap;
    }

    /**
     * Builds a one-to-one map from the first array to the second.
     *
     * @param array $sourceArray The source array.
     * @param array $targetArray The target array.
     * @return array The one-to-one map.
     */
    private static function buildOneToOneMap(array $sourceArray, array $targetArray): array {
        $resultMap = [];

        // To handle potential duplicates in the target array and ensure a unique mapping,
        // we first create a reverse map of value => index.
        $targetValueToIndexMap = [];
        foreach ($targetArray as $index => $value) {
            // If the value already exists, we skip it to ensure one-to-one mapping.
            $key = is_object($value) ? spl_object_hash($value) : $value;
            if (!isset($targetValueToIndexMap[$key])) {
                $targetValueToIndexMap[$key] = $index;
            }
        }

        // Now, iterate through the source array and build the one-to-one map.
        foreach ($sourceArray as $sourceIndex => $sourceValue) {
            $sourceKey = is_object($sourceValue) ? spl_object_hash($sourceValue) : $sourceValue;
            if (isset($targetValueToIndexMap[$sourceKey])) {
                $resultMap[$sourceIndex] = $targetValueToIndexMap[$sourceKey];
            }
        }

        return $resultMap;
    }

    /**
     * Reverses the keys and values of a one-to-many map.
     *
     * @param array $map The map to reverse.
     * @return array The reversed map.
     */
    private static function reverseMap(array $map): array {
        $reversedMap = [];
        foreach ($map as $key => $values) {
            foreach ($values as $value) {
                if (!isset($reversedMap[$value])) {
                    $reversedMap[$value] = [];
                }
                $reversedMap[$value][] = $key;
            }
        }
        return $reversedMap;
    }

}