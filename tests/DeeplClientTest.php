<?php

namespace Scn\DeeplApiConnector;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
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

    /**
     * @var DeeplClient
     */
    private $subject;

    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    /**
     * @var DeeplRequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestFactory;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(DeeplRequestFactoryInterface::class);

        $this->subject = new DeeplClient(
            $this->httpClient,
            $this->requestFactory
        );
    }

    public function testGetUsageCanThrowException()
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplUsageRequestHandler')
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

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willThrowException($clientException);

        $this->expectException(RequestException::class);
        $this->subject->getUsage();
    }

    public function testGetUsageCanReturnUsageModel()
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplUsageRequestHandler')
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

        $this->httpClient->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willReturn($response);

        $this->assertInstanceOf(UsageInterface::class, $this->subject->getUsage());
    }

    public function testGetTranslationCanThrowException()
    {
        $translation = $this->createMock(TranslationConfigInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplTranslationRequestHandler')
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

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willThrowException($clientException);

        $this->expectException(RequestException::class);
        $this->subject->getTranslation($translation);
    }

    public function testGetTranslationCanReturnTranslationModel()
    {
        $translation = $this->createMock(TranslationConfigInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplTranslationRequestHandler')
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

        $this->httpClient->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willReturn($response);

        $this->assertInstanceOf(TranslationInterface::class, $this->subject->getTranslation($translation));
    }

    public function testTranslateCanReturnJsonEncodedObject()
    {
        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplTranslationRequestHandler')
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

        $this->httpClient->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willReturn($response);

        $this->assertInstanceOf(TranslationInterface::class, $this->subject->translate('some text', 'some language'));
    }

    public function testTranslateFileCanReturnInstanceOfResponseModel()
    {
        $fileTranslation = $this->createMock(FileTranslationConfigInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplFileSubmissionRequestHandler')
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

        $this->httpClient->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willReturn($response);

        $this->assertInstanceOf(FileSubmissionInterface::class, $this->subject->translateFile($fileTranslation));
    }

    public function testGetFileTranslationStatusCanReturnInstanceOfResponseModel()
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplFileTranslationStatusRequestHandler')
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

        $this->httpClient->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willReturn($response);

        $this->assertInstanceOf(FileTranslationStatusInterface::class, $this->subject->getFileTranslationStatus($fileSubmission));
    }

    public function testGetFileTranslationCanReturnInstanceOfResponseModel()
    {
        $fileSubmission = $this->createMock(FileSubmissionInterface::class);

        $requestHandler = $this->createMock(DeeplRequestHandlerInterface::class);
        $requestHandler->method('getMethod')
            ->willReturn('some method');
        $requestHandler->method('getPath')
            ->willReturn('some path');
        $requestHandler->method('getBody')
            ->willReturn(['some body' => 'with Elements']);

        $this->requestFactory->method('createDeeplFileTranslationRequestHandler')
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

        $this->httpClient->method('request')
            ->with('some method', 'some path', ['some body' => 'with Elements'])
            ->willReturn($response);

        $this->assertInstanceOf(FileTranslationInterface::class, $this->subject->getFileTranslation($fileSubmission));
    }

    public function testCreateReturnsConnectorInstance()
    {
        $this->assertInstanceOf(
            DeeplClient::class,
            DeeplClient::create('some-api-key')
        );
    }
}
