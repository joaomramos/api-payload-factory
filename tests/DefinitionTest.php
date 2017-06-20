<?php

use \JumiaMarket\ApiPayloadFactory\Definition;

class DefinitionTest extends AbstractTestCase
{
    /** @test */
    public function it_should_return_api_endpoint_and_api_version()
    {
        $endPoint = 'post/create';
        $version = 1.0;

        $definition = new Definition($endPoint, $version);

        $this->assertEquals($endPoint, $definition->getEndPoint());
        $this->assertEquals($version, $definition->getVersion());
    }

    /** @test */
    public function it_should_match_definition_with_payload()
    {
        $field1 = 'Field 1';
        $field2 = 'Field 2';
        $field3 = ['field31', 'field32'];

        $definition = new Definition('post/create', 1.0);
        $definition->setDefinition(
            [
                'field1' => $field1,
                'field2' => $field2,
                'field3' => $field3,
            ]
        );

        $payload = $definition->getPayload();

        $this->assertInstanceOf('StdClass', $payload);
        $this->assertEquals($field1, $payload->field1);
        $this->assertEquals($field2, $payload->field2);
        $this->assertEquals((object) $field3, (object) $payload->field3);
    }

    /** @test */
    public function it_should_be_possible_to_set_and_get_single_definition_values()
    {
        $field1 = 'Field 1';
        $field2 = 123;

        $definition = new Definition('post/create', 1.0);
        $definition->setField1($field1)->setField2($field2);

        $this->assertEquals($field1, $definition->getField1());
        $this->assertEquals($field2, $definition->getField2());
    }
}
