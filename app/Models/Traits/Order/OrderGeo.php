<?php

namespace App\Models\Traits\Order;

use App\Services\GoogleService;

trait OrderGeo
{
    /**
     * Rebuild route after deviation exceeded by creator (logist limit)
     *
     * @param array $latestGeo
     */
    public function rebuildDirectionAfterDeviation(array $latestGeo):bool
    {

        if (!$this->hasDirectionsHistory()) {
            $this->directions_history = json_encode($this->directions);
        }

        $result = $this->buildNewRoute($latestGeo);
        if ($result) {
            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Check, order already has directions history
     *
     * @return bool
     */
    private function hasDirectionsHistory():bool
    {
        return $this->directions_history !== null &&
            $this->directions_history !== 'null';
    }

    /**
     * build route with new latest geo point and old waypoints (addresses)
     *
     * @param $latestGeo
     * @return bool
     */
    private function buildNewRoute($latestGeo):bool
    {
        if ($latestGeo === null) {
            return false;
        }

        $waypoints = $this->getWaypoints();
        if (count($waypoints) < 2) {
            return false;
        }

        $origin = array_shift($waypoints);
        $originLocation = $origin[0] . ',' . $origin[1];
        $destination = array_pop($waypoints);
        $destinationLocation = $destination[0] . ',' . $destination[1];

        // Limit of waypoints for one query (google maps)
        if (count($waypoints) >= 25) {
            $waypoints = array_slice ($waypoints, 0, 24);
        }

        $waypoints[] = [
            $latestGeo['lat'], $latestGeo['lng']
        ];

        $service = new GoogleService(\App::getLocale());
        $data = $service->rebuildRoute($originLocation, $destinationLocation, $waypoints);
        
        if ($data !== false) {
            $this->directions = $data['directions'];

            array_unshift($data['waypoints'], $origin);
            $data['waypoints'][] = $destination;

            $this->direction_waypoints = json_encode($data['waypoints']);

            return true;
        }

        return false;
    }

    /**
     * Get waypoints from directions (if exists) or addresses
     *
     * @return array|mixed
     */
    private function getWaypoints()
    {
        if ($this->direction_waypoints !== null) {
            return json_decode($this->direction_waypoints);
        }

        $from = $this->addresses()
            ->wherePivot('type', 'loading')
            ->get()
            ->map
            ->only(['lat', 'lng'])
            ->toArray();

        $to = $this->addresses()
            ->wherePivot('type', 'unloading')
            ->get()
            ->map
            ->only(['lat', 'lng'])
            ->toArray();

        $waypoints = [];

        foreach ($from as $point) {
            $waypoints[] = [
                $point['lat'], $point['lng']
            ];
        }

        foreach ($to as $point) {
            $waypoints[] = [
                $point['lat'], $point['lng']
            ];
        }

        return $waypoints;
    }
}
