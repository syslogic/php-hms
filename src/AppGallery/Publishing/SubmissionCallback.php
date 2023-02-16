<?php /** @noinspection PhpUnused */
namespace HMS\AppGallery\Publishing;

use InvalidArgumentException;
use phpseclib3\Crypt\Common\AsymmetricKey;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA\PublicKey;
use phpseclib3\Exception\NoKeyLoadedException;

/**
 * Class HMS AppGallery Connect Submission Callback
 *
 * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-notify-release-0000001158245063
 * @author Martin Zeitler
 */
class SubmissionCallback {

    /**
     * @var AsymmetricKey|null $public_key
     * You need to use the public key obtained in "Obtaining the Public Key for Signature Verification" to verify the signature.
     * @link https://developer.huawei.com/consumer/en/doc/development/AppGallery-connect-References/agcapi-gettestkey-0000001158245081
     * @link https://phpseclib.com/docs/rsa#creating--verifying-signatures
     */
    private AsymmetricKey|null $public_key;

    /**
     * @var string|null $rawData JSON string of the app release result, in the format:
     * {"requestId":"xxx", "retCode":xxxxx, "desc":"xxx", "pkgVersion":"xxx", "downloadFileName":"xxx"}".
     */
    private string|null $rawData = null;

    /**
     * @var string|null $signature When sending a notification, Huawei server signs parameters in callBackData using
     * the SHA256WithRSA/PSS algorithm and returns the signed character string in the signatureRSAWithPSS parameter.
     */
    private string|null $signature = null;

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
    public function __construct( string|null $key_file = null ) {
        if ($key_file != null) {
            $this->process_post_request();
            $this->load_rsa_public_key_file( $key_file );
            if ($this->verify($this->rawData, $this->signature)) {
                $data = json_decode($this->rawData);
                $this->requestId  = $data->requestId;
                $this->pkgVersion = $data->pkgVersion;
                $this->fileName   = $data->downloadFileName;
                $this->retCode    = $data->retCode;
                $this->desc       = $data->desc;
            }
        } else {
            throw new NoKeyLoadedException();
        }
    }

    /** Process the fields of the posted HTTPS request. */
    private function process_post_request(): void {
        if (isset($_REQUEST['callBackData']) && !empty($_REQUEST['callBackData'])) {
            $this->rawData = $_REQUEST['callBackData'];
        }
        if (isset($_REQUEST['signatureRSAWithPSS']) && !empty($_REQUEST['signatureRSAWithPSS'])) {
            $this->signature = $_REQUEST['signatureRSAWithPSS'];
        }
    }

    /**
     * Load an RSA Public Key from PEM key file.
     * @noinspection PhpSameParameterValueInspection
     */
    private function load_rsa_public_key_file( string $path = '', string|false $password=false ): void {
        if ($path == '') {$path = '/path/to/key.pem';}
        if ( file_exists( $path ) && is_readable( $path ) ) {
            $this->public_key = PublicKeyLoader::load( file_get_contents( $path ), $password );
        }
    }

    /**
     * Load an RSA Public Key from string.
     * @noinspection PhpSameParameterValueInspection
     */
    private function load_rsa_public_key( string $public_key = '', string|false $password=false ): void {
        $this->public_key = PublicKeyLoader::load( $public_key, $password );
    }

    /**
     * Verify a SHA256 with RSA/PSS message signature.
     *
     * @param string|null $message   The JSON string being passed as `callBackData`.
     * @param string|null $signature The string signed with SHA256WithRSA/PSS.
     */
    private function verify( string|null $message, string|null $signature ): bool {
        if ($message   == null) {throw new InvalidArgumentException("message to verify is null");}
        if ($signature == null) {throw new InvalidArgumentException("signature for verification is null");}
        if ($this->public_key instanceof PublicKey) {
            return $this->public_key->verify( $message, $signature );
        } else {
            throw new NoKeyLoadedException();
        }
    }

    public function asObject(): object {
        return (object) [
            'requestId'  => $this->requestId,
            'pkgVersion' => $this->pkgVersion,
            'fileName'   => $this->fileName,
            'retCode'    => $this->retCode,
            'desc'       => $this->desc
        ];
    }
}
