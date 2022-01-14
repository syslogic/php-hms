<?php /** @noinspection PhpUnused */

namespace HMS\Connect;

/**
 * Class HMS AppGallery Connect Submission Callback
 *
 * TODO: emulate & process post-back.
 * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063
 * @author Martin Zeitler
 */
class SubmissionCallback {

    /**
     * @var string|null $callBackData JSON string of the app release result, in the format:
     * {"requestId":"xxx","retCode":xxxxx,"desc":"xxx","pkgVersion":"xxx","downloadFileName":"xxx"}".
     *
     * @param string $requestId        your request ID, which is the same as the value of requestId passed when an app is submitted for release in download mode.
     * @param int    $retCode          result code. The value 0 indicates success, and other values indicate failure. For details, please refer to Result Codes.
     * @param string $desc             result code description.
     * @param string $pkgVersion       app package version.
     * @param string $downloadFileName app package name.
     */
    private string|null $callBackData;

    /**
     * @var string|null $signatureRSAWithPSS When sending a notification, Huawei server signs parameters in callBackData
     * using the SHA256WithRSA/PSS algorithm and returns the signed character string in the signatureRSAWithPSS parameter.
     */
    private string|null $signatureRSAWithPSS;

    /**
     * @var string|null $public_key
     * You need to use the public key obtained in Obtaining the Public Key for Signature Verification to verify the signature.
     * @see https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-gettestkey-0000001158245081
     */
    private string|null $public_key;

    public function __construct() {}

    /**
     * TODO: port Java implementation to PHP.
     * @param string $payload String for which the signature is to be verified. The JSON string carried in callBackData is passed.
     * @param string $signature Signed string.
     */
    private function verify(string $payload, string $signature): bool {
        // String pubKey = "Public key for signature verification";
        // X509EncodedKeySpec x509EncodedKeySpec = newX509EncodedKeySpec(Base64.decodeBase64(pubKey));
        // KeyFactory keyFactory = KeyFactory.getInstance("RSA");
        // PublicKey publicKey = keyFactory.generatePublic(x509EncodedKeySpec);
        // Signature signature = Signature.getInstance("SHA256WithRSA/PSS");
        // signature.initVerify(publicKey);
        // signature.update(content . getBytes(Charset . forName("UTF-8")));
        return false;
    }
}
