<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector;

use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Scn\DeeplApiConnector\Exception\RequestException;
use Scn\DeeplApiConnector\Handler\DeeplRequestFactoryInterface;
use Scn\DeeplApiConnector\Handler\DeeplRequestHandlerInterface;
use Scn\DeeplApiConnector\Model\FileSubmissionInterface;
use Scn\DeeplApiConnector\Model\FileTranslationConfigInterface;
use Scn\DeeplApiConnector\Model\FileTranslationInterface;
use Scn\DeeplApiConnector\Model\FileTranslationStatusInterface;
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

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn('some content');

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $clientException = $this->createMock(ClientException::class);
        $clientException->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);

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

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn('some content');

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $clientException = $this->createMock(ClientException::class);
        $clientException->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);

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
    
    private function createRequestExpectations(
        MockObject $requestHandler,
        string $method,
        string $path
    ): MockObject {
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
            ->with($method, $path)
            ->willReturn($request);
        
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

    public function testCreateReturnsConnectorInstance(): void
    {
        $this->assertInstanceOf(
            DeeplClient::class,
            DeeplClientFactory::create('some-api-key')
        );
    }
}
