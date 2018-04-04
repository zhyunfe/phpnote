<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午4:14
 */
class BookList implements Countable, Iterator
{
    private $books = [];

    private $currentIndex = 0;

    public function addBook(Book $book)
    {
        $this->books[] = $book;
    }

    public function removeBook(Book $bookToReMove)
    {
        foreach ($this->books as $key => $book) {
            if ($book->getAuthorAndTitle() === $bookToReMove->getAuthorAndTitle()) {
                unset($this->books[$key]);
            }
        }
    }
    public function count()
    {
        return count($this->books);
    }

    /**
     * @return mixed
     * 获取当前元素
     */
    public function current()
    {
        // TODO: Implement current() method.
        return $this->books[$this->currentIndex];
    }

    /**
     * @return int
     * 当前元素的键
     */
    public function key()
    {
        return $this->currentIndex;
    }

    /**
     * 下一个元素
     */
    public function next()
    {
        // TODO: Implement next() method.
        $this->currentIndex++;
    }

    /**
     * 倒回第一元素
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
        $this->currentIndex = 0;
    }

    /**
     * @return bool
     * 检查有效性
     */
    public function valid()
    {
        // TODO: Implement valid() method.
        return isset($this->books[$this->currentIndex]);
    }
}