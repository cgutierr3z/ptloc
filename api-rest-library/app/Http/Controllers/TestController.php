<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use App\Comment;



class TestController extends Controller
{
    public function index(){

    }

    public function testOrm(){

        $books = Book::all();
        //var_dump($books);
        foreach($books as $book){
            echo $book->title."<br>";
            echo $book->author."<br>";
            echo "uplodad_by: ".$book->user->name."<br>";
            echo "uploaded: ".$book->created_at."<br>";

            foreach($book->comments as $com){
                echo $com->comment."<br>";
            }
            
            echo "<hr>";
        }

        die();       
    }

}
