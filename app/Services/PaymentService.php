<?php

namespace App\Services;

use App\Helpers\GeneralFunctions;
use App\Models\Demand;
use App\Models\DemandDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentService
{
    public function makePayemnt($payment)
    {
        // dd($payment);
        $xml = '<BharatKoshPayment DepartmentCode="030" Version="1.0"><Submit>';
        $xml .= '<OrderBatch TotalAmount="' . $payment['amount'] . '" Transactions="1" merchantBatchCode="' . $payment['merchant_batch_code'] . '">';
        $xml .= '<Order InstallationId="11136" OrderCode="' . $payment['merchant_batch_code'] . '">';
        $xml .= '<CartDetails><Description/><Amount CurrencyCode="INR" exponent="0" value="' . $payment['amount'] . '"/>';
        $xml .= '<OrderContent>' . $payment['order_content'] . '</OrderContent><PaymentTypeId>0</PaymentTypeId><PAOCode>043884</PAOCode><DDOCode>243896</DDOCode></CartDetails>';
        $xml .= '<PaymentMethodMask><Include Code="Offline"/></PaymentMethodMask><Shopper><ShopperEmailAddress>' . $payment['email'] . '</ShopperEmailAddress></Shopper>';
        $xml .= '<ShippingAddress><Address><FirstName>' . $payment['first_name'] . '</FirstName><LastName>' . $payment['last_name'] . '</LastName><Address1>' . $payment['address_1'] . '</Address1>' . $payment['address_2'] . '<Address2/><PostalCode>' . $payment['postal_code'] . '</PostalCode><City>' . $payment['city'] . '</City><StateRegion>' . $payment['region'] . '</StateRegion><State>' . $payment['state'] . '</State><CountryCode>' . $payment['country'] . '</CountryCode><MobileNumber>' . $payment['mobile'] . '</MobileNumber></Address></ShippingAddress>';
        $xml .= '<BillingAddress><Address><FirstName>' . $payment['first_name'] . '</FirstName><LastName>' . $payment['last_name'] . '</LastName><Address1>' . $payment['address_1'] . '</Address1>' . $payment['address_2'] . '<Address2/><PostalCode>' . $payment['postal_code'] . '</PostalCode><City>' . $payment['city'] . '</City><StateRegion>' . $payment['region'] . '</StateRegion><State>' . $payment['state'] . '</State><CountryCode>' . $payment['country'] . '</CountryCode><MobileNumber>' . $payment['mobile'] . '</MobileNumber></Address></BillingAddress>';
        $xml .= '<StatementNarrative/><Remarks/></Order></OrderBatch></Submit></BharatKoshPayment>';
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = true;
        $dom->loadXML($xml);
        $simpleFilePath = Storage::disk('public')->path('NTRP/xmls/simple' . date("Ymdhis") . '.xml');
        $signedFilePath = Storage::disk('public')->path('NTRP/xmls/signed' . date("Ymdhis") . '.xml');
        // Save the file
        $dom->save($simpleFilePath);

        // signing xml
        $cert_store = file_get_contents(Storage::disk('public')->path('NTRP/TestCertForLOBA_Exp_2026.pfx'));
        $status = openssl_pkcs12_read($cert_store, $cert_info, '123456');
        $private_key = $cert_info['pkey'];
        $X509certificate = $cert_info['cert'];
        //Read the private key
        $pkeyid = openssl_pkey_get_private($private_key);
        $details = openssl_pkey_get_details($pkeyid);
        $X509 = openssl_x509_parse($X509certificate);
        $publicCertificatePureString = str_replace('-----BEGIN CERTIFICATE-----', '', $X509certificate);
        $publicCertificatePureString = str_replace('-----END CERTIFICATE-----', '', $publicCertificatePureString);
        $publicCertificatePureString = preg_replace("/\r|\n/", "", $publicCertificatePureString);

        $X509Issuer = $X509['issuer']['CN'];
        $X509IssuerName = 'CN=' . $X509Issuer;
        $X509issuerserial = $X509['serialNumber'];

        $XMLRequestDOMDoc = new \DOMDocument();
        $XMLRequestDOMDoc->preserveWhiteSpace = true;
        $XMLRequestDOMDoc->load($simpleFilePath);

        $canonical = $XMLRequestDOMDoc->C14N();
        $DigestValue = base64_encode(hash('sha1', $canonical, true));

        $rootElem = $XMLRequestDOMDoc->documentElement;

        $SignatureNode = $rootElem->appendChild(new \DOMElement('Signature'));
        $SignatureNode->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');

        $SignedInfoNode = $SignatureNode->appendChild(new \DOMElement('SignedInfo'));

        $CanonicalizationMethodNode = $SignedInfoNode->appendChild(new \DOMElement('CanonicalizationMethod'));
        $CanonicalizationMethodNode->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');

        $SignatureMethodNode = $SignedInfoNode->appendChild(new \DOMElement('SignatureMethod'));
        $SignatureMethodNode->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');

        $ReferenceNode = $SignedInfoNode->appendChild(new \DOMElement('Reference'));
        $ReferenceNode->setAttribute('URI', '');

        $TransformsNode = $ReferenceNode->appendChild(new \DOMElement('Transforms'));

        $Transform1Node = $TransformsNode->appendChild(new \DOMElement('Transform'));
        $Transform1Node->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');

        $DigestMethodNode = $ReferenceNode->appendChild(new \DOMElement('DigestMethod'));
        $DigestMethodNode->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');

        $ReferenceNode->appendChild(new \DOMElement('DigestValue', $DigestValue));

        $SignedInfoNode = $XMLRequestDOMDoc->getElementsByTagName('SignedInfo')->item(0);

        if (!openssl_sign($SignedInfoNode->C14N(), $signature, $pkeyid, OPENSSL_ALGO_SHA1)) {
            throw new \Exception('Unable to sign the request');
        }

        $SignatureNode = $XMLRequestDOMDoc->getElementsByTagName('Signature')->item(0);
        $SignatureValueNode = new \DOMElement('SignatureValue', base64_encode($signature));
        $SignatureNode->appendChild($SignatureValueNode);

        $KeyInfoNode = $SignatureNode->appendChild(new \DOMElement('KeyInfo'));

        $X509DataNode = $KeyInfoNode->appendChild(new \DOMElement('X509Data'));
        $X509IssuerSerialNode = $X509DataNode->appendChild(new \DOMElement('X509IssuerSerial'));

        $X509IssuerNameNode = new \DOMElement('X509IssuerName', $X509IssuerName);
        $X509IssuerSerialNode->appendChild($X509IssuerNameNode);

        $X509SerialNumberNode = new \DOMElement('X509SerialNumber', $X509issuerserial);
        $X509IssuerSerialNode->appendChild($X509SerialNumberNode);

        $X509CertificateNode = new \DOMElement('X509Certificate', $publicCertificatePureString);
        $X509DataNode->appendChild($X509CertificateNode);

        // Save the signed xml file
        file_put_contents($signedFilePath, $XMLRequestDOMDoc->saveXML());
        $data = file_get_contents(($signedFilePath));
        $base64 = base64_encode($data);

        /** update payemnt data - add base64 in row */
        $payment = Payment::where('unique_payment_id', $payment['order_code'])->first();
        if (!empty($payment)) {
            $payment->update([
                'request' => $base64
            ]);
        }
        // dd($base64);
        $url = config('constants.paymentURL');
        echo '<form id="postForm" action="' . $url . '" method="POST"><input type="hidden" name="bharrkkosh"value= "' . $base64 . '">
            <h2>Redirecting to payment gateway</h2>
        </form>';
        // Automatically submit the form using JavaScript
        echo '<script type="text/javascript">
        setTimeout(function(){
            document.getElementById("postForm").submit();
        }, 2000);
      </script>';


        /* ---------------------------------------------------------------------------------- callback after failed or success */
        /*$response = $request->BharatkoshResponse;
        $response_decode = base64_decode($response);
        $xmlDoc = new \DOMDocument();
        $xmlDoc->preserveWhiteSpace = true;
        $xmlDoc->loadXML($response_decode);
        $xpath = new \DOMXPath($xmlDoc);
        $xpath->registerNamespace('secdsig', 'http://www.w3.org/2000/09/xmldsig#');
        $query = ".//secdsig:Signature";
        $nodeset = $xpath->query($query, $xmlDoc);

        $query = "./secdsig:SignedInfo";
        $signatureNode = $nodeset->item(0);
        $nodeset = $xpath->query($query, $signatureNode);
        $signedInfoNode = $nodeset->item(0);
        // <element ref="ds:CanonicalizationMethod"/> using this line find c14N
        $signedInfoNodeCanonicalized = $signedInfoNode->C14N();
        $pub_key = openssl_pkey_get_public(file_get_contents(Storage::disk('local')->path('loba.pem')));
        $publicKey = openssl_pkey_get_details($pub_key);
        $query = 'string(./secdsig:SignatureValue)';
        $signature = base64_decode($xpath->evaluate($query, $signatureNode));
        $ok = openssl_verify($signedInfoNodeCanonicalized, $signature, $publicKey['key']);
        if ($ok == 1) {
            $xml = simplexml_load_string($response_decode);
        } else {
            return "Verify not worked";
        } */

        /* ---------------------------------------------- Status Check ------------------------------ */

        $orderId = '';
        $purpose = '';

        // $url = "https://bharatkosh.gov.in/getstatus";
        $url = "http://164.100.129.32/bharatkosh/getstatus";
        $data = array("OrderId" => $orderId, "PurposeId" => $purpose);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $curl_output = curl_exec($ch);
            $response_api = explode('|', $curl_output);
            curl_close($ch);
            if (count($response_api) > 1) {
            } else {
                return $response_api;
            }
        }
    }

    public function processSuccessfulPayment($paymentRecord)
    {
        $payemntType = getServiceCodeById($paymentRecord->type);
        if ($payemntType == "PAY_DEMAND") {
            if (is_null($paymentRecord->demand_id)) {
                return;
            }

            // Start a database transaction for consistency
            DB::transaction(function () use ($paymentRecord) {
                $demand = Demand::find($paymentRecord->demand_id);

                if ($demand) {
                    $this->updateDemand($demand, $paymentRecord->amount);

                    // Process payment details for subheads
                    foreach ($paymentRecord->paymentDetails as $paydetail) {
                        $demandSubhead = DemandDetail::find($paydetail->subhead_id);
                        if ($demandSubhead) {
                            $this->updateDemandSubhead($demandSubhead, $paydetail->paid_amount);
                        }
                    }
                }
            });
        }
        if ($payemntType == "PAY_APP_CHG") {
            $submitted = GeneralFunctions::convertTempAppToFinal($paymentRecord->model_id, $paymentRecord->model, $paymentRecord);
        }
    }

    private function updateDemand($demand, $paymentAmount)
    {
        $updatedStatus = $paymentAmount == $demand->balance_amount
            ? getServiceType('DEM_PAID')
            : getServiceType('DEM_PART_PAID');

        $demand->update([
            'paid_amount' => ($demand->paid_amount ?? 0) + $paymentAmount,
            'balance_amount' => $demand->balance_amount - $paymentAmount,
            'status' => $updatedStatus,
        ]);
    }

    private function updateDemandSubhead($demandSubhead, $paidAmount)
    {

        $demandSubhead->update([
            'paid_amount' => ($demandSubhead->paid_amount ?? 0) + $paidAmount,
            'balance_amount' => $demandSubhead->balance_amount - $paidAmount,
        ]);
    }
}