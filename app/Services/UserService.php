<?php
/**
 * Created by PhpStorm.
 * User: alaa
 * Date: 14/07/20
 * Time: 03:47 م
 */

namespace App\Services;


class UserService
{
    /**
     * Filter users
     *
     * @param array $parameters
     * @param array $users
     * @return array of users
     *
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function filterUsers($users, $parameters): array
    {
        // Check if no query parameter sent then return all users
        if (empty($parameters))
            return array('users' =>  $users);

        if (isset($parameters['provider']) && $parameters['provider'] == 'DataProviderX')
            return array('users' =>  $users['providerX']);

        if (isset($parameters['provider']) && $parameters['provider'] == 'DataProviderY')
            return array('users' =>  $users['providerY']);

        $provider['providerX'] = array_filter($users['providerX'], function($obj) use($parameters) {

            if (isset($parameters['currency']) && $parameters['currency']) {
                if ($obj['currency'] == $parameters['currency'])
                    return true;
            }

            if (isset($parameters['statusCode']) && $parameters['statusCode']) {
                if($parameters['statusCode'] == 'authorised')
                    $parameters['statusCode'] = 1;

                elseif($parameters['statusCode'] == 'decline')
                    $parameters['statusCode'] = 2;

                if($parameters['statusCode'] == 'refunded')
                    $parameters['statusCode'] = 3;

                if ($obj['statusCode'] == $parameters['statusCode'])
                    return true;
            }

            if ((isset($parameters['balanceMin']) && $parameters['balanceMin']) &&
                (isset($parameters['balanceMax']) && $parameters['balanceMax'])) {
                if ($obj['parentAmount'] >= $parameters['balanceMin'] && $obj['parentAmount'] <= $parameters['balanceMax'])
                    return true;
            }

        });

        $provider['providerY'] = array_filter($users['providerY'], function($obj) use($parameters) {

            if (isset($parameters['currency']) && $parameters['currency']) {
                if ($obj['currency'] == $parameters['currency'])
                    return true;
            }

            if (isset($parameters['statusCode']) && $parameters['statusCode']) {
                if($parameters['statusCode'] == 'authorised')
                    $parameters['statusCode'] = 100;

                elseif($parameters['statusCode'] == 'decline')
                    $parameters['statusCode'] = 200;

                if($parameters['statusCode'] == 'refunded')
                    $parameters['statusCode'] = 300;

                if ($obj['status'] == $parameters['statusCode'])
                    return true;
            }

            if ((isset($parameters['balanceMin']) && $parameters['balanceMin']) &&
                (isset($parameters['balanceMax']) && $parameters['balanceMax'])) {
                if ($obj['balance'] >= $parameters['balanceMin'] && $obj['balance'] <= $parameters['balanceMax'])
                    return true;
            }

        });

        return array('users' => $provider);

    }

}