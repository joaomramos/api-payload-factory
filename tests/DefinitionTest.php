<?php

use \JumiaMarket\ApiPayloadFactory\Definition;

class DefinitionTest extends AbstractTestCase
{
    /** @test */
    public function it_should_return_api_endpoint_and_api_version()
    {
        $endPoint = '/INVOICE_ACCRUAL/COMMISSION_FEES';
        $version = '1.0';

        $definition = new Definition($endPoint, $version);

        $this->assertEquals($endPoint, $definition->getEndPoint());
        $this->assertEquals($version, $definition->getVersion());
    }

    /** @test */
    public function it_should_match_definition_with_payload()
    {
        $type = 'INVOICE_ACCRUAL';
        $code = 'COMMISSION_FEES';
        $sellerId = '123';
        $createdBy = 'statemachine';
        $extraInfo = [
            'order_number' => 123
        ];

        $definition = new Definition('/INVOICE_ACCRUAL/COMMISSION_FEES', '1.0');
        $definition->setDefinition(
            [
                'type' => $type,
                'code' => $code,
                'seller_id' => $sellerId,
                'created_by' => $createdBy,
                'extra_info' => $extraInfo
            ]
        );

        $payload = $definition->getPayload();

        $this->assertInstanceOf('StdClass', $payload);
        $this->assertEquals($type, $payload->type);
        $this->assertEquals($code, $payload->code);
        $this->assertEquals($sellerId, $payload->seller_id);
        $this->assertEquals($createdBy, $payload->created_by);
        $this->assertEquals((object) $extraInfo, (object) $payload->extra_info);
    }

    /** @test */
    public function it_should_be_possible_to_set_and_get_single_definition_values()
    {
        $definition = new Definition('/INVOICE_ACCRUAL/COMMISSION_FEES', '1.0');
        $definition->setType('INVOICE_ACCRUAL')->setSellerId(123);

        $this->assertEquals('INVOICE_ACCRUAL', $definition->getType());
        $this->assertEquals(123, $definition->getSellerId());
    }
}
