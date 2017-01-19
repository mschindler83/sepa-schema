<?php

namespace SepaSchema\CreditTransferInitiation;

/**
 * Class CreditTransferInitiation.
 * Creates a pain.001.001.03 XML
 * @package SepaSchema
 */
class CreditTransferInitiation
{
    /**
     * @var PaymentInformation[]
     */
    protected $paymentInformations;

    /**
     * Die <MsgID> in Kombination mit der Kunden-ID oder der Auftraggeber-IBAN kann als Kriterium für
     * die Verhinderung einer Doppelverarbeitung bei versehentlich doppelt eingereichten Dateien
     * dienen und muss somit für jede neue painNachricht einen neuen Wert enthalten.
     *
     * @var string
     */
    protected $messageIdentification;

    /**
     * Datum und Zeit, wann die ZVNachricht durch die anweisende Partei erzeugt wurde.
     *
     * @var \DateTime
     */
    protected $creationDateTime;

    /**
     * Name des Auftraggebers.
     * Begrenzt auf 70 Zeichen.
     *
     * @var string
     */
    protected $initiatingPartyName;

    /**
     * Get messageIdentification
     *
     * @return string
     */
    public function getMessageIdentification()
    {
        return $this->messageIdentification;
    }

    /**
     * Set messageIdentification
     *
     * @param string $messageIdentification
     *
     * @return $this
     */
    public function setMessageIdentification($messageIdentification)
    {
        $this->messageIdentification = $messageIdentification;

        return $this;
    }

    /**
     * Get creationDateTime
     *
     * @return \DateTime
     */
    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    /**
     * Set creationDateTime
     *
     * @param \DateTime $creationDateTime
     *
     * @return $this
     */
    public function setCreationDateTime($creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    /**
     * Anzahl der einzelnen Transaktionen innerhalb der gesamten Nachricht.
     *
     * @return int
     */
    public function getNumberOfTransactions()
    {
        return count($this->paymentInformations);
    }

    /**
     * Summe der Beträge aller Einzeltransaktionen in der gesamten Nachricht.
     * Es sind maximal zwei Nachkommastellen zulässig.
     *
     * @return float
     */
    public function getControlSum()
    {
        $sum = 0;

        foreach ($this->paymentInformations as $pm) {
            $sum += $pm->getInstructedAmount();
        }

        return (float) number_format($sum, 2, '.', '');
    }

    /**
     * Get initiatingPartyName
     *
     * @return string
     */
    public function getInitiatingPartyName()
    {
        return $this->initiatingPartyName;
    }

    /**
     * Set initiatingPartyName
     *
     * @param string $initiatingPartyName
     *
     * @return $this
     */
    public function setInitiatingPartyName($initiatingPartyName)
    {
        $this->initiatingPartyName = $initiatingPartyName;

        return $this;
    }

    public function addPaymentInformation(PaymentInformation $paymentInformation)
    {
        $this->paymentInformations[] = $paymentInformation;
    }

    public function createXml()
    {
        $xml = new \SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?>
             <Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.03"
                       xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                       xsi:schemaLocation="urn:iso:std:iso:20022:tech:xsd:pain.001.001.03pain.001.001.03.xsd">                       
             </Document>'
        );

        $cstmrCdtTrfInitn = $xml->addChild('CstmrCdtTrfInitn');
        $grpHdr = $cstmrCdtTrfInitn->addChild('GrpHdr');

        // GrpHdr
        $grpHdr->addChild('MsgId', $this->getMessageIdentification());
        $grpHdr->addChild('CreDtTm', $this->getCreationDateTime()->format('Y-m-d\TH:i:s.000\Z'));
        $grpHdr->addChild('NbOfTxs', $this->getNumberOfTransactions());

        $initgPty = $grpHdr->addChild('InitgPty');
        $initgPty->addChild('Nm', $this->getInitiatingPartyName());

        foreach ($this->paymentInformations as $pm) {
            $pmtInf = $cstmrCdtTrfInitn->addChild('PmtInf');
            $pmtInf->addChild('PmtInfId', $pm->getPaymentInformationIdentification());
            $pmtInf->addChild('PmtMtd', 'TRF');
            $pmtInf->addChild('BtchBookg', $pm->isBatchBooking() ? 'true': 'false');
            $pmtInf->addChild('NbOfTxs', $this->getNumberOfTransactions());
            $pmtInf->addChild('CtrlSum', $this->getControlSum());

            $pmtTpInf = $pmtInf->addChild('PmtTpInf');
            $svcLvl = $pmtTpInf->addChild('SvcLvl');
            $svcLvl->addChild('Cd', 'SEPA');

            $pmtInf->addChild('ReqdExctnDt', $pm->getRequestedExecutionDate()->format('Y-m-d'));

            $dbtr = $pmtInf->addChild('Dbtr');
            $dbtr->addChild('Nm', $pm->getDebtorName());

            $dbtrAcct = $pmtInf->addChild('DbtrAcct');
            $dbtrAcctId = $dbtrAcct->addChild('Id');
            $dbtrAcctId->addChild('IBAN', $pm->getDebtorIban());

            $dbtrAgt = $pmtInf->addChild('DbtrAgt');
            $finInstnId = $dbtrAgt->addChild('FinInstnId');
            $finInstnId->addChild('BIC', $pm->getDebtorBic());

            $pmtInf->addChild('ChrgBr', 'SLEV');

            $cdtTrfTxInf = $pmtInf->addChild('CdtTrfTxInf');
            $pmtId = $cdtTrfTxInf->addChild('PmtId');
            $pmtId->addChild('EndToEndId', $pm->getEndToEndIdentification());

            $amt = $cdtTrfTxInf->addChild('Amt');
            $instdAmt = $amt->addChild('InstdAmt', $pm->getInstructedAmount());
            $instdAmt->addAttribute('Ccy', $pm->getInstructedCurrency());

            $cdtrAgt = $cdtTrfTxInf->addChild('CdtrAgt');
            $finInstnId2 = $cdtrAgt->addChild('FinInstnId');
            $finInstnId2->addChild('BIC', $pm->getCreditorBic());

            $cdtr = $cdtTrfTxInf->addChild('Cdtr');
            $cdtr->addChild('Nm', $pm->getCreditorName());

            $cdtrAcct = $cdtTrfTxInf->addChild('CdtrAcct');
            $cdtrAcctId = $cdtrAcct->addChild('Id');
            $cdtrAcctId->addChild('IBAN', $pm->getCreditorIban());

            $rmtInf = $cdtTrfTxInf->addChild('RmtInf');
            $rmtInf->addChild('Ustrd', $pm->getRemittanceInfoUnstruct());
        }

        return $xml->saveXML();
    }
}
