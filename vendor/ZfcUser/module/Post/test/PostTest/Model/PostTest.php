<?php
namespace PostTest\Model;

use Post\Model\Post;
use PHPUnit_Framework_TestCase;

class PostTest extends PHPUnit_Framework_TestCase
{
    public function testPostInitialState()
    {
        $post = new Post();

        $this->assertNull($post->content, '"content" should initially be null');
        $this->assertNull($post->id, '"id" should initially be null');
        $this->assertNull($post->title, '"title" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $post = new Post();
        $data  = array('content' => 'some content',
                       'id'     => 123,
                       'title'  => 'some title');

        $post->exchangeArray($data);

        $this->assertSame($data['content'], $post->content, '"content" was not set correctly');
        $this->assertSame($data['id'], $post->id, '"id" was not set correctly');
        $this->assertSame($data['title'], $post->title, '"title" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $post = new Post();

        $post->exchangeArray(array('content' => 'some content',
                                    'id'     => 123,
                                    'title'  => 'some title'));
        $post->exchangeArray(array());

        $this->assertNull($post->content, '"content" should have defaulted to null');
        $this->assertNull($post->id, '"id" should have defaulted to null');
        $this->assertNull($post->title, '"title" should have defaulted to null');
    }
}