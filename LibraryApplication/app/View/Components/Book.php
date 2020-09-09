<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Book extends Component
{
    /**
     * The book object with the book data
     *
     * @var \App\Books
     */
    public $book;

    /**
     * The boolean value to edition settup
     *
     * @var bool
     */
    public $isForEdit = false;

    /**
     * The boolean value to creation settup
     *
     * @var bool
     */
    public $isForCreation = false;

    /**
     * The boolean value to visualization settup
     *
     * @var bool
     */
    public $isForVisualization = false;

    /**
     * The boolean value to list-item settup
     *
     * @var bool
     */
    public $isForListItem = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $book = null)
    {
        $this->book = $book;

        if($type == 'show')
            $this->isForVisualization = true;

        else if($type == 'edit')
            $this->isForEdit = true;

        else if($type == 'create')
            $this->isForCreation = true;

        else if($type == 'list-item')
            $this->isForListItem = true;

        else throw new Exception("invalid option to set the 'type' of 'book' component");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.book');
    }
}
