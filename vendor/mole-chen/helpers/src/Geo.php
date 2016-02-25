<?php
namespace mole\helpers;

/**
 * GEO convert.
 * 
 * @author Jin Chen <jmole.chen@gmail.com>
 * @since 1.0
 */
class Geo
{
    /**
     * Convert circle to polygon.
     * 
     * @param float $lon
     * @param float $lat
     * @param float $radius 
     * @param int $sides
     * @return array
     */
    public static function circle2polygon($lon, $lat, $radius, $sides)
    {
        $points = [];
        $earthRadius = 6371;
        
        //angular distance covered on earth's surface
        $d = $radius / 1000 / $earthRadius;
        $lon = $lon * M_PI / 180;
        $lat = $lat * M_PI / 180;

        for($i = 0; $i < $sides; ++$i) {
            $gpos = [];
            $bearing = $i * M_PI * 2 / $sides;
            $gpos['latitude'] = asin(sin($lat) * cos($d) + cos($lat) * sin($d) * cos($bearing));
            $gpos['longitude'] = (($lon + atan2(sin($bearing) * sin($d) * cos($lat), cos($d) - sin($lat) * sin($gpos['latitude']))) * 180) / M_PI;
            $gpos['latitude'] = ($gpos['latitude'] * 180) / M_PI;
            $points[] = [$gpos['longitude'], $gpos['latitude']];
        }
        $points[] = $points[0];
        
        return $points;
    }
    
    /**
     * Calculate the square point.
     * At a point as the center point, calculate the square of the four points.
     * 
     * Result:
     * ~~~
     * [
     *     'left-top' => '<float>',
     *     'right-top' => '<float>',
     *     'right-bottom' => '<float>',
     *     'left-bottom' => '<float>',
     * ]
     * ~~~
     * 
     * @param float $lng
     * @param float $lat
     * @param float $distance KM
     * @return array
     */
    public static function squarePoint($lng, $lat, $distance = 1)
    {
        $earthRadius = 6371;
        $dlng = 2 * asin(sin($distance / (2 * $earthRadius)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
    
        $dlat = $distance / $earthRadius;
        $dlat = rad2deg($dlat);
    
        return [
            [$lng - $dlng, $lat + $dlat],
            [$lng + $dlng, $lat + $dlat],
            [$lng + $dlng, $lat - $dlat],
            [$lng - $dlng, $lat - $dlat],
        ];
    }
}