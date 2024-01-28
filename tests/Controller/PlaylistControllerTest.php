<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistControllerTest
 *
 * @author Doryan
 */
class PlaylistControllerTest extends WebTestCase{

    private const NOMBREPLAYLIST = 56;
    
     public function testSortOnName(){
        $client = static::createClient();
        $client->request('GET', '/playlists/recherche/name');
        $crawler = $client->submitForm('submit', ['recherche' => 'MCD'], 'POST');
        $this->assertCount(self::NOMBREPLAYLIST,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5',
                'Cours MCD MLD MPD');
    }

    public function testSortOnCategorie(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/recherche/id/categories');
        $client->submitForm('filtrer_categorie', ['recherche' => '7']);
        $this->assertCount(self::NOMBREPLAYLIST,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5',
                "Bases de la programmation (C#)");
    }


    public function testSortOnTitleAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertCount(self::NOMBREPLAYLIST,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5',
                'Bases de la programmation (C#)');
    }

    public function testSortOnTitleDesc(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/DESC');
        $this->assertSelectorTextContains('h5',
                'Visual Studio 2019 et C#');
    }
     public function testAccessDetails(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $client->clickLink('Voir détail');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4',
                "Bases de la programmation (C#)");
    }
}
