<?php
class LinkList {

    public $head;
    public $tail;
    private $count;

    public function __construct(){
        $this->head = null;
        $this->tail = null;
        $this->count = 0;
    }

    public function add($data){
        return $this->push($data);
    }

    public function add_first($data){
        $link = new Link($data);
        if($this->head==null){
            $this->head = $link;
        } else {
            $this->head->previous = $link;
            $link->next = $this->head;
            $this->head = $link;
        }
        $this->count++;
        return $this->count;
    }

    public function add_last($data){
        return $this->push($data);
    }

    public function purge(){
        $current = $this->head;
        while($current!=null){
            $next = $current->next;
            $current->purge();
            $current = $next;
        }
        $this->head = null;
        $this->tail = null;
        $this->count = 0;
    }

    public function push($data){
        $link = new Link($data);
        if($this->head==null){
            $this->head = $link;
        } elseif ($this->tail==null) {
            $this->tail = $link;
            $this->head->next = $this->tail;
            $this->tail->previous = $this->head;
        } else {
            $this->tail->next = $link;
            $link->previous = $this->tail;
            $this->tail = $link;
        }
        $this->count++;
        return $this->count;
    }

    public function to_array(){
        $array = array();
        $current = $this->head;
        while($current!=null){
            $array[] = $current->data;
            $current = $current->next;
        }
        return $array;
    }

    public function to_json(){
        return json_encode($this->to_array());
    }
}

class Link {

    public $data;
    public $next;
    public $previous;

    public function __construct($data){
        $this->data = $data ?: null;
        $this->next = null;
        $this->previous = null;
    }

    public function purge(){
        $this->data = null;
        $this->next = null;
        $this->previous = null;
    }
}
