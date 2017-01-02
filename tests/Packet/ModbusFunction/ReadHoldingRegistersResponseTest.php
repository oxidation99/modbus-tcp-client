<?php

namespace Tests\Packet\ModbusFunction;

use ModbusTcpClient\Packet\IModbusPacket;
use ModbusTcpClient\Packet\ModbusFunction\ReadCoilsResponse;
use ModbusTcpClient\Packet\ModbusFunction\ReadHoldingRegistersResponse;
use ModbusTcpClient\Packet\ModbusFunction\ReadInputDiscretesResponse;
use PHPUnit\Framework\TestCase;

class ReadHoldingRegistersResponseTest extends TestCase
{
    public function testPacketToString()
    {
        $this->assertEquals(
            "\x81\x80\x00\x00\x00\x05\x03\x03\x02\xCD\x6B",
            (new ReadHoldingRegistersResponse("\xCD\x6B", 3, 33152))->__toString()
        );
    }

    public function testPacketProperties()
    {
        $packet = new ReadHoldingRegistersResponse("\xCD\x6B\x0\x0\x0\x01", 3, 33152);
        $this->assertEquals(IModbusPacket::READ_HOLDING_REGISTERS, $packet->getFunctionCode());

        $this->assertEquals("\xCD\x6B\x0\x0\x0\x01", $packet->getRawData());
        $this->assertEquals([0xCD, 0x6B, 0x0, 0x0, 0x0, 0x1], $packet->getData()); //TODO get data as array of words (2 bytes)

        $header = $packet->getHeader();
        $this->assertEquals(33152, $header->getTransactionId());
        $this->assertEquals(0, $header->getProtocolId());
        $this->assertEquals(9, $header->getLength());
        $this->assertEquals(3, $header->getUnitId());
    }

}