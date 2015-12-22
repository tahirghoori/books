<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Book;
use Input, Redirect, Session;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

/**
 * Class BookController
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
    /**
     * @var array
     */
    public $validationRules= array(
                                'title'=>'required',
                                'author'=>'required'
                                    );
    /**
     * Displays a listing of all the books available and allows their sorting as well.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sortBy=Input::get('sortBy');
        $order=Input::get('order');
        if($sortBy AND $order=='asc') {
            $books = Book::orderBy($sortBy,'ASC')->get();
        }
        elseif($sortBy AND $order=="desc"){
            $books = Book::orderBy($sortBy,'DESC')->get();
        }
        else{
            $books = Book::all();
        }
        return view('home')->with('books',$books);
    }

    /**
     * Shows the form for adding a new book.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('addOrEdit');

    }

    /**
     * Stores a newly created book in mysql db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules=$this->validationRules;

        $validateNow= Validator::make(\Input::all(),$validationRules);
        if($validateNow->fails()){
            Session::flash('message', 'ERROR : Please fill all mandatory values. Neither Title nor Author can be blank.');
            return Redirect::to('add')->withErrors($validateNow)->withInput();
        }
        else{
            $book= new Book;
            $book->title= Input::get('title');
            $book->author = Input::get('author');
            $book->save();
            Session::flash('message', 'Successfully added a new book!');
            return Redirect::to('');
        }

    }

    /**
     * Displays details of a single book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $book= Book::find($id);
        return view('showABook')->with('book',$book);
    }

    /**
     * Shows the form for editing/updating a book's details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book= Book::find($id);
        return view('addOrEdit')->with('book',$book);

    }

    /**
     * Updates the specified book in mysql db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validationRules=$this->validationRules;

        $validateNow= Validator::make(Input::all(),$validationRules);
        if($validateNow->fails()){
            Session::flash('message', 'Please fill all mandatory values. Neither Title nor Author can be blank.');
            return Redirect::to('update/'.$id.'/edit')->withErrors($validateNow)->withInput(Input::all());
        }
        else{
            $book= Book::find($id);
            $book->title= Input::get('title');
            $book->author= Input::get('author');
            $book->save();
            Session::flash('message', 'Successfully updated book');
            return Redirect::to('');
        }
    }

    /**
     * Deletes book from the db.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book= Book::find($id);
        $title=$book->title;
        $author=$book->author;
        $id=$book->id;
        $book->delete();
        Session::flash('message', "Successfully deleted book with the id:$id , title: $title, author: $author ");
        return Redirect::to('');
    }

    /**
     *
     * Shows a form for uploading a csv file containing bulk book details.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFileShow(){
        return view('uploadCSVFile');
    }


    /**
     *
     * Uploaded csv file containing book data is parsed and the data is validated
     *
     * @return mixed
     */
    public function processCSVFile(){
        ini_set('auto_detect_line_endings', TRUE);
        $validationRules = $this->validationRules;
        $filePath=Input::file('csvFileName')->getRealPath();
        $parsedData=array();
        $fileHandle= fopen($filePath,'r');
        while(($singleRecord=fgetcsv($fileHandle))!==false){
            if(array(null)!==$singleRecord AND array(null,null)!==$singleRecord) {
                $parsedData[] = array(
                                    'title' => $singleRecord[0],
                                    'author' => $singleRecord[1]
                                     );
                $validateNow = Validator::make($parsedData[count($parsedData)-1], $validationRules);
                if ($validateNow->fails()) {
                    Session::flash('message', 'Please fill all mandatory values. Neither Title nor Author can be blank. No book(s) has been saved. Please upload a valid csv file only, without NULL values.');
                    return Redirect::to('bulkUpload');
                }
            }
            else{
                Session::flash('message', "Invalid or corrupt file data, Please do not leave blank lines.");
                return Redirect::to('bulkUpload');
            }
        }
        fclose($fileHandle);
        $this->storeBooksInBulk($parsedData);
        Session::flash('message', 'Successfully added '.count($parsedData). ' records.');
        return Redirect::to('');
    }

    /**
     *
     * After validation bulk book data of array containing multiple entities of Book
     * are passed as argument to be saved in the db in bulk
     *
     * @param $books
     */
    public function storeBooksInBulk($books)
    {
        foreach ($books as $book) {
            $storeBook = new Book();
            $storeBook->title = $book['title'];
            $storeBook->author = $book['author'];
            $storeBook->save();
            unset($storeBook);
        }
    }


    /**
     *
     * Searches books based on either title or author name
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $criteria= Input::get('criteria');
        $needle=Input::get('searchQuery');
        if($criteria) {

            $books = Book::where($criteria, 'LIKE', "%$needle%")->get();

            return view('search')->with('books', $books);
        }
        else{
            return view('search');
        }
    }
}