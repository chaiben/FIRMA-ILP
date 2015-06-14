<?php

class GeneralTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application('development', APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testHash(){
        $result = Ilp_Tool_General::CreateHash("abc", 10);
        $hash = $result[0];
        $this->assertSame("3ad7fb9c49722a62553f02c620bfd4991f163254", $hash);
        $this->assertSame(true, Ilp_Tool_General::ValidateHash($hash, "abc", 10));
        $this->assertSame(false, Ilp_Tool_General::ValidateHash($hash, "abc", 9));
        $this->assertSame(false, Ilp_Tool_General::ValidateHash($hash, "ab", 10));
    }

    public function testGetILPFromXades(){
        $xades = '<?xml version="1.0" encoding="UTF-8"?>
        <ilp><firmante><nomb>Marçal</nomb><ape1>Machado</ape1><ape2>Chaiben</ape2><fnac>20000101</fnac><tipoid>DNI</tipoid><id>x5958142s</id></firmante><datosilp><tituloilp>Lorem ipsum</tituloilp><codigoilp>ILP2015001</codigoilp></datosilp><ds:Signature Id="Signature-12711086-93aa-486e-9791-14f3225c1d1a-Signature" xmlns:ds="http://www.w3.org/2000/09/xmldsig#"><ds:SignedInfo><ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha512"/><ds:Reference Id="Reference-d788c203-5e53-4839-a144-4b81f9abd1a6" URI=""><ds:Transforms><ds:Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/><ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116"><ds:XPath xmlns:ds="http://www.w3.org/2000/09/xmldsig#">not(ancestor-or-self::ds:Signature)</ds:XPath></ds:Transform></ds:Transforms><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><ds:DigestValue>T+y5+9LyISEnOQ1UxVfzHE6gnzc=</ds:DigestValue></ds:Reference><ds:Reference Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature-12711086-93aa-486e-9791-14f3225c1d1a-SignedProperties"><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><ds:DigestValue>HMEsYw5eV5yLbCd3FBDXAV4ZBZo=</ds:DigestValue></ds:Reference><ds:Reference URI="#Signature-12711086-93aa-486e-9791-14f3225c1d1a-KeyInfo"><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><ds:DigestValue>+8c/sE/ne5w3hJmp9DZ1bjDuy5g=</ds:DigestValue></ds:Reference></ds:SignedInfo><ds:SignatureValue Id="Signature-12711086-93aa-486e-9791-14f3225c1d1a-SignatureValue">Yc0biUekiB34ijjxVglD9p6xV5PdoD3wnOb61RBjPfUaIcZeOMNWw2hJI2L3X3Fi/Tb7Nh4dqUve
            OVcIabqXgR1/hybC54tgrY70UmL91HtgrJt+F7sFXw3ePs7LCYzUYKexLpc8zOuhMmQaqs8nIzOM
            4j0KHY6+W2mHzNraUAA7z6ww4MnM0XxSXBWE46cVUugqabj8Aj0SzDsjjcYbRSDcv/OPp2QsfDRX
            etm6WDsMvA2hX2RmERt5BvwH2aumCdUAdJ0iYoJ6ACCzvgceJl/1uVWIB35YMvToLlUM8uoFhHcQ
            gfDfL9bHnv5leT6Hhcqv+l7W6u3Lxb+CCeAqaw==</ds:SignatureValue><ds:KeyInfo Id="Signature-12711086-93aa-486e-9791-14f3225c1d1a-KeyInfo"><ds:KeyValue><ds:RSAKeyValue><ds:Modulus>0BglkiMiA92z4aoQp4kd74npEPedwMv20TxlJHg0O3ub7JBT86c01d56fI2a8u9jqnOiMrYM50VI
            4DF0Y0uzsuSNkw0mSPDewwet2rorWlylsvaKlQEXghimuOURbkeA1PgUExX9zykeEfp+xdeCvfHN
            c/wtORIOzJnvxOge8ycNp9+EuKFVLV14XjpMm8/eblJmhbXfgeDFedyrAx9LCNBtBm03xrtEnupr
            1BT3Ba2+YgP+qwtMoijkf2HkWBLd2yUBMioEt7782ilu/0++Bd51b1PjSumOhO5p8wELOK6A9jxz
            K+smiU4xgoKTwbM/EHrrsCG9jADGNosx3qf05w==</ds:Modulus><ds:Exponent>AQAB</ds:Exponent></ds:RSAKeyValue></ds:KeyValue><ds:X509Data><ds:X509Certificate>MIIGojCCBYqgAwIBAgIQT+i5p525mtZVI4NC5Bp6ejANBgkqhkiG9w0BAQsFADBLMQswCQYDVQQG
            EwJFUzERMA8GA1UECgwIRk5NVC1SQ00xDjAMBgNVBAsMBUNlcmVzMRkwFwYDVQQDDBBBQyBGTk1U
            IFVzdWFyaW9zMB4XDTE1MDQwNzA3MTIwMVoXDTE5MDQwNzA3MTIwMVowezELMAkGA1UEBhMCRVMx
            EjAQBgNVBAUTCVg1OTU4MTQyUzEYMBYGA1UEBAwPTUFDSEFETyBDSEFJQkVOMRAwDgYDVQQqDAdN
            QVLDh0FMMSwwKgYDVQQDDCNNQUNIQURPIENIQUlCRU4gTUFSw4dBTCAtIFg1OTU4MTQyUzCCASIw
            DQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANAYJZIjIgPds+GqEKeJHe+J6RD3ncDL9tE8ZSR4
            NDt7m+yQU/OnNNXeenyNmvLvY6pzojK2DOdFSOAxdGNLs7LkjZMNJkjw3sMHrdq6K1pcpbL2ipUB
            F4IYprjlEW5HgNT4FBMV/c8pHhH6fsXXgr3xzXP8LTkSDsyZ78ToHvMnDaffhLihVS1deF46TJvP
            3m5SZoW134HgxXncqwMfSwjQbQZtN8a7RJ7qa9QU9wWtvmID/qsLTKIo5H9h5FgS3dslATIqBLe+
            /Nopbv9PvgXedW9T40rpjoTuafMBCziugPY8cyvrJolOMYKCk8GzPxB667AhvYwAxjaLMd6n9OcC
            AwEAAaOCA1AwggNMMIGEBgNVHREEfTB7gRNjaGFpYmVuNzlAZ21haWwuY29tpGQwYjEYMBYGCSsG
            AQQBrGYBBAwJWDU5NTgxNDJTMRYwFAYJKwYBBAGsZgEDDAdDSEFJQkVOMRYwFAYJKwYBBAGsZgEC
            DAdNQUNIQURPMRYwFAYJKwYBBAGsZgEBDAdNQVLDh0FMMAwGA1UdEwEB/wQCMAAwDgYDVR0PAQH/
            BAQDAgXgMCMGA1UdJQQcMBoGCCsGAQUFBwMEBggrBgEFBQcDAgYEVR0lADAdBgNVHQ4EFgQU+0PH
            6fR4NcvbFOJHmG292NvGfacwHwYDVR0jBBgwFoAUsdRPxCN5+kQFCcbrOc/oNbC4IGQwgYIGCCsG
            AQUFBwEBBHYwdDA9BggrBgEFBQcwAYYxaHR0cDovL29jc3B1c3UuY2VydC5mbm10LmVzL29jc3B1
            c3UvT2NzcFJlc3BvbmRlcjAzBggrBgEFBQcwAoYnaHR0cDovL3d3dy5jZXJ0LmZubXQuZXMvY2Vy
            dHMvQUNVU1UuY3J0MIHdBgNVHSAEgdUwgdIwgc8GCisGAQQBrGYDCgEwgcAwKQYIKwYBBQUHAgEW
            HWh0dHA6Ly93d3cuY2VydC5mbm10LmVzL2RwY3MvMIGSBggrBgEFBQcCAjCBhQyBgkNlcnRpZmlj
            YWRvIHJlY29ub2NpZG8uIFN1amV0byBhIGxhcyBjb25kaWNpb25lcyBkZSB1c28gZXhwdWVzdGFz
            IGVuIGxhIERQQyBkZSBsYSBGTk1ULVJDTSAoQy9Kb3JnZSBKdWFuIDEwNi0yODAwOS1NYWRyaWQt
            RXNwYcOxYSkwJQYIKwYBBQUHAQMEGTAXMAgGBgQAjkYBATALBgYEAI5GAQMCAQ8wgbMGA1UdHwSB
            qzCBqDCBpaCBoqCBn4aBnGxkYXA6Ly9sZGFwdXN1LmNlcnQuZm5tdC5lcy9jbj1DUkw0OSxjbj1B
            QyUyMEZOTVQlMjBVc3VhcmlvcyxvdT1DRVJFUyxvPUZOTVQtUkNNLGM9RVM/Y2VydGlmaWNhdGVS
            ZXZvY2F0aW9uTGlzdDtiaW5hcnk/YmFzZT9vYmplY3RjbGFzcz1jUkxEaXN0cmlidXRpb25Qb2lu
            dDANBgkqhkiG9w0BAQsFAAOCAQEAeztC0n/iFx5n8//bO47O/oI2XE9m1jm1yWoO5Ddzb5ZRDGME
            lamPl1bwicyU04wILnfqaQ2GqyYnh4T2rQQ7EWuBZS7VE1LsCxAD3Br6AbXLqquScVV0ZBSEyM7P
            SKHfmmwkq3gv7dtzuSjbAUy1h8cQQ7TKBrHnSCzKrhdOWLAa2xkdPhZV7gkxqeQZ7bXh61iOUzc7
            oXeG3crfIbX5AQAcFAHL2pMP0quQ+QIDhDyMxAzsyWpWSdwvKSt6IWaXnEL0dy1Zcnf3W0TmSUye
            FlopQZCdKptqoXQfmd71ZAKaPUTK9UH5/zZK5klxzwpZzF8EDswtvTVSDZ7PXSAJCw==</ds:X509Certificate></ds:X509Data></ds:KeyInfo><ds:Object><xades:QualifyingProperties Id="Signature-12711086-93aa-486e-9791-14f3225c1d1a-QualifyingProperties" Target="#Signature-12711086-93aa-486e-9791-14f3225c1d1a-Signature" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"><xades:SignedProperties Id="Signature-12711086-93aa-486e-9791-14f3225c1d1a-SignedProperties"><xades:SignedSignatureProperties><xades:SigningTime>2015-06-12T22:16:19+02:00</xades:SigningTime><xades:SigningCertificate><xades:Cert><xades:CertDigest><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><ds:DigestValue>hR18dYMyUSZfkoDqETscuF7fmQg=</ds:DigestValue></xades:CertDigest><xades:IssuerSerial><ds:X509IssuerName>CN=AC FNMT Usuarios, OU=Ceres, O=FNMT-RCM, C=ES</ds:X509IssuerName><ds:X509SerialNumber>106217390063881778427149008600898894458</ds:X509SerialNumber></xades:IssuerSerial></xades:Cert></xades:SigningCertificate></xades:SignedSignatureProperties><xades:SignedDataObjectProperties><xades:DataObjectFormat ObjectReference="#Reference-d788c203-5e53-4839-a144-4b81f9abd1a6"><xades:Description/><xades:ObjectIdentifier><xades:Identifier Qualifier="OIDAsURN">urn:oid:1.2.840.10003.5.109.10</xades:Identifier><xades:Description/></xades:ObjectIdentifier><xades:MimeType>text/xml</xades:MimeType><xades:Encoding>UTF-8</xades:Encoding></xades:DataObjectFormat></xades:SignedDataObjectProperties></xades:SignedProperties></xades:QualifyingProperties></ds:Object></ds:Signature></ilp>';
            $xml = Ilp_Tool_General::getILPFromXades($xades);
            $this->assertXmlStringEqualsXmlString('<?xml version="1.0" encoding="UTF-8"?> <ilp><firmante><nomb>Marçal</nomb><ape1>Machado</ape1><ape2>Chaiben</ape2><fnac>20000101</fnac><tipoid>DNI</tipoid><id>x5958142s</id></firmante><datosilp><tituloilp>Lorem ipsum</tituloilp><codigoilp>ILP2015001</codigoilp></datosilp></ilp>', $xml);
        }
    }