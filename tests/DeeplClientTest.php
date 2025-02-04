<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Generator;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Exception\RequestException;
use Scn\DeeplApiConnector\Handler\DeeplRequestFactoryInterface;
use Scn\DeeplApiConnector\Handler\DeeplRequestHandlerInterface;
use Scn\DeeplApiConnector\Model\BatchTranslationInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\FileTranslationInterface;
use Scn\DeeplApiConnector\Model\FileTranslationStatusInterface;
use Scn\DeeplApiConnector\Model\Glossaries;
use Scn\DeeplApiConnector\Model\GlossariesSupportedLanguagesPairs;
use Scn\DeeplApiConnector\Model\Glossary;
use Scn\DeeplApiConnector\Model\GlossaryEntries;
use Scn\DeeplApiConnector\Model\GlossaryIdSubmission;
use Scn\DeeplApiConnector\Model\GlossarySubmission;
use Scn\DeeplApiConnector\Model\SupportedLanguages;
use Scn\DeeplApiConnector\Model\TranslationConfigInterface;
use Scn\DeeplApiConnector\Model\TranslationInterface;
use Scn\DeeplApiConnector\Model\UsageInterface;

class DeeplClientTest extends TestCase
{
    private DeeplClient $subject;

    private ClientInterface&MockObject $httpClient;

    private DeeplRequestFactoryInterface&MockObject $deeplRequestFactory;

    private RequestFactoryInterface&MockObject $requestFactory;

    private string $apiKey = '<VALID-DEEPL-API-KEY>';

    public function setUp(): void
    {
        $this->deeplRequestFactory = $this->createMock(DeeplRequestFactoryInterface::class);
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);

