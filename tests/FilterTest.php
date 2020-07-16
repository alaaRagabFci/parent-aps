<?php
/**
 * Created by PhpStorm.
 * User: alaa
 * Date: 15/07/20
 * Time: 02:02 م
 */

class FilterTest extends TestCase
{
    /**
     * Test list all users without any filter.
     *
     * @return void
     */
    public function testListAllUsers()
    {
        $response = $this->get('api/v1/users');
        $response->assertResponseStatus(200);
    }

    /**
     * Test list all users with provider x filter.
     *
     * @return void
     */
    public function testListAllUsersWithProviderXFilter()
    {
        $this->get('api/v1/users?provider=DataProviderX');
        $this->seeStatusCode(200);
        $this->seeJson([
            'statusCode' => 1
        ]);
    }

    /**
     * Test list all users with provider y filter.
     *
     * @return void
     */
    public function testListAllUsersWithProviderYFilter()
    {
        $this->get('api/v1/users?provider=DataProviderY');
        $this->seeJson([
            'status' => 100
        ]);
    }

    /**
     * Test list all users with currency.
     *
     * @return void
     */
    public function testListAllUsersWithCurrencyFilter()
    {
        $this->get('api/v1/users?currency=EUR');
        $this->seeJson([
            'currency' => 'EUR'
        ]);
    }

    /**
     * Test list all users with balance.
     *
     * @return void
     */
    public function testListAllUsersWithBalanceFilter()
    {
        $this->get('api/v1/users?balanceMin=100&balanceMax=300');
        $this->dontSeeJson([
            'balance' => 50
        ]);
    }

}