<?php

// # Create Invoice Sample
// This sample code demonstrate how you can create
// an invoice.

require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Invoice;
use PayPal\Api\MerchantInfo;
use PayPal\Api\BillingInfo;
use PayPal\Api\InvoiceItem;
use PayPal\Api\Phone;
use PayPal\Api\Address;
use PayPal\Api\Currency;
use PayPal\Api\PaymentTerm;
use PayPal\Api\ShippingInfo;

$invoice = new Invoice();

// ### Invoice Info
// Fill in all the information that is
// required for invoice APIs
$invoice
    ->setMerchantInfo(new MerchantInfo())
    ->setBillingInfo(array(new BillingInfo()))
    ->setItems(array(new InvoiceItem()))
    ->setNote("Bank account no: 06 0996 0911989 00 \n\n Not registered for GST")
    ->setPaymentTerm(new PaymentTerm())
	->setMerchantMemo("Created with PayPal API");
	//->setNumber(""); TODO set this 'dynamically'

// ### Merchant Info
// A resource representing merchant information that can be
// used to identify merchant
$invoice->getMerchantInfo()
    ->setEmail("mike@mikeybeck.com")
//    ->setFirstName("Dennis")
//    ->setLastName("Doctor")
    ->setbusinessName("Mike Beck")
    ->setPhone(new Phone())
    ->setAddress(new Address());

$invoice->getMerchantInfo()->getPhone()
    ->setCountryCode("64")
    ->setNationalNumber("0275334448");

// ### Address Information
// The address used for creating the invoice
$invoice->getMerchantInfo()->getAddress()
    ->setLine1("66 Hawthorn Ave")
    ->setCity("Dunedin")
    ->setState("Otago")
    ->setPostalCode("9011")
    ->setCountryCode("NZ");

// ### Billing Information
// Set the email address for each billing
$billing = $invoice->getBillingInfo();
$billing[0]
    ->setEmail("m.ikeybec.k@gmail.com")  //TODO set these based on user input
	->setFirstName("")
	->setLastName("")
	->setBusinessName("")
	->setAddress("");

// ### Items List
// You could provide the list of all items for
// detailed breakdown of invoice
// Note: max 100 items per invoice
$items = $invoice->getItems();  //TODO set these ($items[]) based on user input
$items[0]
    ->setName("Sutures")
    ->setQuantity(100)
    ->setUnitPrice(new Currency())
	->setDate("2014-12-16 NZST");

$items[0]->getUnitPrice()
    ->setCurrency("NZD")
    ->setValue(5);

$invoice->getPaymentTerm()
    ->setTermType("NET_15");

// ### Shipping Information
/*
$invoice->getShippingInfo()
    ->setFirstName("Sally")
    ->setLastName("Patient")
    ->setBusinessName("Not applicable")
    ->setPhone(new Phone())
    ->setAddress(new Address());

$invoice->getShippingInfo()->getPhone()
    ->setCountryCode("001")
    ->setNationalNumber("5039871234");

$invoice->getShippingInfo()->getAddress()
    ->setLine1("1234 Main St.")
    ->setCity("Portland")
    ->setState("OR")
    ->setPostalCode("97217")
    ->setCountryCode("US");
*/
// For Sample Purposes Only.
$request = clone $invoice;

try {
    // ### Create Invoice
    // Create an invoice by calling the invoice->create() method
    // with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
    $invoice->create($apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Create Invoice", "Invoice", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create Invoice", "Invoice", $invoice->getId(), $request, $invoice);

return $invoice;
