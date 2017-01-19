<?php

namespace SepaSchema\CreditTransferInitiation;

class PaymentInformation
{
    /**
     * Referenz zur eindeutigen Identifizierung des Sammlers.
     *
     * @var string
     */
    protected $paymentInformationIdentification;

    /**
     * Zahlungsinstrument, z. B. Überweisung.
     * PaymentMethodSCTCode
     * Enthält die Konstante TRF
     *
     * @var string
     */
    protected $paymentMethod;

    /**
     * Indikator, der aussagt, ob es sich um eine
     * Sammelbuchung (true) oder eine Einzelbuchung handelt (false).
     *
     * Nur wenn eine entsprechende Vereinbarung für Einzelbuchungen mit dem Kunden
     * vorliegt, wird im Falle von Belegung mit false, jede Transaktion einzeln auf dem
     * Kontoauszug des Zahlers (Auftraggebers) dargestellt. Andernfalls immer Sammelbuchung
     * (Default/pre-agreed: true).
     *
     * @var bool
     */
    protected $batchBooking;

    /**
     * Art der Zahlung in kodierter Form.
     *
     * Nur die Codes der externen ISO 20022-Codeliste sind zulässig.
     * Hinweise dazu in Kapitel 2.3. http://www.ebics.de/index.php?eID=tx_securedownloads&u=0&g=0&t=1484816391&hash=a9f0a54717f0c3eae724e568a8a16e69da4bafbe&file=/fileadmin/unsecured/anlage3/anlage3_spec/Anlage_3_Datenformate_V3.0.pdf
     * Hinweis: Diese Codes werden nicht im Kontoauszug dargestellt.
     *
     * @var string
     */
    protected $paymentTypeInformationCode;

    /**
     * Ausführungstermin.
     *
     * Vom Kunden gewünschter Ausführungstermin. Fällt der angegebene Termin auf keinen
     * TARGETGeschäftstag, so ist die Bank berechtigt, den folgenden
     * TARGETGeschäftstag als Ausführungstag anzugeben. Geht der Datensatz erst nach der
     * von der Bank angegebenen Cut-Off-Zeit ein, so gilt der Auftrag erst am folgenden
     * Geschäftstag als zugegangen. Banken sind nicht verpflichtet, Auftragsdaten zu
     * verarbeiten, die mehr als 15 Kalendertage VOR dem Ausführungsdatum eingeliefert wurden.
     *
     * Belegen mit 1999-01-01 für sofort
     * @var \DateTime
     */
    protected $requestedExecutionDate;

    /**
     * Name des Auftraggebers.
     * Name ist auf 70 Zeichen begrenzt.
     *
     * @var string
     */
    protected $debtorName;

    /**
     * IBAN des Auftraggebers.
     *
     * @var string
     */
    protected $debtorIban;

    /**
     * BIC des Auftraggebers.
     *
     * @var string
     */
    protected $debtorBic;

    /**
     * Es wird empfohlen, jede Überweisung mit einer eindeutigen Referenz zu belegen.
     * Ist keine Referenz vorhanden muss die Konstante NOTPROVIDED benutzt werden.
     * @var string
     */
    protected $endToEndIdentification;

    /**
     * Währung des Auftrags im ISO4217 format.
     *
     * @var string ISO4217
     */
    protected $instructedCurrency;

    /**
     * Ist mit einem Geldbetrag zu belegen, das Dezimaltrennzeichen ist ein Punkt.
     *
     * @var float
     */
    protected $instructedAmount;

    /**
     * Diese Angabe ist weiterhin erforderlich bei Zahlungen außerhalb EU/EWR.
     * Der BIC kann 8 oder 11 Stellen lang sein.
     *
     * @var string
     */
    protected $creditorBic;

    /**
     * Name des Zahlungsempfänger.
     * Name ist begrenzt auf 70 Zeichen.
     *
     * @var string
     */
    protected $creditorName;

    /**
     * Ist mit einer gültigen IBAN (International Bank Account Number) zu belegen.
     * Diese kann maximal 34 Stellen lang sein.
     *
     * @var string
     */
    protected $creditorIban;

    /**
     * Es wird empfohlen, den unstrukturierten Verwendungszweck zu verwenden.
     * In bilateraler Abstimmung zwischen Zahlungsempfänger und Zahler (Auftraggeber)
     * kann der unstrukturierte Verwendungszweck strukturierte Informationen enthalten.
     * Max 140 Zeichen.
     *
     * @var string
     */
    protected $remittanceInfoUnstruct;

    /**
     * Get paymentInformationIdentification
     *
     * @return string
     */
    public function getPaymentInformationIdentification()
    {
        return $this->paymentInformationIdentification;
    }

