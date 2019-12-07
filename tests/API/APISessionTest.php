<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\CookieJar;

class APISessionTest extends TestCase {
    protected $client;
    protected $jar;
    protected function setUp () {
        $this->jar = new SessionCookieJar('asdasd12ad12312dasd1212asdasd', true);
        $this->client = new Client ([
            'base_uri' => 'http://localhost/biblioteca2/'
        ]);
    }

    public function testUnloadSession() {
        $response = $this->client->get('resources/session', [
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertEquals(false, isset ($data->user));
    }

    public function testCreateSessionFailed () {
        $response = $this->client->post('resources/session', [
            'http_errors' => false,
            'json' => [
                'accounts' => 'admin',
                'passwords' => 'admin'
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode($response->getBody());
        $this->assertEquals('El elemento accounts no está aceptado', $data->error);
    }
    public function testCreateSessionFailedAdded() {
        $response = $this->client->post('resources/session', [
            'http_errors' => false,
            'json' => [
                'account' => 'admin',
                'password' => 'admin',
                'added' => 'asdsa'
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode($response->getBody());
        $this->assertEquals('El elemento added no está aceptado', $data->error);
    }

    public function testCreateSession() {
        $arr = [
            ['account' => 'admin', 'password' => 'admin']
        ];
        foreach ($arr as $i => $json) {
            $response = $this->client->post('resources/session', [
                'http_errors' => false,
                'json' => $json
            ]);
            echo $response->getBody();
            $this->assertEquals(200, $response->getStatusCode());
    
            $data = json_decode($response->getBody());
            $this->assertEquals (true, property_exists ($data, 'user'));
            echo $data->user->id;
        }
        
    }
}