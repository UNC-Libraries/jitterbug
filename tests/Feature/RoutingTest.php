<?php

class RoutingTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testHomepageRedirectResponse()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(302, $response->getStatusCode());
	}

	public function testTransfersIndexResponse()
  {
    $user = factory(Jitterbug\Models\User::class)->create();
    $this->be($user);
    $response = $this->call('GET', '/transfers');

    $this->assertEquals(200, $response->getStatusCode());
  }

}
