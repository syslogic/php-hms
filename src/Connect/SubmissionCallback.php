<?php /** @noinspection PhpUnused */

namespace HMS\Connect;

use phpseclib3\Crypt\Common\AsymmetricKey;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA\PublicKey;

/**
 * Class HMS AppGallery Connect Submission Callback
 *
 * TODO: emulate & process post-back.
 * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063
 * @author Martin Zeitler
 */
class SubmissionCallback {

    /**
     * @var AsymmetricKey|null $public_key
     * You need to use the public key obtained in "Obtaining the Public Key for Signature Verification" to verify the signature.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-gettestkey-0000001158245081
     * @see https://phpseclib.com/docs/rsa#creating--verifying-signatures
     */
    private AsymmetricKey|null $public_key;

    /**
     * @var string|null $callBackData JSON string of the app release result, in the format:
     * {"requestId":"xxx", "retCode":xxxxx, "desc":"xxx", "pkgVersion":"xxx", "downloadFileName":"xxx"}".
     */
    private string|null $callBackData;

    /**
     * @var string|null $signatureRSAWithPSS When sending a notification, Huawei server signs parameters in callBackData
     * using the SHA256WithRSA/PSS algorithm and returns the signed character string in the signatureRSAWithPSS parameter.
     */
    private string|null $signatureRSAWithPSS;

    /** @var string|null $requestId Your request ID, which is the same as the value of requestId passed when an app is submitted for release in download mode. */
    private string|null $requestId;

    /** @var string|null $pkgVersion App package version. */
    private string|null $pkgVersion;

    /** @var string|null $fileName App package name. */
    private string|null $fileName;

    /** @var int $retCode Result code. Value 0 indicates success, and other values indicate failure. For details, please refer to Result Codes. */
    private int $retCode;

    /** @var string|null $desc Result code description. */
    private string|null $desc;

    /** Constructor */
    public function __construct() {
        $this->load_rsa_public_key_file();
        if ($this->verify($this->callBackData, $this->signatureRSAWithPSS)) {
            $data = json_decode($this->callBackData);
            $this->requestId  = $data->requestId;
            $this->pkgVersion = $data->pkgVersion;
            $this->fileName   = $data->downloadFileName;
            $this->retCode    = $data->retCode;
            $this->desc       = $data->desc;
        }
    }

    /**
     * @param string $message String for which the signature is to be verified. The JSON string carried in callBackData is passed.
     * @param string $signature Signed string.
     */
    private function verify(string $message, string $signature): bool {
        // base64_decode($this->public_key);
        // String pubKey = "Public key for signature verification";
        // X509EncodedKeySpec x509EncodedKeySpec = newX509EncodedKeySpec(Base64.decodeBase64(pubKey));
        // KeyFactory keyFactory = KeyFactory.getInstance("RSA");
        // PublicKey publicKey = keyFactory.generatePublic(x509EncodedKeySpec);
        // Signature signature = Signature.getInstance("SHA256WithRSA/PSS");
        // signature.initVerify(publicKey);
        // signature.update(content.getBytes(Charset.forName("UTF-8")));
        if ($this->public_key instanceof PublicKey) {
            return $this->public_key->verify($message, $signature);
        } else {
            return false;
        }
    }

    /**
     * @noinspection PhpSameParameterValueInspection
     */
    private function load_rsa_public_key(string $public_key = '', string|false $password=false ) {
        $this->public_key = PublicKeyLoader::load( $public_key, $password );
    }

    /**
     * @noinspection PhpSameParameterValueInspection
     */
    private function load_rsa_public_key_file( string $path = '', string|false $password=false ) {
        if ($path == '') {$path = '/path/to/key.pem';}
        if (file_exists( $path ) && is_readable( $path )) {
            $this->public_key = PublicKeyLoader::load( file_get_contents( $path ), $password );
        }
    }
}
