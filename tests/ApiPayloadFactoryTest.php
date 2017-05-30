<?php

use JumiaMarket\ApiPayloadFactory\ApiPayloadFactory;

class ApiPayloadFactoryTest extends AbstractTestCase
{
    /** @test */
    public function it_should_instantiate_the_factory()
    {
        $this->assertInstanceOf(ApiPayloadFactory::class, new ApiPayloadFactory());
    }
}