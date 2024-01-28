<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Formation;
use DateTime;

/**
 * Description of AcceuilTest
 *
 * @author Doryan
 */
class AcceuilTest extends TestCase {
    
     public function testGetPublishedAtString(){
        $formation = new Formation();
        $publishedAt = new DateTime("2020-01-01");
        $formation->setPublishedAt($publishedAt);
        $this->assertEquals("01/01/2020", $formation->getPublishedAtString());
    }
}
