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
        $definition = ApiPayloadFactory::define('post/create', 1.1);
        $this->assertInstanceOf(Definition::class, $definition);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_should_not_be_possible_to_define_a_definition_with_a_non_valid_enpoint_format()
    {
        $definition = ApiPayloadFactory::define(false, 1.1);
    }

    /**
     * @test
     * @expectedException \JumiaMarket\ApiPayloadFactory\Exception\DefinitionDuplicatedException
     */
    public function it_should_not_be_possible_to_define_a_definition_twice()
    {
        $definition = ApiPayloadFactory::define('post/create', 1.2);
        $definition = ApiPayloadFactory::define('post/create', 1.2);
    }

    /** @test */
    public function it_should_define_two_definitions()
    {
        $postCreateDefinition = ApiPayloadFactory::define('post/create', 1.3);
        $postUpdateDefinition = ApiPayloadFactory::define('post/update', 1.3);

        $this->assertInstanceOf(Definition::class, $postCreateDefinition);
        $this->assertInstanceOf(Definition::class, $postUpdateDefinition);
        $this->assertNotEquals($postCreateDefinition, $postUpdateDefinition);
    }

    /** @test */
    public function it_should_define_same_endpoint_with_two_different_versions()
    {
        $postCreateDefinition1 = ApiPayloadFactory::define('post/create', 1.4);
        $postCreateDefinition2 = ApiPayloadFactory::define('post/update', 1.5);

        $this->assertInstanceOf(Definition::class, $postCreateDefinition1);
        $this->assertInstanceOf(Definition::class, $postCreateDefinition2);
        $this->assertNotEquals($postCreateDefinition1, $postCreateDefinition2);
    }
}