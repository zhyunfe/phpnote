<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午4:21
 */
class Test
{
    public function index()
    {
        $bookList = new BookList();
        $bookList->addBook(new Book('Learning PHP Design Patterns','William Sanders'));
        $bookList->addBook(new Book('Clean Code','Robert C. Martin'));

        $books = [];
        foreach ($bookList as $book) {
            $books[] = $book->getAuthorAndTitle();
        }
        var_dump($books);
    }
}