        $this->subject = new DeeplClient(
            $this->apiKey,
            $this->deeplRequestFactory,
            $this->httpClient,
            $this->requestFactory,
        );
    }

    #[Test]
    public function getUsageOnRequestException(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some_method');
        $requestHandler->method('getPath')
            ->willReturn('/some/path');

        $this->deeplRequestFactory->method('createDeeplUsageRequestHandler')
            ->willReturn($requestHandler);

        $clientException = $this->createMock(ClientException::class);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some_method',
            '/some/path',
            'application/json',
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willThrowException($clientException);

        $this->expectException(RequestException::class);
        $this->subject->getUsage();
    }

    #[Test]
    public function getUsage(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplUsageRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            'application/json',
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(UsageInterface::class, $this->subject->getUsage());
    }

    #[Test]
    public function getTranslationOnRequestException(): void
    {
        $translation = $this->createMock(TranslationConfigInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplTranslationRequestHandler')
            ->willReturn($requestHandler);

        $clientException = $this->createMock(ClientException::class);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            'application/json',
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willThrowException($clientException);

        $this->expectException(RequestException::class);
        $this->subject->getTranslation($translation);
    }

    #[Test]
    public function getTranslation(): void
    {
        $translation = $this->createMock(TranslationConfigInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplTranslationRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);

        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(TranslationInterface::class, $this->subject->getTranslation($translation));
    }

    #[Test]
    public function translate(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplTranslationRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value', 'some other string' => ['more text' => 'more values']]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $contentType = 'application/json';
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            'application/json'
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(TranslationInterface::class, $this->subject->translate('some text', 'some language'));
    }

    #[Test]
    public function translateBatch(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $stream = $this->createMock(StreamInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplBatchTranslationRequestHandler')
            ->willReturn($requestHandler);

        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn(json_encode(['translations' => ['content']]));

        $contentType = 'application/json';
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(BatchTranslationInterface::class, $this->subject->translateBatch(['some text'], 'some language'));
    }

    #[Test]
    public function translateFile(): void
    {
        $fileTranslation = $this->createMock(FileTranslationConfigInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplFileSubmissionRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(FileSubmissionInterface::class, $this->subject->translateFile($fileTranslation));
    }

    #[Test]
    public function getFileTranslationStatus(): void
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplFileTranslationStatusRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(FileTranslationStatusInterface::class, $this->subject->getFileTranslationStatus($fileSubmission));
    }

    #[Test]
    public function getFileTranslation(): void
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);

        $this->deeplRequestFactory->method('createDeeplFileTranslationRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(FileTranslationInterface::class, $this->subject->getFileTranslation($fileSubmission));
    }

    public static function errorStatusCodeProvider(): Generator
    {
        yield [404];
        yield [403];
        yield [500];
    }

    #[Test, DataProvider(methodName: 'errorStatusCodeProvider')]
    public function responseWithErrorStatusCodeTriggersError(int $statusCode): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);

        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplUsageRequestHandler')
            ->willReturn($requestHandler);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            'application/json',
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $this->expectException(RequestException::class);
        $this->expectExceptionCode($statusCode);

        $this->subject->getUsage();
    }

    #[Test]
    public function getSupportedLanguages(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplSupportedLanguageRetrievalRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['with value', 'some-other value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(SupportedLanguages::class, $this->subject->getSupportedLanguages());
    }

    #[Test]
    public function getGlossariesSupportedLanguagesPairs(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplGlossariesSupportedLanguagesPairsRetrievalRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['supported_languages' => ['with value', 'some-other value']]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(GlossariesSupportedLanguagesPairs::class, $this->subject->getGlossariesSupportedLanguagesPairs());
    }

    #[Test]
    public function getGlossariesList(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplGlossariesListRetrievalRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['glossaries' => ['with value', 'some-other value']]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        self::assertInstanceOf(Glossaries::class, $this->subject->getGlossariesList());
    }

    #[Test]
    public function createGlossary(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplGlossaryCreateRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['with value', 'some-other value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossarySubmission::class);

        self::assertInstanceOf(Glossary::class, $this->subject->createGlossary($submission));
    }

    #[Test]
    public function retrieveGlossary(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplGlossaryRetrieveRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['with value', 'some-other value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossaryIdSubmission::class);
        self::assertInstanceOf(Glossary::class, $this->subject->retrieveGlossary($submission));
    }

    #[Test]
    public function deleteGlossary(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplGlossaryDeleteRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['with value', 'some-other value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossaryIdSubmission::class);
        self::assertTrue($this->subject->deleteGlossary($submission));
    }

    #[Test]
    public function retrieveGlossaryEntries(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplGlossaryEntriesRetrieveRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['content' => 'test']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($json);

        $contentType = 'application/json';
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn([$contentType]);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path',
            $contentType,
        );

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossaryIdSubmission::class);
        self::assertInstanceOf(GlossaryEntries::class, $this->subject->retrieveGlossaryEntries($submission));
    }

    private function createRequestExpectations(
        MockObject $requestHandler,
        string $method,
        string $path,
        string $contentType,
    ): MockObject {
        $base_uri = 'https://api.deepl.com';
        $request = $this->createMock(RequestInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $requestHandler->expects(self::once())
            ->method('getMethod')
            ->willReturn('some method');
        $requestHandler->expects(self::once())
            ->method('getPath')
            ->willReturn('some path');
        $requestHandler->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $requestHandler->expects(self::once())
            ->method('getContentType')
            ->willReturn($contentType);

        $this->requestFactory->expects(self::once())
            ->method('createRequest')
            ->with($method, sprintf('%s%s', $base_uri, $path))
            ->willReturn($request);

        $callNr = 1;
        $request->expects(self::exactly(2))
            ->method('withHeader')
            ->with(self::callback(
                function (...$header) use (&$callNr, $contentType): bool {
                    return match ($callNr++) {
                        1 => ($header[0] === 'Authorization' && $header[1] ==='DeepL-Auth-Key '.$this->apiKey),
                        2 => ($header[0] === 'Content-Type' && $header[1] === $contentType),
                    };
                }
            ))
            ->willReturnSelf();

        $request->expects(self::once())
            ->method('withBody')
            ->with($stream)
            ->willReturnSelf();

        return $request;
    }
}
