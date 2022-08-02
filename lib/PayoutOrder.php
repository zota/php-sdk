<?php

namespace Zotapay;

/**
 * Class PayoutOrder.
 */
class PayoutOrder extends AbstractOrder
{
    /**
     * customerBankAccountNumber
     * @var string
     */
    protected $customerBankAccountNumber;

    /**
     * customerBankAccountName
     * @var string
     */
    protected $customerBankAccountName;

    /**
     * customerBankBranch
     * @var string
     */
    protected $customerBankBranch;

    /**
     * customerBankAddress
     * @var string
     */
    protected $customerBankAddress;

    /**
     * customerBankZipCode
     * @var string
     */
    protected $customerBankZipCode;

    /**
     * customerBankRoutingNumber
     * @var string
     */
    protected $customerBankRoutingNumber;

    /**
     * customerBankProvince
     * @var string
     */
    protected $customerBankProvince;

    /**
     * customerBankArea
     * @var string
     */
    protected $customerBankArea;

    /**
     * customerCountryCode
     * @var string
     */
    protected $customerCountryCode;

    /**
     * customerPersonalID
     * @var string
     */
    protected $customerPersonalID;

    /**
     * customerBankAccountNumberDigit
     * @var string
     */
    protected $customerBankAccountNumberDigit;

    /**
     * customerBankAccountType
     * @var string
     */
    protected $customerBankAccountType;

    /**
     * customerBankSwiftCode
     * @var string
     */
    protected $customerBankSwiftCode;

    /**
     * customerBankBranchDigit
     * @var string
     */
    protected $customerBankBranchDigit;

    /**
     * redirectUrl
     * @var string
     */
    protected $redirectUrl;

    /**
     * Get the value of customerBankAccountNumber
     *
     * @return string
     */
    public function getCustomerBankAccountNumber()
    {
        return $this->customerBankAccountNumber;
    }


    /**
     * Set the value of customerBankAccountNumber
     *
     * @param string $customerBankAccountNumber
     *
     * @return self
     */
    public function setCustomerBankAccountNumber($customerBankAccountNumber)
    {
        $this->customerBankAccountNumber = $customerBankAccountNumber;

        return $this;
    }


    /**
     * Get the value of customerBankAccountName
     *
     * @return string
     */
    public function getCustomerBankAccountName()
    {
        return $this->customerBankAccountName;
    }


    /**
     * Set the value of customerBankAccountName
     *
     * @param string $customerBankAccountName
     *
     * @return self
     */
    public function setCustomerBankAccountName($customerBankAccountName)
    {
        $this->customerBankAccountName = $customerBankAccountName;

        return $this;
    }


    /**
     * Get the value of customerBankBranch
     *
     * @return string
     */
    public function getCustomerBankBranch()
    {
        return $this->customerBankBranch;
    }


    /**
     * Set the value of customerBankBranch
     *
     * @param string $customerBankBranch
     *
     * @return self
     */
    public function setCustomerBankBranch($customerBankBranch)
    {
        $this->customerBankBranch = $customerBankBranch;

        return $this;
    }


    /**
     * Get the value of customerBankAddress
     *
     * @return string
     */
    public function getCustomerBankAddress()
    {
        return $this->customerBankAddress;
    }


    /**
     * Set the value of customerBankAddress
     *
     * @param string $customerBankAddress
     *
     * @return self
     */
    public function setCustomerBankAddress($customerBankAddress)
    {
        $this->customerBankAddress = $customerBankAddress;

        return $this;
    }


    /**
     * Get the value of customerBankZipCode
     *
     * @return string
     */
    public function getCustomerBankZipCode()
    {
        return $this->customerBankZipCode;
    }


    /**
     * Set the value of customerBankZipCode
     *
     * @param string $customerBankZipCode
     *
     * @return self
     */
    public function setCustomerBankZipCode($customerBankZipCode)
    {
        $this->customerBankZipCode = $customerBankZipCode;

        return $this;
    }


    /**
     * Get the value of customerBankRoutingNumber
     *
     * @return string
     */
    public function getCustomerBankRoutingNumber()
    {
        return $this->customerBankRoutingNumber;
    }


