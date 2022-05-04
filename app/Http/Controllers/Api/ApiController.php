<?php

namespace App\Http\Controllers\Api;

use App\Services\DataArraySerializer;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Manager;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Inn-Logist API",
 *         description="Api for Inn-Logist API",
 *         @OA\License(name="MIT"),
 *         @OA\Contact(
 *             email="filonuse@gmail.com"
 *         )
 *     ),
 *     @OA\Server(
 *         description="OpenApi host",
 *         url="http://innlogist.com/api/v2"
 *     ),
 *     @OA\PathItem(
 *          path="/api/v1.0"
 *     ),
 *     @OA\Tag(
 *          name="Auth",
 *          description="Login, logout - get & refresh tokens",
 *     )
 * )
 */

 class ApiController extends Controller
{
    use ApiResponse;

    /**
     * @var Manager
     */
    protected $fractal;

    /**
     * ApiController constructor.
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->setFractal($fractal);
        $this->fractal->setSerializer(new DataArraySerializer);
    }
}
