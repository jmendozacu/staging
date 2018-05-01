<?php
namespace MageBackup\Aws\Api\Parser;

use MageBackup\Aws\CommandInterface;
use MageBackup\Aws\Exception\AwsException;
use MageBackup\Psr\Http\Message\ResponseInterface;
use MageBackup\GuzzleHttp\Psr7;

/**
 * @internal Decorates a parser and validates the x-amz-crc32 header.
 */
class Crc32ValidatingParser extends AbstractParser
{
    /** @var callable */
    private $parser;

    /**
     * @param callable $parser Parser to wrap.
     */
    public function __construct(callable $parser)
    {
        $this->parser = $parser;
    }

    public function __invoke(
        CommandInterface $command,
        ResponseInterface $response
    ) {
        if ($expected = $response->getHeaderLine('x-amz-crc32')) {
            $hash = hexdec(Psr7\hash($response->getBody(), 'crc32b'));
            if ($expected != $hash) {
                throw new AwsException(
                    "crc32 mismatch. Expected {$expected}, found {$hash}.",
                    $command,
                    [
                        'code'             => 'ClientChecksumMismatch',
                        'connection_error' => true,
                        'response'         => $response
                    ]
                );
            }
        }

        $fn = $this->parser;
        return $fn($command, $response);
    }
}