<?php
/**
 * Created by PhpStorm.
 * User: alaa
 * Date: 14/07/20
 * Time: 03:20 م
 */

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * List users
     *
     * @return array of users
     *
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function listUsers(): array
    {
        $data =  request()->query();

        //Get files path
        $pathX = storage_path() . "/json/DataProviderX.json";
        $pathY = storage_path() . "/json/DataProviderY.json";

        $jsonX['providerX'] = json_decode(file_get_contents($pathX), true)['users'];
        $jsonY['providerY'] = json_decode(file_get_contents($pathY), true)['users'];

        $result = array_merge($jsonX, $jsonY);

        return $this->userService->filterUsers($result, $data);

    }

}