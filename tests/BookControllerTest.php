<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Book;

/**
 * Class BookControllerTest
 */
class BookControllerTest extends TestCase
{
    /**
     * Tests to see if a book can be added to the db
     *
     * @return void
     */
    public function testProcessBookCreate()
    {
        $this->visit('/add')
            ->type('Inferno','title')
            ->type('Dante','author')
            ->press('Submit')
            ->see('Successfully added a new book');
    }

    /**
     *
     * Tests deletion of a book from the db based on its id
     *
     */
    public function testProcessBookDelete()
    {
        //creating a book to delete
        $book= new Book();
        $book->title='The Hobbit';
        $book->author='Tolkien';
        $book->save();

        $this->visit('/')
            ->press('book'.$book->id)
            ->see('Successfully deleted book');

    }

    /**
     *
     * Tests updating of an existing book record and validates change in values
     *
     */
    public function testProcessBookEdit()
    {
        //create a new book
        $book= new Book();
        $book->title='Another Book About Php I think';
        $book->author='Sherlock Holmes';
        $book->save();
        $bookEditURL='/books/'.$book->id.'/edit';

        //now update it
        $updatedTitle='No this is a JScript Book';
        $updatedAuthor='Ali';
        $this->visit($bookEditURL)
            ->type($updatedTitle,'title')
            ->type($updatedAuthor,'author')
            ->press('Submit');

        //confirm the values have been updated
        $updatedBook= Book::find($book->id);
        $this->assertEquals($updatedBook->title,$updatedTitle);
        $this->assertEquals($updatedBook->author,$updatedAuthor);
    }

    /**
     *
     * Tests the module showing details of a single book is working by first adding a new book
     * and matching the data inserted vs data seen.
     *
     */
    public function testProcessBookShow(){
        //create a book
        $book= new Book();
        $book->title='The Hobbit';
        $book->author='Tolkien';
        $book->save();

        //see if the created book shows the same details used earlier
        $bookShowURL='/books/'.$book->id;
        $this->visit($bookShowURL)
            ->see('Tolkien')
            ->see('The Hobbit');
    }

    /**
     *
     * Tests missing argument Author for book addition, if it is truly missing we seek confirmation of an error.
     *
     */
    public function testMissingAuthorForBookAddition(){
        $this->visit('/add')
            ->type('Geography','title')
            ->press('Submit')
            ->see('Error');
    }

    /**
     *
     *  Tests missing argument Title for book addition, if it is truly missing we seek confirmation of an error.
     *
     */
    public function testMissingTitleForBookAddition(){
        $this->visit('/add')
            ->type('Ali','author')
            ->press('Submit')
            ->see('Error');
    }

    /**
     *
     * Tests uploading of a csv file with data containing titles of multiple books and authors
     * and saves them in bulk. Confirmation of the addition is sought by self-testing/seeing the presence
     * of the expected data on the display page.
     *
     */
    public function testBulkDataEntry(){
        $pathToSampleCSVFile=__DIR__."/../public/downloads/sample.csv";
        $parsedData= array_map('str_getcsv', file($pathToSampleCSVFile));
        $resource=  $this->visit('/bulkUpload')
                        ->attach($pathToSampleCSVFile,'csvFileName')
                        ->press('Upload');
        foreach($parsedData as $value){
            $resource=$resource->see($value[0])->see($value[1]);
        }
    }


}