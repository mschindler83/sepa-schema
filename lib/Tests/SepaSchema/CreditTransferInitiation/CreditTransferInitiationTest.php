<?php

namespace Tests\CreditTransferInitiation;

use SepaSchema\CreditTransferInitiation\CreditTransferInitiation;
use SepaSchema\CreditTransferInitiation\PaymentInformation;

class CreditTransferInitiationTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture;

    public function setUp()
    {
        $this->fixture = file_get_contents(__DIR__ . '/../Fixtures/cti.xml');
        $this->fixture = str_replace(array("\n", "  "), '', $this->fixture);
    }

    public function testCreateSepa()
    {
        $c = new CreditTransferInitiation();
        $c->setMessageIdentification('Message-ID-4711');
        $c->setCreationDateTime(new \DateTime('2010-11-11T09:30:47'));
        $c->setInitiatingPartyName('Initiator Name');

        $paymentInformation = new PaymentInformation();
        $paymentInformation->setPaymentInformationIdentification('Payment-Information-ID-4711');
        $paymentInformation->setBatchBooking(true);
        $paymentInformation->setRequestedExecutionDate(new \DateTime('2010-11-25'));
        $paymentInformation->setDebtorName('Debtor Name');
        $paymentInformation->setDebtorIban('DE87200500001234567890');
        $paymentInformation->setDebtorBic('BANKDEFFXXX');
        $paymentInformation->setEndToEndIdentification('OriginatorID1235');
        $paymentInformation->setInstructedCurrency('EUR');
        $paymentInformation->setInstructedAmount(112.72);
        $paymentInformation->setCreditorBic('SPUEDE2UXXX');
        $paymentInformation->setCreditorName('Other Creditor Name');
        $paymentInformation->setCreditorIban('DE21500500001234567897');
        $paymentInformation->setRemittanceInfoUnstruct('Unstructured Remittance Information');

        $c->addPaymentInformation($paymentInformation);

        $result = $c->createXml();

        $result = str_replace(array("\n", "  "), '', $result);
        $this->assertSame($this->fixture, $result);
    }
}