    /**
     * Set paymentInformationIdentification
     *
     * @param string $paymentInformationIdentification
     *
     * @return $this
     */
    public function setPaymentInformationIdentification($paymentInformationIdentification)
    {
        $this->paymentInformationIdentification = $paymentInformationIdentification;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get batchBooking
     *
     * @return bool
     */
    public function isBatchBooking()
    {
        return $this->batchBooking;
    }

    /**
     * Set batchBooking
     *
     * @param bool $batchBooking
     *
     * @return $this
     */
    public function setBatchBooking($batchBooking)
    {
        $this->batchBooking = $batchBooking;

        return $this;
    }

    /**
     * Get paymentTypeInformationCode
     *
     * @return string
     */
    public function getPaymentTypeInformationCode()
    {
        return $this->paymentTypeInformationCode;
    }

    /**
     * Set paymentTypeInformationCode
     *
     * @param string $paymentTypeInformationCode
     *
     * @return $this
     */
    public function setPaymentTypeInformationCode($paymentTypeInformationCode)
    {
        $this->paymentTypeInformationCode = $paymentTypeInformationCode;

        return $this;
    }

    /**
     * Get requestedExecutionDate
     *
     * @return \DateTime
     */
    public function getRequestedExecutionDate()
    {
        return $this->requestedExecutionDate;
    }

    /**
     * Set requestedExecutionDate
     *
     * @param \DateTime $requestedExecutionDate
     *
     * @return $this
     */
    public function setRequestedExecutionDate($requestedExecutionDate)
    {
        $this->requestedExecutionDate = $requestedExecutionDate;

        return $this;
    }

    /**
     * Get debtorName
     *
     * @return string
     */
    public function getDebtorName()
    {
        return $this->debtorName;
    }

    /**
     * Set debtorName
     *
     * @param string $debtorName
     *
     * @return $this
     */
    public function setDebtorName($debtorName)
    {
        $this->debtorName = $debtorName;

        return $this;
    }

    /**
     * Get debtorIban
     *
     * @return string
     */
    public function getDebtorIban()
    {
        return $this->debtorIban;
    }

    /**
     * Set debtorIban
     *
     * @param string $debtorIban
     *
     * @return $this
     */
    public function setDebtorIban($debtorIban)
    {
        $this->debtorIban = $debtorIban;

        return $this;
    }

    /**
     * Get debtorBic
     *
     * @return string
     */
    public function getDebtorBic()
    {
        return $this->debtorBic;
    }

    /**
     * Set debtorBic
     *
     * @param string $debtorBic
     *
     * @return $this
     */
    public function setDebtorBic($debtorBic)
    {
        $this->debtorBic = $debtorBic;

        return $this;
    }

    /**
     * Get endToEndIdentification
     *
     * @return string
     */
    public function getEndToEndIdentification()
    {
        return $this->endToEndIdentification;
    }

    /**
     * Set endToEndIdentification
     *
     * @param string $endToEndIdentification
     *
     * @return $this
     */
    public function setEndToEndIdentification($endToEndIdentification)
    {
        $this->endToEndIdentification = $endToEndIdentification;

        return $this;
    }

    /**
     * Get instructedCurrency
     *
     * @return string
     */
    public function getInstructedCurrency()
    {
        return $this->instructedCurrency;
    }

    /**
     * Set instructedCurrency
     *
     * @param string $instructedCurrency
     *
     * @return $this
     */
    public function setInstructedCurrency($instructedCurrency)
    {
        $this->instructedCurrency = $instructedCurrency;

        return $this;
    }

    /**
     * Get instructedAmount
     *
     * @return float
     */
    public function getInstructedAmount()
    {
        return $this->instructedAmount;
    }

    /**
     * Set instructedAmount
     *
     * @param float $instructedAmount
     *
     * @return $this
     */
    public function setInstructedAmount($instructedAmount)
    {
        $this->instructedAmount = $instructedAmount;

        return $this;
    }

    /**
     * Get creditorBic
     *
     * @return string
     */
    public function getCreditorBic()
    {
        return $this->creditorBic;
    }

    /**
     * Set creditorBic
     *
     * @param string $creditorBic
     *
     * @return $this
     */
    public function setCreditorBic($creditorBic)
    {
        $this->creditorBic = $creditorBic;

        return $this;
    }

    /**
     * Get creditorName
     *
     * @return string
     */
    public function getCreditorName()
    {
        return $this->creditorName;
    }

    /**
     * Set creditorName
     *
     * @param string $creditorName
     *
     * @return $this
     */
    public function setCreditorName($creditorName)
    {
        $this->creditorName = $creditorName;

        return $this;
    }

    /**
     * Get creditorIban
     *
     * @return string
     */
    public function getCreditorIban()
    {
        return $this->creditorIban;
    }

    /**
     * Set creditorIban
     *
     * @param string $creditorIban
     *
     * @return $this
     */
    public function setCreditorIban($creditorIban)
    {
        $this->creditorIban = $creditorIban;

        return $this;
    }

    /**
     * Get remittanceInfoUnstruct
     *
     * @return string
     */
    public function getRemittanceInfoUnstruct()
    {
        return $this->remittanceInfoUnstruct;
    }

    /**
     * Set remittanceInfoUnstruct
     *
     * @param string $remittanceInfoUnstruct
     *
     * @return $this
     */
    public function setRemittanceInfoUnstruct($remittanceInfoUnstruct)
    {
        $this->remittanceInfoUnstruct = $remittanceInfoUnstruct;

        return $this;
    }
}
