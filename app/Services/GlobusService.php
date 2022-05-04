<?php

namespace App\Services;

use App\Models\CredentialsOutside;
use WebSocket\Client;

use Illuminate\Http\Request;

class GlobusService
{
    const EXPORT_URL = 'https://globus.elsyton.com/export/ROUTE-EXPORT';

    private $filename = 'layer.kml';

    /**
     * @return array
     * @throws \WebSocket\BadOpcodeException
     */
    public function receive(): array
    {
        if ($data = $this->getAuthData()) {

            $client = new Client("ws://" . config('globus.globus_host') . ":" . config('globus.globus_port'));

            $client->send($data);

            $auth = json_decode($client->receive(), true);

            if ($auth['successful']) {
                $client->send(json_encode(['name' => 'devicesList']));
                $result = json_decode($client->receive(),true);

                if (isset($result['devices'])) {
                    return $result['devices'];
                }
            }
        }

        return [];
    }

    /**
     * @return string
     */
    private function getAuthData()
    {
        $data = CredentialsOutside::query()->where(['type' => 'globus', 'user_id' => \Auth::user()->id])->first();

        if (isset($data) && $data != null) {
            return json_encode([
                'name'     => 'auth',
                'login'    => $data->login,
                'password' => decrypt($data->password),
                'api_key'  => decrypt($data->api_key),
            ]);
        }

        return false;
    }

    /**
     * @param $data
     * @return string
     */
    public function moveGGeoKml($data)
    {
        return $this->generateLayerKml($this->getRoute($data));
    }

    public function getDirections($data)
    {
        return $this->getRoute($data);
    }

    /**
     * @param $data
     * @return string
     */
    private function generateLayerKml($data)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');

        $node    = $dom->createElementNS('http://www.opengis.net/kml/2.2', 'kml');
        $parNode = $dom->appendChild($node);

        $dnode   = $dom->createElement('Document');
        $docNode = $parNode->appendChild($dnode);

        $styleNode = $dom->createElement('Style');
        $styleNode->setAttribute('id', 'lineGreen');

        $styleLine = $dom->createElement('LineStyle');
        $color     = $dom->createElement('color', 'B3007b00');
        $styleLine->appendChild($color);
        $width = $dom->createElement('width', '7');
        $styleLine->appendChild($width);
        $styleNode->appendChild($styleLine);
        $docNode->appendChild($styleNode);

        // Creates a Placemark and append it to the Document.
        $node = $dom->createElement('Placemark');
        $node->setAttribute('id', 'dev');
        $placeNode = $docNode->appendChild($node);

        // Create name, and description elements and assigns them the values of the name and address columns from the results.
        $nameNode = $dom->createElement('name', 'route');
        $placeNode->appendChild($nameNode);
        $styleUrl = $dom->createElement('styleUrl', '#lineGreen');
        $placeNode->appendChild($styleUrl);

        // Creates a Point element.
        $lineStringNode = $dom->createElement('LineString');

        $coorStr = '';
        foreach ($data as $item) {
            // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
            $coorStr .= $item['lng'] . ',' . $item['lat'] . ',0 ';
        }

        $coorNode = $dom->createElement('coordinates', $coorStr);
        $lineStringNode->appendChild($coorNode);
        $placeNode->appendChild($lineStringNode);

        $dir = public_path('upload' . DIRECTORY_SEPARATOR . 'globus');

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dom->saveXML();
    }

    /**
     * @param $data
     * @return string
     */
    public function generateLoadKml($data)
    {
        $this->moveGGeoKml($data);

        $dom = new \DOMDocument('1.0', 'UTF-8');

        $node    = $dom->createElementNS('http://www.opengis.net/kml/2.2', 'kml');
        $parNode = $dom->appendChild($node);

        $fnode      = $dom->createElement('Folder');
        $folderNode = $parNode->appendChild($fnode);

        $nameNode = $dom->createElement('name', 'links');
        $folderNode->appendChild($nameNode);

        $open = $dom->createElement('open', 0);
        $folderNode->appendChild($open);

        $visibility = $dom->createElement('visibility', 0);
        $folderNode->appendChild($visibility);

        $networkLink = $dom->createElement('NetworkLink');
        $netNode     = $parNode->appendChild($networkLink);

        $nameNode = $dom->createElement('name', 'Loads globus.kml');
        $netNode->appendChild($nameNode);

        $openN = $dom->createElement('open', 0);
        $netNode->appendChild($openN);

        $visibilityN = $dom->createElement('visibility', 0);
        $netNode->appendChild($visibilityN);

        $refreshVisibility = $dom->createElement('refreshVisibility', 0);
        $netNode->appendChild($refreshVisibility);

        $flyToView = $dom->createElement('flyToView', 0);
        $netNode->appendChild($flyToView);

        $link = $dom->createElement('Link');

        $href = $dom->createElement('href', url('/upload/globus/' . $this->filename));
        $link->appendChild($href);

        $netNode->appendChild($link);

        return $dom->saveXML();
    }

    /**
     * @param $data
     * @return array
     */
    private function getRoute($data)
    {
        $query = [
            'key'       => $data['key'],
            'from_date' => $data['from_date'],
            'to_date'   => $data['to_date'],
            'ids'       => $data['ids'],
        ];
        $array = [];

        try {
            $url = self::EXPORT_URL . '?' . http_build_query($query);

            $data = $this->csvToArray(file_get_contents($url));

            foreach ($data as $item) {
                $array[] = [
                    floatval($item['latitude']),
                    floatval($item['longitude'])
                ];
            }
        } catch (\Exception $e) {}

        return $array;
    }

    /**
     * @param $csv
     * @param string $delimiter
     * @return array
     */
    private function csvToArray($csv, $delimiter = ';'): array
    {
        $array = array();
        $lines = explode("\n", $csv);

        if (count($lines)) {
            $keys = str_getcsv($lines[0], $delimiter);
            unset($lines[0]);

            $limit = count($keys);

            foreach ($lines as $line) {
                if (!empty($line))
                    $array[] = array_combine($keys, array_slice(str_getcsv($line, ';'), 0, $limit));
            }
        }

        return $array;
    }
}