    /**
     * Set the value of customerBankRoutingNumber
     *
     * @param string $customerBankRoutingNumber
     *
     * @return self
     */
    public function setCustomerBankRoutingNumber($customerBankRoutingNumber)
    {
        $this->customerBankRoutingNumber = $customerBankRoutingNumber;

        return $this;
    }


    /**
     * Get the value of customerBankProvince
     *
     * @return string
     */
    public function getCustomerBankProvince()
    {
        return $this->customerBankProvince;
    }


    /**
     * Set the value of customerBankProvince
     *
     * @param string $customerBankProvince
     *
     * @return self
     */
    public function setCustomerBankProvince($customerBankProvince)
    {
        $this->customerBankProvince = $customerBankProvince;

        return $this;
    }


    /**
     * Get the value of customerBankArea
     *
     * @return string
     */
    public function getCustomerBankArea()
    {
        return $this->customerBankArea;
    }


    /**
     * Set the value of customerBankArea
     *
     * @param string $customerBankArea
     *
     * @return self
     */
    public function setCustomerBankArea($customerBankArea)
    {
        $this->customerBankArea = $customerBankArea;

        return $this;
    }

    /**
     * Get the value of customerCountryCode
     *
     * @return string
     */
    public function getCustomerCountryCode()
    {
        return $this->customerCountryCode;
    }


    /**
     * Set the value of customerCountryCode
     *
     * @param string $customerCountryCode
     *
     * @return self
     */
    public function setCustomerCountryCode($customerCountryCode)
    {
        $this->customerCountryCode = $customerCountryCode;

        return $this;
    }

    /**
     * Get the value of customerPersonalID
     *
     * @return string
     */
    public function getCustomerPersonalID()
    {
        return $this->customerPersonalID;
    }


    /**
     * Set the value of customerPersonalID
     *
     * @param string $customerPersonalID
     *
     * @return self
     */
    public function setCustomerPersonalID($customerPersonalID)
    {
        $this->customerPersonalID = $customerPersonalID;

        return $this;
    }

    /**
     * Get the value of customerBankAccountNumberDigit
     *
     * @return string
     */
    public function getCustomerBankAccountNumberDigit()
    {
        return $this->customerBankAccountNumberDigit;
    }


    /**
     * Set the value of customerBankAccountNumberDigit
     *
     * @param string $customerBankAccountNumberDigit
     *
     * @return self
     */
    public function setCustomerBankAccountNumberDigit($customerBankAccountNumberDigit)
    {
        $this->customerBankAccountNumberDigit = $customerBankAccountNumberDigit;

        return $this;
    }

    /**
     * Get the value of customerBankAccountType
     *
     * @return string
     */
    public function getCustomerBankAccountType()
    {
        return $this->customerBankAccountType;
    }


    /**
     * Set the value of customerBankAccountType
     *
     * @param string $customerBankAccountType
     *
     * @return self
     */
    public function setCustomerBankAccountType($customerBankAccountType)
    {
        $this->customerBankAccountType = $customerBankAccountType;

        return $this;
    }

    /**
     * Get the value of customerBankSwiftCode
     *
     * @return string
     */
    public function getCustomerBankSwiftCode()
    {
        return $this->customerBankSwiftCode;
    }


    /**
     * Set the value of customerBankSwiftCode
     *
     * @param string $customerBankSwiftCode
     *
     * @return self
     */
    public function setCustomerBankSwiftCode($customerBankSwiftCode)
    {
        $this->customerBankSwiftCode = $customerBankSwiftCode;

        return $this;
    }

    /**
     * Get the value of customerBankBranchDigit
     *
     * @return string
     */
    public function getCustomerBankBranchDigit()
    {
        return $this->customerBankBranchDigit;
    }


    /**
     * Set the value of customerBankBranchDigit
     *
     * @param string $customerBankBranchDigit
     *
     * @return self
     */
    public function setCustomerBankBranchDigit($customerBankBranchDigit)
    {
        $this->customerBankBranchDigit = $customerBankBranchDigit;

        return $this;
    }

    /**
     * Get the value of redirectUrl
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Set the value of redirectUrl
     *
     * @param string $redirectUrl
     *
     * @return self
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }
}
