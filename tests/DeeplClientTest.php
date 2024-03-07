<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use GuzzleHttp\Exception\ClientException;
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
    /** @var DeeplClient */
    private $subject;

    /** @var ClientInterface|MockObject */
    private $httpClient;

    /** @var DeeplRequestFactoryInterface|MockObject */
    private $deeplRequestFactory;

    /** @var RequestFactoryInterface|MockObject */
    private $requestFactory;

    public function setUp(): void
    {
        $this->deeplRequestFactory = $this->createMock(DeeplRequestFactoryInterface::class);
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);

        $this->subject = new DeeplClient(
            $this->deeplRequestFactory,
            $this->httpClient,
            $this->requestFactory
        );
    }

    public function testGetUsageCanThrowException(): void
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');

        $this->deeplRequestFactory->method('createDeeplUsageRequestHandler')
            ->willReturn($requestHandler);

        $clientException = $this->createMock(ClientException::class);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willThrowException($clientException);

        $this->expectException(RequestException::class);
        $this->subject->getUsage();
    }

    public function testGetUsageCanReturnUsageModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(UsageInterface::class, $this->subject->getUsage());
    }

    public function testGetTranslationCanThrowException(): void
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
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willThrowException($clientException);

        $this->expectException(RequestException::class);
        $this->subject->getTranslation($translation);
    }

    public function testGetTranslationCanReturnTranslationModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(TranslationInterface::class, $this->subject->getTranslation($translation));
    }

    public function testTranslateCanReturnJsonEncodedObject(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(TranslationInterface::class, $this->subject->translate('some text', 'some language'));
    }

    public function testTranslateBatchPerformsBatchTranslations(): void
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

        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['translations' => ['content']]));

        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(
            BatchTranslationInterface::class,
            $this->subject->translateBatch(['some text'], 'some language')
        );
    }

    public function testTranslateFileCanReturnInstanceOfResponseModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(FileSubmissionInterface::class, $this->subject->translateFile($fileTranslation));
    }

    public function testGetFileTranslationStatusCanReturnInstanceOfResponseModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(FileTranslationStatusInterface::class, $this->subject->getFileTranslationStatus($fileSubmission));
    }

    public function testGetFileTranslationCanReturnInstanceOfResponseModel(): void
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);

        $this->deeplRequestFactory->method('createDeeplFileTranslationRequestHandler')
            ->willReturn($requestHandler);

        $json = json_encode(['some string' => 'with value']);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['plain/text']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(FileTranslationInterface::class, $this->subject->getFileTranslation($fileSubmission));
    }

    public function errorStatusCodeProvider(): array
    {
        return [
            [404],
            [403],
            [500],
        ];
    }

    /**
     * @dataProvider errorStatusCodeProvider
     */
    public function testResponseWithErrorStatusCodeTriggersError(int $statusCode): void
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
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $this->expectException(RequestException::class);
        $this->expectExceptionCode($statusCode);

        $this->subject->getUsage();
    }

    public function testGetSupportedLanguagesReturnsSupportedLanguagesModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(SupportedLanguages::class, $this->subject->getSupportedLanguages());
    }

    public function testGetGlossariesSupportedLanguagesPairsGetCorrectModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(GlossariesSupportedLanguagesPairs::class, $this->subject->getGlossariesSupportedLanguagesPairs());
    }

    public function testGetGlossariesListGetCorrectModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(Glossaries::class, $this->subject->getGlossariesList());
    }

    public function testCreateGlossaryGetCorrectModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossarySubmission::class);

        $this->assertInstanceOf(Glossary::class, $this->subject->createGlossary($submission));
    }

    public function testRetrieveGlossaryGetCorrectModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossaryIdSubmission::class);
        $this->assertInstanceOf(Glossary::class, $this->subject->retrieveGlossary($submission));
    }

    public function testDeleteGlossaryGetCorrectBoolean(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossaryIdSubmission::class);
        $this->assertTrue($this->subject->deleteGlossary($submission));
    }

    public function testRetrieveGlossaryEntriesGetCorrectModel(): void
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
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn(['application/json']);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $request = $this->createRequestExpectations(
            $requestHandler,
            'some method',
            'some path'
        );

        $this->httpClient->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $submission = $this->createMock(GlossaryIdSubmission::class);
        $this->assertInstanceOf(GlossaryEntries::class, $this->subject->retrieveGlossaryEntries($submission));
    }

    private function createRequestExpectations(
        MockObject $requestHandler,
        string $method,
        string $path
    ): MockObject {
        $base_uri = 'http://something';
        $request = $this->createMock(RequestInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $contentType = 'some-content-type';
        $requestHandler->expects($this->once())
            ->method('getMethod')
            ->willReturn('some method');
        $requestHandler->expects($this->once())
            ->method('getPath')
            ->willReturn('some path');
        $requestHandler->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $requestHandler->expects($this->once())
            ->method('getContentType')
            ->willReturn($contentType);

        $this->requestFactory->expects($this->once())
            ->method('createRequest')
            ->with($method, sprintf('%s%s', $base_uri, $path))
            ->willReturn($request);

        $this->deeplRequestFactory->expects($this->once())
            ->method('getDeeplBaseUri')
            ->willReturn($base_uri);

        $request->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', $contentType)
            ->willReturnSelf();
        $request->expects($this->once())
            ->method('withBody')
            ->with($stream)
            ->willReturnSelf();

        return $request;
    }
}
