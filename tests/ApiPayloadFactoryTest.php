<?php

use JumiaMarket\ApiPayloadFactory\ApiPayloadFactory;
use JumiaMarket\ApiPayloadFactory\Definition;

/**
 * @backupStaticAttributes disabled
 */
class ApiPayloadFactoryTest extends AbstractTestCase
{
    /** @test */
    public function it_should_instantiate_the_factory()
    {
        $this->assertInstanceOf(ApiPayloadFactory::class, new ApiPayloadFactory());
    }

    /** @test */
    public function it_should_create_a_definition()
    {
        $definition = $this->getApiPayloadFactory()->define('post/create', 1.1);
        $this->assertInstanceOf(Definition::class, $definition);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_should_not_be_possible_to_define_a_definition_with_a_non_valid_enpoint_format()
    {
        $this->getApiPayloadFactory()->define(false, 1.1);
    }

    /**
     * @test
     * @expectedException \JumiaMarket\ApiPayloadFactory\Exception\DefinitionDuplicatedException
     */
    public function it_should_not_be_possible_to_define_a_definition_twice()
    {
        $factory = $this->getApiPayloadFactory();
        $factory->define('post/create', 1.2);
        $factory->define('post/create', 1.2);
    }

    /** @test */
    public function it_should_define_two_definitions()
    {
        $factory = $this->getApiPayloadFactory();
        $postCreateDefinition = $factory->define('post/create', 1.3);
        $postUpdateDefinition = $factory->define('post/update', 1.3);

        $this->assertInstanceOf(Definition::class, $postCreateDefinition);
        $this->assertInstanceOf(Definition::class, $postUpdateDefinition);
        $this->assertNotEquals($postCreateDefinition, $postUpdateDefinition);
    }

    /** @test */
    public function it_should_define_same_endpoint_with_two_different_versions()
    {
        $factory = $this->getApiPayloadFactory();
        $postCreateDefinition1 = $factory->define('post/create', 1.4);
        $postCreateDefinition2 = $factory->define('post/update', 1.5);

        $this->assertInstanceOf(Definition::class, $postCreateDefinition1);
        $this->assertInstanceOf(Definition::class, $postCreateDefinition2);
        $this->assertNotEquals($postCreateDefinition1, $postCreateDefinition2);
    }

    /** @test */
    public function it_should_create_a_new_payload()
    {
        $version = 1.1;
        $factory = $this->getApiPayloadFactory();
        $factory->define('post/create', $version);
        $payload = $factory->create('post/create', $version);

        $this->assertInstanceOf(Definition::class, $payload);
        $this->assertEquals($version, $payload->getVersion());
    }

    /**
     * @test
     * @expectedException \JumiaMarket\ApiPayloadFactory\Exception\DefinitionNotFoundException
     */
    public function it_should_not_be_possible_to_create_a_payload_not_defined()
    {
        $this->getApiPayloadFactory()->create('post/create');
    }

    /**
     * @test
     * @expectedException \JumiaMarket\ApiPayloadFactory\Exception\DefinitionNotFoundException
     */
    public function it_should_not_be_possible_to_create_a_payload_for_a_version_not_defined()
    {
        $factory = $this->getApiPayloadFactory();
        $factory->define('post/create', 1.1);
        $factory->create('post/create', 1.2);
    }

    /** @test */
    public function it_should_load_factories_from_a_path()
    {
        $factory = $this->getApiPayloadFactory();
        $factory->loadFactories(__DIR__ . '/factories');
        $this->assertSame(1, $factory->count());
    }

    /**
     * @test
     * @expectedException \JumiaMarket\ApiPayloadFactory\Exception\DirectoryNotFoundException
     */
    public function it_should_not_be_possible_to_load_factories_if_path_is_not_valid()
    {
        $this->getApiPayloadFactory()->loadFactories('/invalid_factories_path');
    }

    protected function getApiPayloadFactory()
    {
        return new ApiPayloadFactory();
    }
}