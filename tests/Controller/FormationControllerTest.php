<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of FormationControllerTest
 *
 * @author Doryan
 */
class FormationControllerTest extends WebTestCase{

    private const NOMBREFORMATIONS = 230;
    private const URLFORMATION = '/formations';
    private const ASSERTCONTAINS = 'Eclipse n°4 : WindowBuilder';
    
     public function testSortOnTitle(){
        $client = static::createClient();
        $client->request('GET', self::URLFORMATION);
        $client->submitForm('filtrer', ['recherche' => 'android']);
        $this->assertSelectorTextContains('h5',
                'Android Studio (complément n°13) : Permissions');
    }

    public function testSortOnPlaylist(){
        $client = static::createClient();
        $client->request('GET', self::URLFORMATION);
        $client->submitForm('filtrer', ['recherche' => 'MCD']);
        $this->assertSelectorTextContains('h5',
                'MCD exercice 18 : sujet 2006 (cas Credauto)');
    }

    public function testSortOnCategorie(){
        $client = static::createClient();
        $client->request('GET', '/formations/recherche/id/categories');
        $client->submitForm('filtrer', ['recherche' => '2']);
        $this->assertSelectorTextContains('h5',
                'Eclipse n°2 : rétroconception avec ObjectAid');
    }

    public function testSortOnTitleAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        $this->assertCount(self::NOMBREFORMATIONS,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5',
                'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }

    public function testSortOnTitleDesc(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/title/DESC');
        $this->assertSelectorTextContains('h5',
                'UML : Diagramme de classes');
    }

    public function testSortOnPlaylistAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertCount(self::NOMBREFORMATIONS,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5',
                'Bases de la programmation n°74 - POO : collections');
    }

     public function testSortOnPlaylistDesc(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/name/DESC/playlist');
        $this->assertSelectorTextContains('h5',
                'C# : ListBox en couleur');
    }

    public function testSortOnDateAsc(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/publishedAt/ASC');
        $this->assertCount(self::NOMBREFORMATIONS,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5',
                "Cours UML (12 à 15 / 33) : diagramme d'états");
    }

    public function testSortOnDateDesc(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/publishedAt/DESC');
        $this->assertSelectorTextContains('h5',
                self::ASSERTCONTAINS);
    }
    
     public function testAccessDetails(){
        $client = static::createClient();
        $client->request('GET', self::URLFORMATION);
        $client->clickLink('une formation');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/5', $uri);
        $this->assertSelectorTextContains('h4',
                self::ASSERTCONTAINS);
    }

}