<?php

namespace App\Tests;


use App\Entity\IncomingMessage;
use App\Entity\Message;
use App\Entity\MessageType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageApiTest extends WebTestCase
{
    private $lastInsertedId = null;
    private \Doctrine\ORM\EntityManager $entityManager;
    private $client = null;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->lastInsertedId = $this->entityManager
            ->getrepository(Message::class)
            ->findby([],["id"=>'desc'], 1, 0)[0]
            ->getId();
    }

    public function testMessageList(): void
    {
        $type = $this->entityManager->getRepository(MessageType::class)->find(1);
        $message = new IncomingMessage();
        $message->setType($type);
        $message->setSubject('Incoming message test');
        $message->setContent('Incoming message test');
        $message->setSender('Unit test');
        $message->setDate(new \DateTime());
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        $this->client->request('GET', '/messages');
        $response = $this->client->getResponse();
        self::assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }

    public function testMessageStore(): void
    {
        $message = [
            'type_id' => 2,
            'subject' => 'Test outgoing message',
            'content' => 'Lorum ipsum outgoing',
            'sender' => 'Unit test store'
        ];
        $this->client->request(
            'POST',
            '/api/messages',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($message, JSON_THROW_ON_ERROR)
        );
        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->lastInsertedId = $responseData['message']['id'];
    }

    public function testMessageShow(): void
    {
        $this->client->request('GET', '/api/messages/'.$this->lastInsertedId);
        self::assertResponseIsSuccessful();
    }

    public function testMessageUpdate(): void
    {
        $message = [
            'subject' => 'Test outgoing message 1',
            'content' => 'Lorum ipsum outgoing',
            'sender' => 'Unit test update'
        ];
        $this->client->request(
            'PUT',
            '/api/messages/'.$this->lastInsertedId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($message, JSON_THROW_ON_ERROR)
        );
        $response = $this->client->getResponse();
        self::assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }

    public function testMessageDelete(): void
    {
        $this->client->request('DELETE', '/api/messages/'.$this->lastInsertedId);
        self::assertResponseIsSuccessful();
    }
}
